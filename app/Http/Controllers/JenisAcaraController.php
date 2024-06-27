<?php

namespace App\Http\Controllers;

use App\Models\JenisAcara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class JenisAcaraController extends Controller
{
    public function index( Request $request) {
        $title="Jenis Acara";
        $data=JenisAcara::where('jenis_acara', 'like', '%' . $request->search . '%')->paginate(10);//mengambil 10 data
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('jenis_acara.index',compact('title', 'data', 'offset'));
    }
    public function tambah_jenis_acara(Request $request ){
$validator= Validator::make($request->all(), [
    'jenis_acara' => 'required|string|max:255',
]);
if ($validator->fails()) {
    $messages = $validator->errors()->all();
    Alert::error($messages)->flash();
    return back()->withErrors($validator)->withInput();
}
$data = new JenisAcara();
$data->jenis_acara = $request->jenis_acara;
$data->save();
Alert::success('Success', 'Data Berhasil di tambah')->flash();//menampilkan pesan sukses
return redirect()->route('jenis_acara');
    }
    public function hapus_jenis_acara($id){
        $data = JenisAcara::find($id);
        $data->delete();
        Alert::success('Success', 'Data Berhasil di hapus')->flash();
        return redirect()->route('jenis_acara');
    }

    public function update_jenis_acara(Request $request){
        $validator= Validator::make($request->all(), [
            'id' => 'required',
            'jenis_acara' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $data = JenisAcara::find($request->id);
        $data->jenis_acara = $request->jenis_acara;
        $data->save();
        Alert::success('Success', 'Data Berhasil di update')->flash();
        return redirect()->route('jenis_acara');
    }
}
