@extends('front.layouts.app')
@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">

                @include('front.message')

                <section class="section-3 py-5 bg-2 ">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-md-10 ">
                                <h2>Find Jobs</h2>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="align-end">
                                    <form action="{{ route('jobs') }}" method="GET">
                                        <select name="sort" id="sort" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Latest
                                            </option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                                Oldest
                                            </option>
                                        </select>

                                </div>
                            </div>
                        </div>

                        <div class="row pt-5">
                            <div class="col-md-4 col-lg-3 sidebar mb-4">

                                <form action="{{ route('jobs') }}" method="GET">
                                    <div class="card border-0 shadow p-4">
                                        <div class="mb-4">
                                            <h2>Keywords</h2>
                                            <input type="text" name="keywords" placeholder="Keywords"
                                                class="form-control" value="{{ request('keywords') }}">
                                        </div>

                                        <div class="mb-4">
                                            <h2>Location</h2>
                                            <input type="text" name="location" placeholder="Location"
                                                class="form-control" value="{{ request('location') }}">
                                        </div>

                                        <div class="mb-4">
                                            <h2>Category</h2>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">Select a Category</option>
                                                @foreach ($categories as $category)
                                                    <option {{ request('category') == $category->id ? 'selected' : '' }}
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <div class="mb-4">
                                            <h2>Job Type</h2>
                                            @foreach ($jobsTypes as $jobType)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input " name="jobs_type[]" type="checkbox"
                                                        value="{{ $jobType->id }}" id="{{ $jobType->id }}"
                                                        {{ in_array($jobType->id, request('jobs_type', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label "
                                                        for="{{ $jobType->id }}">{{ $jobType->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mb-4">
                                            <h2>Experience</h2>
                                            <select name="experience" id="experience" class="form-control">
                                                <option value="">Select Experience</option>
                                                <option {{ request('experience') == '1' ? 'selected' : '' }}
                                                    value="1">
                                                    1 Year</option>
                                                <option {{ request('experience') == '2' ? 'selected' : '' }}
                                                    value="2">2
                                                    Years</option>
                                                <option {{ request('experience') == '3' ? 'selected' : '' }}
                                                    value="3">3
                                                    Years</option>
                                                <option {{ request('experience') == '4' ? 'selected' : '' }}
                                                    value="4">4
                                                    Years</option>
                                                <option {{ request('experience') == '5' ? 'selected' : '' }}
                                                    value="5">5
                                                    Years</option>
                                                <option {{ request('experience') == '6' ? 'selected' : '' }}
                                                    value="6">6
                                                    Years</option>
                                                <option {{ request('experience') == '7' ? 'selected' : '' }}
                                                    value="7">7
                                                    Years</option>
                                                <option {{ request('experience') == '8' ? 'selected' : '' }}
                                                    value="8">8
                                                    Years</option>
                                                <option {{ request('experience') == '9' ? 'selected' : '' }}
                                                    value="9">9
                                                    Years</option>
                                                <option {{ request('experience') == '10' ? 'selected' : '' }}
                                                    value="10">10
                                                    Years</option>
                                                <option {{ request('experience') == '10_plus' ? 'selected' : '' }}
                                                    value="10_plus">10+ Years</option>
                                            </select>
                                        </div>
                                        <div class="d-grid mt-3">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                Filter Jobs
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 col-lg-9 ">
                                <div class="job_listing_area">
                                    <div class="job_lists">
                                        <div class="row g-4">
                                            @if ($jobs->isNotEmpty())
                                                @foreach ($jobs as $job)
                                                    <div class="col-md-4 d-flex">
                                                        <div class="card border-0 p-3 shadow mb-4 w-100 h-100">
                                                            <div class="card-body d-flex flex-column">

                                                                <h3 class="border-0 fs-5 pb-2 mb-0 text-truncate">
                                                                    {{ $job->title }}
                                                                </h3>

                                                                <p>
                                                                    {{ Str::words($job->description, 10, '...') }}
                                                                </p>

                                                                <div
                                                                    class="bg-light p-3 border flex-grow-1 d-flex flex-column justify-content-center">
                                                                    <p class="mb-0">
                                                                        <span class="fw-bolder"><i
                                                                                class="fa fa-map-marker"></i></span>
                                                                        <span class="ps-1">{{ $job->location }}</span>
                                                                    </p>

                                                                    <p class="mb-0">
                                                                        <span class="fw-bolder"><i
                                                                                class="fa fa-clock-o"></i></span>
                                                                        <span
                                                                            class="ps-1">{{ $job->jobType->name }}</span>
                                                                    </p>


                                                                    <p class="mb-0">
                                                                        <span class="fw-bolder"><i
                                                                                class="fa fa-usd"></i></span>
                                                                        <span
                                                                            class="ps-1">{{ $job->salary ?? 'Not Specified' }}</span>
                                                                    </p>

                                                                </div>

                                                                <div class="d-grid mt-3">
                                                                    <a href="{{ route('jobDetails', $job->id) }}"
                                                                        class="btn btn-primary btn-lg">Details</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12 text-center py-5">
                                                    <h4 class="text-muted">No jobs found</h4>
                                                    <p>Try changing your filters or search keywords</p>
                                                </div>
                                            @endif



                                        </div>
                                        <div class="mt-3">
                                            {{ $jobs->links('pagination::bootstrap-5') }}
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>


            </div>
    </section>
@endsection

@section('customJs')
@endsection
