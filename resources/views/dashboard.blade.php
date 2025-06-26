<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Kartu Total Karyawan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                            <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.28-2.72a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479m7.28 2.72a3 3 0 01-4.682 2.72a9.094 9.094 0 013.741.479M6.585 12.585a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479m7.28 2.72a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Total Karyawan</p>
                            <p class="text-3xl font-semibold text-gray-900">{{ $totalKaryawan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Total Departemen -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18M3 7.5h18M3 12h18m-4.5 9v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Total Departemen</p>
                            <p class="text-3xl font-semibold text-gray-900">{{ $totalDepartemen }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Total Jabatan -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                             <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" /></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 truncate">Total Jabatan</p>
                            <p class="text-3xl font-semibold text-gray-900">{{ $totalJabatan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Aktivitas Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Karyawan Baru Bergabung -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Karyawan Baru Bergabung</h3>
                        <ul role="list" class="mt-4 divide-y divide-gray-200">
                            @forelse ($latestEmployees as $employee)
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
                                <li class="py-3 text-center text-sm text-gray-500">Tidak ada karyawan baru.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Penilaian Kinerja Terkini -->
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Penilaian Kinerja Terkini</h3>
                        <ul role="list" class="mt-4 divide-y divide-gray-200">
                            @forelse ($recentReviews as $review)
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
                                <li class="py-3 text-center text-sm text-gray-500">Tidak ada penilaian kinerja baru.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kartu Grafik -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-white">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Distribusi Karyawan per Departemen</h3>
                    <div class="h-80 md:h-96">
                         <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Memindahkan data dari PHP ke JavaScript dengan aman
        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);

        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('departmentChart');
            if (canvas) {
                new Chart(canvas, {
                    type: 'doughnut',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Jumlah Karyawan',
                            data: chartData,
                            backgroundColor: [
                                '#4f46e5', // Indigo-600
                                '#16a34a', // Green-600
                                '#ca8a04', // Yellow-600
                                '#dc2626', // Red-600
                                '#9333ea', // Purple-600
                                '#ea580c',  // Orange-600
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                        },
                        cutout: '65%',
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>