<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary-fixed-variant": "#6d390c",
                        "surface-container-low": "#f1f4f4",
                        "on-secondary-fixed-variant": "#00504b",
                        "tertiary-fixed": "#ffdcc5",
                        "tertiary-container": "#8e5426",
                        "on-primary": "#ffffff",
                        "secondary": "#236863",
                        "on-background": "#181c1d",
                        "on-primary-fixed": "#001f23",
                        "on-tertiary-fixed": "#301400",
                        "on-surface-variant": "#3e494a",
                        "surface-container-high": "#e6e9e9",
                        "inverse-primary": "#82d3de",
                        "surface-bright": "#f7fafa",
                        "surface-dim": "#d7dadb",
                        "on-surface": "#181c1d",
                        "surface-tint": "#006972",
                        "surface-container-highest": "#e0e3e3",
                        "secondary-fixed": "#acefe7",
                        "secondary-container": "#a9ece5",
                        "inverse-surface": "#2d3132",
                        "outline": "#6f797a",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#9becf7",
                        "secondary-fixed-dim": "#90d3cb",
                        "on-secondary-fixed": "#00201e",
                        "tertiary-fixed-dim": "#ffb783",
                        "primary-fixed-dim": "#82d3de",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#286d67",
                        "on-tertiary-container": "#ffd7bd",
                        "background": "#f7fafa",
                        "error": "#ba1a1a",
                        "primary": "#00535b",
                        "error-container": "#ffdad6",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#93000a",
                        "primary-container": "#006d77",
                        "surface": "#f7fafa",
                        "inverse-on-surface": "#eef1f2",
                        "on-primary-fixed-variant": "#004f56",
                        "surface-container": "#ebeeef",
                        "surface-variant": "#e0e3e3",
                        "outline-variant": "#bec8ca",
                        "primary-fixed": "#9ff0fb",
                        "tertiary": "#713d10",
                        "on-error": "#ffffff"
                    },

                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },

                    spacing: {
                        "card-padding": "20px",
                        "gutter": "24px",
                        "margin-page": "32px",
                        "stack-sm": "8px",
                        "stack-lg": "24px",
                        "stack-md": "16px",
                        "unit": "4px"
                    },

                    fontFamily: {
                        "h1": ["Inter"],
                        "label-caps": ["Inter"],
                        "h3": ["Inter"],
                        "body-md": ["Inter"],
                        "stat-value": ["Inter"],
                        "body-lg": ["Inter"],
                        "h2": ["Inter"]
                    },

                    fontSize: {
                        "h1": ["32px", {
                            lineHeight: "40px",
                            letterSpacing: "-0.02em",
                            fontWeight: "700"
                        }],

                        "label-caps": ["12px", {
                            lineHeight: "16px",
                            letterSpacing: "0.05em",
                            fontWeight: "600"
                        }],

                        "h3": ["20px", {
                            lineHeight: "28px",
                            fontWeight: "600"
                        }],

                        "body-md": ["14px", {
                            lineHeight: "20px",
                            fontWeight: "400"
                        }],

                        "stat-value": ["36px", {
                            lineHeight: "44px",
                            letterSpacing: "-0.03em",
                            fontWeight: "700"
                        }],

                        "body-lg": ["16px", {
                            lineHeight: "24px",
                            fontWeight: "400"
                        }],

                        "h2": ["24px", {
                            lineHeight: "32px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }]
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }

        body {
            background-color: #F8FAFA;
        }
    </style>
</head>

<body class="font-body-md text-on-background">

    <!-- HEADER -->
    <header
        class="bg-surface flex justify-between items-center px-margin-page w-full h-16 border-b border-outline-variant sticky top-0 z-50">

        <!-- LEFT -->
        <div class="flex items-center gap-stack-lg">

            <span class="font-h2 text-h2 font-bold text-primary">
                Clean IoT
            </span>

            <nav class="hidden md:flex gap-stack-md h-full items-center">

                <a class="text-on-surface-variant font-body-md pb-1 hover:text-primary transition-colors h-full flex items-center mt-1"
                    href="/petugas/dashboard">
                    Dashboard
                </a>

                <a class="text-on-surface-variant font-body-md pb-1 hover:text-primary transition-colors h-full flex items-center mt-1"
                    href="/petugas/container">
                    Info
                </a>

            </nav>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            @php

                use App\Models\Container;

                // Kontainer penuh
                $warningPenuh = Container::where('persen', '>=', 80)->get();

                // Baterai lemah
                $warningBaterai = Container::where('baterai', '<=', 20)->get();

                // Total notifikasi
                $totalNotif = $warningPenuh->count() + $warningBaterai->count();

            @endphp

            <!-- NOTIFICATION -->
            <div x-data="{ open: false }" class="relative">

                <!-- Button -->
                <button @click="open = !open"
                    class="relative p-2 rounded-full hover:bg-surface-container-highest transition-colors active:scale-95 duration-150">

                    <span class="material-symbols-outlined">
                        notifications
                    </span>

                    @if($totalNotif > 0)

                        <span
                            class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center">
                            {{ $totalNotif }}
                        </span>

                    @endif

                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-3 w-[400px] bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-50">

                    <!-- Header -->
                    <div class="px-4 py-3 border-b bg-gray-50">

                        <h3 class="font-semibold text-gray-700">
                            Notifikasi Kontainer
                        </h3>

                    </div>

                    <div class="max-h-[450px] overflow-y-auto">

                        <!-- ========================= -->
                        <!-- KONTTAINER PENUH -->
                        <!-- ========================= -->

                        <div class="p-4 border-b">

                            <h4 class="font-semibold text-red-600 mb-3">
                                Kepenuhan ≥ 80%
                            </h4>

                            @forelse($warningPenuh as $item)

                                <div class="mb-3 p-3 rounded-xl bg-red-50 border border-red-100">

                                    <div class="flex justify-between items-start">

                                        <div>

                                            <div class="font-semibold text-gray-800">
                                                {{ $item->kode_container }}
                                            </div>

                                            <div class="text-sm text-gray-600 mt-1">
                                                {{ $item->lokasi }}
                                            </div>

                                        </div>

                                        <div class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">

                                            {{ $item->persen }}%

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="text-sm text-gray-500 bg-gray-50 p-3 rounded-xl">

                                    Tidak ada kontainer penuh

                                </div>

                            @endforelse

                        </div>

                        <!-- ========================= -->
                        <!-- BATERAI LEMAH -->
                        <!-- ========================= -->

                        <div class="p-4">

                            <h4 class="font-semibold text-yellow-600 mb-3">
                                Baterai ≤ 20%
                            </h4>

                            @forelse($warningBaterai as $item)

                                <div class="mb-3 p-3 rounded-xl bg-yellow-50 border border-yellow-100">

                                    <div class="flex justify-between items-start">

                                        <div>

                                            <div class="font-semibold text-gray-800">
                                                {{ $item->kode_container }}
                                            </div>

                                            <div class="text-sm text-gray-600 mt-1">
                                                {{ $item->lokasi }}
                                            </div>

                                        </div>

                                        <div class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-semibold">

                                            {{ $item->baterai }}%

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="text-sm text-gray-500 bg-gray-50 p-3 rounded-xl">

                                    Tidak ada baterai lemah

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

            <!-- LOGOUT -->
            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit"
                    class="p-2 rounded-full hover:bg-error-container transition-colors active:scale-95 duration-150">

                    <span class="material-symbols-outlined text-error">
                        logout
                    </span>

                </button>

            </form>

            <!-- PROFILE -->
            <div class="flex items-center gap-3 ml-2">

                <!-- FOTO -->
                <div class="h-10 w-10 rounded-full overflow-hidden border border-outline-variant bg-gray-100">

                    <img src="{{ session('foto')
    ? asset('storage/' . session('foto'))
    : asset('foto_petugas/default-user.png') }}" alt="Foto" class="w-full h-full object-cover">

                </div>

                <!-- NAMA -->
                <div class="hidden md:block">

                    <div class="text-sm font-semibold text-gray-800 leading-none">
                        {{ session('nama_lengkap') }}
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Petugas Kebersihan
                    </div>

                </div>

            </div>

        </div>

    </header>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- CONTENT -->
    <main>

        @yield('content')

    </main>

</body>

</html>