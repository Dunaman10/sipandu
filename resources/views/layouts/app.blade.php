<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | SIPANDU RT 03 - TailAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{
        page: '{{ request()->route()->getName() ?? 'dashboard' }}',
        loaded: true,
        darkMode: localStorage.getItem('darkMode') === 'true',
        stickyMenu: false,
        sidebarToggle: false,
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }
        }
    }"
    :class="{'dark bg-gray-900': darkMode === true}"
    class="font-outfit antialiased bg-gray-50 text-gray-800 dark:text-gray-200"
>
    <!-- Overlay on small devices -->
    <div
        x-show="sidebarToggle"
        @click="sidebarToggle = false"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-9999 bg-gray-900/50 backdrop-blur-xs xl:hidden"
        x-cloak
    ></div>

    <!-- Page Wrapper Start -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <aside
            :class="sidebarToggle ? 'translate-x-0 xl:w-22.5' : '-translate-x-full xl:translate-x-0'"
            class="sidebar fixed top-0 left-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-auto border-r border-gray-200 bg-white px-5 transition-all duration-300 xl:static xl:translate-x-0 dark:border-gray-800 dark:bg-black"
            @click.outside="if (window.innerWidth < 1280) sidebarToggle = false"
        >
            <!-- SIDEBAR HEADER -->
            <div
                :class="sidebarToggle ? 'justify-center' : 'justify-between'"
                class="sidebar-header flex items-center gap-2 pt-7 pb-6 border-b border-gray-100 dark:border-gray-800"
            >
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <span class="logo flex items-center gap-2.5" :class="sidebarToggle ? 'hidden' : ''">
                        <img class="dark:hidden h-8 w-auto" src="/images/logo/logo.svg" alt="SIPANDU Logo" />
                        <img class="hidden dark:block h-8 w-auto" src="/images/logo/logo-dark.svg" alt="SIPANDU Logo" />
                        <span class="rounded-md bg-brand-50 px-2 py-0.5 text-xs font-extrabold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                            RT 03
                        </span>
                    </span>
                    <img
                        class="logo-icon h-8 w-8"
                        :class="sidebarToggle ? 'xl:block' : 'hidden'"
                        src="/images/logo/logo-icon.svg"
                        alt="Logo Icon"
                    />
                </a>
            </div>
            <!-- SIDEBAR HEADER -->

            <!-- Sidebar Navigation -->
            <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear mt-4">
                <nav x-data="{selected: '{{ request()->segment(1) ?: 'dashboard' }}'}">
                    <!-- Menu Group: Utama -->
                    <div>
                        <h3 class="mb-3 text-xs leading-5 font-semibold text-gray-400 uppercase tracking-wider">
                            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">MENU UTAMA</span>
                        </h3>

                        <ul class="mb-5 flex flex-col gap-1.5">
                            <!-- Dashboard Item -->
                            <li>
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="menu-item group {{ request()->routeIs('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Dashboard
                                    </span>
                                </a>
                            </li>

                            <!-- Data Warga Item -->
                            <li>
                                <a
                                    href="{{ route('warga.index') }}"
                                    class="menu-item group {{ request()->routeIs('warga.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('warga.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Data Master Warga
                                    </span>
                                </a>
                            </li>

                            <!-- Kas Warga Item -->
                            <li>
                                <a
                                    href="{{ route('kas.index') }}"
                                    class="menu-item group {{ request()->routeIs('kas.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('kas.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M3 6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6V18C21 19.1046 20.1046 20 19 20H5C3.89543 20 3 19.1046 3 18V6ZM5 5.5C4.72386 5.5 4.5 5.72386 4.5 6V18C4.5 18.2761 4.72386 18.5 5 18.5H19C19.2761 18.5 19.5 18.2761 19.5 18V6C19.5 5.72386 19.2761 5.5 19 5.5H5ZM12 8C10.067 8 8.5 9.567 8.5 11.5C8.5 13.433 10.067 15 12 15C13.933 15 15.5 13.433 15.5 11.5C15.5 9.567 13.933 8 12 8ZM10 11.5C10 10.3954 10.8954 9.5 12 9.5C13.1046 9.5 14 10.3954 14 11.5C14 12.6046 13.1046 13.5 12 13.5C10.8954 13.5 10 12.6046 10 11.5Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Keuangan Kas RT
                                    </span>
                                </a>
                            </li>

                            <!-- K-Means Item -->
                            @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                            <li>
                                <a
                                    href="{{ route('clustering.index') }}"
                                    class="menu-item group {{ request()->routeIs('clustering.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('clustering.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM5 5V19H19V5H5ZM7 14C7 13.4477 7.44772 13 8 13H10C10.5523 13 11 13.4477 11 14V17H7V14ZM13 10C13 9.44772 13.4477 9 14 9H16C16.5523 9 17 9.44772 17 10V17H13V10ZM10 7C10 6.44772 10.4477 6 11 6H13C13.5523 6 14 6.44772 14 7V17H10V7Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text flex items-center justify-between w-full" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        <span>K-Means Clustering</span>
                                        <span class="rounded bg-brand-50 px-1.5 py-0.5 text-[10px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">Bansos</span>
                                    </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Menu Group: Keamanan & Ronda -->
                    <div>
                        <h3 class="mb-3 text-xs leading-5 font-semibold text-gray-400 uppercase tracking-wider">
                            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">KEAMANAN &amp; RONDA</span>
                        </h3>

                        <ul class="mb-5 flex flex-col gap-1.5">
                            <!-- Ronda Jadwal -->
                            <li>
                                <a
                                    href="{{ route('ronda.index') }}"
                                    class="menu-item group {{ request()->routeIs('ronda.index') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('ronda.index') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Jadwal &amp; Absensi Ronda
                                    </span>
                                </a>
                            </li>

                            <!-- Rekapitulasi Keaktifan -->
                            <li>
                                <a
                                    href="{{ route('ronda.rekap') }}"
                                    class="menu-item group {{ request()->routeIs('ronda.rekap') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('ronda.rekap') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M4.5 4C4.5 3.17157 5.17157 2.5 6 2.5H18C18.8284 2.5 19.5 3.17157 19.5 4V20C19.5 20.8284 18.8284 21.5 18 21.5H6C5.17157 21.5 4.5 20.8284 4.5 20V4ZM6 4V20H18V4H6ZM8 7.5C8 7.08579 8.33579 6.75 8.75 6.75H15.25C15.6642 6.75 16 7.08579 16 7.5C16 7.91421 15.6642 8.25 15.25 8.25H8.75C8.33579 8.25 8 7.91421 8 7.5ZM8 12C8 11.5858 8.33579 11.25 8.75 11.25H15.25C15.6642 11.25 16 11.5858 16 12C16 12.4142 15.6642 12.75 15.25 12.75H8.75C8.33579 12.75 8 12.4142 8 12ZM8 16.5C8 16.0858 8.33579 15.75 8.75 15.75H12.25C12.6642 15.75 13 16.0858 13 16.5C13 16.9142 12.6642 17.25 12.25 17.25H8.75C8.33579 17.25 8 16.9142 8 16.5Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Rekapitulasi Keaktifan
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Menu Group: Administrasi (Admin Only) -->
                    @if(auth()->user()->isAdmin())
                    <div>
                        <h3 class="mb-3 text-xs leading-5 font-semibold text-gray-400 uppercase tracking-wider">
                            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">PENGATURAN</span>
                        </h3>

                        <ul class="mb-5 flex flex-col gap-1.5">
                            <li>
                                <a
                                    href="{{ route('pengguna.index') }}"
                                    class="menu-item group {{ request()->routeIs('pengguna.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('pengguna.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="22"
                                        height="22"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Manajemen Pengguna
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </nav>
            </div>
            <!-- Sidebar Navigation -->

            <!-- Bottom User Card -->
            <div class="mt-auto pb-6 pt-4 border-t border-gray-100 dark:border-gray-800" :class="sidebarToggle ? 'hidden' : ''">
                <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3 dark:bg-gray-800/60">
                    <img
                        class="h-10 w-10 rounded-full object-cover"
                        src="/images/user/owner.png"
                        alt="User Avatar"
                    />
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-bold text-gray-800 dark:text-white truncate">{{ auth()->user()->name }}</h4>
                        <span class="block text-[11px] text-brand-500 font-medium">{{ auth()->user()->role_label }}</span>
                    </div>
                </div>
            </div>
        </aside>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
            <!-- ===== Header Start ===== -->
            <header class="sticky top-0 z-999 flex w-full border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="flex grow items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                    <!-- Left: Hamburger & Search Input -->
                    <div class="flex items-center gap-4">
                        <!-- Hamburger Toggle Button -->
                        <button
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-800"
                            @click.stop="sidebarToggle = !sidebarToggle"
                        >
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"/>
                            </svg>
                        </button>

                        <!-- Search Bar -->
                        <div class="relative hidden sm:block">
                            <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-gray-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                placeholder="Cari data warga, kas, ronda..."
                                class="h-10 w-64 lg:w-80 rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-12 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-white/5 dark:text-gray-100"
                            />
                            <span class="absolute top-1/2 right-2.5 -translate-y-1/2 rounded border border-gray-200 bg-white px-1.5 py-0.5 text-[10px] text-gray-400 dark:border-gray-700 dark:bg-gray-800">
                                ⌘ K
                            </span>
                        </div>
                    </div>

                    <!-- Right Controls -->
                    <div class="flex items-center gap-3">
                        <!-- Dark Mode Toggle Button (Circular) -->
                        <button
                            class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                            @click="toggleDarkMode()"
                            title="Ganti Mode Gelap / Terang"
                        >
                            <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <!-- Notification Bell (Circular) -->
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800"
                            >
                                <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                                </span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                @click.outside="open = false"
                                class="absolute right-0 mt-3 w-80 rounded-2xl border border-gray-200 bg-white p-4 shadow-xl dark:border-gray-800 dark:bg-gray-900 z-50 text-xs"
                                x-cloak
                            >
                                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-2">
                                    <h5 class="font-bold text-gray-800 dark:text-white">Pemberitahuan Sistem</h5>
                                    <span class="rounded bg-brand-50 px-1.5 py-0.5 text-[10px] font-bold text-brand-600">RT 03</span>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-gray-600 dark:text-gray-300">Sistem SIPANDU RT 03 telah disinkronkan dengan modul K-Means, Kas Keuangan, dan Ronda Malam.</p>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Area -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-3 rounded-lg p-1 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <img
                                    class="h-9 w-9 rounded-full object-cover"
                                    src="/images/user/owner.png"
                                    alt="Avatar"
                                />
                                <span class="hidden text-left sm:block">
                                    <span class="block text-xs font-bold text-gray-800 dark:text-white">{{ auth()->user()->name }}</span>
                                    <span class="block text-[11px] text-gray-500 dark:text-gray-400">{{ auth()->user()->role_label }}</span>
                                </span>
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- User Dropdown Menu -->
                            <div
                                x-show="open"
                                @click.outside="open = false"
                                x-transition
                                class="absolute right-0 mt-2 w-56 rounded-2xl border border-gray-200 bg-white p-2 shadow-xl dark:border-gray-800 dark:bg-gray-900 z-50 text-xs"
                                x-cloak
                            >
                                <div class="px-3 py-2 border-b border-gray-100 dark:border-gray-800 mb-1">
                                    <p class="font-bold text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-gray-400 text-[11px] truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Keluar Sistem
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6 lg:p-8 space-y-6">
                    <!-- TailAdmin Breadcrumb -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-2 border-b border-gray-200/60 dark:border-gray-800">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white/90">
                            @yield('page_title', 'Dashboard')
                        </h2>
                        <nav>
                            <ol class="flex items-center gap-1.5 text-xs">
                                <li>
                                    <a class="inline-flex items-center gap-1.5 text-gray-500 hover:text-brand-500 dark:text-gray-400" href="{{ route('dashboard') }}">
                                        Home
                                        <svg class="stroke-current" width="14" height="14" viewBox="0 0 17 16" fill="none">
                                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                                <li class="font-semibold text-gray-800 dark:text-white/90">
                                    @yield('title', 'Dashboard')
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Flash Alerts -->
                    @if(session('success'))
                    <div class="flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 dark:border-emerald-800/50 dark:bg-emerald-950/40 dark:text-emerald-300" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs font-semibold">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="flex items-center justify-between rounded-xl border border-red-200 bg-red-50 p-4 text-red-800 dark:border-red-800/50 dark:bg-red-950/40 dark:text-red-300" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs font-semibold">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
            <!-- ===== Main Content End ===== -->

            <!-- ===== Footer Start ===== -->
            <footer class="mt-auto border-t border-gray-200 bg-white py-4 px-6 text-center text-xs text-gray-500 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} <strong>SIPANDU RT 03</strong> &mdash; Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03, Kelurahan Kedaung. Menggunakan Template TailAdmin.</p>
            </footer>
            <!-- ===== Footer End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- Page Wrapper End -->

    @stack('scripts')
</body>
</html>
