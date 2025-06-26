<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    
                    <!-- Header Kartu dengan Tombol Aksi -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Profil Karyawan</h2>
                        <div class="flex items-center gap-x-2 mt-2 md:mt-0">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Kembali
                            </a>
                            @if(in_array(auth()->user()->role, ['admin', 'manager']))
                                <a href="{{ route('reviews.create', $employee->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Tambah Penilaian
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Bagian Header Profil -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6">
                        <div class="flex-shrink-0 mb-4 sm:mb-0">
                            @if ($employee->photo)
                                <img class="h-24 w-24 rounded-full object-cover" src="{{ asset('uploads/photos/' . $employee->photo) }}" alt="Foto Profil">
                            @else
                                <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-200 text-gray-600">
                                    <span class="text-3xl font-medium leading-none">{{ strtoupper(substr($employee->nama_lengkap, 0, 2)) }}</span>
                                </span>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $employee->nama_lengkap }}</h3>
                            <p class="text-md text-gray-600">{{ $employee->position->nama_jabatan ?? 'Jabatan tidak tersedia' }}</p>
                            <p class="text-sm text-gray-500">{{ $employee->department->nama_departemen ?? 'Departemen tidak tersedia' }}</p>
                        </div>
                    </div>

                    <!-- Pemisah -->
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-8 gap-y-10">
                            
                            <!-- Kolom Informasi Detail -->
                            <div class="lg:col-span-1">
                                <h3 class="text-lg font-medium text-gray-900">Informasi & Kontak</h3>
                                <dl class="mt-4 space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email Akun</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->user->email ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->no_telepon }}</dd>
                                    </div>
                                     <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($employee->tanggal_bergabung)->isoFormat('D MMMM YYYY') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->alamat }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Kolom Riwayat Penilaian -->
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900">Riwayat Penilaian Kinerja</h3>
                                <div class="mt-4 space-y-4">
                                    @forelse ($employee->performanceReviews->sortByDesc('tanggal_review') as $review)
                                        <div class="p-4 border rounded-lg hover:bg-gray-50 transition duration-150">
                                            <div class="flex justify-between items-baseline">
                                                <p class="font-semibold text-gray-800">Skor: <span class="text-xl font-bold {{ $review->skor_kinerja >= 85 ? 'text-green-600' : ($review->skor_kinerja >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $review->skor_kinerja }}</span><span class="text-sm text-gray-500"> / 100</span></p>
                                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($review->tanggal_review)->isoFormat('D MMM YYYY') }}</p>
                                            </div>
                                            <p class="mt-2 text-gray-700 text-sm">{{ $review->komentar }}</p>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 px-4 border-2 border-dashed rounded-lg">
                                             <p class="text-sm text-gray-500">Belum ada data penilaian.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
