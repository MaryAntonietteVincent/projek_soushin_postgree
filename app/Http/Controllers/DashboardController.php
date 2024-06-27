<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $title="Dashboard";
        if (Auth::check()) {
            $role=auth()->user()->role;

            switch ($role) {
                case 'admin':
            return view('dashboard.dashboard_admin',compact('title'));
                    break;
                
            case 'pelanggan':
                $userId = Auth::id();
                $pelanggan=Pelanggan::where('id_user', $userId)->first();
                $jumlah_pesanan = Keranjang::where('id_pelanggan', $pelanggan->id)->count();// menghitung keranjang berdsarkan id pelanggan
                return view('dashboard.dashboard_pelanggan',compact('title','jumlah_pesanan'));
                break;
                    # code...
                    
            }
        }
    }
}
