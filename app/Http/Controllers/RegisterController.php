<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class RegisterController extends Controller
{
    protected $uploadApi;

    public function __construct()
    {
        // Configure Cloudinary
        Configuration::instance(env('CLOUDINARY_URL'));

        // Instantiate UploadApi
        $this->uploadApi = new UploadApi();
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Upload to Cloudinary
            $uploadedFile = $request->file('profile_picture');
            $uploadResult = $this->uploadApi->upload($uploadedFile->getRealPath(), [
                'folder' => 'profiles',
                'resource_type' => 'image',
                'transformation' => [
                    ['width' => 300, 'height' => 300, 'crop' => 'fill'],
                ],
            ]);

            // Get the public_id (path)
            $cloudinaryPath = $uploadResult['public_id'];

            // Create user
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile_picture' => $uploadResult['secure_url'],
            ]);

            // Log in user
            auth()->login($user);

            return redirect('/dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            \Log::error('Cloudinary upload failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['profile_picture' => 'Failed to upload image: ' . $e->getMessage()])
                ->withInput();
        }
    }
}