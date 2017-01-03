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
        $name = $request->name;
        $search = 'name';
        if (is_numeric($name)) {
            $search = 'phone_number';
        } elseif (filter_var($request->name, FILTER_VALIDATE_EMAIL)) {
            $search = 'email';
        }
        if($user = User::where($search,$name)->firstorfail()) {
            $result['status'] = 1;
            $result['active'] = $user->active;
        }else{
            $result['status'] = 0;
        }
            return response()->json($result);
    }

}
