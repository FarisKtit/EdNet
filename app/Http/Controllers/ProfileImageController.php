<?php

namespace App\Http\Controllers;

use App\ProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



class ProfileImageController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.profile.user_profile_img', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Make sure file to upload is an image of any of the extensions jpeg,png,jpg,gif,svg and not more than 2MB
        $request->validate([
          'profile-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('profile-image');



        //Create path with filename as randome hash
        $path = $file->hashName('profile_images/user_storage_' . Auth::user()->id);

        $thumbnail_path = $file->hashName('profile_images/user_storage_' . Auth::user()->id . '/thumbnail');

        $user = Auth::user();

        //Delete old profile picture if it exists
        $path_to_delete = storage_path('app/public/' . $user->profile_image_filename);
        $thumbnail_path_to_delete = storage_path('app/public/' . $user->profile_image_thumbnail_filename);

        if(!empty($user->profile_image_filename) && file_exists($path_to_delete)) {
          unlink($path_to_delete);
        }
        if(!empty($user->profile_image_thumbnail_filename) && file_exists($thumbnail_path_to_delete)) {
          unlink($thumbnail_path_to_delete);
        }

        //Save new path to profile picture
        $user->profile_image_filename = $path;
        $user->profile_image_thumbnail_filename = $thumbnail_path;
        $user->save();

        //Use Image/Intervention for image manipulation
        $image = Image::make($file);

        $thumbnail_image = Image::make($file);
        $crop_st_x = intval($request->get('x1'));
        $crop_st_y = intval($request->get('y1'));
        $crop_w = intval($request->get('w'));
        $crop_h = intval($request->get('h'));

        //Check if image needs cropping, if so crop
        if($crop_w != null && $crop_w != 0 && $crop_h != null && $crop_h != 0) {
          $image = $image->crop($crop_w, $crop_h, $crop_st_x, $crop_st_y);
          $thumbnail_image = $thumbnail_image->crop($crop_w, $crop_h, $crop_st_x, $crop_st_y);
        }

        $image = $image->resize(null, 250, function($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        });

        $thumbnail_image = $thumbnail_image->resize(null, 50, function($constraint) {
          $constraint->aspectRatio();
          $constraint->upsize();
        });

        //Store image and redirect

        Storage::put($path, (string) $image->encode(), 'public');

        Storage::put($thumbnail_path, (string) $thumbnail_image->encode(), 'public');

        return redirect()->back()->with('success', 'Successfully updated your profile picture.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProfileImage  $profileImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProfileImage $profileImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProfileImage  $profileImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfileImage $profileImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProfileImage  $profileImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfileImage $profileImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProfileImage  $profileImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfileImage $profileImage)
    {
        //
    }
}
