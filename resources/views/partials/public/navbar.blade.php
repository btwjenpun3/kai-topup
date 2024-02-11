<nav class="navbar navbar-expand-lg bg-custom"
    style="background-color: white;box-shadow: 0px 15px 10px rgba(0, 0, 0, 0.1);border-bottom:2px solid white">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="/img/logo.png" width="50" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
                </li>
                <li class="nav-item" style="background-color: transparent;border:solid 3px rgb(17, 177, 44);">
                    <a class="nav-link" href="{{ route('auth.index') }}" style="color:rgb(17, 177, 44);"><i
                            class="fa-solid fa-user"></i> Daftar
                        Member</a>
                </li>
                <li class="nav-item dropdown" style="background-color:#2596be;">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-layer-group"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li style="background-color: transparent;"><a class="dropdown-item text-dark"
                                href="{{ route('lihat.harga.index') }}"><i class="fa-solid fa-tag"></i> Harga</a>
                        </li>
                        <li style="background-color: transparent;"><a class="dropdown-item text-dark"
                                href="{{ route('about.index') }}"><i class="fa-solid fa-circle-info"></i> Tentang
                                Kami</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
