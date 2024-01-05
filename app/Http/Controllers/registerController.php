<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class RegisterController extends Controller
{
    public function indexx()
    {
        return view('login.register');
    }
 
    public function storee(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required',
            'role' => 'required'
        ]);
 
        $validatedData['password'] = Hash::make($validatedData['password']);
 
        User::create($validatedData);
        return redirect('/')->with('success', 'Registration Succesfull! Please Login');
    }
}