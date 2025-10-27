<x-app-layout title="Detail User - {{ $user->name }}">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Header -->
        <div class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail User</h1>
                        <p class="text-gray-600 mt-1">Informasi lengkap pengguna dan UMKM terkait</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('user-management.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- User Details -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Informasi Pengguna</h3>
                    <button onclick="toggleEditUser()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <i class="fas fa-edit mr-2"></i> Edit User
                    </button>
                </div>

                <!-- View Mode -->
                <div id="user-view" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peran</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role ?? 'user') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($user->status === 'approved') bg-green-100 text-green-800
                            @elseif($user->status === 'rejected') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            @if($user->status === 'approved') Disetujui
                            @elseif($user->status === 'rejected') Ditolak
                            @else Pending @endif
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dibuat Pada</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terakhir Update</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Edit Mode -->
                <form id="user-edit" method="POST" action="{{ route('user-management.update', $user->id) }}" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peran</label>
                        <select name="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $user->status === 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ $user->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="md:col-span-2 flex justify-end space-x-3">
                        <button type="button" onclick="toggleEditUser()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>

            @if($user->umkm)
            <!-- UMKM Details -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Informasi UMKM</h3>
                    <button onclick="toggleEditUmkm()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <i class="fas fa-edit mr-2"></i> Edit UMKM
                    </button>
                </div>

                <!-- View Mode -->
                <div id="umkm-view" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Usaha</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->umkm->nama_usaha }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori Usaha</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->umkm->kategori_usaha }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->umkm->deskripsi }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->umkm->alamat }}</p>
                    </div>
                </div>

                <!-- Edit Mode -->
                <form id="umkm-edit" method="POST" action="{{ route('user-management.update-umkm', $user->umkm->id) }}" class="hidden grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Usaha</label>
                        <input type="text" name="nama_usaha" value="{{ $user->umkm->nama_usaha }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori Usaha</label>
                        <input type="text" name="kategori_usaha" value="{{ $user->umkm->kategori_usaha }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $user->umkm->deskripsi }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $user->umkm->alamat }}</textarea>
                    </div>
                    <div class="md:col-span-2 flex justify-end space-x-3">
                        <button type="button" onclick="toggleEditUmkm()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Batal</button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    <script>
        function toggleEditUser() {
            const view = document.getElementById('user-view');
            const edit = document.getElementById('user-edit');
            view.classList.toggle('hidden');
            edit.classList.toggle('hidden');
        }

        function toggleEditUmkm() {
            const view = document.getElementById('umkm-view');
            const edit = document.getElementById('umkm-edit');
            view.classList.toggle('hidden');
            edit.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
