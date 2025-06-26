<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Tim') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Kartu Statistik Manajer -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Kartu Total Anggota Tim -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                            <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.28-2.72a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479m7.28 2.72a3 3 0 01-4.682 2.72a9.094 9.094 0 013.741.479M6.585 12.585a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479m7.28 2.72a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Total Anggota Tim</p>
                            <p class="text-3xl font-semibold text-gray-900">{{ $totalTeamMembers }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Aktivitas Terbaru untuk Manajer -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Anggota Tim Baru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Anggota Tim Baru</h3>
                        <ul role="list" class="mt-4 divide-y divide-gray-200">
                            @forelse ($latestTeamHires as $employee)
                                <li class="py-3 flex">
                                    @if ($employee->photo)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('uploads/photos/' . $employee->photo) }}" alt="">
                                    @else
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                                            <span class="font-medium text-gray-600">{{ strtoupper(substr($employee->nama_lengkap, 0, 2)) }}</span>
                                        </span>
                                    @endif
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $employee->nama_lengkap }}</p>
                                        <p class="text-sm text-gray-500">{{ $employee->position->nama_jabatan ?? 'N/A' }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="py-3 text-center text-sm text-gray-500">Tidak ada anggota tim baru.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Penilaian Kinerja Terkini di Tim Anda -->
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Penilaian Kinerja Terkini (Tim)</h3>
                        <ul role="list" class="mt-4 divide-y divide-gray-200">
                            @forelse ($recentTeamReviews as $review)
                                <li class="py-3">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-indigo-600 truncate">{{ $review->employee->nama_lengkap ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($review->tanggal_review)->diffForHumans() }}</p>
                                    </div>
                                    <div class="mt-1 flex items-center justify-between">
                                        <p class="text-sm text-gray-600 line-clamp-1">{{ $review->komentar }}</p>
                                        <p class="text-sm font-semibold {{ $review->skor_kinerja >= 85 ? 'text-green-600' : ($review->skor_kinerja >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $review->skor_kinerja }}</p>
                                    </div>
                                </li>
                             @empty
                                <li class="py-3 text-center text-sm text-gray-500">Tidak ada penilaian kinerja baru di tim Anda.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
