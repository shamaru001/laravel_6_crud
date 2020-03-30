<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{

    /**
     * Get new authentication token.
     *
     * @param Request $request
     * @return Response
     */
    public function getToken(Request $request)
    {
        $user = User::where('email', $request->get('email'))->take(1)->first();
        $password = (!empty($user))? Hash::make($request->password) : "";
        if (!empty($user) && Hash::check($user->getAuthPassword(), $password)) {
            $token = Str::random(80);
            $user->update([
                'api_token' => hash('sha256', $token),
            ]);
            return response([
                'token' => hash('sha256', $token),
                'type'=> 'Bearer',
            ], 200);
        } else  {
            return response([
                'message'=> 'invalid data'
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
