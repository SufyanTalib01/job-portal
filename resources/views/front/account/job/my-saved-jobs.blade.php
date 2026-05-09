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
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">

                    @include('front.message')

                    <div class="card border-0 shadow mb-4">
                        <!-- paste here  -->
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">Saved Jobs</h3>
                                </div>


                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @foreach ($savedjobs as $savedjob)
                                            <tr>
                                                <td>
                                                    <div class="job-name fw-500">{{ $savedjob->job->title }}</div>
                                                    <div class="info1">{{ $savedjob->job->jobType->name }} .
                                                        {{ $savedjob->job->location }}
                                                    </div>
                                                </td>
                                                <td>{{ $savedjob->job->applications->count() }}</td>
                                                <td>
                                                    <div class="job-status text-capitalize">
                                                        {{ $savedjob->job->status == 1 ? 'Active' : 'Inactive' }}</div>
                                                </td>
                                                <td>
                                                    <div class="action-dots float-end">
                                                        <a href="#" class="" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('jobDetails', $savedjob->job_id) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                            </li>

                                                            <li>
                                                                <form
                                                                    action="{{ route('account.savedjobdelete', $savedjob->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item"
                                                                        onclick="return confirm('Are you sure want to delete?')">
                                                                        <i class="fa fa-trash"></i> Remove
                                                                    </button>
                                                                </form>

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <div>
                                {{ $savedjobs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('customJs')
@endsection
