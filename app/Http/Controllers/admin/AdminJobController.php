<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function index()
    {
        $data['jobs'] = Job::orderBy('created_at', 'desc')->with('user', 'applications')->paginate(10);
        return view('admin.jobs.list', $data);
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $data['job'] = Job::with('jobType', 'category')->where('id', $job->id)->first();
        $data['jobTypes'] = JobType::all();
        $data['categories'] = Category::all();
        return view('admin.jobs.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

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
            $job->is_featured = $request->has('is_featured') ? '1' : '0';
            $job->status = $request->status;
            $job->save();

            session()->flash('success', 'Job updated successfully.');

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
