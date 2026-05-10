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
                            <li class="breadcrumb-item active">User Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4">

                        @include('front.message')


                        <form action="{{ route('admin.userupdate', $user->id) }}" method="post" name="userForm"
                            id="userForm">
                            @csrf
                            @method('put')
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">User Profile</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name*</label>
                                    <input type="text" id="name" name="name" placeholder="Enter Name"
                                        class="form-control" value="{{ $user->name ?? '' }}">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" id="email" name="email" placeholder="Enter Email"
                                        class="form-control" value="{{ $user->email ?? '' }}">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation</label>
                                    <input type="text" id="designation" name="designation" placeholder="Designation"
                                        class="form-control" value="{{ $user->designation ?? '' }}">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile</label>
                                    <input type="text" id="mobile" name="mobile" placeholder="Mobile"
                                        class="form-control" value="{{ $user->mobile ?? '' }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        $('#userForm').submit(function(e) {
            e.preventDefault();

            $('.form-control').removeClass('is-invalid');
            $('.text-danger').html('');

            $.ajax({
                url: '{{ route('admin.userupdate', $user->id) }}',
                type: 'POST',
                data: $('#userForm').serialize(),
                dataType: 'json',



                success: function(response) {

                    if (response.status == true) {
                        window.location.href = '{{ route('admin.users') }}';
                    }

                    if (response.status == false) {
                        errors = response.errors;
                        if (errors.name) {
                            $('#name')
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.name);
                        }

                        if (errors.email) {
                            $('#email')
                                .addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.email);
                        }

                        if (errors.designation) {
                            $('#designation').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.designation);
                        }

                        if (errors.mobile) {
                            $('#mobile').addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.mobile);
                        }

                    }
                },
            });
        })
    </script>
@endsection
