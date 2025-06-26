<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Penilaian Kinerja untuk: ') }} {{ $employee->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reviews.store', $employee->id) }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Review -->
                            <div>
                                <x-input-label for="tanggal_review" :value="__('Tanggal Penilaian')" />
                                <x-text-input id="tanggal_review" class="block mt-1 w-full" type="date" name="tanggal_review" :value="old('tanggal_review', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_review')" class="mt-2" />
                            </div>

                            <!-- Skor Kinerja -->
                            <div>
                                <x-input-label for="skor_kinerja" :value="__('Skor Kinerja (1-100)')" />
                                <x-text-input id="skor_kinerja" class="block mt-1 w-full" type="number" name="skor_kinerja" :value="old('skor_kinerja')" required min="1" max="100" />
                                <x-input-error :messages="$errors->get('skor_kinerja')" class="mt-2" />
                            </div>

                            <!-- Komentar -->
                            <div class="md:col-span-2">
                                <x-input-label for="komentar" :value="__('Komentar / Feedback')" />
                                <textarea id="komentar" name="komentar" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('komentar') }}</textarea>
                                <x-input-error :messages="$errors->get('komentar')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('employees.show', $employee->id) }}" class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Simpan Penilaian') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>