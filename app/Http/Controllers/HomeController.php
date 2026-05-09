<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::withCount(['jobs' => function ($query) {
            $query->where('status', 1);
        }])
            ->orderBy('name', 'asc')
            ->take(8)
            ->get();
        $data['isfeaturedjobs'] = Job::with('jobType')->where('is_featured', 1)->orderBy('created_at', 'desc')->take(6)->get();
        $data['latestjobs'] = Job::with('jobType')->orderBy('created_at', 'desc')->take(6)->get();
        return view('front.home', $data);
    }
}
