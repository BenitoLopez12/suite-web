@extends('layouts.app')
@section('content')
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon_tabantaj.png') }}">
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection


<div id="login" class="fondo clase_animacion">
    <div class="caja_marca">
        <div class="marca">
            <img src="{{ asset('img/logo_policromatico.png') }}"><br>
            <p class="by">By <strong>Silent</strong>for<strong>Business</strong></p>
            <p class="bienvenidos"><strong>Bienvenidos al</strong> Sistema de Gestión Normativa</p>
        </div>
    </div>

    @if(session('message'))
        <div class="alert alert-info" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="caja_form">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            @php
                use App\Models\Organizacion;
                $organizacion = Organizacion::select('id', 'logotipo')->first();
                if (!is_null($organizacion)) {
                    $logotipo = $organizacion->logotipo;
                } else {
                    $logotipo = 'silent4business.png';
                }
            @endphp

            <img src="{{ asset($logotipo) }}" class="logo_silent">
            <h3 class="mt-5" style="color: #345183; font-weight: normal; font-size:24px;">Iniciar Sesión</h3>
            <div class="input-group mt-5">
                <div class="input-group-prepend">
                    <span class="input-group-text" style="background-color: #fff;"><i class="bi bi-person"></i></span>
                </div>
                <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid ' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="input-group" style="margin-top:12px;">
                <div class="input-group-prepend">
                    <span class="input-group-text" style="background-color: #fff;"><i class="bi bi-lock"></i></span>
                </div>
                <input id="password" name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                @if($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="text-center" style="margin-top:20px;">
                <button type="submit" class="btn_enviar" style="background-color: #3c4b64;">Enviar</button>
            </div>
            @if(Route::has('password.request'))
                <a class="btn" href="{{ route('password.request') }}" style="margin-top:20px; color: #006DDB; font-size: 12px;">¿Olvidó su contraseña?</a>
             @endif
            <div class=" mt-2">
                <a class="btn_registrate" href="{{ route('register') }}" style="margin-top:52px;">Crear Cuenta</a>
            </div>
            <a class="btn" href="https://silent4business.com/aviso-de-privacidad/" target="_blank" style="margin-top: 50px; color: #006DDB; font-size: 12px;">Aviso de privacidad </a>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script type="text/javascript">
    $("#login").click(function(){
        $("#login").removeClass("clase_animacion");
    });
</script>



{{ \TawkTo::widgetCode('https://tawk.to/chat/5fa08d15520b4b7986a0a19b/default') }}

@endsection



