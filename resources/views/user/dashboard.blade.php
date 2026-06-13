@extends('user.header')
@section('content')

    <main class="p-margin-page space-y-gutter">
        <!-- Hero Map Section -->
        <section class="relative w-full h-[500px] rounded-xl overflow-hidden border border-outline-variant shadow-sm">

            <!-- LEAFLET CSS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

            <!-- MAP -->
            <div id="map" class="w-full h-full z-10"></div>

        </section>

        <!-- LEAFLET JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>

            // =========================
            // INIT MAP
            // =========================
            var map = L.map('map');

            // =========================
            // TILE LAYER
            // =========================
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

                attribution: '&copy; OpenStreetMap'

            }).addTo(map);

            // =========================
            // ARRAY UNTUK AUTO ZOOM
            // =========================
            var bounds = [];

            // =========================
            // CUSTOM ICON
            // =========================
            function createIcon(color) {

                return L.divIcon({

                    className: '',

                    html: `
                                        <div style="
                                            width:20px;
                                            height:20px;
                                            background:${color};
                                            border:3px solid white;
                                            border-radius:50%;
                                            box-shadow:0 0 10px rgba(0,0,0,0.4);
                                        "></div>
                                    `,

                    iconSize: [20, 20],
                    iconAnchor: [10, 10]

                });

            }

            // =========================
            // LOOP DATA CONTAINER
            // =========================
            @foreach ($containers as $container)

                @if ($container->latitude && $container->longitude)

                    @php

                        if ($container->persen >= 81) {

                            $status = 'Penuh';
                            $color = '#dc2626';

                        } elseif ($container->persen >= 11) {

                            $status = 'Berisi';
                            $color = '#f59e0b';

                        } else {

                            $status = 'Kosong';
                            $color = '#16a34a';

                        }

                    @endphp

                    // KOORDINAT
                    var lat = {{ $container->latitude }};
                    var lng = {{ $container->longitude }};

                    // MASUKKAN KE ARRAY BOUNDS
                    bounds.push([lat, lng]);

                    // =========================
                    // MARKER
                    // =========================
                    var marker = L.marker(
                        [lat, lng],
                        {
                            icon: createIcon('{{ $color }}')
                        }
                    ).addTo(map);

                    // =========================
                    // POPUP
                    // =========================
                    marker.bindPopup(`

                                                                                        <div style="width:220px">

                                                                                            <h3 style="
                                                                                                font-size:16px;
                                                                                                font-weight:bold;
                                                                                                margin-bottom:8px;
                                                                                                color:#00535b;
                                                                                            ">
                                                                                                {{ $container->kode_containers }}
                                                                                            </h3>

                                                                                            <p style="margin-bottom:6px;">
                                                                                                <b>Lokasi:</b><br>
                                                                                                {{ $container->nama_lokasi }}
                                                                                            </p>

                                                                                            <p style="margin-bottom:6px;">
                                                                                                <b>Status:</b>
                                                                                                {{ $status }}
                                                                                            </p>

                                                                                            <p style="margin-bottom:6px;">
                                                                                                <b>Persentase:</b>
                                                                                                {{ $container->persen }}%
                                                                                            </p>

                                                                                            <p style="margin-bottom:10px;">
                                                                                                <b>Baterai:</b>
                                                                                                {{ $container->baterai }}%
                                                                                            </p>

                                                                                            <a href="https://www.google.com/maps?q={{ $container->latitude }},{{ $container->longitude }}"
                                                                                                target="_blank"
                                                                                                style="
                                                                                                    display:inline-block;
                                                                                                    padding:8px 12px;
                                                                                                    background:#00535b;
                                                                                                    color:white;
                                                                                                    border-radius:8px;
                                                                                                    text-decoration:none;
                                                                                                    font-size:14px;
                                                                                                    font-weight:600;
                                                                                                ">

                                                                                                📍 Buka Google Maps

                                                                                            </a>

                                                                                        </div>

                                                                                    `);

                @endif

            @endforeach

                            // =========================
                            // AUTO FOCUS KE TITIK
                            // =========================
                            if (bounds.length > 0) {

                map.fitBounds(bounds, {

                    padding: [50, 50]

                });

            } else {

                // DEFAULT JIKA TIDAK ADA DATA
                map.setView([-6.200000, 106.816666], 11);

            }

        </script>
        <!-- Data Table Section -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
            <div class="p-card-padding border-b border-outline-variant flex justify-between items-center bg-white">
                <div>
                    <h3 class="font-h2 text-h2 text-primary">Ringkasan Status Tong Sampah</h3>
                    <p class="text-body-md text-on-surface-variant">Laporan status terperinci untuk semua sensor IoT yang
                        terhubung</p>
                </div>
                <a href="/export-excel"
                    class="bg-primary text-on-primary px-stack-lg py-2 rounded-lg font-bold hover:opacity-90 transition-all flex items-center gap-2">

                    <span class="material-symbols-outlined text-[18px]">
                        download
                    </span>

                    Ekspor Excel

                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    <thead>

                        <tr
                            class="bg-surface-container-low text-on-surface-variant font-label-caps text-label-caps border-b border-outline-variant">

                            <th class="px-6 py-4">Nomor</th>
                            <th class="px-6 py-4">Kode Tong Sampah</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Kecamatan</th>
                            <th class="px-6 py-4">Kelurahan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Persentase Kepenuhan</th>
                            <th class="px-6 py-4">Status Baterai</th>
                            <th class="px-6 py-4">Waktu Pembaruan</th>
                            <th class="px-6 py-4">Maps</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-outline-variant">

                        @forelse ($containers as $container)

                            @php

                                // STATUS
                                if ($container->persen >= 81) {

                                    $status = 'Penuh';

                                    $statusBg = 'bg-error text-white';

                                    $progressBg = 'bg-error';

                                    $textColor = 'text-error';

                                } elseif ($container->persen >= 11) {

                                    $status = 'Berisi';

                                    $statusBg = 'bg-orange-500 text-white';

                                    $progressBg = 'bg-orange-500';

                                    $textColor = 'text-orange-500';

                                } else {

                                    $status = 'Kosong';

                                    $statusBg = 'bg-green-600 text-white';

                                    $progressBg = 'bg-green-600';

                                    $textColor = 'text-green-600';

                                }

                                // ICON BATERAI
                                if ($container->baterai >= 80) {

                                    $batteryIcon = 'battery_full';

                                } elseif ($container->baterai >= 60) {

                                    $batteryIcon = 'battery_5_bar';

                                } elseif ($container->baterai >= 40) {

                                    $batteryIcon = 'battery_4_bar';

                                } elseif ($container->baterai >= 20) {

                                    $batteryIcon = 'battery_3_bar';

                                } else {

                                    $batteryIcon = 'battery_1_bar';

                                }

                            @endphp

                            <tr class="hover:bg-surface-container-low transition-colors">

                                <!-- NOMOR -->
                                <td class="px-6 py-4 text-body-md font-semibold text-primary">

                                    {{ $loop->iteration }}

                                </td>

                                <!-- KODE -->
                                <td class="px-6 py-4 text-body-md">

                                    {{ $container->kode_containers }}

                                </td>

                                <!-- LOKASI -->
                                <td class="px-6 py-4 text-body-md">

                                    {{ $container->nama_lokasi }}

                                </td>

                                <!-- KECAMATAN -->
                                <td class="px-6 py-4 text-body-md">

                                    {{ $container->kecamatan->nama_kecamatan ?? '-' }}

                                </td>

                                <!-- KELURAHAN -->
                                <td class="px-6 py-4 text-body-md">

                                    {{ $container->kelurahan->nama_kelurahan ?? '-' }}

                                </td>

                                <!-- STATUS -->
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full font-bold text-[12px] {{ $statusBg }}">

                                        {{ $status }}

                                    </span>

                                </td>

                                <!-- PERSENTASE -->
                                <td class="px-6 py-4">

                                    <div class="w-full bg-surface-container-high h-2.5 rounded-full overflow-hidden">

                                        <div class="{{ $progressBg }} h-full" style="width: {{ $container->persen }}%">
                                        </div>

                                    </div>

                                    <span class="text-[12px] font-bold {{ $textColor }} mt-1 inline-block">

                                        {{ $container->persen }}%

                                    </span>

                                </td>

                                <!-- BATERAI -->
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-2 font-bold text-[12px]">

                                        <span class="material-symbols-outlined text-[18px]">

                                            {{ $batteryIcon }}

                                        </span>

                                        <span>

                                            {{ $container->baterai }}%

                                        </span>

                                    </div>

                                </td>

                                <!-- UPDATE -->
                                <td class="px-6 py-4 text-body-md text-on-surface-variant">

                                    {{ \Carbon\Carbon::parse($container->updated_at)->diffForHumans() }}

                                </td>

                                <!-- MAPS -->
                                <td class="px-6 py-4">

                                    <a href="https://www.google.com/maps?q={{ $container->latitude }},{{ $container->longitude }}"
                                        target="_blank"
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-primary text-white hover:scale-110 transition">

                                        <span class="material-symbols-outlined">

                                            location_on

                                        </span>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="text-center py-10 text-gray-500">

                                    Tidak ada data container

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>
            <div
                class="p-4 bg-surface-container-low flex justify-between items-center text-body-md text-on-surface-variant">
                <span class=""></span>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1 border border-outline-variant rounded bg-white hover:bg-surface-container-high disabled:opacity-50"
                        disabled="">Sebelumnya</button>
                    <button
                        class="px-3 py-1 border border-outline-variant rounded bg-white hover:bg-surface-container-high">Berikutnya</button>
                </div>
            </div>
        </div>
        <!-- Quick Stats Bento Grid -->
        @php

            $totalContainer = $containers->count();

            $tongPenuh = $containers->where('persen', '>=', 81)->count();

            $tongBerisi = $containers->whereBetween('persen', [11, 80])->count();

            $tongKosong = $containers->where('persen', '<=', 10)->count();

            $perluPengosongan = $containers->where('persen', '>=', 80)->count();

            $lowBattery = $containers->where('baterai', '<=', 20)->count();

            $totalWarning = $perluPengosongan + $lowBattery;

        @endphp

        <!-- CARD STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-gutter">

            <!-- TOTAL -->
            <div class="bg-white border border-outline-variant p-card-padding rounded-xl shadow-sm">

                <p class="text-label-caps text-on-surface-variant mb-2">

                    Total Tong Sampah

                </p>

                <div class="flex justify-between items-end">

                    <h4 class="text-stat-value font-stat-value text-primary">

                        {{ $totalContainer }}

                    </h4>

                    <span class="text-primary-container font-bold text-[12px] mb-2">

                        Total Aktif

                    </span>

                </div>

            </div>

            <!-- PERLU PENGOSONGAN -->
            <div class="bg-white border border-outline-variant p-card-padding rounded-xl shadow-sm">

                <p class="text-label-caps text-on-surface-variant mb-2">

                    Perlu Pengosongan

                </p>

                <div class="flex justify-between items-end">

                    <h4 class="text-stat-value font-stat-value text-error">

                        {{ $perluPengosongan }}

                    </h4>

                    <span class="text-error font-bold text-[12px] mb-2">

                        Prioritas Tinggi

                    </span>

                </div>

            </div>

            <!-- KOSONG -->
            <div class="bg-white border border-outline-variant p-card-padding rounded-xl shadow-sm">

                <p class="text-label-caps text-on-surface-variant mb-2">

                    Tong Kosong

                </p>

                <div class="flex justify-between items-end">

                    <h4 class="text-stat-value font-stat-value text-green-600">

                        {{ $tongKosong }}

                    </h4>

                    <span class="text-green-600 font-bold text-[12px] mb-2">

                        Optimal

                    </span>

                </div>

            </div>

            <!-- BERISI -->
            <div class="bg-white border border-outline-variant p-card-padding rounded-xl shadow-sm">

                <p class="text-label-caps text-on-surface-variant mb-2">

                    Tong Berisi

                </p>

                <div class="flex justify-between items-end">

                    <h4 class="text-stat-value font-stat-value text-orange-500">

                        {{ $tongBerisi }}

                    </h4>

                    <span class="text-orange-500 font-bold text-[12px] mb-2">

                        Normal

                    </span>

                </div>

            </div>

            <!-- PENUH -->
            <div class="bg-white border border-outline-variant p-card-padding rounded-xl shadow-sm">

                <p class="text-label-caps text-on-surface-variant mb-2">

                    Tong Penuh

                </p>

                <div class="flex justify-between items-end">

                    <h4 class="text-stat-value font-stat-value text-error">

                        {{ $tongPenuh }}

                    </h4>

                    <span class="text-error font-bold text-[12px] mb-2">

                        Segera

                    </span>

                </div>

            </div>

        </div>

        <!-- FLOAT WARNING BUTTON -->
        <div class="fixed bottom-8 right-8 z-50">

            <button onclick="openWarningModal()"
                class="bg-error text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95 relative">

                <span class="material-symbols-outlined text-[28px]" style='font-variation-settings: "FILL" 1;'>

                    warning

                </span>

                <!-- TOTAL WARNING -->
                <span
                    class="absolute -top-1 -right-1 w-5 h-5 bg-white text-error rounded-full text-[10px] flex items-center justify-center font-bold border-2 border-error">

                    {{ $totalWarning }}

                </span>

            </button>

        </div>

        <!-- MODAL WARNING -->
        <div id="warningModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[999] p-4">

            <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden">

                <!-- HEADER -->
                <div class="bg-error text-white px-6 py-4 flex justify-between items-center">

                    <h2 class="text-xl font-bold flex items-center gap-2">

                        <span class="material-symbols-outlined">
                            warning
                        </span>

                        Notifikasi Peringatan

                    </h2>

                    <button onclick="closeWarningModal()">

                        <span class="material-symbols-outlined">
                            close
                        </span>

                    </button>

                </div>

                <!-- CONTENT -->
                <div class="p-6 max-h-[500px] overflow-y-auto">

                    <!-- TONG PENUH -->
                    <h3 class="text-lg font-bold text-error mb-4">

                        Tong Sampah Penuh (>80%)

                    </h3>

                    <div class="space-y-4 mb-8">

                        @forelse ($containers->where('persen', '>=', 80) as $container)

                            <div class="border border-red-200 rounded-xl p-4 bg-red-50">

                                <div class="flex justify-between items-start">

                                    <div>

                                        <h4 class="font-bold text-red-700">

                                            {{ $container->kode_containers }}

                                        </h4>

                                        <p class="text-sm text-gray-600">

                                            {{ $container->nama_lokasi }}

                                        </p>

                                        <p class="text-sm mt-1">

                                            Kepenuhan:
                                            <span class="font-bold text-red-600">

                                                {{ $container->persen }}%

                                            </span>

                                        </p>

                                    </div>

                                    <a href="https://www.google.com/maps?q={{ $container->latitude }},{{ $container->longitude }}"
                                        target="_blank" class="bg-error text-white px-3 py-2 rounded-lg text-sm">

                                        Maps

                                    </a>

                                </div>

                            </div>

                        @empty

                            <div class="text-gray-500">

                                Tidak ada tong penuh

                            </div>

                        @endforelse

                    </div>

                    <!-- BATERAI LEMAH -->
                    <h3 class="text-lg font-bold text-orange-500 mb-4">

                        Baterai Lemah (<20%) </h3>

                            <div class="space-y-4">

                                @forelse ($containers->where('baterai', '<=', 20) as $container)

                                    <div class="border border-orange-200 rounded-xl p-4 bg-orange-50">

                                        <div class="flex justify-between items-start">

                                            <div>

                                                <h4 class="font-bold text-orange-600">

                                                    {{ $container->kode_containers }}

                                                </h4>

                                                <p class="text-sm text-gray-600">

                                                    {{ $container->nama_lokasi }}

                                                </p>

                                                <p class="text-sm mt-1">

                                                    Baterai:
                                                    <span class="font-bold text-orange-500">

                                                        {{ $container->baterai }}%

                                                    </span>

                                                </p>

                                            </div>

                                            <a href="https://www.google.com/maps?q={{ $container->latitude }},{{ $container->longitude }}"
                                                target="_blank" class="bg-orange-500 text-white px-3 py-2 rounded-lg text-sm">

                                                Maps

                                            </a>

                                        </div>

                                    </div>

                                @empty

                                    <div class="text-gray-500">

                                        Tidak ada baterai lemah

                                    </div>

                                @endforelse

                            </div>

                </div>

            </div>

        </div>

        <!-- SCRIPT -->
        <script>

            function openWarningModal() {

                document.getElementById('warningModal')
                    .classList.remove('hidden');

                document.getElementById('warningModal')
                    .classList.add('flex');

            }

            function closeWarningModal() {

                document.getElementById('warningModal')
                    .classList.remove('flex');

                document.getElementById('warningModal')
                    .classList.add('hidden');

            }

        </script>
        </body>

        </html>
        
        {{-- <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

            <div onclick="showTable('all')"
                class="bg-white border border-outline-variant p-5 rounded-xl shadow-sm cursor-pointer hover:shadow-lg transition">

                <p class="text-sm text-on-surface-variant mb-2">
                    Total Tong Sampah
                </p>

                <h4 class="text-4xl font-bold text-primary">
                    {{ $containers->count() }}
                </h4>

            </div>

            <div onclick="showTable('penuh')"
                class="bg-white border border-outline-variant p-5 rounded-xl shadow-sm cursor-pointer hover:shadow-lg transition">

                <p class="text-sm text-on-surface-variant mb-2">
                    Tong Penuh
                </p>

                <h4 class="text-4xl font-bold text-red-600">
                    {{ $containers->where('persen', '>=', 81)->count() }}
                </h4>

            </div>

            <div onclick="showTable('berisi')"
                class="bg-white border border-outline-variant p-5 rounded-xl shadow-sm cursor-pointer hover:shadow-lg transition">

                <p class="text-sm text-on-surface-variant mb-2">
                    Tong Berisi
                </p>

                <h4 class="text-4xl font-bold text-yellow-700">
                    {{ $containers->whereBetween('persen', [11, 80])->count() }}
                </h4>

            </div>

            <div onclick="showTable('kosong')"
                class="bg-white border border-outline-variant p-5 rounded-xl shadow-sm cursor-pointer hover:shadow-lg transition">

                <p class="text-sm text-on-surface-variant mb-2">
                    Tong Kosong
                </p>

                <h4 class="text-4xl font-bold text-green-600">
                    {{ $containers->whereBetween('persen', [0, 10])->count() }}
                </h4>

            </div>

            <div onclick="showTable('urgent')"
                class="bg-white border border-outline-variant p-5 rounded-xl shadow-sm cursor-pointer hover:shadow-lg transition">

                <p class="text-sm text-on-surface-variant mb-2">
                    Butuh Pengosongan
                </p>

                <h4 class="text-4xl font-bold text-red-700">
                    {{ $containers->where('persen', '>=', 90)->count() }}
                </h4>

            </div>

        </div> --}}
        
@endsection