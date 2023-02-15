<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          @php
              $segment = request()->segments();
          @endphp
          <li><a href="{{ url('/') }}" class="nav-link px-2 {{ (count($segment) == 0) ? 'text-secondary' : 'text-white' }}">Home</a></li>
          <li><a href="{{ url('/mahasiswa') }}" class="nav-link px-2 {{ (isset($segment[0]) && ($segment[0] == 'mahasiswa') && (count($segment) == 1)) ? 'text-secondary' : 'text-white' }}">Mahasiswa</a></li>
          <li><a href="{{ url('/mahasiswa/laporan') }}" class="nav-link px-2 {{ (isset($segment[1]) && $segment[1] == 'laporan') ? 'text-secondary' : 'text-white' }}">Laporan</a></li>
        </ul>

        {{-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
        </form>

        <div class="text-end">
          <button type="button" class="btn btn-outline-light me-2">Login</button>
          <button type="button" class="btn btn-warning">Sign-up</button>
        </div> --}}
      </div>
    </div>
  </header>