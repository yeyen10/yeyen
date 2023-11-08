<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrapicons@1.10.5/font/bootstrap-icons.css">
    <title>Tambah Data</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Politeknik Negeri Bengkalis| D-IV Keamanan Sistem Informasi</a>
        </div>
    </nav>
    <div class="container">
        <a href="{{ route('admin.home') }}">
            <i class="bi-arrow-left h1"></i>
        </a>
        <div class="container mt-3">
            @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fadeshow" role="alert">
                <strong>Berhasil!</strong> {{ Session::get('success')}}
                <button type="button" class="btn-close" data-bsdismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (Session::get('failed'))
            <div class="alert alert-danger alert-dismissible fadeshow" role="alert">
                <strong>Gagal!</strong> {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bsdismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card mt-4" style="width: 800px">
                    <div class="card-body">
                        <h5 class="card-title text-center">TambahData</h5>
                        <form action="{{ route('postTambahAdmin') }}"method="POST">
                            @csrf
                            <div class="form-group mt-4">
                                <label class="text-secondary mb-2">NamaAdmin</label>
                                <input type="text" class="form-controlborder border-secondary form-control"name="name" required value="{{old('name') }}">
                                <span class="text-danger">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div><br>
                            <div class="form-group mt-1">
                                <label class="text-secondary mb-2">EmailAdmin</label>
                                <input type="email" class="form-controlborder border-secondary form-control"name="email" required value="{{old('email') }}">
                                <span class="text-danger">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div><br>
                            <div class="form-group mt-1">
                                <label class="text-secondary">Pilih JenisKelamin</label><br>
                                <div class="form-check form-checkinline">
                                    <input class="form-check-input"type="radio" name="jenisKelamin"value="Laki-laki">
                                    <label class="form-check-label"for="inlineRadio1">Laki-laki</label>
                                </div>
                                <div class="form-check form-checkinline">
                                    <input class="form-check-input"type="radio" name="jenisKelamin"value="Perempuan">
                                    <label class="form-check-label"for="inlineRadio2">Perempuan</label>
                                </div>
                            </div><br>
                            <div class="form-group mt-1">
                                <label class="text-secondary mb2">Password Admin</label>
                                <input type="password" class="formcontrol border border-secondary form-control"name="password" required>
                                <span class="text-danger">
                                    @error('password')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div><br>
                            <div class="form-group mt-1">
                                <label class="text-secondary mb2">Konfirmasi Password Admin</label>
                                <input type="password" class="formcontrol border border-secondary form-control"name="password_confirmation"required>
                                <span class="text-danger">
                                    @error('password_confirmation')
                                    {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <button type="submit" class="btn btn-successmt-5">Tambah Data Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><br><br><br><br>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>