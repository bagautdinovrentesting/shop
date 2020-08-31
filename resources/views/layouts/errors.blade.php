@if(!empty($errors->all()))
    @foreach($errors->all() as $message)
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endforeach
@elseif(session()->has('success'))
    <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
@elseif(session()->has('message'))
    <div class="alert alert-primary" role="alert">{{ session()->get('message') }}</div>
@endif
