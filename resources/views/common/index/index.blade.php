@extends('layouts.app')

@section('app-content')

    @include('layouts.groups')

    <livewire:order.index :groupId="$currentGroup->id"  />

@endsection