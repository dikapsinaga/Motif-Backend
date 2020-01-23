<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Motif') }}</title>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('Semantic-UI-CSS-master/calendar.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.semanticui.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    {{-- <script src="{{ asset('Semantic-UI-CSS-master/calendar.min.js') }}"></script> --}}
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.semanticui.min.js"></script>
    {{-- <script src="{{ asset('js/Chart.bundle.js')}}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" charset="utf-8"></script> --}}


    <title>App Name - @yield('title')</title>
</head>

<body>
    <side-bar class="ui visible inverted left vertical sidebar menu">
        <a class="item header ui" href="{{ url('/home') }}">
            <h3 class="ui inverted header">
                <i class="circular inverted user teal icon"></i>
                <div class="content">
                    Admin
                    <div class="sub header">Admin</div>
                </div>
            </h3>

        </a>

        <a class="item" href="{{url('admin/home')}}">
            <i class="home icon"></i>Home
        </a>

        <a class="item" href="{{url('admin/berita')}}">
            <i class="shopping basket icon"></i>Berita
        </a>

        <div class="item">
            <div class="header">Pembayaran Produk</div>
            <div class="menu">
                <a class="item" href="{{url('admin/pembayaran/barang/notPaid')}}">Belum Dibayar</a>
                <a class="item" href="{{url('admin/pembayaran/barang/notConfirmed')}}">Belum Dikonfirmasi</a>
                <a class="item" href="{{url('admin/pembayaran/barang/diproses')}}">Diproses</a>
                <a class="item" href="{{url('admin/pembayaran/barang/dikirim')}}">Dikirim</a>
            </div>
        </div>

        <div class="item">
            <div class="header">Pembayaran Investasi</div>
            <div class="menu">
                <a class="item" href="{{url('admin/pembayaran/investasi/notPaid')}}">Belum Dibayar</a>
                <a class="item" href="{{url('admin/pembayaran/investasi/notConfirmed')}}">Belum Dikonfirmasi</a>
                <a class="item" href="{{url('admin/pembayaran/investasi/diproses')}}">Diproses</a>

            </div>
        </div>

        <div class="item">
            <div class="header">Pembayaran Hasil Investasi</div>
            <div class="menu">
                <a class="item" href="{{url('admin/pembayaran/investasi/hasil/notPaid')}}">Belum Dibayar</a>
                <a class="item" href="{{url('admin/pembayaran/investasi/hasil/notConfirmed')}}">Belum Dikonfirmasi</a>
                <a class="item" href="{{url('admin/pembayaran/investasi/hasil/diproses')}}">Diproses</a>

            </div>
        </div>

{{-- 
        <a class="item" 
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="sign out icon"></i>Logout
        </a>
        <form id="logout-form" action="{{ url('admin/logout')}}" method="POST" style="display: none;">
            @csrf
        </form> --}}

    </side-bar>


    <div class="pusher">
        <div class="ui bottom attachment segment pushable">
            <div class="ui header segment">
                @yield('nav')

            </div>
            <div class="pusher" id="main-content">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>

<style>
    .ui.header.segment {
        margin: 0;
        padding: 2em 2em;
        border: 0;
        border-radius: 0;
        box-shadow: 0;

    }

    #main-content {
        padding: 20px 40px;
        /* padding-bottom: 0; */
        width: 80%;
        /* height: 500px; */
        background-color: rgba(204, 204, 204, 0.25);
        /* background-color: white; */

    }

    .pushable {
        /* padding: 0 !important; */
    }
</style>


<script>
    $('.ui.dropdown').dropdown();
</script>