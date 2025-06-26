<div class="flex flex-col h-full">
    <!-- Bagian Atas Sidebar (Profil Pengguna) -->
    <div class="flex-shrink-0 p-4 border-b border-gray-700">
        <a href="{{ route('profile.edit') }}" class="flex items-center group w-full">
            <div class="flex-shrink-0">
                @if(Auth::user()->employee && Auth::user()->employee->photo)
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('uploads/photos/' . Auth::user()->employee->photo) }}" alt="Foto Profil">
                @else
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-700">
                        <span class="text-sm font-medium leading-none text-white">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </span>
                @endif
            </div>
            <div x-show="!isSidebarMinimized" class="ml-3 flex-1">
                <p class="text-sm font-semibold text-white truncate group-hover:text-gray-200">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-400 group-hover:text-gray-300">Lihat Profil</p>
            </div>
        </a>
    </div>

    <!-- Bagian Tengah (Menu Navigasi) -->
    <div class="flex-grow overflow-y-auto">
        <nav class="mt-4 px-2 space-y-1">
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-slot name="icon">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1.125-1.5M12 16.5v2.25m0 0l1.125 1.5m-1.125-1.5l-1.125 1.5M3.75 16.5l1.125-1.5m0 0h7.5" /></svg>
                </x-slot>
                <span x-show="!isSidebarMinimized" x-transition>{{ (Auth::user()->role === 'manager') ? __('Manajemen Tim') : __('Dashboard') }}</span>
            </x-sidebar-link>
            
            @if (Auth::user()->role == 'admin')
                <div class="pt-4">
                    <h3 x-show="!isSidebarMinimized" class="px-4 mt-4 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen</h3>
                    <x-sidebar-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                        <x-slot name="icon">
                           <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        </x-slot>
                        <span x-show="!isSidebarMinimized" x-transition>{{ __('Karyawan') }}</span>
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                         <x-slot name="icon">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.28-2.72a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479m7.28 2.72a3 3 0 01-4.682 2.72a9.094 9.094 0 013.741.479M6.585 12.585a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479m7.28 2.72a3 3 0 00-4.682-2.72a9.094 9.094 0 003.741-.479" /></svg>
                        </x-slot>
                        <span x-show="!isSidebarMinimized" x-transition>{{ __('Pengguna') }}</span>
                    </x-sidebar-link>
                </div>
                <div class="pt-4">
                    <h3 x-show="!isSidebarMinimized" class="px-4 mt-4 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengaturan</h3>
                    <x-sidebar-link :href="route('departments.index')" :active="request()->routeIs('departments.*')">
                         <x-slot name="icon">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18M3 7.5h18M3 12h18m-4.5 9v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" /></svg>
                        </x-slot>
                        <span x-show="!isSidebarMinimized" x-transition>{{ __('Departemen') }}</span>
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('positions.index')" :active="request()->routeIs('positions.*')">
                         <x-slot name="icon">
                           <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" /></svg>
                        </x-slot>
                        <span x-show="!isSidebarMinimized" x-transition>{{ __('Jabatan') }}</span>
                    </x-sidebar-link>
                    <x-sidebar-link :href="route('reports.performance')" :active="request()->routeIs('reports.performance')">
                         <x-slot name="icon">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A2.625 2.625 0 011.5 18.375v-2.25zM16.5 13.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125h-2.25a2.625 2.625 0 01-2.625-2.625v-2.25zM9.75 12.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v9c0 .621-.504 1.125-1.125 1.125h-2.25A1.125 1.125 0 019.75 21v-9zM4.5 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM19.5 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" /></svg>
                        </x-slot>
                        <span x-show="!isSidebarMinimized" x-transition>{{ __('Laporan') }}</span>
                    </x-sidebar-link>
                </div>
            @endif
        </nav>
    </div>
</div>