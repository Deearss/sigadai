<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 px-4 sm:px-0">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan aktivitas dan metrik utama barang gadai Anda.</p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                
                <!-- Kiri: Metrik Utama (2 Kolom) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Row 1: Status Barang -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Barang</p>
                                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBarang }}</h3>
                                </div>
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-1.5">
                                <span class="text-xs text-gray-500">Keseluruhan data tercatat</span>
                                <a href="{{ route('barang.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1 transition-colors relative z-20 group">
                                    Lihat Data <span class="group-hover:translate-x-1 transition-transform" aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Barang Aktif</p>
                                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $barangAktif }}</h3>
                                </div>
                                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-1.5">
                                <span class="text-xs text-gray-500">Sedang dalam masa gadai</span>
                                <a href="{{ route('barang.index', ['status' => 'aktif']) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 inline-flex items-center gap-1 transition-colors relative z-20 group">
                                    Filter Aktif <span class="group-hover:translate-x-1 transition-transform" aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Jatuh Tempo</p>
                                    <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $barangJatuhTempo }}</h3>
                                </div>
                                <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-1.5">
                                <span class="text-xs text-gray-500">Membutuhkan tindakan</span>
                                <a href="{{ route('barang.index', ['status' => 'jatuh_tempo']) }}" class="text-sm font-semibold text-red-600 hover:text-red-800 inline-flex items-center gap-1 transition-colors relative z-20 group">
                                    Cek Sekarang <span class="group-hover:translate-x-1 transition-transform" aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Keuangan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gray-900 rounded-2xl p-6 shadow-lg text-white flex flex-col justify-between relative overflow-hidden group">
                            <!-- Background Pattern -->
                            <div class="absolute -right-6 -top-6 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L22 7L12 12L2 7L12 2Z" fill="currentColor"/>
                                    <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                    <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            
                            <div class="relative z-10">
                                <p class="text-sm font-medium text-gray-400">Total Taksiran (Keseluruhan)</p>
                                <h3 class="text-3xl font-bold mt-2">Rp {{ number_format($totalTaksiranKeseluruhan, 0, ',', '.') }}</h3>
                            </div>
                            <div class="relative z-10 mt-6 flex items-center text-sm text-gray-400">
                                Nilai aset seluruh data historis
                            </div>
                        </div>

                        <div class="bg-indigo-600 rounded-2xl p-6 shadow-lg text-white flex flex-col justify-between relative overflow-hidden group">
                            <!-- Background Pattern -->
                            <div class="absolute -right-6 -top-6 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2V22M12 2L6 8M12 2L18 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <div class="relative z-10">
                                <p class="text-sm font-medium text-indigo-200">Taksiran Barang Aktif</p>
                                <h3 class="text-3xl font-bold mt-2">Rp {{ number_format($totalTaksiranAktif, 0, ',', '.') }}</h3>
                            </div>
                            <div class="relative z-10 mt-6 flex items-center text-sm text-indigo-200">
                                Nilai aset yang sedang berjalan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Chart (1 Kolom) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
                    <h3 class="text-base font-semibold text-gray-900 mb-6">Distribusi Status Barang</h3>
                    
                    <div class="relative flex-1 min-h-[250px] w-full flex items-center justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                    
                    <div class="mt-6 flex justify-center w-full">
                        <a href="{{ route('barang.index') }}" class="w-full text-center px-4 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Kelola Semua Barang &rarr;
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statusChart').getContext('2d');
            
            // Data dari Controller
            const rawData = @json($statusStats);
            const labels = Object.keys(rawData);
            const data = Object.values(rawData);
            
            // Kalo data kosong semua (belum ada barang), set dummy biar chart tetep render bagus
            const isDataEmpty = data.every(item => item === 0);
            const chartData = isDataEmpty ? [1] : data;
            const chartBgColors = isDataEmpty 
                ? ['#f3f4f6'] 
                : ['#10b981', '#6366f1', '#ef4444']; // Aktif (Emerald), Ditebus (Indigo), Jatuh Tempo (Red)
                
            const chartBorderColors = isDataEmpty 
                ? ['#e5e7eb'] 
                : ['#059669', '#4f46e5', '#dc2626'];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: isDataEmpty ? ['Belum ada data'] : labels,
                    datasets: [{
                        data: chartData,
                        backgroundColor: chartBgColors,
                        borderColor: chartBorderColors,
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            enabled: !isDataEmpty,
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            padding: 12,
                            titleFont: {
                                family: "'Inter', sans-serif",
                                size: 13
                            },
                            bodyFont: {
                                family: "'Inter', sans-serif",
                                size: 13
                            },
                            cornerRadius: 8,
                            displayColors: true,
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
