@extends('layouts.admin.app', ['title' => trans('admin.users')])

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-sm items-list">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя пользователя</th>
                <th>Email</th>
                <th>Группа пользователя</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
