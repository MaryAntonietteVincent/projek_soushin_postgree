<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function index( Request $request) {
        $title="Kelas";
        $data=Kelas::where('kelas', 'like', '%' . $request->search . '%')->paginate(10);
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('kelas.index',compact('title', 'data', 'offset'));
    }

    public function tambah_kelas(Request $request) {
        $data = new Kelas();
        $data->kelas = $request->input('kelas');
        $data->save();
        Alert::success('Success', 'Data Berhasil di tambah')->flash();
        return redirect()->back();
    }
    public function update_kelas(Request $request) {
        $data = Kelas::find($request->input('id'));
        $data->kelas = $request->input('kelas');
        $data->save();
        Alert::success('Success', 'Data Berhasil di ubah')->flash();
        return redirect()->back();
        
    }

    public function data_materi($id) {
        $kelas=Kelas::find($id);
        $title="Materi Dari Kelas" . $kelas->kelas;
        $data=Materi::where('id_kelas', $id) ->paginate(30);
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('kelas.materi',compact('title', 'data','id','offset'));

    }
    public function tambah_materi(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_materi' => 'required|string|max:255',
            'id_kelas' => 'required|exists:kelas,id',
            // 'harga' => 'required',
            'file_materi' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,pdf,doc,xls,xlsx|max:2048',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        $fileName = time() . '.' . $request->file('file_materi')->getClientOriginalExtension();
        $request->file('file_materi')->move(public_path() . '/materi', $fileName);
        $data = new Materi();
        $data->nama_materi = $request->input('nama_materi');
        $data->id_kelas = $request->input('id_kelas');
        $data->file_materi = $fileName;
        $data->save();
        Alert::success('Success', 'Data Berhasil di tambah')->flash();
        return redirect()->back();
    }
    public function hapus_materi($id) {
        $data = Materi::find($id);
        $file=(public_path('/materi/'.$data->file_materi));
        if (file_exists($file)) {
        @unlink($file);
        }
        $data->delete();
        Alert::success('Success', 'Data Berhasil di hapus')->flash();
        return redirect()->back();
    }
    public function  update_materi(Request $request) {
        if ($request->hasFile('file_materi')) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'nama_materi' => 'required|string|max:255',
                'id_kelas' => 'required|exists:kelas,id',
                'file_materi' => 'required|mimes:jpeg,png,jpg,gif,svg,docx,pdf,doc,xls,xlsx|max:2048',
            # code..
            ]);

        } else {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'nama_materi' => 'required|string|max:255',
                'id_kelas' => 'required|exists:kelas,id',
            ]);
        }

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $data = Materi::find($request->input('id'));
        $data->nama_materi = $request->input('nama_materi');
        $data->id_kelas = $request->input('id_kelas');
        if ($request->hasFile('file_materi')) {
            $file=(public_path('/materi/'.$data->file_materi));
            if (file_exists($file)) {
            @unlink($file);
            }
            $fileName = time() . '.' . $request->file('file_materi')->getClientOriginalExtension();
            $request->file('file_materi')->move(public_path() . '/materi', $fileName);
            $data->file_materi = $fileName; 
        }
        $data->save();
        Alert::success('Success', 'Data Berhasil di ubah')->flash();
        return redirect()->back();
        
    }

    public function hapus_kelas($id) {
        $data = Kelas::find($id);
        $materi = Materi::where('id_kelas', $id)->get();
        foreach ($materi as $key => $value) {
            $file=(public_path('/materi/'.$value->file_materi));
            if (file_exists($file)) {
            @unlink($file);
            }
            $value->delete();
        }
        $data->delete();
        Alert::success('Success', 'Data Berhasil di hapus')->flash();
        return redirect()->back();

    }
}
