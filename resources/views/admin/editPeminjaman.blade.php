<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrapicons@1.10.5/font/bootstrap-icons.css">
    <title>tambah data</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Politeknik Negeri Bengkalis | D-IV Keamanan Sistem Informasi</a>
        </div>
    </nav>
    <div class="container">
        <a href="{{ route('admin.peminjaman') }}">
            <i class="bi-arrow-left h1"></i>
        </a>
        <div class="container mt-3">
            @if (Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::get('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ Session::get('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card mt-4" style="width: 800px">
                    <div class="card-body">
                        <h5 class="card-title text-center">Edit Data Peminjaman</h5>
                        <form action="/postEditPeminjaman/{{ $data->id }}" method="POST">
                            @csrf
                            <div class="form-group mt-4">
                                <label class="text-secondary mb-2">Nomor Anggota</label>
                                <input type="text" class="form-control border border-secondary form-control" name="idUser" required value="{{ $data->id_user }}">
                                <span class="text-danger">
                                    @error('idUser')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <br>
                            <div class="form-group mt-1">
                                <label class="text-secondary mb-2">ID Buku</label>
                                <input type="text" class="form-control border border-secondary form-control" name="kodeBuku" required value="{{ $data->id_buku }}">
                                <span class="text-danger">
                                    @error('kodeBuku')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <br>
                            <div class="form-group mt-1">
                                <label class="text-secondary mb-2">Tanggal Peminjaman</label>
                                <input type="text" class="form-control border border-secondary form-control" name="tanggalPeminjaman" required value="{{ $data->tanggal_pinjam }}">
                                <span class="text-danger">
                                    @error('tanggalPeminjaman')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <br>
                            <div class="form-group mt-1">
                                <label class="text-secondary mb-2">Tanggal Pengembalian</label>
                                <input type="text" class="form-control border border-secondary form-control" name="tanggalPengembalian" required value="{{ $data->tanggal_kembali }}">
                                <span class="text-danger">
                                    @error('tanggalPengembalian')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <br>
                            <div class="form-group mt-1">
                                <label class="text-secondary">Pilih Status Peminjaman</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="Belum Dikembalikan" @if ($data->status == 'Belum Dikembalikan') checked @endif>
                                    <label class="form-check-label" for="inlineRadio1">Belum Dikembalikan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" value="Sudah Dikembalikan" @if ($data->status == 'Sudah Dikembalikan') checked @endif>
                                    <label class="form-check-label" for="inlineRadio2">Sudah Dikembalikan</label>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success mt-5">Update Data Peminjaman</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
