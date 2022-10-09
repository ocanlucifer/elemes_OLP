<?php

namespace App\Http\Controllers;

use App\Models\UserPictureProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\CloudinaryStorage;
use App\Http\Requests\PostPictureRequest;
use App\Http\Resources\UserPictureProfileResource;

class UserPictureProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = auth()->user()->id;
        $user_pp = UserPictureProfile::where('user_id', $userid)->first();
        if ($user_pp) {
            return $this->sendResponse(new UserPictureProfileResource($user_pp), 'User Picture Profile Retrieve Successfully');
        }
        return $this->sendError('profile picture not found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostPictureRequest $request)
    {
        $image  = $request->file('image');
        $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
        $user_pp = UserPictureProfile::create([
            'image' => $result,
            'user_id' => auth()->user()->id,
        ]);
        if ($user_pp) {
            return $this->sendResponse(new UserPictureProfileResource($user_pp), 'profile picture saved', 201);
        }
        return $this->sendError('profile picture save failed', $user_pp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPictureProfile  $userPictureProfile
     * @return \Illuminate\Http\Response
     */
    public function update(PostPictureRequest $request, $id)
    {
        $userid = auth()->user()->id;
        $file   = $request->file('image');
        $image = UserPictureProfile::where('id', $id)->where('user_id', $userid)->first();
        if ($image) {
            $result = CloudinaryStorage::replace($image->image, $file->getRealPath(), $file->getClientOriginalName());
            $image->update([
                'image'     => $result,
                'user_id'   => $userid
            ]);
            return $this->sendResponse(new UserPictureProfileResource($image), 'profile picture updated');
        }
        return $this->sendError('profile picture not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPictureProfile  $userPictureProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = UserPictureProfile::find($id);
        if ($image) {
            CloudinaryStorage::delete($image->image);
            $image->delete();
            return $this->sendResponse(new UserPictureProfileResource($image), 'profile picture deleted');
        }
        return $this->sendError('profile picture not found');
    }
}
