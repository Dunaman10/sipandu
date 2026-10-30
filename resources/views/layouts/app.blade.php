<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | SIPANDU RT 03 - TailAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <script>
        (function() {
            var stored = localStorage.getItem('darkMode');
            var isDark = stored !== null ? JSON.parse(stored) : true;
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{
        page: '{{ request()->route()->getName() ?? 'dashboard' }}',
        loaded: true,
        darkMode: localStorage.getItem('darkMode') !== null ? JSON.parse(localStorage.getItem('darkMode')) : true,
        stickyMenu: false,
        sidebarToggle: false,
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', JSON.stringify(this.darkMode));
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
    class="font-outfit antialiased bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200"
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
        <!-- ===== Sidebar Start (TailAdmin & PRD SIPANDU RT 03 Strictly) ===== -->
        <aside
            :class="sidebarToggle ? 'translate-x-0 xl:w-22.5' : '-translate-x-full xl:translate-x-0'"
            class="sidebar fixed top-0 left-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-auto border-r border-gray-200 bg-white px-5 transition-all duration-300 xl:static xl:translate-x-0 dark:border-gray-800 dark:bg-black"
            @click.outside="if (window.innerWidth < 1280) sidebarToggle = false"
        >
            <!-- SIDEBAR HEADER -->
            <div
                :class="sidebarToggle ? 'justify-center' : 'justify-between'"
                class="sidebar-header flex items-center gap-2 pt-8 pb-7"
            >
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="logo flex items-center gap-2 shrink-0 whitespace-nowrap" :class="sidebarToggle ? 'hidden' : 'flex'">
                        <img class="dark:hidden h-8 w-auto shrink-0" src="/images/logo/logo.svg" alt="SIPANDU Logo" />
                        <img class="hidden dark:block h-8 w-auto shrink-0" src="/images/logo/logo-dark.svg" alt="SIPANDU Logo" />
                        <span class="shrink-0 inline-flex items-center rounded bg-brand-50 px-2 py-0.5 text-[11px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 whitespace-nowrap leading-none">
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
            <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
                <nav>
                    <!-- Menu Group: MENU UTAMA -->
                    <div>
                        <h3 class="mb-4 text-xs leading-5 text-gray-400 uppercase tracking-wider font-semibold">
                            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">MENU UTAMA</span>
                        </h3>

                        <ul class="mb-6 flex flex-col gap-1.5">
                            <!-- Dashboard -->
                            <li>
                                <a
                                    href="{{ route('dashboard') }}"
                                    class="menu-item group {{ request()->routeIs('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="24"
                                        height="24"
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
                                        Dashboard Ringkasan
                                    </span>
                                </a>
                            </li>

                            <!-- Modul 3: Manajemen Data Warga (CRUD) -->
                            <li>
                                <a
                                    href="{{ route('warga.index') }}"
                                    class="menu-item group {{ request()->routeIs('warga.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('warga.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="24"
                                        height="24"
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
                                        Data Warga RT
                                    </span>
                                </a>
                            </li>

                            <!-- Modul 4: K-Means Clustering (Bansos) -->
                            @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                            <li>
                                <a
                                    href="{{ route('clustering.index') }}"
                                    class="menu-item group {{ request()->routeIs('clustering.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('clustering.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="24"
                                        height="24"
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
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        K-Means Clustering
                                    </span>
                                    <span class="bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 rounded-full px-2 py-0.5 text-xs font-semibold" :class="sidebarToggle ? 'xl:hidden' : ''">AI</span>
                                </a>
                            </li>
                            @endif

                            <!-- Modul: Jadwal Ronda Malam (Untuk Mading & WhatsApp Warga) -->
                            <li>
                                <a
                                    href="{{ route('ronda.index') }}"
                                    class="menu-item group {{ request()->routeIs('ronda.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('ronda.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="24"
                                        height="24"
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
                                        Jadwal Ronda
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Menu Group: ADMINISTRASI & SISTEM (Admin Only) -->
                    @if(auth()->user()->isAdmin())
                    <div>
                        <h3 class="mb-4 text-xs leading-5 text-gray-400 uppercase tracking-wider font-semibold">
                            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">ADMINISTRASI &amp; SISTEM</span>
                        </h3>

                        <ul class="mb-6 flex flex-col gap-1.5">
                            <!-- Peran 1: Admin Superadmin (CRUD User Pengguna) -->
                            <li>
                                <a
                                    href="{{ route('pengguna.index') }}"
                                    class="menu-item group {{ request()->routeIs('pengguna.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                >
                                    <svg
                                        class="{{ request()->routeIs('pengguna.*') ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM11.0991 7.52507C11.0991 8.02213 11.5021 8.42507 11.9991 8.42507H12.0001C12.4972 8.42507 12.9001 8.02213 12.9001 7.52507C12.9001 7.02802 12.4972 6.62507 12.0001 6.62507H11.9991C11.5021 6.62507 11.0991 7.02802 11.0991 7.52507ZM12.0001 17.3714C11.5859 17.3714 11.2501 17.0356 11.2501 16.6214V10.9449C11.2501 10.5307 11.5859 10.1949 12.0001 10.1949C12.4143 10.1949 12.7501 10.5307 12.7501 10.9449V16.6214C12.7501 17.0356 12.4143 17.3714 12.0001 17.3714Z" fill="currentColor"/>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                                        Kelola Pengguna
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </nav>
            </div>
        </aside>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- ===== Header Start ===== -->
            <header
                x-data="{menuToggle: false}"
                class="sticky top-0 z-9999 flex w-full border-gray-200 bg-white xl:border-b dark:border-gray-800 dark:bg-gray-900"
            >
                <div class="flex grow flex-col items-center justify-between xl:flex-row xl:px-6">
                    <div class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 lg:py-4 xl:justify-normal xl:border-b-0 xl:px-0 dark:border-gray-800">
                        <!-- Hamburger Toggle Button -->
                        <button
                            :class="sidebarToggle ? 'xl:bg-transparent dark:xl:bg-transparent bg-gray-100 dark:bg-gray-800' : ''"
                            class="z-9999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 xl:h-11 xl:w-11 xl:border dark:border-gray-800 dark:text-gray-400 cursor-pointer"
                            @click.stop="sidebarToggle = !sidebarToggle"
                        >
                            <svg class="hidden fill-current xl:block" width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z" fill=""/>
                            </svg>
                            <svg :class="sidebarToggle ? 'hidden' : 'block xl:hidden'" class="fill-current xl:hidden" width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z" fill=""/></svg>
                        </button>

                        <a href="{{ route('dashboard') }}" class="xl:hidden flex items-center gap-2">
                            <img class="dark:hidden h-7 w-auto" src="/images/logo/logo.svg" alt="SIPANDU" />
                            <img class="hidden dark:block h-7 w-auto" src="/images/logo/logo-dark.svg" alt="SIPANDU" />
                            <span class="rounded bg-brand-50 px-1.5 py-0.5 text-[10px] font-bold text-brand-600">RT 03</span>
                        </a>

                        <!-- Search Bar -->
                        <div class="hidden xl:block">
                            <form action="{{ route('warga.index') }}" method="GET">
                                <div class="relative">
                                    <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                                        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z" fill=""/>
                                        </svg>
                                    </span>
                                    <input
                                        id="search-input"
                                        type="text"
                                        name="search"
                                        placeholder="Cari NIK, Nama Warga, atau No KK..."
                                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-107.5 dark:border-gray-800 dark:bg-white/3 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                    <button
                                        id="search-button"
                                        type="submit"
                                        class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-lg border border-gray-200 bg-gray-50 px-1.75 py-[4.5px] text-xs tracking-[-0.2px] text-gray-500 dark:border-gray-800 dark:bg-white/3 dark:text-gray-400 cursor-pointer"
                                    >
                                        <span> ⌘ </span>
                                        <span> K </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Controls Area -->
                    <div :class="menuToggle ? 'flex' : 'hidden'" class="w-full items-center justify-between gap-4 px-5 py-4 xl:flex xl:justify-end xl:px-0">
                        <div class="flex items-center gap-2 2xsm:gap-3">
                            <!-- Dark Mode Toggler -->
                            <button
                                class="relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white cursor-pointer"
                                @click.prevent="toggleDarkMode()"
                                title="Ganti Mode Gelap / Terang"
                            >
                                <svg class="hidden dark:block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99998 15.7088C10.4142 15.7088 10.75 16.0445 10.75 16.4588V17.7088C10.75 18.123 10.4142 18.4588 9.99998 18.4588C9.58577 18.4588 9.24998 18.123 9.24998 17.7088V16.4588C9.24998 16.0445 9.58577 15.7088 9.99998 15.7088ZM5.96356 15.0972C6.25646 14.8043 6.25646 14.3295 5.96356 14.0366C5.67067 13.7437 5.1958 13.7437 4.9029 14.0366L4.01902 14.9204C3.72613 15.2133 3.72613 15.6882 4.01902 15.9811C4.31191 16.274 4.78679 16.274 5.07968 15.9811L5.96356 15.0972ZM4.29224 10.0001C4.29224 10.4143 3.95645 10.7501 3.54224 10.7501H2.29224C1.87802 10.7501 1.54224 10.4143 1.54224 10.0001C1.54224 9.58592 1.87802 9.25013 2.29224 9.25013H3.54224C3.95645 9.25013 4.29224 9.58592 4.29224 10.0001ZM4.9029 5.9637C5.1958 6.25659 5.67067 6.25659 5.96356 5.9637C6.25646 5.6708 6.25646 5.19593 5.96356 4.90303L5.07968 4.01915C4.78679 3.72626 4.31191 3.72626 4.01902 4.01915C3.72613 4.31204 3.72613 4.78692 4.01902 5.07981L4.9029 5.9637Z" fill="currentColor"/>
                                </svg>
                                <svg class="dark:hidden" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z" fill="currentColor"/>
                                </svg>
                            </button>

                            <!-- Notification Menu Area with Orange Ping Dot -->
                            <div class="relative" x-data="{ dropdownOpen: false, notifying: true }" @click.outside="dropdownOpen = false">
                                <button
                                    class="relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white cursor-pointer"
                                    @click.prevent="dropdownOpen = !dropdownOpen; notifying = false"
                                >
                                    <span :class="!notifying ? 'hidden' : 'flex'" class="absolute top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-orange-400">
                                        <span class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"></span>
                                    </span>
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z" fill=""/>
                                    </svg>
                                </button>

                                <!-- Notification Dropdown -->
                                <div
                                    x-show="dropdownOpen"
                                    class="shadow-theme-lg dark:bg-gray-dark absolute -left-15 mt-4.25 flex h-80 w-80 flex-col rounded-2xl border border-gray-200 bg-white p-3 xl:right-0 xl:left-auto dark:border-gray-800 z-50"
                                    x-cloak
                                >
                                    <div class="mb-3 flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                                        <h5 class="text-base font-semibold text-gray-800 dark:text-white/90">Pemberitahuan Sistem</h5>
                                        <button @click="dropdownOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">✕</button>
                                    </div>
                                    <div class="overflow-y-auto space-y-2 text-xs text-gray-600 dark:text-gray-400">
                                        <div class="p-2.5 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-gray-800">
                                            <p class="font-semibold text-gray-800 dark:text-white">SIPANDU RT 03 Siap</p>
                                            <p class="mt-0.5 text-gray-500">Kelurahan Kedaung &bull; Sistem Terpadu Aktif.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Area -->
                        <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                            <a class="flex items-center text-gray-700 dark:text-gray-400 cursor-pointer" href="#" @click.prevent="dropdownOpen = !dropdownOpen">
                                <span class="mr-3 h-11 w-11 overflow-hidden rounded-full ring-2 ring-brand-500/30">
                                    <img src="/images/user/owner.png" alt="Avatar" class="h-full w-full object-cover" />
                                </span>
                                <div class="text-left hidden sm:block mr-2">
                                    <span class="text-theme-sm block font-semibold text-gray-800 dark:text-white/90 leading-tight">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <span class="text-theme-xs block text-brand-600 dark:text-brand-400 font-medium">
                                        {{ auth()->user()->role_label }}
                                    </span>
                                </div>
                                <svg :class="dropdownOpen && 'rotate-180'" class="stroke-gray-500 dark:stroke-gray-400 transition" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                    <path d="M4.3125 8.65625L9 13.3437L13.6875 8.65625" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- User Dropdown Menu -->
                            <div
                                x-show="dropdownOpen"
                                class="shadow-theme-lg dark:bg-gray-dark absolute right-0 mt-4.25 flex w-65 flex-col rounded-2xl border border-gray-200 bg-white p-3 dark:border-gray-800 z-50"
                                x-cloak
                            >
                                <div class="border-b border-gray-100 dark:border-gray-800 pb-2.5 mb-2">
                                    <span class="text-theme-sm block font-bold text-gray-800 dark:text-white/90">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <span class="text-theme-xs block text-gray-500 dark:text-gray-400">
                                        {{ auth()->user()->email }}
                                    </span>
                                    <span class="inline-block mt-1 text-[10px] rounded bg-brand-50 px-2 py-0.5 font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 uppercase">
                                        {{ auth()->user()->role_label }}
                                    </span>
                                </div>

                                <ul class="flex flex-col gap-1 border-b border-gray-100 dark:border-gray-800 pb-2 mb-2 text-sm">
                                    @if(auth()->user()->isAdmin())
                                    <li>
                                        <a href="{{ route('pengguna.index') }}" class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                            Kelola Akun Pengguna
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('dashboard') }}" class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                            Dashboard
                                        </a>
                                    </li>
                                </ul>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group text-theme-sm flex w-full items-center gap-2 rounded-lg px-3 py-2 font-semibold text-error-600 hover:bg-error-50 dark:hover:bg-error-500/10 dark:text-error-400 cursor-pointer">
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
                <div class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
                    @yield('content')
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    @stack('scripts')
</body>
</html>
