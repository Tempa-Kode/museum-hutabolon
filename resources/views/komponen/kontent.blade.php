<ul class="sidebar-nav">
    <li class="sidebar-header">
        Master Data
    </li>

    <li class="sidebar-item {{ Route::currentRouteName() == "dashboard" ? "active" : "" }}">
        <a class="sidebar-link" href="{{ route("dashboard") }}">
            <i class="align-middle" data-feather="sliders"></i> <span
                class="align-middle">Dashboard</span>
        </a>
    </li>
    <li class="sidebar-item {{ Route::currentRouteName() == "situs-sejarah.index" ? "active" : "" }}">
        <a class="sidebar-link" href="{{ route("situs-sejarah.index") }}">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle">Data Situs
                Sejarah</span>
        </a>
    </li>
    <li class="sidebar-item {{ Route::currentRouteName() == "kategori.index" ? "active" : "" }}">
        <a class="sidebar-link" href="{{ route("kategori.index") }}">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle">Data
                Kategori</span>
        </a>
    </li>
    <li class="sidebar-item {{ Route::currentRouteName() == "komentar.index" ? "active" : "" }}">
        <a class="sidebar-link" href="{{ route('komentar.index') }}">
            <i class="align-middle" data-feather="database"></i> <span class="align-middle">Data
                Komentar</span>
        </a>
    </li>
    <li class="sidebar-item {{ Route::currentRouteName() == "event.index" ? "active" : "" }}">
        <a class="sidebar-link" href="{{ route("event.index") }}">
            <i class="align-middle" data-feather="database"></i>
            <span class="align-middle">Data Event</span>
        </a>
    </li>
</ul>
