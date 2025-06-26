<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Karyawan: ') }} {{ $employee->nama_lengkap }}
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

                    <form method="POST" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ $employee->user_id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Nama Lengkap -->
                            <div>
                                <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $employee->nama_lengkap)" required autofocus />
                            </div>
                            <!-- No Telepon -->
                            <div>
                                <x-input-label for="no_telepon" :value="__('Nomor Telepon')" />
                                <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon" :value="old('no_telepon', $employee->no_telepon)" required />
                            </div>
                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $employee->alamat) }}</textarea>
                            </div>
                            <!-- Departemen -->
                            <div>
                                <x-input-label for="department_id" :value="__('Departemen')" />
                                <select name="department_id" id="department_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id) == $department->id)>
                                            {{ $department->nama_departemen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Jabatan -->
                            <div>
                                <x-input-label for="position_id" :value="__('Jabatan')" />
                                <select name="position_id" id="position_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}" @selected(old('position_id', $employee->position_id) == $position->id)>
                                            {{ $position->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tanggal Bergabung -->
                            <div>
                                <x-input-label for="tanggal_bergabung" :value="__('Tanggal Bergabung')" />
                                <x-text-input id="tanggal_bergabung" class="block mt-1 w-full" type="date" name="tanggal_bergabung" :value="old('tanggal_bergabung', $employee->tanggal_bergabung)" required />
                            </div>
                             <!-- Foto Profil -->
                            <div class="md:col-span-2">
                                <x-input-label for="photo" :value="__('Foto Profil (Opsional)')" />
                                <div class="mt-2 flex items-center gap-x-3">
                                @if ($employee->photo)
                                    {{-- Path URL yang baru, tanpa 'storage' --}}
                                    <img class="h-24 w-24 rounded-full object-cover" src="{{ asset('uploads/photos/' . $employee->photo) }}" alt="Foto Profil">
                                @else
                                        <span class="inline-block h-16 w-16 overflow-hidden rounded-full bg-gray-100">
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    @endif
                                    <input id="photo" name="photo" type="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button class="ms-4">Perbarui Karyawan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>