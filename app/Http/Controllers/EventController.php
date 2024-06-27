<?php

namespace App\Http\Controllers;

use App\Models\events;
use App\Models\JenisAcara;
use App\Models\Keranjang;
use App\Models\Pelanggan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $title = "Event";

        $searchTerm = $request->search;

        if (auth()->user()->role == 'pelanggan') { //jika pelanggan
            $userId = Auth::id();
            $pelanggan = Pelanggan::where('id_user', $userId)->first();
            $jumlah_pesanan = Keranjang::where('id_pelanggan', $pelanggan->id)->count();
            $data = events::where('title', 'like', '%' . $searchTerm . '%') //mencari sesuai title
                ->orWhere('description', 'like', '%' . $searchTerm . '%') //mencari sesuai description
                ->orWhere('location', 'like', '%' . $searchTerm . '%') //mencari sesuai location
                ->orWhere('organizer', 'like', '%' . $searchTerm . '%') //mencari sesuai organizer
                ->orWhere('start_date', 'like', '%' . $searchTerm . '%') //  mencari sesuai start_date
                ->orWhere('end_date', 'like', '%' . $searchTerm . '%') //mencari sesuai end_date
                ->orWhere('status', 'like', '%' . $searchTerm . '%') //mencari sesuai status
                ->paginate(10); //mengambil 10 data
            $offset = ($data->currentPage() - 1) * $data->perPage();
            return view('event.index', compact('title', 'data', 'offset', 'jumlah_pesanan'));
            # code...
        }

        $data = events::where('title', 'like', '%' . $searchTerm . '%')
            ->orWhere('description', 'like', '%' . $searchTerm . '%')
            ->orWhere('location', 'like', '%' . $searchTerm . '%')
            ->orWhere('organizer', 'like', '%' . $searchTerm . '%')
            ->orWhere('start_date', 'like', '%' . $searchTerm . '%')
            ->orWhere('end_date', 'like', '%' . $searchTerm . '%')
            ->orWhere('status', 'like', '%' . $searchTerm . '%')
            ->paginate(10);
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('event.index', compact('title', 'data', 'offset'));
    }
    public function tambah_event()
    {
        $jenis_acara = JenisAcara::all(); //mengambil semua data di tabelenis acara
        $title = " Tambah Event";
        return view('event.tambah_event', compact('title', 'jenis_acara'));
    }
    public function edit_event($id)
    {
        $jenis_acara = JenisAcara::all(); //mengambil semua data di tabel jenis acara
        $data = events::find($id); //mengambil data
        $title = "Edit Event";
        return view('event.edit_event', compact('title', 'data', 'jenis_acara'));
    }
    public function tambah_event_proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date', //validasi start_date harus lebih besar dari end_date
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            // 'type' => 'required|string|max:50',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'image_event' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //validasi gambar mimes berfungsi untuk menentukan ekstensi gambar yang diperbolehkan
            'id_jenisacara' => 'required|exists:jenis_acaras,id', //validasi id_jenisacara harus ada di tabel jenis acaras
            'capacity' => 'required|numeric', //validasi capacity harus angka
            'price' => 'required'

        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        $data = new events();
        $fileName = time() . '.' . $request->file('image_event')->getClientOriginalExtension(); //mengambil ekstensi dari gambar

        $request->file('image_event')->move(public_path() . '/event', $fileName);
        // $data->gambar = $fileName;
        $tanggal_awal = Carbon::parse($request->start_date)->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($request->end_date)->format('Y-m-d');
        $price = str_replace('.', '', $request->price);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->start_date = $tanggal_awal;
        $data->end_date = $tanggal_akhir;
        $data->location = $request->location;
        $data->organizer = $request->organizer;
        // $data->type = $request->type;
        $data->status = $request->status;
        $data->image_event = $fileName;
        $data->id_jenisacara = $request->id_jenisacara;
        $data->capacity = $request->capacity;
        $data->price = $price;
        $data->save();
        Alert::success('Success', 'Data Berhasil di tambah')->flash();
        return redirect()->route('ipen');
    }

    public function event_detail($id)
    {
        $data = events::with('jenisacara')->find($id); //mencari data berdasarkan id
        if (auth()->user()->role == "pelanggan") { //jika pelanggan
            $id_user = Auth::id(); // Asumsikan pelanggan adalah user yang sedang login
            $Pelanggan = Pelanggan::where('id_user', $id_user)->first();

            $id_pelanggan = $Pelanggan->id;
            $jumlah_pesanan = Keranjang::where('id_pelanggan', $id_pelanggan)->count(); //menghitung data dari tabel keranjang berdasarkan id pelanggan
            $title = "Detail Event";
            return view('event.detail_ipen', compact('title', 'data', 'id_pelanggan', 'id_user', 'jumlah_pesanan'));
        }
        $title = "Detail Event";
        return view('event.detail_ipen', compact('title', 'data'));
    }

    public function update_event(Request $request, $id)
    {
        if ($request->hasFile('image_event')) { //jika ada gambar
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'location' => 'required|string|max:255',
                'organizer' => 'required|string|max:255',
                // 'type' => 'required|string|max:50',
                'status' => 'required|in:upcoming,ongoing,completed,cancelled',
                'image_event' => 'required|max:2048|mimes:jpeg,jpg,png',
                'id_jenisacara' => 'required|exists:jenis_acaras,id',
                'capacity' => 'required|numeric',
                'price' => 'required'

            ]);
        } else {
            //jika tidak ada gambar
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'location' => 'required|string|max:255',
                'organizer' => 'required|string|max:255',
                // 'type' => 'required|string|max:50',
                'status' => 'required|in:upcoming,ongoing,completed,cancelled', //validasi status in upcoming,ongoing,completed,cancelled 
                //merupakan in dari array yang mana harus berupa upcoming,ongoing,completed,cancelled
                'id_jenisacara' => 'required|exists:jenis_acaras,id',
                'capacity' => 'required|numeric',
                'price' => 'required'
            ]);
        }
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $data = events::find($id); //mencari data berdasarkan id
        $tanggal_awal = Carbon::parse($request->start_date)->format('Y-m-d'); //mengubah format dari string ke date dengan format Y-m-d
        $tanggal_akhir = Carbon::parse($request->end_date)->format('Y-m-d');
        $price = str_replace('.', '', $request->price); //menghilangkan titik
        $data->title = $request->title;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->start_date = $tanggal_awal;
        $data->end_date = $tanggal_akhir;
        $data->location = $request->location;
        $data->organizer = $request->organizer;
        // $data->type = $request->type;
        $data->status = $request->status;
        $data->id_jenisacara = $request->id_jenisacara;
        $data->capacity = $request->capacity;
        $data->price = $price;

        if ($request->hasFile('image_event')) {
            # code...
            $file = (public_path('/event/' . $data->image_event));
            @unlink($file);
            $fileName = time() . '.' . $request->file('image_event')->getClientOriginalExtension();
            $request->file('image_event')->move(public_path() . '/event', $fileName);
            $data->image_event = $fileName;
        }
        $data->save();
        Alert::success('Success', 'Data Berhasil di ubah')->flash();
        return redirect()->route('ipen');
    }
    public function hapus_event($id)
    {
        $data = events::find($id);
        $file = (public_path('/event/' . $data->image_event));
        if (file_exists($file)) {
            @unlink($file);
        }
        $data->delete();
        Alert::success('Success', 'Data Berhasil di hapus')->flash();
        return redirect()->route('ipen');
    }
}
