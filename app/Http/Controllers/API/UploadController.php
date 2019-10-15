<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Upload\AvatarRequest;
use App\Http\Requests\Upload\ThumbnailRequest;
use App\Http\Resources\UploadResource;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param string $path
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $file
     * @return UploadResource
     */
    private function save($path, $file)
    {
        $path = $file->store($path);

        return new UploadResource([
            'url' => $path
        ]);
    }

    public function avatar(AvatarRequest $request): UploadResource
    {
        $file = $request->file('avatar');
        return $this->save('avatars', $file);
    }

    public function thumbnail(ThumbnailRequest $request): UploadResource
    {
        $file = $request->file('thumbnail');
        return $this->save('songs/thumbnail', $file);
    }

    public function song(Request $request): UploadResource
    {
        $file = $request->file('song');
        return $this->save('songs', $file);
    }
}
