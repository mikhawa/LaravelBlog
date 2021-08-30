@extends('base')

@section('content')
    <p>Du texte</p>
    <p>@php
        for($i=1;$i<=5;$i++){
            echo "$i ";
        }
    @endphp</p>
@endsection