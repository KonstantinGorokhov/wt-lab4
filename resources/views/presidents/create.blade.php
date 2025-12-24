@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Добавить президента</h1>

    <form action="{{ route('presidents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Имя (рус.)</label>
            <input type="text" name="name_ru" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Имя (англ.)</label>
            <input type="text" name="name_en" class="form-control" required>
        </div>

        {{-- <div class="mb-3">
            <label class="form-label">Период</label>
            <input type="text" name="period" class="form-control">
        </div> --}}

        <div class="mb-3">
            <label class="form-label">Краткое описание</label>
            <textarea name="short_description" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Полное описание</label>
            <textarea name="full_description" class="form-control" rows="5"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Дата начала</label>
                <input type="date" name="term_start" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Дата окончания</label>
                <input type="date" name="term_end" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Фото</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection
