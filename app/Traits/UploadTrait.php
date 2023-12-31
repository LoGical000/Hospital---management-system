<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function UploadImage(Request $request, $inputname , $foldername , $disk, $imageable_id, $imageable_type) {

        if( $request->hasFile( $inputname ) ) {

            // Check img
            if (!$request->file($inputname)->isValid()) {
                flash('Invalid Image!')->error()->important();
                return redirect()->back()->withInput();
            }

            $photo = $request->file($inputname);
            $name = \Str::slug($request->input('name'));
            $filename = time() . '-' .$name.  '.' . $photo->getClientOriginalExtension();


            // insert Image
            $Image = new Image();
            $Image->filename = $filename;
            $Image->imageable_id = $imageable_id;
            $Image->imageable_type = $imageable_type;
            $Image->save();
            return $request->file($inputname)->storeAs($foldername, $filename, $disk);

        }

        return null;

    }

    public function Delete_file($disk,$path,$filename){

        Storage::disk($disk)->delete($path);
        Image::where('filename',$filename)->delete();

    }

}
