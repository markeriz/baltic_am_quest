@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title m-0 float-start align-self-center">{{ __('Shares with you') }}</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Full name') }}</th>
                    <th>{{ __('Telephone') }}</th>
                    <th>{{ __('Shared by') }}</th>
                    <th class="text-end">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shares_with_user as $share)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $share->address_book->full_name }}</td>
                        <td>{{ $share->address_book->telephone }}</td>
                        <td>{{ $share->user->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('address_book_shares.delete', $share->id) }}" class="btn btn-danger btn-sm p-0 px-4" title="Cancel share"
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
                        <td colspan="5">{{ __('No data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
