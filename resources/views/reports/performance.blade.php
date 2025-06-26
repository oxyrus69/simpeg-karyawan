<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kinerja Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Grafik Tren Kinerja -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Tren Rata-rata Skor Kinerja Bulanan</h3>
                    <div class="h-80">
                         <canvas id="monthlyPerformanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tabel Rata-rata per Departemen -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                     <h3 class="text-xl font-semibold text-gray-800 mb-4">Rangkuman Kinerja per Departemen</h3>
                     <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departemen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Penilaian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata Skor</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($departmentPerformance as $dept)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dept['nama_departemen'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dept['jumlah_review'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $dept['rata_rata_skor'] >= 85 ? 'text-green-600' : ($dept['rata_rata_skor'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ number_format($dept['rata_rata_skor'], 2) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Belum ada data penilaian untuk ditampilkan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data dari controller
            const monthlyLabels = @json($monthlyLabels);
            const monthlyScores = @json($monthlyScores);

            // Inisialisasi Grafik
            const ctx = document.getElementById('monthlyPerformanceChart');
            new Chart(ctx, {
                type: 'line', // Tipe grafik garis
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Rata-rata Skor Kinerja',
                        data: monthlyScores,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100 // Skor maksimal adalah 100
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>