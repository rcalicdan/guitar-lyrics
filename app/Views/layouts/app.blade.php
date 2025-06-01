<!Doctype html>
<html lang="en">

<head>
    @include('includes.head')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!-- App Wrapper -->
 
    <div class="app-wrapper">
        <!-- Header Navigation -->
        @include('includes.header-navigation')

        <!-- Sidebar -->
        @include('includes.sidebar')

        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            @include('includes.content-header')

            <!-- Main Content Area -->
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        @include('includes.footer')
    </div>

    @include('includes.scripts')
    @stack('custom-scripts')
</body>

</html>
