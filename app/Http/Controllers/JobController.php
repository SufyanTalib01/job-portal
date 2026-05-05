<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $data['categories'] = Category::where('status', 1)->get();
        $data['jobsTypes'] = JobType::where('status', 1)->get();
        $query = Job::with('jobType')->where('status', 1);

        if (filled($request->keywords)) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keywords . '%')
                    ->orWhere('keywords', 'like', '%' . $request->keywords . '%');
            });
        }
        if (filled($request->location)) {
            $query = $query->where('location', 'like', '%' . $request->location . '%');
        }

        if (filled($request->category)) {
            $query = $query->where('category_id', $request->category);
        }

        if (filled($request->jobs_type)) {
            $query = $query->whereIn('jobs_type_id', $request->jobs_type);
        }

        if (filled($request->experience)) {
            $query = $query->where('experience', $request->experience);
        }

        if (filled($request->sort)) {
            if ($request->sort == 'latest') {
                $query = $query->orderBy('created_at', 'desc');
            }

            if ($request->sort == 'oldest') {
                $query = $query->orderBy('created_at', 'asc');
            }
        } else {
            $query = $query->orderBy('created_at', 'desc');
        }

        $data['jobs'] = $query->paginate(9);

        return view('front.jobs', $data);
    }
}
