@csrf
@if(isset($president))
    @method('PUT')
@endif

<div class="mb-3">
    <label class="form-label">Имя (рус.)</label>
    <input type="text" name="name_ru" class="form-control" required
           value="{{ old('name_ru', $president->name_ru ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Имя (англ.)</label>
    <input type="text" name="name_en" class="form-control" required
           value="{{ old('name_en', $president->name_en ?? '') }}">
</div>

{{-- <div class="mb-3">
    <label class="form-label">Период</label>
    <input type="text" name="period" class="form-control" required
           value="{{ old('period', $president->period ?? '') }}">
</div> --}}

<div class="mb-3">
    <label class="form-label">Краткое описание</label>
    <textarea name="short_description" class="form-control" rows="3" required>{{ old('short_description', $president->short_description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Полное описание</label>
    <textarea name="full_description" class="form-control" rows="6">{{ old('full_description', $president->full_description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Дата начала срока</label>
        <input type="date" name="term_start" class="form-control"
               value="{{ old('term_start', isset($president->term_start) ? $president->term_start->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Дата конца срока</label>
        <input type="date" name="term_end" class="form-control"
               value="{{ old('term_end', isset($president->term_end) ? $president->term_end->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Фото</label>
    <input type="file" name="image" class="form-control">

    @if(isset($president) && $president->image_path)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $president->image_path) }}" width="150" class="rounded">
        </div>
    @endif
</div>

<button type="submit" class="btn btn-primary">Сохранить</button>
