<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use App\Http\Requests\Open\AuthRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function logout(Request $request){
        if($request->user() !== null){
            $request->user()->currentAccessToken()->delete();
        }

        $this->response['status'] = 'OK';
    }

    public function login(AuthRequest $request): Response|JsonResponse|Application|ResponseFactory
    {
        $user = User::query()->where('email', $request['email'])->get()->first();

        if(!Hash::check($request['password'], $user->password)){
            $this->response['message'] = 'Неверный email или пароль';
            return response()->json($this->response, 422);
        }

        if(Hash::needsRehash($user->password)){
            $user->password = Hash::make($request['password']);
        }

        return $this->respondWithToken($user);
    }

    private function respondWithToken(User $user): Response|Application|ResponseFactory
    {
        $token = $user->createToken(hash("sha256", openssl_random_pseudo_bytes(64)));
        $this->response['data'] = [
            'type' => 'Bearer',
            'token' => $token->plainTextToken
        ];
        return response($this->response);
    }
}
