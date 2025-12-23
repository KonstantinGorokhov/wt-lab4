@extends('layouts.app')

@section('title', 'Редактировать президента')

@section('content')
<div class="container px-4">

    <h1 class="mb-4">Редактировать: {{ $president->name_ru }}</h1>

    <form action="{{ route('presidents.update', $president) }}"
          method="POST"
          enctype="multipart/form-data">
        @include('presidents._form', ['president' => $president])
    </form>

</div>
@endsection
