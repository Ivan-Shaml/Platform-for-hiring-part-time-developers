<?php

namespace App\Services;

use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;
use App\Models\Hire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class DeveloperService {


    public static function getDeveloper() {
        return Developer::all();
    }

    public static function handleData($developer, $data) {
        self::handleUploadedImage('profile_picture', $developer);
        $developer->name=$data['name'];
        $developer->email=$data['email'];
        $developer->phone=$data['phone'];
        $developer->location=$data['location'];
//        $developer->profile_picture=$data['profile_picture'];
        $developer->price_per_hour=$data['price_per_hour'];
        $developer->technology=$data['technology'];
        $developer->description=$data['description'];
        $developer->years_of_experience=$data['years_of_experience'];
        $developer->native_language=$data['native_language'];
        $developer->linkedin_profile_link=$data['linkedin_profile_link'];
        $developer->save();
    }

    public static function createDeveloper($data) {
        $developer = new Developer();
        self::handleData($developer, $data);
    }

    public static function updateDeveloper($id, $data) {
        $developer = Developer::find($id);

        $hire = Hire::where('developer_id', $id)->get();
        foreach($hire as $single_hire) {
            $single_hire->names = request()->get('name', 'No Data');
            $single_hire->save();
        }
        self::handleData($developer, $data);
//        $developer->update();
        $developer->hires()->associate($hire);
    }

    public static function handleUploadedImage($image, $data_from): void
    {
        if (!is_null($image)) {
            if(request()->has($image)){
                Storage::disk('public')->delete('developer/'.$data_from[$image]);
                $imageName = time().'.'.request()->file($image);
                request()->file('profile_picture')->storeAs('public/developer', $imageName);
                $data_from->profile_picture = $imageName;
            }
        }
    }

    public static function deleteDeveloper($id) {
        $developers = Developer::find($id);
        Storage::disk('public')->delete('developer/'.$developers->profile_picture);
        $developers->delete();
    }

}
