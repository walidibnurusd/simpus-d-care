<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }

        return view('auth.login');
    }

 
    public function login(Request $request)
{
    $request->validate([
        'login' => 'required', // Input bisa berupa email atau NIP
        'password' => 'required',
        'captcha' => 'required',
    ]);

    $inputCaptcha = $request->input('captcha-input');
    $generatedCaptcha = $request->input('captcha-code');
    
    // Validasi CAPTCHA
    if ($inputCaptcha !== $generatedCaptcha) {
        return response()->json([
            'message' => 'CAPTCHA does not match.',
            'inputCaptcha' => $inputCaptcha,
            'generatedCaptcha' => $generatedCaptcha
        ], 400);
    }

    $login = $request->input('login'); // Input yang bisa berupa email atau NIP
    $password = $request->input('password');

    // Mencari pengguna berdasarkan email atau NIP
    $user = User::where(function ($query) use ($login) {
        $query->where('email', $login)
              ->orWhere('nip', $login);
    })->first();

    if ($user && Auth::attempt(['email' => $user->email, 'password' => $password]) ||
        ($user && $user->nip === $login && Auth::attempt(['password' => $password]))
    ) {
        return response()->json(['message' => 'Login successful.']);
    }

    return response()->json(['message' => 'Email/NIP atau kata sandi yang Anda masukkan salah'], 401);
}


    public function logout()
    {
        Auth::logout();
        return redirect('/login'); // Sesuaikan dengan rute login Anda
    }
    public function update(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->no_hp = $validatedData['phone'];
        $user->address = $validatedData['address'];
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    } catch (Exception $e) {
        
        return redirect()->back()->withErrors('An error occurred while updating the profile. Please try again.');
    }
} 
public function changePassword(Request $request, $id)
{
    try {
        // Validasi input dari form
        $validatedData = $request->validate([
            'password' => 'required', 
            'newPassword' => 'required', 
            'confirmPassword' => 'required|same:newPassword',
        ]);

        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah password lama yang dimasukkan sesuai dengan password yang ada di database
        if (!Hash::check($validatedData['password'], $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Password lama tidak sesuai']);
        }

        // Jika password lama sesuai, maka update dengan password baru
        if ($request->filled('newPassword')) {
            $user->password = bcrypt($validatedData['newPassword']);
        }

        // Simpan perubahan ke database
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    } catch (Exception $e) {
        // Log error dan tampilkan pesan kesalahan
        Log::error('Error updating password: ' . $e->getMessage());
        return redirect()->back()->withErrors('Terjadi kesalahan saat mengubah password. Silakan coba lagi.');
    }
}


}
