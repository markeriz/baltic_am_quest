<header class="mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between">
            <a href="{{ route('address_books.index') }}" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                <i class="bi bi-journal-bookmark h2 mb-1"></i>
                <span class="px-2">Address book task</span>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ route('address_books.index') }}" class="nav-link px-2">{{ __('List') }}</a></li>
                <li><a href="{{ route('address_book_shares.index') }}" class="nav-link px-2">{{ __('Shares') }}</a></li>
            </ul>

            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-lines-fill text-danger"></i>
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">{{ __('profile') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

