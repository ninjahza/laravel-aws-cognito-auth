<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <div class="p-3">
                <h4 class="text-muted font-18 m-b-5 text-center">Welcome!</h4>
                <p class="text-muted text-center">Sign in to continue</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="username" class="col-sm-4 col-form-label text-md-right">{{ __('Username') }}</label>

                        <div class="col-md-6">
                            <input id="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                    @if ($errors->any())
                        <h4 class="font-18 m-b-5 error text-center">{{ implode('', $errors->all(':message')) }}</h4>
                    @endif
                </form>
            </div>

        </div>
    </div>
</div>