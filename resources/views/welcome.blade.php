<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ config('settings.site_name', 'Laravel') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
    </style>

</head>

<body>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7">
                    <img src="{{ asset('images/logo_um.png') }}"class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-5">
					
                    <form>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form1Example13" class="form-control form-control-lg" />
                            <label class="form-label" for="form1Example13">Email address</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="form1Example23" class="form-control form-control-lg" />
                            <label class="form-label" for="form1Example23">Password</label>
                        </div>

                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3"
                                    checked />
                                <label class="form-check-label" for="form1Example3"> Remember me </label>
                            </div>
                            <a href="#!">Forgot password?</a>
                        </div>

                        <!-- Submit button -->
                        <div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
						</div>
						@if(config('app.cas_enable') || config('settings.google_enable') == 'yes')
							<div class="divider d-flex align-items-center my-4">
								<p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
							</div>
						@endif

						@if(config('settings.google_enable') == 'yes')
							<div class="d-grid gap-2">
								<a class="btn btn-danger btn-lg" href="{{ route('auth.google') }}" role="button">
									<i class="fa fa-gooogle"></i> Continue with Google
								</a>
							</div>
						@endif
						
						@if(config('settings.cas_enable') == 'yes') 
							<p>
								<div class="d-grid gap-2">	
									<a class="btn btn-dark btn-lg btn-block" href="{{ route('auth.cas') }}" role="button">
										<i class="fa fa-gooogle"></i> Continue with CAS
									</a>
								</div>
							</p>
						@endif

                    </form>
                </div>
            </div>
        </div>
    </section>
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
