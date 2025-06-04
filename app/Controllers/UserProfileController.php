<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Facades\Auth;
use App\Helpers\AuditHelper;
use App\Models\User;
use App\Requests\UserProfile\UpdateImageRequest;
use App\Requests\UserProfile\UpdatePasswordRequest;
use App\Requests\UserProfile\UpdateProfileRequest;
use App\Services\ImageUploadService;

class UserProfileController extends BaseController
{
    private $imageUploadService;

    public function __construct()
    {
        $this->imageUploadService = new ImageUploadService;
    }

    public function updateUserInformationPage(): ?string
    {
        $user = auth()->user();
        $isUpdatingProfile = true;
        $contentTitle = 'Update Personal Information';

        return blade_view('contents.user-toggle.index', [
            'isUpdatingProfile' => $isUpdatingProfile,
            'contentTitle' => $contentTitle,
            'user' => $user,
        ]);
    }

    public function updateUserPasswordPage(): ?string
    {
        $isUpdatingPassword = true;
        $contentTitle = 'Update Password';

        return blade_view('contents.user-toggle.index', [
            'isUpdatingPassword' => $isUpdatingPassword,
            'contentTitle' => $contentTitle
        ]);
    }

    public function updateUserImagePage(): ?string
    {
        $isUpdatingImage = true;
        $contentTitle = 'Update Profile Image';
        $userImage = auth()->user()->image_path;

        return blade_view('contents.user-toggle.index', [
            'isUpdatingImage' => $isUpdatingImage,
            'contentTitle' => $contentTitle,
            'userImage' => $userImage,
        ]);
    }

    public function showUserProfilePage(): ?string
    {
        $user = auth()->user();

        $contentTitle = 'Profile Page';
        $isShowingProfilePage = true;

        return blade_view('contents.user-toggle.index', [
            'user' => $user,
            'isShowingProfilePage' => $isShowingProfilePage,
            'contentTitle' => $contentTitle,
        ]);
    }

    public function updateUserInformation()
    {
        auth()->user()->update(UpdateProfileRequest::validateRequest());
        AuditHelper::logUpdated(User::class, auth()->user()->getOriginal());

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updateUserPassword()
    {
        $validatedData = UpdatePasswordRequest::validateRequest();
        $user = auth()->user();

        if (!password_verify($validatedData['old_password'], $user->password)) {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }

        $user->update([
            'password' => $validatedData['new_password'],
        ]);

        AuditHelper::logUpdated(User::class, $user->getOriginal());

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function updateUserImage()
    {
        $validatedData = UpdateImageRequest::validateRequest(false);
        $image = $validatedData->file('profile_image');
        $imagePath = $this->imageUploadService->uploadProfile($image);

        auth()->user()->update([
            'image_path' => $imagePath,
        ]);

        AuditHelper::logUpdated(User::class, auth()->user()->getOriginal());

        return redirect()->back()->with('success', 'Profile image updated successfully.');
    }
}
