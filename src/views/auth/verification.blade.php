<div class="wrapper-page">
    <div class="card">
        <div class="card-body">

            <div class="p-3">
                <h4 class="text-muted font-18 m-b-5 text-center">Welcome {{ session('username') }}!</h4>
                <p class="text-muted text-center">We have sent a verification code via {{ session('verifyMethod') }}</p>

                <form method="POST" action="{{ route('verify') }}">
                    @csrf

                    <div class="form-group">
                        <label for="code">Verification Code</label>
                        <input type="text" class="form-control" id="code" placeholder="Verification Code" name="code">
                    </div>

                    <div class="form-group row m-t-20">
                        <div class="col-12 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Verify</button>
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