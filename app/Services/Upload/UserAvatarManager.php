<?php

namespace App\Services\Upload;

use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class UserAvatarManager
{
	const AVATAR_WIDTH = 160;
    const AVATAR_HEIGHT = 160;
    protected $user;
    private $fs;
    private $imageManager;
    private $request;

    public function __construct(Filesystem $fs, ImageManager $imageManager, Request $request)
    {
        $this->fs = $fs;
        $this->imageManager = $imageManager;
        $this->request = $request;
    }

    /**
    	==================== PUBLIC FUNCTION ==============
    */

    /**
     * Upload and crop user avatar to predefined width and height.
     *
     * @param User $user
     * @return string Avatar file name.
     */
    public function uploadAndCropAvatar(User $user)
    {
        list($name, $avatarImage) = $this->uploadFile($user);

        try {
            $this->cropAndResizeImage($avatarImage);
            $this->deleteAvatarIfUploaded($user);
        } catch (\Exception $e) {
            logger("Cannot upload avatar. " . $e->getMessage());
            $this->fs->delete($this->getDestinationDirectory() . "/" . $name);
            return null;
        }

        return $name;
    }

    /**
     * @param User $user
     */
    public function deleteAvatarIfUploaded(User $user)
    {
        if ($this->userHasUploadedAvatar($user)) {
            $path = sprintf("%s/%s", $this->getDestinationDirectory(), $user->avatar);
            $this->fs->delete($path);
        }
    }


    /**
    	=====================PRIVATE FUNCTION===================
    */

    /**
     * Upload avatar photo for provided user and
     * delete old avatar if exists.
     *
     * @param User $user
     * @return array
     */
    private function uploadFile(User $user)
    {
        $name = $this->generateAvatarName();
        $uploadedFile = $this->getUploadedFileFromRequest();

        $targetFile = $uploadedFile->move($this->getDestinationDirectory(), $name);

        return [$name, $targetFile];
    }

    /**
     * Build random avatar name.
     *
     * @return string
     */
    private function generateAvatarName()
    {
        $file = $this->getUploadedFileFromRequest();

        return sprintf(
            "%s.%s",
            md5(str_random() . time()),
            $file->getClientOriginalExtension()
        );
    }

    /**
     * Get uploaded file from HTTP request.
     *
     * @return array|null|\Symfony\Component\HttpFoundation\File\UploadedFile
     */
    private function getUploadedFileFromRequest()
    {
        return $this->request->file('avatar');
    }

    /**
     * Get destination directory where avatar should be uploaded.
     *
     * @return string
     */
    private function getDestinationDirectory()
    {
        return public_path('upload/users');
    }

    /**
     * Crop image from provided selected points and
     * resize it to predefined width and height.
     *
     * @param File $avatarImage
     * @return \Intervention\Image\Image
     */
    private function cropAndResizeImage(File $avatarImage)
    {
        $points = $this->request->get('points');
        $image = $this->imageManager->make($avatarImage->getRealPath());

        // Calculate delta between two points on X axis. This
        // value will be used as width and height for cropped image.
        $size = floor($points['x2'] - $points['x1']);

        return $image->crop($size, $size, (int) $points['x1'], (int) $points['y1'])
            ->resize(self::AVATAR_WIDTH, self::AVATAR_HEIGHT)
            ->save();
    }

    /**
     * Check if user has uploaded avatar photo.
     * If he is using some external url for avatar, then
     * it is assumed that avatar is not uploaded manually.
     *
     * @param User $user
     * @return bool
     */
    private function userHasUploadedAvatar(User $user)
    {
        return $user->avatar && ! str_contains($user->avatar, ['http', 'gravatar']);
    }
}