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
                                            <a class="heart_mark" href="#"> <i class="fa fa-heart-o"
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
                                    <a href="#" class="btn btn-secondary">Save</a>
                                    @if (Auth::check())
                                        <a href="" onclick="applyJob({{ $jobDetail->id }})"
                                            class="btn btn-primary">Apply</a>
                                    @else
                                        <a href="#" onclick="event.preventDefault()"
                                            class="btn btn-primary disable">Login
                                            to Apply</a>
                                    @endif

                                </div>
                            </div>
                        </div>
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
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {},

                });
            }
        }
    </script>
@endsection
