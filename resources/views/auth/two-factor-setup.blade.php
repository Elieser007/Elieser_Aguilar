@extends('layouts.app')

@section('content')
<div>
	<h1>Configurar 2FA</h1>
	<p>Escanea este código QR con tu aplicación de autenticación:</p>
	<img src="{{ $qrCodeUrl }}" alt="Código QR">
	<form method="POST" action="{{ route('two-factor.verify') }}">
		@csrf
		<label for="code">Código 2FA:</label>
		<input type="text" name="code" id="code" required>
		<button type="submit">Verificar</button>
	</form>
</div>
@endsection
