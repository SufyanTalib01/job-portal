@extends('front.layouts.app')
{{-- @include('front.message') --}}

@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="jobs.html"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <div class="container job_details_area">

            @include('front.message')

            @if (!empty($jobDetail))
                <div class="row pb-5">
                    <div class="col-md-8">
                        <div class="card shadow border-0">
                            <div class="job_details_header">
                                <div class="single_jobs white-bg d-flex justify-content-between">
                                    <div class="jobs_left d-flex align-items-center">
                                        <div class="jobs_conetent">
                                            <a href="#">
                                                <h4>{{ $jobDetail->title }}</h4>
                                            </a>
                                            <div class="links_locat d-flex align-items-center">
                                                <div class="location">
                                                    <p> <i class="fa fa-map-marker"></i> {{ $jobDetail->location }}</p>
                                                </div>
                                                <div class="location">
                                                    <p> <i class="fa fa-clock-o"></i>
                                                        {{ $jobDetail->jobType->name ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jobs_right">
                                        <div class="apply_now">
                                            <a class="heart_mark {{ Auth::check() && $hasSaved ? 'saved-job' : '' }}"
                                                href="javascript:void(0)" onclick="savedjob({{ $jobDetail->id }})"> <i
                                                    class="fa fa-heart{{ Auth::check() && $hasSaved ? '' : '-o' }}"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="descript_wrap white-bg">
                                @if ($jobDetail->description)
                                    <div class="single_wrap">
                                        <h4>Job description</h4>
                                        {!! nl2br($jobDetail->description) !!}

                                    </div>
                                @endif
                                @if ($jobDetail->responsibility)
                                    <div class="single_wrap">
                                        <h4>Responsibility</h4>
                                        {!! nl2br($jobDetail->responsibility) !!}
                                    </div>
                                @endif
                                @if ($jobDetail->qualifications)
                                    <div class="single_wrap">
                                        <h4>Qualifications</h4>
                                        {!! nl2br($jobDetail->qualifications) !!}
                                    </div>
                                @endif
                                @if ($jobDetail->benefits)
                                    <div class="single_wrap">
                                        <h4>Benefits</h4>
                                        {!! nl2br($jobDetail->benefits) !!}
                                    </div>
                                @endif
                                <div class="border-bottom"></div>
                                <div class="pt-3 text-end">
                                    @if (Auth::check())
                                        @if ($hasSaved)
                                            <button class="btn btn-success" disabled>
                                                <i class="fa fa-check"></i> Saved
                                            </button>
                                        @else
                                            <a href="#"
                                                onclick="event.preventDefault(); savedjob({{ $jobDetail->id }})"
                                                class="btn btn-primary">Save</a>
                                        @endif
                                    @else
                                        <a href="#" onclick="event.preventDefault()"
                                            class="btn btn-primary disable">Login
                                            to Save</a>
                                    @endif

                                    @if (Auth::check())
                                        @if ($hasApplied)
                                            <button class="btn btn-success" disabled>
                                                <i class="fa fa-check"></i> Applied
                                            </button>
                                        @else
                                            <a href="#"
                                                onclick="event.preventDefault(); applyJob({{ $jobDetail->id }})"
                                                class="btn btn-primary">Apply</a>
                                        @endif
                                    @else
                                        <a href="#" onclick="event.preventDefault()"
                                            class="btn btn-primary disable">Login
                                            to Apply</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        @if (Auth::check() && Auth::user()->id == $jobDetail->user_id)
                            <div class="card shadow border-0 mt-4">
                                <div class="job_details_header">
                                    <div class="single_jobs white-bg d-flex justify-content-between">
                                        <div class="jobs_left d-flex align-items-center">
                                            <div class="jobs_conetent">
                                                <h4>Applications</h4>

                                            </div>
                                        </div>
                                        <div class="jobs_right">

                                        </div>
                                    </div>
                                </div>
                                <div class="descript_wrap white-bg">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Applied At</th>
                                        </tr>
                                        @if ($applications->isNotEmpty())
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td>{{ $application->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $application->user->email ?? 'N/A' }}</td>
                                                    <td>{{ $application->user->mobile ?? 'N/A' }}</td>
                                                    <td>{{ $application->applied_at->format('d M Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">No applications found.</td>
                                            </tr>
                                        @endif
                                    </table>
                                    <div class="pt-3 text-end">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow border-0">
                            <div class="job_sumary">
                                <div class="summery_header pb-1 pt-4">
                                    <h3>Job Summery</h3>
                                </div>
                                <div class="job_content pt-3">
                                    <ul>
                                        <li>Published on: <span>{{ $jobDetail->created_at->format('d M Y') }}</span></li>
                                        <li>Vacancy: <span>{{ $jobDetail->vacancy . 'Position' ?? 'N/A' }} </span></li>
                                        <li>Salary: <span>{{ $jobDetail->salary ?? 'N/A' }}</span></li>
                                        <li>Location: <span>{{ $jobDetail->location ?? 'N/A' }}</span></li>
                                        <li>Job Nature: <span> {{ $jobDetail->JobType->name ?? 'N/A' }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow border-0 my-4">
                            <div class="job_sumary">
                                <div class="summery_header pb-1 pt-4">
                                    <h3>Company Details</h3>
                                </div>
                                <div class="job_content pt-3">
                                    <ul>
                                        <li>Name: <span>{{ $jobDetail->company_name ?? 'N/A' }}</span></li>
                                        <li>Location: <span>{{ $jobDetail->company_location ?? 'N/A' }}</span></li>
                                        <li>Website: <span>{{ $jobDetail->company_website ?? 'N/A' }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        function applyJob(id) {
            if (confirm('Are you sure you want to apply for this job?')) {
                $.ajax({
                    url: '{{ route('account.applyJob') }}',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            }
        }


        // saved job 
        function savedjob(id) {
            if (confirm('Are you sure you want to save this job?')) {
                $.ajax({
                    url: '{{ route('account.savedJob') }}',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            }
        }
    </script>
@endsection
