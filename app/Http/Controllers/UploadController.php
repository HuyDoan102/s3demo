<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadS3(Request $request)
    {
        $temp = "";
        if($request->hasFile('profile_image')) {
            $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $filenametostore = $filename . '_' . time() . '.' . $extension;
//             dd($filenametostore);
            Storage::disk('s3')->put($filenametostore, fopen($request->file('profile_image'), 'r+'), 'public');
        }
        $temp_images = Storage::disk('s3')->files();
        return view('s3', compact('temp_images'));
    }
}
