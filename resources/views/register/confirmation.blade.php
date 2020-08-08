@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Gracias por registrarte, Te enviamos un enlace a tu correo para que inicies sesión.</strong>
                        </div>

                        {!! Field::email('email') !!}

                        {!! Field::text('username') !!}

                        {!! Field::text('first_name') !!}

                        {!! Field::text('last_name') !!}
                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Regístrate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
