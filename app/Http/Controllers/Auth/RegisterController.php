<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'user_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'required|numeric|digits_between:10,11|unique:users,phone_number',
            'pass' => 'required|min:6|same:cpass',
            'cpass' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->input('name'),
            'user_name' => $request->input('user_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('pass')),
        ]);

        Log::info('User created', $user->toArray());

        // Redirect with success message
        return response()->json([
            'message' => 'Registration successful! Please log in.'
        ], 200);
    }
}
