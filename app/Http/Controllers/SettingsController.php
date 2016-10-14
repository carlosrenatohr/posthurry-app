<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class SettingsController extends Controller {

    public function getIndex() {
        return view( 'settings/forms', [ 'user' => Auth::user() ] );
    }

    public function postIndex( Request $request ) {
        User::where( 'id', Auth::user()->id )->update( [ 'timezones' => $request->get( 'timezones' ) ] );

        return redirect( url( 'settings' ) );
    }
}
