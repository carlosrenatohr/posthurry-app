<?php
namespace App\Http\Controllers;
class AccessController extends Controller
{

    public function index()
    {
        return view('layouts.main-page', ['withoutHeader' => true]);
    }

}