@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Activar 2FA</h2>
    <div>
        {!! $QR_Image !!}
        <p>Clave secreta: {{ $secret }}</p>
    </div>
    <form method="POST" action="{{ route('2fa.enable') }}">
        @csrf
        <label for="one_time_password">Código de Google Authenticator:</label>
        <input type="text" name="one_time_password" id="one_time_password" required autofocus>
        <button type="submit">Activar</button>
    </form>
    <form method="POST" action="{{ route('2fa.disable') }}">
        @csrf
        <button type="submit">Desactivar 2FA</button>
    </form>
</div>
@endsection