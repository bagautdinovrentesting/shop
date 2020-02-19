@extends('layouts.admin.app', ['title' => trans('admin.sections')])

@section('toolbar')
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.sections.create') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-plus"></i> Добавить Раздел
        </a>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-sm items-list">
            <thead>
            <tr>
                <th></th>
                <th>Название</th>
                <th>Описание</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
                @foreach($sections as $section)
                    <tr>
                        <td class="product-img">
                            @if (!empty($section->photo))
                                <img src="{{ Storage::url("$section->photo") }}" alt="{{ $section->name }}" class="img-fluid">
                            @else
                                <img src="https://placehold.it/70x70" alt="{{ $section->name }}" class="img-fluid">
                            @endif
                        </td>
                        <td>{{ $section->name }}</td>
                        <td>{{ mb_substr($section->description, 0, 175) }}</td>
                        <td class="text-center">
                            <span class="status">
                                @if($section->status)
                                    <i class="fas fa-check-circle status-ok"></i>
                                @else
                                    <i class="fas fa-minus-circle status-not"></i>
                                @endif
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.sections.destroy', $section->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <div class="btn-group v-top">
                                    <a href="{{ route('admin.sections.edit', $section->id) }}" class="edit-item mr-2"><i class="fas fa-edit"></i></a>
                                    <button class="btn p-0 border-top-0"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
