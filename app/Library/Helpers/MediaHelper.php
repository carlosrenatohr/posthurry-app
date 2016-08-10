<?php

namespace App\Library\Helpers;
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 08-10-16
 * Time: 10:37 AM
 */
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MediaHelper
{
    public static function upload($image) {
        $validate = Validator::make(['image' => $image], ['image' => 'required']);
        if(!$validate->fails() ) {
            if($image->isValid()) {
                try {
                    $destinationPath = public_path('uploads');
                    $extension = $image->getClientOriginalExtension(); // getting image extension
                    $fileName = time().'_'.md5($image->getClientOriginalName()).'.'.$extension; // renameing image
                    $file = $image->move($destinationPath, $fileName); // uploading file to given path
                    return $file;
                } catch(\Exception $e) {
                    dd($e);
                }
            }
        }
        else {
            dd('something is validating an image');
        }
    }

    public static function comparisonIsExpired($date, $minutes) {
        $limit = new Carbon($date);
//        $expiration = $limit->addDays($days);
        $expiration = $limit->addMinutes($minutes);
//        $expiration->hour(0);
//        $expiration->minute(0);
//        $expiration->minute($days);
        $now = Carbon::now();

        return $now->gt($expiration);
    }

}