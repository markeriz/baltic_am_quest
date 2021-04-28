@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title m-0 float-start align-self-center">{{ __('Address books') }}</h5>
        <a class="btn btn-success btn-sm px-5" href="{{ route('address_books.create') }}" title="New address book">{{ __('New') }}</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-sm mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Full name') }}</th>
                    <th>{{ __('Telephone') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($address_books as $address_book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $address_book->full_name }}</td>
                        <td>{{ $address_book->telephone }}</td>
                        <td class="text-end">
                            <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                <i class="bi bi-menu-up"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('address_books.show', $address_book->id) }}">{{ __('Show') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('address_books.edit', $address_book->id) }}">{{ __('Edit') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('address_book_shares.show_users', $address_book->id) }}">{{ __('Share with') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a href="{{ route('address_books.destroy', $address_book->id) }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                            document.getElementById('destroy-ID{{ $address_book->id }}').submit();">
                                        {{ __('Delete') }}
                                    </a>
                                    <form id="destroy-ID{{ $address_book->id }}" action="{{ route('address_books.destroy', $address_book->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">{{ __('No data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
