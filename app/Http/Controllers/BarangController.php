<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index(Request $request)
    {

        $title = "Data Barang";
        if (auth()->user()->role == 'pelanggan') {
            $userId = Auth::id();
            $pelanggan=Pelanggan::where('id_user', $userId)->first();
            $jumlah_pesanan = Keranjang::where('id_pelanggan', $pelanggan->id)->count();
            $data = Barang::where('nama_produk', 'like', '%' . $request->search . '%')->orWhere('deskripsi', 'like', '%' . $request->search . '%')->orWhere('harga', 'like', '%' . $request->search . '%')->paginate(10);
            $offset = ($data->currentPage() - 1) * $data->perPage();
            return view('barang.index', compact('title', 'data', 'offset', 'jumlah_pesanan'));
        } else {
            # code...
            $data = Barang::where('nama_produk', 'like', '%' . $request->search . '%')->orWhere('deskripsi', 'like', '%' . $request->search . '%')->orWhere('harga', 'like', '%' . $request->search . '%')->paginate(10);
            $offset = ($data->currentPage() - 1) * $data->perPage();
            return view('barang.index', compact('title', 'data', 'offset'));
        }
    }

    public function tambah_barang()
    {
        $title = "Tambah Data Barang";
        return view('barang.tambah', compact('title'));
    }

    public function tambah_barang_proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required',
            'gambar' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $harga = str_replace('.', '', $request->harga);//menghilangkan titik
        $data = new Barang();//membuat object data dari model Barang
        $data->nama_produk = $request->nama_produk;
        $data->deskripsi = $request->deskripsi;
        $data->harga = $harga;

        $fileName = time() . '.' . $request->file('gambar')->getClientOriginalExtension();//mengambil ekstensi file

        $request->file('gambar')->move(public_path() . '/produk', $fileName);//mengupload file ke public/produk
        $data->gambar = $fileName; //mengisi kolom gambar dengan file yang diupload
        $data->save();
        Alert::success('Success', 'Data Berhasil di tambah')->flash();//menampilkan pesan berhasil
        return redirect()->route('barang');//mengembalikan ke halaman route barang
    }

    public function hapus_barang($id)
    {
        $data = Barang::find($id);//mencari data berdasarkan id
        $file = (public_path('/produk/' . $data->gambar));//mengambil lokasi file
        if (file_exists($file)) {//jika file ada
            @unlink($file);//menghapus file
        }
        $data->delete();//menghapus data
        Alert::success('Success', 'Data Berhasil di hapus')->flash();
        return redirect()->route('barang');
    }
    public function edit_barang($id)
    {
        $data = Barang::find($id);//mencari data berdasarkan id
        $title = "Edit Data Barang";
        return view('barang.edit', compact('title', 'data'));//mengembalikan ke halaman edit
    }

    public function update_barang(Request $request, $id)
{
    // Validasi input berdasarkan apakah ada file gambar yang diunggah atau tidak
    if ($request->hasFile('gambar')) { // Jika ada gambar yang diunggah
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required',
            'gambar' => 'required|max:2048|mimes:jpeg,jpg,png',
        ]);
    } else { // Jika tidak ada gambar yang diunggah
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required',
            // 'gambar' => 'required', // Dihapus karena tidak diperlukan jika tidak ada gambar yang diunggah
        ]);
    }

    // Jika validasi gagal, kembalikan ke halaman edit dengan pesan error
    if ($validator->fails()) {
        $messages = $validator->errors()->all();
        Alert::error($messages)->flash();
        return back()->withErrors($validator)->withInput(); // Kembali ke halaman sebelumnya dengan pesan error validasi dan input sebelumnya
    }

    // Mengubah format harga (menghilangkan titik atau koma sebagai pemisah ribuan)
    $harga = str_replace(['.', ','], '', $request->harga);

    // Mengambil data barang yang akan diupdate berdasarkan $id
    $data = Barang::find($id);
    $data->nama_produk = $request->nama_produk;
    $data->deskripsi = $request->deskripsi;
    $data->harga = $harga;

    // Jika ada gambar yang diunggah, proses pengelolaan gambar
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama dari direktori penyimpanan
        $file = public_path('/produk/' . $data->gambar);
        @unlink($file);

        // Simpan gambar baru ke direktori penyimpanan
        $fileName = time() . '.' . $request->file('gambar')->getClientOriginalExtension();
        $request->file('gambar')->move(public_path() . '/produk', $fileName);
        $data->gambar = $fileName;
    }

    // Simpan perubahan data barang ke database
    $data->save();

    // Tampilkan pesan sukses menggunakan library Alert
    Alert::success('Success', 'Data Berhasil di update')->flash();

    // Redirect pengguna kembali ke halaman daftar barang setelah update selesai
    return redirect()->route('barang');
}

}
