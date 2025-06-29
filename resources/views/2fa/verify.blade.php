
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Verificación en dos pasos</h2>
    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <div>
            <label for="one_time_password">Código de Google Authenticator:</label>
            <input type="text" name="one_time_password" id="one_time_password" required autofocus>
            @error('one_time_password')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Verificar</button>
    </form>
</div>
@endsection