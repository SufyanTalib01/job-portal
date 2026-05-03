<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Psy\Readline\Hoa\Console;

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

    public function createJob()
    {

        $data['categories'] = Category::where('status', 1)->get();
        $data['jobTypes'] = JobType::where('status', 1)->get();
        return view('front.account.job.create', $data);
    }

    public function saveJob(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer|min:1',
            'salary' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'responsibility' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'experience' => 'required|string|in:1,2,3,4,5,6,7,8,9,10,10_plus',
            'keywords' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'company_location' => 'nullable|string|max:255',
            'company_website' => 'nullable|max:255',
        ]);



        if ($validator->passes()) {
            // Save the job to the database
            // ...
            $job = new Job();
            $job->title = $request->title;
            $job->user_id = Auth::id();
            $job->category_id = $request->category_id;
            $job->jobs_type_id = $request->job_type_id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->experience = $request->experience;
            $job->keywords = $request->keywords;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();


            Session::flash('success', 'Job created successfully.');




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

    public function myJobs()
    {
        $id = Auth::user()->id;
        $data['jobs'] = Job::with('category', 'jobType')->where('user_id', $id)->orderBy('created_at', 'asc')->paginate(10);
        return view('front.account.job.my-jobs', $data);
    }

    public function editjob(Request $request, $id)
    {
        $data['job'] = Job::with('category', 'jobType')->where('id', $id)->first();
        $data['categories'] = Category::where('status', 1)->get();
        $data['jobTypes'] = JobType::where('status', 1)->get();
        return view('front.account.job.edit', $data);
    }

    public function updateJob(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer|min:1',
            'salary' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'responsibility' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'experience' => 'required|string|in:1,2,3,4,5,6,7,8,9,10,10_plus',
            'keywords' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'company_location' => 'nullable|string|max:255',
            'company_website' => 'nullable|max:255',
        ]);

        if ($validator->passes()) {
            // Update the job in the database
            $job = Job::findOrFail($id);
            $job->title = $request->title;
            $job->category_id = $request->category_id;
            $job->jobs_type_id = $request->job_type_id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->experience = $request->experience;
            $job->keywords = $request->keywords;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            Session::flash('success', 'Job updated successfully.');

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

    public function deleteJob($id)
    {
        $job = Job::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $job->delete();

        return redirect()->route('account.myJobs')
            ->with('success', 'Job deleted successfully.');
    }
}
