<?php
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 08-09-16
 * Time: 12:37 AM
 */
namespace App\Http\Controllers;
use App\Blasting;
use App\User;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlastingController extends Controller
{

    public function index(Request $request) {
        $user_id = $request->session()->get('logged_in');
        $user = User::find($user_id);
        return view('blasting.index', ['user' => $user]);
    }
}