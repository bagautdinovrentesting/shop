@extends('admin.template')

@section('content')
    @foreach($users as $user)
        {{ $user->name }}
        <br>
    @endforeach
    <form action="/admin/add_product" method="POST">
        {{ csrf_field() }}
        <input type="text" name="name">
        <input type="submit" value="@lang('messages.form_submit')">
    </form>

    <form action="/admin/delete_product/1" method="POST">
        @method('DELETE')
        @csrf
        <input type="submit" value="@lang('messages.form_delete')">
    </form>
@endsection
