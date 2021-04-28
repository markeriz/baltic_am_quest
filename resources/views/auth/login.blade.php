@extends('layout.app')

@section('content')
<div class="container display-relative">
    <div class="position-absolute top-50 start-50 translate-middle bg-color-100 w-25 border">
        <form action="{{ route('check') }}" method="post" class="w-100 p-5">
            <h4 class="text-uppercase text-center pb-4">{{ __('Login form') }}</h4>
            @csrf
            <div class="col-12 mb-2">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-12">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary text-capitalize">{{ __('Login') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
