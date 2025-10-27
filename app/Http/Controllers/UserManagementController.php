<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // buat fungsi untuk nantinya melihat list user dan mengelola user
    public function index(Request $request)
    {
        // Only superadmin can access
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $q = $request->input('q');
        $status = $request->input('status', 'all');

        $query = User::with('umkm');

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('user-management.index', compact('users'));
    }
    public function changeStatus(Request $request, $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $newStatus = $request->input('status');

        // Validate the new status
        if (!in_array($newStatus, ['approved', 'rejected', 'pending'])) {
            return redirect()->back()->withErrors(['Invalid status provided.']);
        }

        $user->status = $newStatus;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
    public function show(User $user)
    {
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        return view('user-management.detail', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,superadmin',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'status']));

        return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function updateUmkm(Request $request, $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $umkm = \App\Models\UmkmProfile::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kategori_usaha' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        $umkm->update($request->only(['nama_usaha', 'kategori_usaha', 'deskripsi', 'alamat']));

        return redirect()->back()->with('success', 'Data UMKM berhasil diperbarui.');
    }


}
