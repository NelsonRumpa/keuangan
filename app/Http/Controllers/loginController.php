<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class loginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user(); // Mengambil data pengguna yang sudah login
            $role = $user->role;
    
            if ($role === 1) {
                return redirect()->intended('/admin'); // Jika role adalah 1 (admin), arahkan ke halaman admin
            } elseif ($role === 2){
                return redirect()->intended('/bendahara'); // Jika role adalah 0 (pegawai), arahkan ke halaman pegawai
            }else{
                return redirect()->intended('/transaksi');
            }
        }
 
        return back()->with('loginError', 'Login failed');
    }
 
    public function logout(Request $request)
    {
        Auth::logout();
 
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
 
        return redirect('/');
    }


}
