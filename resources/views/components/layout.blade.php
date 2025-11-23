<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" type="image/x-icon" href="assets/icons/cash.svg"/>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">

        <title>{{$judul}}</title>
        <style>
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                margin: 0;
            }

            .sidebar {
                width: 250px;
                background-color: #ffffff;
                border-right: 1px solid #e0e0e0;
                height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                overflow-y: auto;
                padding-top: 20px;
            }
            .sidebar a {
                color: #333;
                text-decoration: none;
                margin: 4px 10px;
            }
            .sidebar li {
                color: #333;
                display: block;
                padding: 4px 20px;
                border-radius: 8px;
                margin-top: 4px;
            }
            .sidebar li a {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .sidebar li a i {
                font-size: 16px;
                transition: color 0.3s ease;
            }
            .sidebar span.section-title {
                display: block;
                padding: 10px 20px 4px 12px;
                margin-top: 10px;
                margin-bottom: 4px;
                font-size: 12px;
                font-weight: 600;
                color: #888;
            }
            .sidebar li:hover {
                background-color: #F0F2F4;
            }
            .sidebar li.active {
                background-color: #E0F0FB;
            }

            .sidebar li.active a {
                color: #007acc !important;
            }

            .sidebar li.active a i {
                color: #007acc !important;
            }


            .content-wrapper {
                display: flex;
                flex-direction: column;
                flex: 1;
                margin-left: 250px;
                min-height: 100vh;
                background-color: #F5F5F9;
            }
            .main-content {
                flex: 1;
                overflow-y: auto;
                padding: 10px;
                background-color: #F5F5F9;
            }
            .navbar-brand {
                color: #007acc !important;
                font-weight: bold;
            }
            footer {
                background-color: #F5F5F9;
                padding: 10px 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="d-flex">
        <!-- Sidebar -->
            <div class="sidebar">
                <div class="app-brand text-center mb-4">
                    <h4 style="color:#007acc; font-weight:bold;">CekSPP</h4>
                </div>
                @php
                    $role = null;
                @endphp
                @if (Auth::guard('petugas')->check())
                    @if (Auth::guard('petugas')->user()->level === 'admin')
                        @php $role = 'admin'@endphp
                        @include('sidebar.admin')
                    @else
                        @php $role = 'petugas' @endphp
                        @include('sidebar.petugas')
                    @endif
                @endif

                @if (Auth::guard('siswa')->check())
                    @php $role = 'siswa' @endphp
                    @include('sidebar.siswa')
                @endif
            </div>


            <!-- Main Content -->
            <div class="content-wrapper">

                <nav class="navbar navbar-light bg-white shadow-sm px-3">
                    <span class="navbar-brand mb-0 h1"></span>
                    <div class="d-flex">
                        <span class="me-3 mt-1">Halo, {{$role}} ...</span>
                        <form action="/logout" method="post" onsubmit="return confirm('Anda yakin ingin login?')">@csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-escape"></i> logout</button>
                        </form>
                    </div>
                </nav>


                <div class="main-content container py-4">
                    <div class="px-4">
                        {{$slot}}
                    </div>
                </div>

                <footer>
                    <p>© 2025 - Web Aplikasi CekSPP</p>
                </footer>
            </div>
        </div>



        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('api.js') }}"></script>
    </body>
</html>
