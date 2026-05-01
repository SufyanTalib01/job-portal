@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show mx-3 mt-2" role="alert">
        {{ Session::get('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-2 mt-2" role="alert">
        {{ Session::get('error') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
