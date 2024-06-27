<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KeranjangController extends Controller
{

    public function tambah_keranjang(Request $request)
    {
        auth()->user()->id;
        $pelanggan = Pelanggan::where('id_user', auth()->user()->id)->first();//mengambil data pelanggan berdasarkan id user
        // dd($pelanggan->id);
        $validator = Validator::make($request->all(), [
            // 'id_user' => 'required',
            'id_barang' => 'required',
            'qty' => 'required',
            'subtotal_harga' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $subtotal = str_replace('.', '', $request->subtotal_harga);
        $cek = Keranjang::where('id_pelanggan', $pelanggan->id)->where('id_barang', $request->id_barang)->first();//mengambil data keranjang berdasarkan id pelanggan dan id barang
        if ($cek) {//jika data ada
            $cek->update([//update data
                'qty' => $cek->qty + $request->qty,// mengubah kolom qty dengan penambahan qty
                'sub_total' => $cek->sub_total + $subtotal//mengubah kolom sub_total dengan penambahan sub_total
                   
            ]);
        } else {
            $data = new Keranjang();//membuat object data dari model Keranjang
            $data->id_pelanggan = $pelanggan->id;//mengisi kolom id pelanggan
            $data->id_barang = $request->id_barang;//mengisi kolom id barang
            $data->qty = $request->qty;//mengisi kolom qty
            $data->sub_total = $subtotal;//mengisi kolom sub_total
            $data->save();
        }
        Alert::success('Success', 'Data Berhasil di tambah')->flash();
        return redirect()->route('barang');
    }
}
