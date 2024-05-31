@extends('layouts.auth')

@section('content')
<div class="container-xl px-4">
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
            <div class="card my-5">       
                <hr class="my-0" />
                <div class="card-body p-5">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="" width="100" height="100" />
                    </div>
                    <!-- BEGIN: Login Form-->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="text-gray-600 small" for="input_type">Email / Pseudo</label>
                            <input
                                class="form-control form-control-solid @if($errors->get('email') OR $errors->get('username')) is-invalid @endif"
                                type="text"
                                id="input_type"
                                name="input_type"
                                placeholder=""
                                value="{{ old('input_type') }}"
                                autocomplete="off"
                            />
                            @if ($errors->get('email') OR $errors->get('username'))
                                <div class="invalid-feedback">
                                    Mot de passe/Pseudonyme incorrect
                                </div>
                            @endif
                        </div>
                        <!-- Form Group (password)-->
                        <div class="mb-3">
                            <label class="text-gray-600 small" for="password">Mot de passe</label>
                            <input
                                class="form-control form-control-solid @if($errors->get('email') OR $errors->get('username')) is-invalid @endif @error('password') is-invalid @enderror"
                                type="password"
                                id="password" name="password"
                                placeholder=""
                            />
                            @error('password')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Form Group (forgot password link)-->
                        <div class="mb-3"><a class="small" href="#">Mot de passe oublié ?</a></div>
                        <!-- Form Group (login box)-->
                        <div class="d-flex align-items-center justify-content-between mb-0">
                            <div class="form-check">
                                <input class="form-check-input" id="remember_me" name="remember" type="checkbox" />
                                <label class="form-check-label" for="remember_me">Se souvenir de moi.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Connexion</button>
                        </div>
                    </form>
                    <!-- END: Login Form-->
                </div>
                <hr class="my-0" />
                <div class="card-body px-5 py-4">
                    <div class="small text-center">
                        Nouveau ici ?
                        <a href="{{ route('register') }}">Créer un compte !</a>
                    </div>
                </div>
            </div>
            <!-- END: Social Login Form-->
        </div>
    </div>
</div>
@endsection
