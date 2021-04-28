@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title m-0 float-start align-self-center">{{ __('Showing address book') }}</h5>
        <a class="btn btn-warning btn-sm px-5" href="{{ route('address_books.edit', $address_book->id) }}">{{ __('Edit') }}</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="row g-0 border">
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-end text-primary">
                        <i class="bi bi-person h1"></i>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $address_book->full_name }}</h5>
                            <p class="card-text">{{ $address_book->telephone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title m-0 float-start align-self-center">{{ __('Sharing address book with') }}</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-response">
                            <table class="table table-striped table-hover table-sm m-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th class="text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($address_book->address_book_shares as $share)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $share->user->name }}</td>
                                            <td>{{ $share->user->email }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('address_book_shares.delete', $share->id) }}" class="btn btn-danger btn-sm p-0 px-4"
                                                    onclick="event.preventDefault();
                                                        document.getElementById('destroy-ID{{ $share->id }}').submit();">
                                                    <i class="bi bi-backspace-reverse"></i>
                                                </a>
                                                <form id="destroy-ID{{ $share->id }}" action="{{ route('address_book_shares.delete', $share->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">{{ __('No shares') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
