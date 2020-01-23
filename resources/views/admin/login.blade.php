<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Motif') }}</title>

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('Semantic-UI-CSS-master/semantic.min.css') }}">
    <script src="{{ asset('Semantic-UI-CSS-master/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('Semantic-UI-CSS-master/semantic.min.js') }}"></script> --}}

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

    <title>Motif</title>
</head>

<body>
    <div class="ui four column centered grid">
        <div class="column">
            <div class="ui raised segment">
                {{-- <h2 class="ui blue image header">
                    <img src="{{url('/images/myimage.jpg')}}" class="image">
                    <div class="content">
                        Motif.
                    </div>
                </h2> --}}
        
                <h2 class="ui center aligned icon header">
                    <i class="circular users teal inverted icon"></i>
                    Motif.
                </h2>
                    <form class="ui large form" method="POST" action="{{ url('admin/login')}}">
                        @csrf
                        <div class="ui  segment">
                            <div class="field">
                                <div class="ui left icon input">
                                    <i class="user icon"></i>
                                    <input type="text" name="email" placeholder="E-mail address">
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <i class="lock icon"></i>
                                    <input type="password" name="password" placeholder="Password">
                                </div>  
                            </div>
                        </div>
                        <br>
                        <br>
                        <input class="fluid ui teal submit button" type="submit" value="Submit">
                    </form>
                    </div>
                </div>
            </div>
</body>

</html>

<style type="text/css">
    body {
        background-color: #DADADA;
    }

    .ui.grid {
        height: 100%;
        /* margin-top: 50px; */
        padding-top: 7%;
    }

    /* body>.grid {
        height: 100%;
    }

    .image {
        margin-top: -100px;
    }

    .column {
        max-width: 450px;
    } */
</style>