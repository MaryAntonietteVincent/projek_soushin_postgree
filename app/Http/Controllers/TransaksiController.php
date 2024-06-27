<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Detailtransaksi;
use App\Models\Keranjang;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function pembayaran(Request $request)
    {

       // Menetapkan judul halaman menjadi "Halaman Pembayaran dan Pengambilan".
$title = "Halaman Pembayaran dan Pengambilan";

// Mengambil kata kunci pencarian dari input request pengguna.
$keyword = $request->search;

// Menetapkan batas jumlah hasil yang akan ditampilkan per halaman dalam pagination.
$limit = 20;

// Membuat query untuk mengambil data transaksi yang memenuhi kriteria tertentu.
$data = Transaksi::with('pelanggan') // Memuat relasi 'pelanggan' dengan transaksi untuk menghindari query tambahan nanti.
    ->where('status_pesanan', 'belum') // Memfilter hanya transaksi yang status pesanannya adalah "belum".
    ->where('status_ambil', 'belum') // Memfilter hanya transaksi yang status pengambilannya adalah "belum diambil".
    ->where(function ($query) use ($keyword) { // Menggunakan closure untuk menambahkan kondisi pencarian.
        // Memfilter transaksi berdasarkan tanggal pesan yang mengandung kata kunci pencarian.
        $query->where('tanggal_pesan', 'like', '%' . $keyword . '%')
            // Memfilter transaksi berdasarkan tanggal ambil yang mengandung kata kunci pencarian.
            ->orWhere('tanggal_ambil', 'like', '%' . $keyword . '%')
            // Memfilter transaksi berdasarkan nama pelanggan yang mengandung kata kunci pencarian.
            ->orWhereHas('pelanggan', function ($query) use ($keyword) { 
                // Menggunakan `orWhereHas` untuk mencari dalam relasi 'pelanggan'.
                // `orWhereHas` menambahkan kondisi pencarian pada entitas terkait (pelanggan).
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    })
    // Mengatur pagination dengan batas jumlah hasil per halaman.
    ->paginate($limit);

        return view('transaksi.pembayaran', compact('title', 'data', 'keyword'));
    }
    public function pesanan_selesai(Request $request)
    {

        // Menetapkan judul halaman menjadi "Halaman Transaksi Selesai".
$title = "Halaman Transaksi Selesai";

// Mengambil kata kunci pencarian dari input request pengguna.
$keyword = $request->search;

// Menetapkan batas jumlah hasil yang akan ditampilkan per halaman dalam pagination.
$limit = 20;

// Membuat query untuk mengambil data transaksi yang memenuhi kriteria tertentu.
$data = Transaksi::with('pelanggan') // Memuat relasi 'pelanggan' dengan transaksi untuk menghindari query tambahan nanti.
    ->where('status_pesanan', 'selesai') // Memfilter hanya transaksi yang status pesanannya adalah "selesai".
    ->where('status_ambil', 'sudah') // Memfilter hanya transaksi yang status pengambilannya adalah "sudah diambil".
    ->where(function ($query) use ($keyword) { // Menggunakan closure untuk menambahkan kondisi pencarian.
        // Memfilter transaksi berdasarkan tanggal pesan yang mengandung kata kunci pencarian.
        $query->where('tanggal_pesan', 'like', '%' . $keyword . '%')
            // Memfilter transaksi berdasarkan tanggal ambil yang mengandung kata kunci pencarian.
            ->orWhere('tanggal_ambil', 'like', '%' . $keyword . '%')
            // Memfilter transaksi berdasarkan nama pelanggan yang mengandung kata kunci pencarian.
            ->orWhereHas('pelanggan', function ($query) use ($keyword) { 
                // Menggunakan `orWhereHas` untuk mencari dalam relasi 'pelanggan'.
                // `orWhereHas` menambahkan kondisi pencarian pada entitas terkait (pelanggan).
                $query->where('name', 'like', '%' . $keyword . '%');
            });
    })
    // Mengatur pagination dengan batas jumlah hasil per halaman.
    ->paginate($limit);
        return view('transaksi.pesanan_selesai', compact('title', 'data', 'keyword'));
    }
    public function detail_pesanan($id)
    {
        // 1. Menentukan judul halaman
        $title = "Detail Pesanan";
        // 2. Mengambil detail transaksi dengan relasi ke model Barang berdasarkan ID transaksi
        $data = Detailtransaksi::with('barang')->where('id_transaksi', $id)->get();
        // 3. Mengarahkan ke view 'transaksi.detail_pembayaran' dengan data yang diambil dan judul halaman
        return view('transaksi.detail_pembayaran', compact('data', 'title'));
    }
    
    public function detail_pesananselesai($id)
    {
           // 1. Menentukan judul halaman
        $title = "Detail Pesanan";
     // 2. Mengambil detail transaksi dengan relasi ke barang berdasarkan ID transaksi
        $data = Detailtransaksi::with('barang')->where('id_transaksi', $id)->get();
    // 3. Mengarahkan ke view 'transaksi.detail_pesananselesai' dengan data yang diambil dan judul halaman
        return view('transaksi.detail_pesananselesai', compact('data', 'title'));
    }
    

    public function pembayaran_proses(Request $request)
{
    // 1. Temukan data transaksi berdasarkan ID yang diterima dari permintaan.
    $data = Transaksi::find($request->id);
 // 2. Menghapus tanda titik dari jumlah yang dibayarkan untuk memastikan bahwa itu adalah angka murni.
$bayar = str_replace('.', '', $request->bayar);
    // 3. Periksa apakah jumlah yang dibayarkan kurang dari total harga transaksi.
    if ($bayar < $data->total_harga) {
        // 4. Jika pembayaran kurang dari total harga, tampilkan pesan error dan kembalikan ke halaman sebelumnya.
        Alert::error('Error', 'Pembayaran Kurang')->flash();
        return back();
    }

    // 5. Jika pembayaran mencukupi, perbarui status transaksi menjadi 'sudah diambil'.
    $data->status_ambil = "sudah";

    // 6. Simpan jumlah yang dibayarkan oleh pelanggan.$data->total_bayar = $bayar;
// 7. Perbarui status pesanan menjadi 'selesai'.
    $data->status_pesanan = "selesai";
    // 8. Simpan perubahan data transaksi ke database.
    $data->save();
 // 9. Tampilkan pesan sukses bahwa pembayaran berhasil.
    Alert::success('Success', 'Pembayaran Berhasil')->flash();
    // 10. Alihkan pengguna ke rute 'pembayaran_danpengambilan' setelah pembayaran berhasil diproses.
    return redirect()->route('pembayaran_danpengambilan');
}


    public function halaman_keranjang()
    {
        $title = "Halaman Keranjang";
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();
        $id_pelanggan = $Pelanggan->id;
        $jumlah_pesanan = Keranjang::where('id_pelanggan', $id_pelanggan)->count();
        $data = Keranjang::with('pelanggan', 'barang')->where('id_pelanggan', $id_pelanggan)->get(); //menampilkan semua data di tabel keranjang dengan id pelanggan yang sesuai dan with berfungsi untuk menampilkan tabel pelanggan dan tabel barang dengan id keranjang yang sesuai yang berelasi dengan tael keranjang
        return view('transaksi.halaman_keranjang', compact('title', 'jumlah_pesanan', 'data'));
    }
    public function tambah_qty($id)
    {
        $data = Keranjang::find($id); //mencari data keranjang berdasarkan id
        $barang = Barang::find($data->id_barang); //mencari data barang berdasarkan id

        $data->sub_total = $data->sub_total + $barang->harga; //menghitung subtotal dengan penambahan subtotal dan harga
        $data->qty = $data->qty + 1; //menghitung qty dengan penambahan qty
        $data->save();
        return redirect()->route('halaman_keranjang');
    }

    public function kurang_qty($id)
    {
        // 1. Cari data keranjang berdasarkan ID yang diberikan.
        $data = Keranjang::find($id);

        // 2. Cari data barang berdasarkan ID barang yang terdapat di keranjang.
        $barang = Barang::find($data->id_barang);

        // 3. Kurangi sub_total keranjang dengan harga barang yang dikurangi.
        $data->sub_total = $data->sub_total - $barang->harga;

        // 4. Kurangi jumlah barang (qty) di keranjang sebesar 1.
        $data->qty = $data->qty - 1;

        // 5. Simpan perubahan yang telah dilakukan pada data keranjang.
        $data->save();

        // 6. Alihkan pengguna ke halaman keranjang.
        return redirect()->route('halaman_keranjang');
    }

    public function reset_qty($id)
    {
        // 1. Cari data keranjang berdasarkan ID yang diberikan.
        $data = Keranjang::find($id);

        // 2. Hapus data keranjang yang ditemukan.
        $data->delete();

        // 3. Alihkan pengguna ke halaman keranjang.
        return redirect()->route('halaman_keranjang');
    }


    public function pemesanan(Request $request)
    {

        // 1. Dapatkan ID user yang sedang login.
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login

        // 2. Temukan data pelanggan berdasarkan ID user yang sedang login.
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();

        // 3. Dapatkan ID pelanggan dari data pelanggan yang ditemukan.
        $id_pelanggan = $Pelanggan->id;

        // 4. Validasi input dari request.
        $validator = Validator::make($request->all(), [
            'tanggal_ambil' => 'required|date', // Memastikan tanggal ambil ada dan berformat tanggal
            'total_harga' => 'required|numeric|min:0', // Memastikan total harga ada dan merupakan angka positif
            'id_keranjang.*' => 'required|exists:keranjangs,id', // Memastikan setiap item keranjang ada di tabel `keranjangs`
        ]);

        // 5. Jika validasi gagal, tampilkan pesan kesalahan dan kembali ke halaman sebelumnya dengan input dan kesalahan.
        if ($validator->fails()) {
            $messages = $validator->errors()->all(); // Mengambil semua pesan kesalahan validasi.
            Alert::error($messages)->flash(); // Menampilkan pesan kesalahan menggunakan alert (SweetAlert atau serupa).
            return back()->withErrors($validator)->withInput(); // Kembali ke halaman sebelumnya dengan input dan pesan kesalahan.
        }

        // 6. Format tanggal ambil menjadi format 'Y-m-d'.
        $tanggal_ambil = Carbon::parse($request->tanggal_ambil)->format('Y-m-d');

        // 7. Dapatkan ID keranjang dari request.
        $idKeranjang = $request->id_keranjang;

        // 8. Hilangkan tanda titik dari total harga agar menjadi angka murni.
        $total_harga = str_replace('.', '', $request->total_harga);

        // 9. Buat entri baru di tabel `transaksis` untuk menyimpan data pesanan.
        $data = new Transaksi();
        $data->id_pelanggan = $id_pelanggan; // Mengatur ID pelanggan
        $data->total_harga = $total_harga; // Mengatur total harga
        $data->status_ambil = "belum"; // Status pengambilan default adalah "belum"
        $data->status_pesanan = "belum"; // Status pesanan default adalah "belum"
        $data->tanggal_ambil = $tanggal_ambil; // Mengatur tanggal ambil
        $data->tanggal_pesan = Carbon::now()->format('Y-m-d'); // Mengatur tanggal pesan menjadi tanggal saat ini
        $data->save(); // Simpan data transaksi

        // 10. Proses setiap item keranjang yang dipilih untuk dimasukkan ke detail transaksi.
        foreach ($idKeranjang as $id) {
            $keranjang = Keranjang::find($id); // Temukan data keranjang berdasarkan ID

            // 11. Buat entri baru di tabel `detail_transaksis` untuk setiap item keranjang.
            $detail = new DetailTransaksi();
            $detail->id_transaksi = $data->id; // Hubungkan detail transaksi dengan transaksi
            $detail->id_barang = $keranjang->id_barang; // Setel ID barang
            $detail->qty = $keranjang->qty; // Setel jumlah barang
            $detail->sub_total = $keranjang->sub_total; // Setel subtotal harga
            $detail->save(); // Simpan detail transaksi

            // 12. Hapus item dari keranjang setelah diproses.
            $keranjang->delete(); // Hapus item keranjang yang sudah diproses
        }

        // 13. Tampilkan pesan sukses menggunakan alert (SweetAlert)).
        Alert::success('Success', 'Pemesanan Berhasil')->flash(); // Menampilkan pesan sukses

        // 14. Alihkan pengguna ke halaman pesanan saya.
        return redirect()->route('pesanan_saya'); // Mengarahkan ke halaman "pesanan saya"
    }


    public function pesanan_saya()
    {
        // 1. Setel judul halaman.
        $title = "Pesanan Saya";

        // 2. Dapatkan ID user yang sedang login.
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login

        // 3. Temukan data pelanggan berdasarkan ID user yang sedang login.
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();

        // 4. Dapatkan ID pelanggan dari data pelanggan yang ditemukan.
        $id_pelanggan = $Pelanggan->id;

        // 5. Hitung jumlah item dalam keranjang untuk pelanggan yang sedang login.
        $jumlah_pesanan = Keranjang::where('id_pelanggan', $id_pelanggan)->count();

        // 6. Dapatkan data transaksi yang terkait dengan pelanggan yang sedang login,
        //    dan muat hubungan `pelanggan` dengan setiap transaksi.
        $data = Transaksi::with('pelanggan')
            ->where('id_pelanggan', $id_pelanggan)
            ->paginate(20);

        // 7. Alihkan data ke view `transaksi.pesanan_saya` bersama dengan variabel 'title', 'data', dan 'jumlah_pesanan'.
        return view('transaksi.pesanan_saya', compact('title', 'data', 'jumlah_pesanan'));
    }


    public function pesanan_saya_detail($id)
    {
        // 1. Setel judul halaman.
        $title = "Detail Pesanan Saya";
        // 2. Dapatkan ID user yang sedang login.
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login
 // 3. Temukan data pelanggan berdasarkan ID user yang sedang login.
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();
// 4. Dapatkan ID pelanggan dari data pelanggan yang ditemukan.
        $id_pelanggan = $Pelanggan->id;
 // 5. Hitung jumlah item dalam keranjang untuk pelanggan yang sedang login.
        $jumlah_pesanan = Keranjang::where('id_pelanggan', $id_pelanggan)->count();
// 6. Dapatkan data detail transaksi yang terkait dengan ID transaksi tertentu,
        //    dan muat hubungan `barang` dengan setiap detail transaksi.
        $data = Detailtransaksi::with('barang')
            ->where('id_transaksi', $id)
            ->get();
 // 7. Alihkan data ke view `transaksi.pesanan_saya_detail` bersama dengan variabel 'title', 'data', dan 'jumlah_pesanan'.
        return view('transaksi.pesanan_saya_detail', compact('title', 'data', 'jumlah_pesanan'));
    }
}
