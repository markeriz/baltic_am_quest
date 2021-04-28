@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mt-1">{{ __('Edit address book') }}</h5>
    </div>
    <form action="{{ route('address_books.update', $address_book->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="first_name" class="form-label">{{ __('First name') }}</label>
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') ?? $address_book->first_name }}">
                    </div>
                    <div class="col">
                        <label for="last_name" class="form-label">{{ __('Last name') }}</label>
                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') ?? $address_book->last_name }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">{{ __('Telephone') }}</label>
                <input type="text" class="form-control" name="telephone" value="{{ old('telephone') ?? $address_book->telephone }}">
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-success btn-sm px-5">{{ __('Update') }}</button>
        </div>
    </form>
</div>
@endsection
