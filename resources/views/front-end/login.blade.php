<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
{{-- <div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Login Form -->
        <form action="{{ route('login.store') }}" method="post">
            <input type="text" id="login" class="fadeIn second mt-3" name="login" placeholder="login">
            <input type="text" id="password" class="fadeIn third" name="login" placeholder="password">
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>
    </div>
</div> --}}

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Relipa Portal</h5>
                        <form action="{{ route('login.store') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <label for="floatingInput">Email address</label>
                                <input type="email" class="form-control" id="floatingInput" name="email"
                                    placeholder="name@example.com">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="floatingPassword">Password</label>
                                <input type="password" class="form-control" id="floatingPassword" name="password"
                                    placeholder="Password">          
                            </div>

                            <div class="input-group mb-3">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                                    <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                        {{ trans('global.remember_me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                                    in</button>
                            </div>
                            <hr class="my-4">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
