<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Keranjang;
use App\Models\Materi;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AbsenController extends Controller
{
    public function index()
    {
        $title = "Absen";
        
        
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();
        $id_pelanggan = $Pelanggan->id;
        $jumlah_pesanan = Keranjang::where('id_pelanggan',$id_pelanggan)->count();

        // Ambil tanggal hari ini
        $today = Carbon::now()->format('Y-m-d');
        $jam_sekarang = Carbon::now()->format('H:i:s');
        // Ambil data jadwal berdasarkan tanggal hari ini
        $jadwals = DB::table('jadwals')
            ->leftJoin('absens', function ($join) use ($id_pelanggan, $today) {
                $join->on('jadwals.id', '=', 'absens.id_jadwal')
                    ->where('absens.id_pelanggan', '=', $id_pelanggan)
                    ->where('absens.tanggal', '=', $today);
            })
            ->Join('kelas', function ($join) use ($id_pelanggan, $today) {
                $join->on('kelas.id', '=', 'jadwals.id_kelas')
                    ->where('jadwals.tanggal', '=', $today);
            })
            ->select('jadwals.*','kelas.kelas as kelas','kelas.id as id_kelas', 'absens.status as absen_status')
            ->whereDate('jadwals.tanggal', $today)
            ->get();
        return view('absen.index', compact('jadwals', 'jumlah_pesanan', 'title', 'jam_sekarang'));
    }


    public function actabsen(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();
        $absen = new Absen();
        if ($request->status == "izin") {
            $validator = Validator::make($request->all(), [
                // 'id' => 'required|integer',
                'id_jadwal' => 'required|exists:jadwals,id',
                'status' => 'required|in:izin,hadir,alpha',
                'bukti_surat' => 'required|max:2048|mimes:pdf,doc,docx',
            ]);

            $fileName = time() . '.' . $request->file('bukti_surat')->getClientOriginalExtension();

            $request->file('bukti_surat')->move(public_path() . '/bukti_surat', $fileName);
            $absen->bukti_surat = $fileName;
        } else {
            $validator = Validator::make($request->all(), [
                // 'id' => 'required|integer',
                'id_jadwal' => 'required|exists:jadwals,id',
                'status' => 'required|in:izin,hadir,alpha',
                //   'bukti_surat' => 'required|max:2048|mimes:pdf,doc,docx',
            ]);
        }
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        $absen->id_jadwal = $request->id_jadwal;
        $absen->status = $request->status;
        $absen->id_pelanggan = $Pelanggan->id;
        $absen->tanggal = $today;
        $absen->save();
        Alert::success("Berhasil", "Absen Berhasil")->flash();
        return redirect()->route('absen');
    }

    public function rekapabsenid($id)
    {
        $title = "Rekap Absen";
        $jadwal = Jadwal::find($id);
        $jam_sekarang = Carbon::now()->format('H:i:s');
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');
        if ($tanggal_sekarang >= $jadwal->tanggal) {
            if ($jam_sekarang > $jadwal->jam_akhir) {
                $Pelanggan=Pelanggan::all();

                foreach ($Pelanggan as $Pelanggans) {
                    $cek=Absen::where('id_jadwal', $id)->where('id_pelanggan', $Pelanggans->id)->first();
                    if ($cek == null) {
                        $absen = new Absen();
                        $absen->id_jadwal = $id;
                        $absen->id_pelanggan = $Pelanggans->id;
                        $absen->tanggal = $tanggal_sekarang;
                        $absen->status = "tidak hadir";
                        $absen->save();
                    }
                }
            }
        }

        $data=Absen::with('jadwal','pelanggan')->where('id_jadwal', $id)->get();
        // $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('jadwal.rekap_absen', compact('title', 'data', 'jadwal'));
    }



    public function lihat_materiuser($id) {
        $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login
        $Pelanggan = Pelanggan::where('id_user', $id_user)->first();

        $id_pelanggan = $Pelanggan->id;
        $jumlah_pesanan=Keranjang::where('id_pelanggan', $id_pelanggan)->count();
        $kelas=Kelas::find($id);
        $title = "Materi dari kelas" .$kelas->kelas;
        $data=Materi::where('id_kelas', $id) ->paginate(30);
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('absen.materi',compact('title', 'data','id','offset','id_pelanggan','jumlah_pesanan'));
    }
}
