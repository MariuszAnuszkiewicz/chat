<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;
use App\UserProfile;
use App\Traits\HashUserKeyTrait;
use App\Traits\GetFilesTrait;
use App\Traits\ClearFilesTrait;
use App\Traits\ClearDirectoriesTrait;
use App\Traits\UploadProfileImagesTrait;
use App\Classes\DataStore;
use App\Exceptions\FailSavingException;
use Illuminate\Http\UploadedFile;

class UserProfileController extends Controller
{
    use HashUserKeyTrait, GetFilesTrait, ClearFilesTrait, ClearDirectoriesTrait, UploadProfileImagesTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param UserProfile $modelUserProfile
     * @param User $modelUser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, UserProfile $modelUserProfile, User $modelUser)
    {
         $dataStore = new DataStore();
         $documentRoot = $request->server('DOCUMENT_ROOT');
         $pathToGuestFile = $dataStore->generatePathForGuestFile(Auth::user()->name, Auth::user()->id);
         $guestUserId = $this->getPermanentAccessGuestUserId($pathToGuestFile, DataStore::DATA_FILE, $modelUser, $request->input('data-profile-value'));
         $users = [
             'host_id' => intval(Auth::user()->id),
             'guest_id' => intval($guestUserId),
             'username_host' => Auth::user()->name,
             'username_guest' => $dataStore->storeUsername($modelUser, $guestUserId, "string", "guest"),
         ];

         $guestProfiles = $modelUserProfile->getUserIdByNamesExceptHost(Auth::user()->name);
         $quantityUserProfileFromServer = count($this->getDirectoryUserProfilesFromServer($documentRoot, $users['host_id']));
         $quantityUserProfileFromDatabase = count($modelUserProfile->getUserIdByName($users['username_host']));
         $usernameFromProfile = $dataStore->storeUsername($modelUser, $users['host_id'], "string", null);
         $request->session()->put('user_hash', $this->createHashKey($usernameFromProfile, $users['host_id']));

         if (Auth::check() && $quantityUserProfileFromServer < UserProfile::LIMIT_USER_PROFILE && $quantityUserProfileFromDatabase < UserProfile::LIMIT_USER_PROFILE) {
             try {
                 $modelUserProfile->insertDataToUserProfile(
                     $users['host_id'],
                     $request->session()->pull('user_hash'),
                     Auth::user()->name,
                     Auth::check(),
                     $this->getDirectoryElements($documentRoot . UserProfile::AVATAR_USER_PROFILE_PATH . DataStore::DEFAULT_FILE)
                 );
             } catch (FailSavingException $e) {
                $request->session()->flash('error', 'Problem to save data: ' . $e->getMessage());
             }
         }
         elseif (Auth::check() && $quantityUserProfileFromServer > 0) {
             $modelUserProfile->updateByUserId($value = 1, $users['host_id']);
         }
         $avatarHost = $modelUserProfile->getAvatarImage($users['host_id']);
         return view('application.profile.index', ['users' => $users, 'guestProfiles' => $guestProfiles, 'avatarHost' => $avatarHost, 'idGuest' => $users['guest_id']]);
    }

    /**
     * @param Request $request
     * @param UserProfile $modelUserProfile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, UserProfile $modelUserProfile)
    {
        $users = [
            'host_id' => intval(Auth::user()->id),
            'username_host' => Auth::user()->name,
        ];
        $validator = Validator::make($request->all(), [
            'profile_image' => 'image|max:3000',
        ]);
        $files = [
            'image' => $request->file('profile_image'),
        ];
        $folders = [
            'img' => public_path('img/profiles/'),
            'catalogue' => public_path('img/profiles/') . $users['username_host'] . '_' . $users['host_id'] . '_' . rand(),
        ];

        if ($validator->fails()) {
             return redirect('application/profile/' . $users['host_id'])
            ->withErrors($validator)
            ->withInput();
        }

        if (!$request->hasFile('profile_image')) {
            $request->session()->flash('status', 'Please upload image');
        } else {
            $documentRoot = $request->server('DOCUMENT_ROOT');
            $newFile = $this->buildFullPathForImage($request, $users, $folders, 'new_file');
            $quantityFiles = count(glob($documentRoot . UserProfile::AVATAR_USER_PROFILE_PATH . $this->getDirectoryUserProfiles($modelUserProfile, $users['host_id'])));
            try {
                if ($modelUserProfile->getAvatarImage($users['host_id'])[0]->avatar != $this->getDirectoryElements($folders['img'] . 'default\default-avatar.jpg')) {
                    if ($documentRoot . UserProfile::AVATAR_USER_PROFILE_PATH . $this->getDirectoryUserProfiles($modelUserProfile, $users['host_id']) . $this->getFileNameFromUserProfile($modelUserProfile, $users['host_id']) != $this->getDirectoryUserProfilesFromServer($documentRoot, $users['host_id'])) {
                        $this->removeRedundantFiles($documentRoot . UserProfile::AVATAR_USER_PROFILE_PATH . $this->getDirectoryUserProfiles($modelUserProfile, $users['host_id']));
                        if ($quantityFiles > 0) {
                            $this->removeRedundantDirectoriesImg($documentRoot . UserProfile::AVATAR_USER_PROFILE_PATH, $users['host_id'], $users['username_host']);
                        }
                    }
                }
                $modelUserProfile->updateImageUserProfile($this->getDirectoryElements($this->buildFullPathForImage($request, $users, $folders, 'full_path', $newFile)), $users['host_id']);
                $upload = $this->moveFileToDirectory($files['image'], $documentRoot, $newFile, $modelUserProfile, $users['host_id']);
                $file = new UploadedFile($upload, true);
                $request->session()->flash('status', 'Image moved successfully');

                if ($file->getFileInfo()->getFilename() != $this->getFileNameFromUserProfile($modelUserProfile, $users['host_id'])) {
                    $modelUserProfile->updateImageUserProfile($this->getDirectoryElements($this->buildFullPathForImage($request, $users, $folders, 'full_path', $newFile)), $users['host_id']);
                }

            } catch (\Exception $e) {
                if ($e->getMessage() == "Undefined variable: upload") {
                    $request->session()->flash('error', 'Problem to upload file, unknown extension');
                }
            }
        }
        return view('application.profile.edit_profile', ['id' => $users['host_id']]);
    }

    public function logout(UserProfile $modelUserProfile)
    {
        $idHost = (int) Auth::user()->id;
        $modelUserProfile->updateByUserId($value = 0, $idHost);
        auth()->logout();
        return redirect('/application');
    }
}
