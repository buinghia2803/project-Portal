<?php

namespace App\Http\Controllers\Api\V1\Auth;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{
    public function signup(Request $request){
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|string|unique:members',
            'password' => 'required|string|confirmed'
        ]);

        $user = new Member([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_by' => 1
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created Member!'
        ], 201);
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user()
    {

    try {
        $user = Member::with('roles:title,id')->select(['id', 'full_name', 'email', 'nick_name', 'member_code'])->find(Auth::user()->id);

        $data = [];

        if ($user) {
            $data['id'] = $user['id'];
            $data['full_name'] = $user['full_name'];
            $data['email'] = $user['email'];
            $data['nick_name'] = $user['nick_name'];
            $data['member_code'] = $user['member_code'];
            $data['avatar'] = isset($user->avatar->thumbnail) ? $user->avatar->thumbnail : url('storage/avatars/relipa.jpeg');
            $data['roles'] = $user['roles']->map(function ($role) {
                return collect($role)->only(['id', 'title'])->all();
            });
        }

        return response()->json($data, 200);

        } catch (NotFoundHttpException $exception) {
            return response()->json(["error" => $exception], 401);
        }
    }
}