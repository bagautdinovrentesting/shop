@extends('layouts.admin.app', ['title' => trans('admin.products')])

@section('toolbar')
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.group_properties.create') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-plus"></i> Добавить группу свойств
        </a>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-sm btn-outline-secondary ml-3">
            <i class="fas fa-plus"></i> Добавить свойство
        </a>
    </div>
@endsection

@section('content')
    <div class="table-responsive property-list">
        @if ($groups->isNotEmpty())
            <div id="GroupProperties">
                @foreach($groups as $group)
                    <div class="card mb-4">
                        <a class="group-property-name" href="{{ route('admin.group_properties.edit', $group->id) }}">
                            {{ $group->name }}
                        </a>
                        <table class="table table-striped table-sm items-list">
                            <thead>
                                <tr class="d-flex text-center">
                                    <th class="text-left col-7">Название</th>
                                    <th class="col-1">Сорт</th>
                                    <th class="col-1">Тип</th>
                                    <th class="col-2">Множественное</th>
                                    <th class="col-1">Удалить</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group->properties->sortBy('sort') as $property)
                                    <tr class="d-flex text-center">
                                        <td class="text-left col-7">
                                            <a href="{{ route('admin.properties.edit', $property->id) }}">{{ $property->name }}</a>
                                        </td>
                                        <td class="col-1">{{ $property->sort }}</td>
                                        <td class="col-1">{{ $property->type }}</td>
                                        <td class="col-2">
                                            <span class="status">
                                                @if($property->multiple)
                                                    <i class="fas fa-check-circle status-ok"></i>
                                                @else
                                                    <i class="fas fa-minus-circle status-not"></i>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="col-1">
                                            <div class="btn-group v-top">
                                                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn p-0 border-top-0 align-top"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning" role="alert">{{ __('admin.empty_properties') }}</div>
        @endif
    </div>
@endsection
