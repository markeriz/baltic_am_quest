@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title m-0 float-start align-self-center">{{ __('Choose user to share') }}</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Full name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-end">
                            <a href="{{ route('address_book_shares.store', [request()->route('address_book'), $user->id]) }}" class="btn btn-success btn-sm p-0 px-4"
                                onclick="event.preventDefault();
                                    document.getElementById('destroy-ID{{ $user->id }}').submit();">
                                <i class="bi bi-share"></i>
                            </a>
                            <form id="destroy-ID{{ $user->id }}" action="{{ route('address_book_shares.store', [request()->route('address_book'), $user->id]) }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">{{ __('no data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
