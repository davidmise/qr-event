<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ResetPassword;
use App\Http\Requests\ForgotPasswordRequest; // Correct the namespace and class
use App\Http\Requests\ResetPasswordRequest; // Correct the namespace and class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Notifications\PasswordResetNotification;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:255|string',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            /** @var  **/
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials, user login failed.',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }

    /**
      * @param ForgotPasswordRequest $request
      * @return JsonResponse
      * @throws ValidationException
      *
      **/
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        // if user does not exist, throw error
        if (!$user || !$user->email) {
            return response()->json([
                'status' => 'No user Found',
                'message' => 'Incorrect Email Address'
            ], 400);
        }

        // Generate 4 digit random token
        $resetPasswordToken = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);

        // In case user has already created forgot password, do not create another record
        // instead update existing token with new one
        if (!$userPassReset = ResetPassword::where('email', $user->email)->first()) {
            // Store Token to the db with expiration time i.e 1hr
            ResetPassword::create([
                'email' => $user->email,
                'token' => $resetPasswordToken,
            ]);
        } else {
            // Store Token to the db with expiration time i.e 1hr
            $userPassReset->update([
                'email' => $user->email,
                'token' => $resetPasswordToken,
            ]);
        }

        // Send notification to the user about the reset token
        $user->notify(
            new PasswordResetNotification(
                $user,
                $resetPasswordToken
            )
        );

        return new JsonResponse(['message' => 'A Code has been Sent to your Email Address.']);
    }

    /**
      * @param ResetPasswordRequest $request
      * @return JsonResponse
      * @throws ValidationException
      *
      **/
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        // Validate the request
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        // throw exception if user is not found
        if (!$user) {
            return response()->json([
                'status' => 'No user Found',
                'message' => 'Incorrect Email Address'
            ], 404);
        }

        $resetRequest = ResetPassword::where('email', $user->email)->first();

        if (!$resetRequest || $resetRequest->token != $attributes['token']) {
            return response()->json([
                'status' => 'An Error occurred',
                'message' => 'Token Mismatch'
            ], 400);
        }

        // Update User's Password
        $user->fill([
            'password' => Hash::make($attributes['password']),
        ]);
        $user->save();

        // Delete previous token
        $user->tokens()->delete();
        $resetRequest->delete();

        // Get token for authenticated user
        $token = $user->createToken('authToken')->plainTextToken;

        // create a response
        $loggingResponse = [
            'user' => UserResource::make($user),
            'token' => $token
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Password Reset Success',
            'data' => $loggingResponse
        ], 201);
    }
}
