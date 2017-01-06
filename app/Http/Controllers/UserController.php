<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //This controller closely related with user profile

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('active');
    }

}
