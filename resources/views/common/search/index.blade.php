@extends('layouts.app')

@section('app-content')

    @include('layouts.groups')

    <livewire:search.index :group="$group" />

@endsection