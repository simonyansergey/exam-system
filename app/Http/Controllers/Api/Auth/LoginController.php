<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Log in a user
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $data = $request->validate([
            'email' => ['required', Rule::exists('users', 'email')],
            'password' => ['required']
        ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(
                ['message' => 'Wrong credentials!'],
                Response::HTTP_FORBIDDEN
            );
        }

        $user = User::where('email', $data['email'])->first();

        return response()->json(
            ['token' => $user->createToken('Api token')->plainTextToken],
            Response::HTTP_OK
        );
    }
}
