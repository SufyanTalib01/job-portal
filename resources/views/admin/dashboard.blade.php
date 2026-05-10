@extends('front.layouts.app')
{{-- S  --}}
{{-- S  --}}
@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body text-center py-5">
                            <h2 class="card-title fw-bold mb-3">Admin Dashboard</h2>

                            <p class="card-text text-muted fs-5">
                                Welcome to the admin dashboard! Here you can manage users,
                                monitor activities, and control system operations efficiently.
                            </p>
                        </div>
                    </div>

                </div>
    </section>
@endsection

@section('customJs')
@endsection
