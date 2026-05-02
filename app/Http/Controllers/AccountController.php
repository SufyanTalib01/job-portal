<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AccountController extends Controller
{
    public function register()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5|same:password_confirmation',
            'password_confirmation' => 'required|string|min:5',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            Session::flash('success', 'Registration successful. You can now login.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function profile()
    {
        return view('front.account.profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You have been logged out successfully.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user,
            'designation' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
        ]);

        if ($validator->passes()) {
            $user = User::find($user);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            Session::flash('success', 'Profile updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function updateProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->passes()) {

            $id = Auth::user()->id;
            $user = User::find($id);

            File::delete(public_path('profile-pictures/' . $user->image));
            File::delete(public_path('profile-pictures/thumb/' . $user->image));


            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = $id . '-' . time() . '.' . $ext;
            $image->move(public_path('profile-pictures/'), $imageName);


            $user->image = $imageName;
            $user->save();

            // create new image instance (800 x 600)
            $sourcePath = public_path('profile-pictures/' . $imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);


            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path('profile-pictures/thumb/' . $imageName));


            Session::flash('success', 'Profile picture updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
