<nav class="navbar navbar-expand navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Accident Reporting</a>

        {{-- Menghilangkan Tombol Hamburger Toggler --}}
        
        {{-- Memindahkan Dropdown keluar dari .collapse untuk memastikan selalu terlihat --}}
        <ul class="navbar-nav ms-auto"> 
            {{-- ms-auto untuk memaksanya ke kanan --}}
            @auth
                {{-- Dropdown Profil Pengguna --}}
                <li class="nav-item dropdown">
                    {{-- Tombol Dropdown: Menampilkan Nama User dan Panah --}}
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    {{-- Isi Dropdown Menu --}}
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                        <li class="dropdown-item-text text-wrap">
                            <span class="d-block text-truncate fw-bold">{{ Auth::user()->name }}</span>
                            <small class="d-block text-truncate text-muted">{{ Auth::user()->email }}</small>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        {{-- Tombol Logout --}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
        
        {{-- Hapus div collapse lama yang sudah tidak terpakai --}}
        {{-- <div class="collapse navbar-collapse justify-content-end" id="navbarNav">...</div> --}}

    </div>
</nav>