<!-- TopAppBar -->
<header
    class="flex justify-between items-center w-full px-margin-page h-16 bg-surface border-b border-outline-variant sticky top-0 z-40">

    <!-- LEFT -->
    <div class="flex items-center gap-stack-md">

        <!-- Logo -->
        <h2 class="font-h2 text-h2 text-primary">
            Clean IoT
        </h2>

        <!-- Search -->
        <div class="relative ml-stack-lg">

            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant">
                search
            </span>

            <input
                class="pl-10 pr-4 py-2 bg-surface-container rounded-full border-none focus:ring-2 focus:ring-primary text-body-md w-64 transition-all"
                placeholder="Cari lokasi atau ID bin..." type="text" />

        </div>

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
</div>

</header>

<!-- ALPINE JS -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>