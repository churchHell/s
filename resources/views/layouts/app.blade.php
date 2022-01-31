@extends('layouts.empty')

@section('empty-content')

    @include('layouts.header')

    @yield('app-content')

    @include('layouts.footer')

@endsection
