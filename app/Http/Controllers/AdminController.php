<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjaman;


class AdminController extends Controller
{
    public function tambah()
    {
        return view('admin.tambah');
    }

    public function postTambahAdmin(Request $request)
    {
        // Validasi input data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'jenisKelamin' => 'required',
            'password' => 'required|min:8|max:20|confirmed'
        ]);

        // Simpan data admin baru
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = 'admin';
        $user->jenis_kelamin = $request->jenisKelamin;
        $user->password = Hash::make($request->password);
        $user->save();

        // Periksa apakah penyimpanan berhasil
        if ($user) {
            return back()->with('success', 'Admin baru berhasil ditambah!');
        } else {
            return back()->with('failed', 'Gagal menambah admin baru!');
        }
    }

    public function adminBuku(Request $request) {
        $search = $request->input('search');
        $data = Buku::where(function ($query) use ($search) {
            $query->where('judul_buku', 'LIKE', '%' . $search . '%');
        })->paginate(5);

        return view('admin.buku', compact('data'));
    }
    public function editAdmin($id) {
        $data = User::find($id);
        return view('admin.edit', compact('data'));
    }
    
    public function postEditAdmin(Request $request, $id) {
        // Validasi data yang diterima dari form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns',
            'jenisKelamin' => 'required',
        ]);
    
        // Mengambil data admin berdasarkan ID
        $user = User::find($id);
    
        // Memperbarui data admin dengan data yang diterima dari form
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->jenisKelamin;
        $user->save();
    
        if ($user) {
            return back()->with('success', 'Data admin berhasil diupdate!');
        } else {
            return back()->with('failed', 'Gagal mengupdate data admin!');
        }
    }
    
    public function deleteAdmin($id) {
        // Mengambil data admin berdasarkan ID
        $data = User::find($id);
    
        // Menghapus data admin
        $data->delete();
    
        if ($data) {
            return back()->with('success', 'Data berhasil dihapus!');
        } else {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
    

    public function tambahBuku() {
        return view('admin.tambahBuku');
    }

    public function postTambahBuku(Request $request) {
        $request->validate([
            'kodeBuku' => 'required',
            'judulBuku' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required|date',
            'gambar' => 'required|image|max:5120',
            'deskripsi' => 'required',
            'kategori' => 'required',
        ]);

        $buku = new Buku;
        $buku->kode_buku = $request->kodeBuku;
        $buku->judul_buku = $request->judulBuku;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahunTerbit;
        $buku->deskripsi = $request->deskripsi;
        $buku->kategori = $request->kategori;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);
            $buku->gambar = $filename;
        }

        $buku->save();

        if ($buku) {
            return back()->with('success', 'Buku baru berhasil ditambahkan!');
        } else {
            return back()->with('failed', 'Data gagal ditambahkan!');
        }
    }

    public function editBuku($id) {
        $data = Buku::find($id);
        $kategori = buku::distinct()->pluck('kategori');

        return view('admin.editBuku', compact('data','kategori'));  
    }

    public function postEditBuku(Request $request, $id) {
        $request->validate([
            'kodeBuku' => 'required',
            'judulBuku' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahunTerbit' => 'required',
            'gambar' => 'image|max:5120',
            'deskripsi' => 'required',
            'kategori' => 'required'
        ]);

        $buku = Buku::find($id);
        $buku->kode_buku = $request->kodeBuku;
        $buku->judul_buku = $request->judulBuku;
        $buku->penulis = $request->penulis;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahunTerbit;
        $buku->deskripsi = $request->deskripsi;
        $buku->kategori = $request->kategori;

        if ($request->hasFile('gambar')) {
            $filepath = 'images/' . $buku->gambar;
            if (File::exists($filepath)) {
                File::delete($filepath);
            }

            $file = $request->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/', $filename);
            $buku->gambar = $filename;
        }

        $buku->save();

        if ($buku) {
            return back()->with('success', 'Buku berhasil diupdate!');
        } else {
            return back()->with('failed', 'Buku gagal diupdate!');
        }
    }

    public function deleteBuku($id) {
        $buku = Buku::find($id);
        $filepath = 'images/' . $buku->gambar;

        if (File::exists($filepath)) {
            File::delete($filepath);
        }

        $buku->delete();

        if ($buku) {
            return back()->with('success', 'Data buku berhasil dihapus!');
        } else {
            return back()->with('failed', 'Gagal menghapus data buku!');
        }
    }


    public function adminPeminjaman(Request $request) {
        $search = $request->input('search');
        $data = Peminjaman::where(function($query) use ($search) {
            $query->where('id_user', 'LIKE', '%' .$search. '%');
        })->paginate(5);
        return view('admin.peminjaman', compact('data'));
    }
    
    public function tambahPeminjaman() {
        return view('admin.tambahPeminjaman');
    }
    
    public function postTambahPeminjaman(Request $request) {
        $request->validate([
            'idUser' => 'required',
            'kodeBuku' => 'required|int',
            'tanggalPeminjaman' => 'required|date',
            'tanggalPengembalian' => 'required|date'
        ]);
    
        $peminjaman = new Peminjaman;
        $peminjaman->id_user = $request->idUser;
        $peminjaman->id_buku = $request->kodeBuku;
        $peminjaman->tanggal_pinjam = $request->tanggalPeminjaman;
        $peminjaman->tanggal_kembali = $request->tanggalPengembalian;
        $peminjaman->status = 'Belum Dikembalikan';
        $peminjaman->save();
    
        if($peminjaman) {
            return back()->with('success', 'Data peminjaman berhasil ditambahkan!');
        } else {
            return back()->with('failed', 'Gagal menambahkan data peminjaman!');
        }
    }
    
    public function editPeminjaman($id) {
        $data = Peminjaman::find($id);
        return view('admin.editPeminjaman', compact('data'));
    }
    
    public function postEditPeminjaman(Request $request, $id) {
        $request->validate([
            'idUser' => 'required',
            'kodeBuku' => 'required|int',
            'tanggalPeminjaman' => 'required',
            'tanggalPengembalian' => 'required',
            'status' => 'required'
        ]);
    
        $peminjaman = Peminjaman::find($id);
        $peminjaman->id_user = $request->idUser;
        $peminjaman->id_buku = $request->kodeBuku;
        $peminjaman->tanggal_pinjam = $request->tanggalPeminjaman;
        $peminjaman->tanggal_kembali = $request->tanggalPengembalian;
        $peminjaman->status = $request->status;
        $peminjaman->save();
    
        if($peminjaman){
            return back()->with('success', 'Data peminjaman berhasil diupdate!');
        } else {
            return back()->with('failed', 'Gagal mengupdate data peminjaman!');
        }
    }
    
    public function deletePeminjaman($id) {
        $data = Peminjaman::find($id);
        $data->delete();
        if($data) {
            return back()->with('success', 'Data peminjaman berhasil dihapus!');
        } else {
            return back()->with('failed', 'Gagal menghapus data peminjaman!');
        }
    }
    public function detailPeminjaman($id_peminjaman, $id_user, $id_buku) {
        $detailPeminjaman = Peminjaman::select('peminjaman.', 'buku.', 'users.*')
            ->join('buku', 'peminjaman.id_buku', '=', 'buku.id')
            ->join('users', 'peminjaman.id_user', '=', 'users.id')
            ->where('peminjaman.id', $id_peminjaman)
            ->where('buku.id', $id_buku)
            ->where('users.id', $id_user)
            ->first();
    
        if (!$detailPeminjaman) {
            abort(404, 'Data tidak ditemukan');
        }
        return view('admin.detailPeminjaman', compact('detailPeminjaman'));

    }

    public function cetakDataPeminjaman() {
        $data = Peminjaman::all();
        return view('admin.cetakPeminjaman', compact('data'));
        }
}