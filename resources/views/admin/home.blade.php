@extends('layouts.dashboard')
@section('title', 'Home')

@section('content')
@section('nav', 'Home')

<h3 class="ui top attached header">
    Selamat datang,
</h3>


<div class="ui attached segment">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima iusto ex consequatur perspiciatis soluta doloremque atque? Numquam officia labore, natus, aliquid suscipit nihil unde tempora accusamus odit atque quisquam nesciunt.
</div>

<style>
    .ui.top.attached.header {
        font-size: 1.8em;
        line-height: 1em;
        padding: 0.8em;
    }

    .ui.attached.segment {
        font-size: 1em;
        padding: 2.5em;
    }

    p {
        margin: 0 0 1em;
        font-size: 1.13rem;
        line-height: 1.8rem;
        font-kerning: 1rem;

    }
</style>


@endsection