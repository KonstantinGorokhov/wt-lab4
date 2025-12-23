@extends('layouts.app')

@section('title', 'Добавить президента')

@section('content')
    <h1 class="mb-4">Добавить президента</h1>

    <form action="{{ route('presidents.store') }}" method="POST" enctype="multipart/form-data">
        @include('presidents._form')
    </form>
@endsection
