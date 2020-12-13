<!DOCTYPE html>
<html :class="{ 'dark': dark }" x-data="admin()" lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name','Koala')}} Admin</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/v4-shims.min.css"
          integrity="sha512-KNosrY5jkv7dI1q54vqk0N3x1xEmEn4sjzpU1lWL6bv5VVddcYKQVhHV08468FK6eBBSXTwGlMMZLPTXSpHYHA=="
          crossorigin="anonymous"/>

    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" rel="stylesheet">
    <!--Button Extension Datatables CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div
    class="flex h-screen bg-gray-50 dark:bg-gray-700"
    :class="{ 'overflow-hidden': isSideMenuOpen }"
>
    <x-admin.sidebar>
        <x-slot name="footer">
            <div class="p-2">
                @auth()
                    <div class="font-semibold dark:bg-gray-700">Authenticated: {{Auth::user()->name}}</div>
                    <button class="btn bg-danger text-white w-full hover:bg-primary">Log Out <i
                            class="fas fa-sign-out-alt"></i></button>
                @endauth
            </div>
        </x-slot>
    </x-admin.sidebar>
    <div class="flex flex-col flex-1 w-full">
        <x-admin.header/>
        <main class="h-full overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js" integrity="sha512-G3jAqT2eM4MMkLMyQR5YBhvN5/Da3IG6kqgYqU9zlIH4+2a+GuMdLb5Kpxy6ItMdCfgaKlo2XFhI0dHtMJjoRw==" crossorigin="anonymous"></script>
<script src="{{ asset('js/koaladmin.js') }}"></script>

<!--Datatables -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script>
    function admin() {
        function getThemeFromLocalStorage() {
            // if user already changed the theme, use it
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }

            // else return their preferences
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        }

        function setThemeToLocalStorage(value) {
            window.localStorage.setItem('dark', value)
        }

        return {
            dark: getThemeFromLocalStorage(),
            toggleTheme() {
                this.dark = !this.dark
                setThemeToLocalStorage(this.dark)
            },
            isSideMenuOpen: false,
            toggleSideMenu() {
                this.isSideMenuOpen = !this.isSideMenuOpen
            },
            closeSideMenu() {
                this.isSideMenuOpen = false
            },
            isNotificationsMenuOpen: false,
            toggleNotificationsMenu() {
                this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
            },
            closeNotificationsMenu() {
                this.isNotificationsMenuOpen = false
            },
            isProfileMenuOpen: false,
            toggleProfileMenu() {
                this.isProfileMenuOpen = !this.isProfileMenuOpen
            },
            closeProfileMenu() {
                this.isProfileMenuOpen = false
            },
            isPagesMenuOpen: false,
            togglePagesMenu() {
                this.isPagesMenuOpen = !this.isPagesMenuOpen
            },
            // Modal
            isModalOpen: false,
            trapCleanup: null,
        }
    }
</script>
@stack('scripts')
</body>
</html>
