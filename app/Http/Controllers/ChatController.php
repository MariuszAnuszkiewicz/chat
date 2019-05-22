<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Traits\EncodeHashUserKeyTrait;
use App\Traits\GetFilesTrait;
use App\Classes\DataStore;
use App\UserProfile;
use App\Chat;
use App\User;
use Auth;

class ChatController extends Controller
{
    use EncodeHashUserKeyTrait, GetFilesTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param Chat $modelChat
     * @param User $modelUser
     * @param UserProfile $modelUserProfile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, Chat $modelChat, User $modelUser, UserProfile $modelUserProfile)
    {
        $dataStore = new DataStore();
        $pathToGuestFile = $dataStore->generatePathForGuestFile(Auth::user()->name, Auth::user()->id);
        $guestUserId = $this->getPermanentAccessGuestUserId($pathToGuestFile, DataStore::DATA_FILE, $modelUser, $request->input('data-profile-value'));
        $users = [
            'host_id' => intval(Auth::user()->id),
            'guest_id' => intval($guestUserId),
            'username_host' => Auth::user()->name,
            'username_guest' => $dataStore->storeUsername($modelUser, $guestUserId, "string", "guest"),
        ];

        $usernameFromProfile = $dataStore->storeUsername($modelUser, $users['host_id'], "string", null);
        $messages = null;
        $validator = Validator::make($request->all(), [
            'message' => 'required|min:3|max:255',
        ]);
        if ($request->isMethod('post') || $request->isMethod('get')) {
            if ($this->encodeHashKey($usernameFromProfile, $users['host_id'], $request->session()->get('user_hash')) == true) {
                $messageInput = (!$validator->fails()) ? $request->input('message') : null;
                if ($request->input('send-btn')) {
                    $validator->fails() ? $request->session()->flash('error', 'Field message is empty') : response()->json(['errors' => $validator->getMessageBag()->toArray()]);
                    if ($messageInput) {
                        $inputData = response()->json($messageInput)->getData();
                        $modelChat->insertDataToChat($users['guest_id'], $inputData);
                    }
                }
                $messages['host'] = $modelChat->getMessagesByUserId($users['host_id']);
                $messages['host_count'] = count($modelChat->getMessagesByUserId($users['host_id']));
            }
            $messages['guest'] = $modelChat->getMessagesByUserId($users['guest_id']);
            $messages['guest_count'] = count($messages['guest']);

        }
        $avatarHost = $modelUserProfile->getAvatarImage($users['host_id']);
        $avatarGuest = $modelUserProfile->getAvatarImage($users['guest_id']);
        if ($request->ajax()) {
            return response()->json(['messages' => $messages]);
        }

        return view('application.chat.index', ['messages' => $messages,
                                                    'users' => $users,
                                                    'idGuest' => $users['guest_id'],
                                                    'avatarHost' => $avatarHost,
                                                    'avatarGuest' => $avatarGuest
                                                   ]);

    }

    public function clear(Chat $modelChat)
    {
        $idHost = (int) Auth::user()->id;
        $modelChat->deleteByUserId($idHost);
        return redirect('/application/chat');
    }

    public function logout(UserProfile $modelUserProfile)
    {
        $idHost = (int) Auth::user()->id;
        $modelUserProfile->updateByUserId($value = 0, $idHost);
        auth()->logout();
        return redirect('/application');
    }
}
