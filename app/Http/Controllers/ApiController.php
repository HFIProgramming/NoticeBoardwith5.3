<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     *
     */
    public function __construct(){
        //nothing for now :(
    }

    /**
     * Username verification before login.
     * Status 1 found; 0 no found
     * Active 1 already; 0 need further step
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUsername(Request $request){
        return response()->json(User::username($request->username));
    }

}
