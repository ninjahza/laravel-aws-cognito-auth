<div class="wrapper-page">
    <div class="card">
        <div class="card-body">

            <div class="p-3">
                <h4 class="text-muted font-18 m-b-5 text-center">Register</h4>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="useremail">Email</label>
                        <input type="email" class="form-control" id="useremail" placeholder="Enter email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="userpassword">Password</label>
                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" placeholder="Enter phone number" name="phone_number" required>
                    </div>

                    <div class="form-group row m-t-20">
                        <div class="col-12 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
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