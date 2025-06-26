<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Cek apakah profil karyawan sudah ada --}}
            @if ($employee)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 bg-white">
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
                                    </dl>
                                </div>

                                <!-- Kolom Riwayat Penilaian -->
                                <div class="lg:col-span-2">
                                    <h3 class="text-lg font-medium text-gray-900">Riwayat Penilaian Kinerja Saya</h3>
                                    <div class="mt-4 space-y-4">
                                        @forelse ($employee->performanceReviews->sortByDesc('tanggal_review') as $review)
                                            <div class="p-4 border rounded-lg">
                                                <div class="flex justify-between items-baseline">
                                                    <p class="font-semibold text-gray-800">Skor: <span class="text-xl font-bold {{ $review->skor_kinerja >= 85 ? 'text-green-600' : ($review->skor_kinerja >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $review->skor_kinerja }}</span><span class="text-sm text-gray-500"> / 100</span></p>
                                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($review->tanggal_review)->isoFormat('D MMM YYYY') }}</p>
                                                </div>
                                                <p class="mt-2 text-gray-700 text-sm">{{ $review->komentar }}</p>
                                            </div>
                                        @empty
                                            <div class="text-center py-8 px-4 border-2 border-dashed rounded-lg">
                                                 <p class="text-sm text-gray-500">Anda belum memiliki riwayat penilaian kinerja.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Tampilan jika profil karyawan belum dibuat oleh admin --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p class="text-lg font-semibold">Selamat Datang!</p>
                        <p class="mt-2 text-gray-600">Profil karyawan Anda belum lengkap. Silakan hubungi Administrator untuk melengkapi data Anda.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>