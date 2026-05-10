<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $data['jobs'] = Job::orderBy('created_at', 'desc')->with('user')->paginate(10);
        return view('admin.jobs.list', $data);
    }
}
