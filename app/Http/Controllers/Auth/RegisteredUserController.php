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
        ];

        $isUmkm = $request->has('is_umkm');
        if ($isUmkm) {
            $rules = array_merge($rules, [
                'nama_usaha' => ['required', 'string', 'max:255'],
                'deskripsi' => ['nullable', 'string'],
                'kategori_usaha' => ['nullable', 'string', 'max:255'],
                'alamat' => ['nullable', 'string'],
            ]);
        }

        $request->validate($rules);

        // Create user with default role/status. If UMKM selected, set role later.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $isUmkm ? 'umkm' : 'user',
            'status' => $isUmkm ? 'pending' : 'approved',
        ]);

        // If registering as UMKM, create UMKM profile and link
        if ($isUmkm) {
            $umkm = UmkmProfile::create([
                'nama_usaha' => $request->nama_usaha,
                'deskripsi' => $request->deskripsi ?? null,
                'kategori_usaha' => $request->kategori_usaha ?? null,
                'alamat' => $request->alamat ?? null,
                'status' => 'pending',
            ]);

            // link user -> umkm
            $user->umkm_id = $umkm->id;
            $user->save();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
