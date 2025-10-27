<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UmkmProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\NewUserRegistered;
use Illuminate\Support\Facades\Mail;
use Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama_usaha' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kategori_usaha' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
        ];

        $request->validate($rules);

        // Create UMKM profile first
        $umkm = UmkmProfile::create([
            'nama_usaha' => $request->nama_usaha,
            'deskripsi' => $request->deskripsi ?? null,
            'kategori_usaha' => $request->kategori_usaha,
            'alamat' => $request->alamat ?? null,
        ]);

        // Create user with UMKM role and pending status
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'umkm',
            'status' => 'pending',
            'umkm_id' => $umkm->id,
        ]);
        try {
            // Kirim email ke semua superadmin untuk approval
            $superadmins = User::where('role', 'superadmin')->get();
            foreach ($superadmins as $admin) {
                Mail::to($admin->email)->send(new NewUserRegistered($user));
            }
            //code...
        } catch (\Throwable $th) {
            Log::error('Failed to send new user registration email to superadmins: ' . $th->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
