@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <style>
        /* Fondo con imagen pequeña que se repite */
        .login-page {
            position: relative !important;
            min-height: 100vh !important;
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #000 !important;
        }
        
        /* Tu imagen de fondo - se repite en mosaico */
        .login-page::before {
            content: "";
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-image: url('{{ asset('img/fondo-login.jpg') }}') !important;
            background-repeat: repeat !important; /* Se repite como mosaico */
            background-size: auto !important; /* Tamaño original */
            opacity: 0.6 !important; /* Muy transparente para que no opaque */
            z-index: 1 !important;
        }
        
        /* Overlay oscuro para que resalte el texto */
        .login-page::after {
            content: "";
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0, 0, 0, 0.7) !important;
            z-index: 2 !important;
        }
        
        /* Caja de login - por encima del fondo */
        .login-box {
            width: 380px !important;
            position: relative !important;
            z-index: 10 !important;
            margin: 0 auto !important;
        }
        
        /* Tarjeta blanca */
        .card {
            background: white !important;
            border-radius: 15px !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
            border: none !important;
        }
        
        /* Header */
        .card-header {
            background: transparent !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
            padding: 25px 25px 15px 25px !important;
            text-align: center !important;
        }
        
        .card-header h3 {
            color: #333 !important;
            font-weight: 700 !important;
            font-size: 1.6rem !important;
            margin: 0 0 5px 0 !important;
        }
        
        .card-header p {
            color: #666 !important;
            font-size: 0.9rem !important;
            margin: 0 !important;
        }
        
        /* Cuerpo */
        .card-body {
            padding: 20px 25px 25px 25px !important;
        }
        
        /* Input groups */
        .input-group {
            margin-bottom: 1.2rem !important;
        }
        
        .input-group-prepend {
            display: flex !important;
        }
        
        .input-group-text {
            background: #f8f9fa !important;
            border: 1px solid #e2e8f0 !important;
            border-right: none !important;
            border-radius: 8px 0 0 8px !important;
            padding: 0.6rem 1rem !important;
            color: #4a5568 !important;
        }
        
        .form-control {
            border: 1px solid #e2e8f0 !important;
            border-left: none !important;
            border-radius: 0 8px 8px 0 !important;
            padding: 0.6rem 1rem !important;
            height: auto !important;
            font-size: 0.95rem !important;
        }
        
        .form-control:focus {
            border-color: #4299e1 !important;
            box-shadow: 0 0 0 0.2rem rgba(66, 153, 225, 0.1) !important;
            outline: none !important;
        }
        
        .form-control::placeholder {
            color: #a0aec0 !important;
            font-size: 0.9rem !important;
        }
        
        /* Checkbox */
        .icheck-primary {
            margin-top: 0.3rem !important;
        }
        
        .icheck-primary label {
            margin-left: 8px !important;
            color: #4a5568 !important;
            font-size: 0.9rem !important;
            font-weight: 400 !important;
        }
        
        /* Botón */
        .btn-primary {
            background: #dc2626 !important;
            border: none !important;
            padding: 0.6rem 1rem !important;
            font-size: 0.95rem !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            transition: all 0.2s !important;
        }
        
        .btn-primary:hover {
            background: #b91c1c !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3) !important;
        }
        
        .btn-primary i {
            margin-right: 5px !important;
        }
        
        /* Mensajes de error */
        .invalid-feedback {
            color: #dc2626 !important;
            font-size: 0.8rem !important;
            margin-top: 0.2rem !important;
            padding-left: 10px !important;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-box {
                width: 90% !important;
            }
            
            .row {
                flex-direction: column !important;
            }
            
            .col-7, .col-5 {
                max-width: 100% !important;
                flex: 0 0 100% !important;
                text-align: center !important;
            }
            
            .col-5 {
                margin-top: 15px !important;
            }
            
            .card-header h3 {
                font-size: 1.4rem !important;
            }
        }
    </style>
@stop

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');
    
    if (config('adminlte.use_route_url', false)) {
        $loginUrl = $loginUrl ? route($loginUrl) : '';
    } else {
        $loginUrl = $loginUrl ? url($loginUrl) : '';
    }
@endphp

@section('auth_header')
    <h3>Sistema de Votación</h3>
    <p>Iniciar Sesión</p>
@stop

@section('auth_body')
    <form action="{{ $loginUrl }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="Correo electrónico" autofocus required>
        </div>
        @error('email')
            <div class="invalid-feedback d-block mb-2">
                {{ $message }}
            </div>
        @enderror

        {{-- Password field --}}
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" required>
        </div>
        @error('password')
            <div class="invalid-feedback d-block mb-2">
                {{ $message }}
            </div>
        @enderror

        {{-- Remember me and login button --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        Recordarme
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button type="submit" class="btn btn-block btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Ingresar
                </button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    {{-- Vacío --}}
@stop
