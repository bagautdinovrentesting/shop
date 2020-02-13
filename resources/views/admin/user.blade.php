@extends('layouts.admin.app', ['title' => trans('admin.users')])

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-sm items-list">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Группа</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
