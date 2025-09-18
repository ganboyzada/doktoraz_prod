<nav class="inno-nav mb-3">
    <button data-toggle="#inno_sidebar" class="d-sm-none me-3 btn btn-sm btn-outline-dark fs-5"><i class="bi bi-list"></i></button>

    <h1 class="fs-6 my-0 me-2">{{ __('Admin Panel') }}</h1>
    
    <div class="dropdown ms-auto">
        <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fs-5 bi bi-person-fill-gear"></i>
            {{ explode(' ', auth()->user()->name)[0] }}
        </button>
        <ul class="dropdown-menu">
            <li>
                <a href="#" class="btn">
                    <i class="bi bi-gear"></i>
                    {{ __('Settings') }}
                </a>
            </li>
            <li>
                <form action="/logout" method="POST">
                @csrf
                <a href="/logout" onclick="event.preventDefault();
                                    this.closest('form').submit();" class="btn fw-bold text-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    {{ __('Logout') }}
                </a>
                </form>
            </li>
        </ul>
    </div>
</nav>