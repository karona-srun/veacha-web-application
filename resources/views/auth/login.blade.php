<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login Page - Veacha</title>
        <link rel="icon" href="{{ asset('favicon.png') }}">
		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme4.css">
</head>
<body>
    <div class="form-body">
        <div class="row">            
            <div class="img-holder">
                <div class="info-holder">
                    <img class="logo-size" src="{{ asset('veacha.png') }}" alt="">
				<img src="{{ asset('dist/img/graphic1.svg') }}" alt="">
                </div>
            </div>
            
            <div class="form-holder">
                <div class="form-content">                   
                    <div class="form-items">
                        <h3>{{ __('veacha.loggin_platform') }}</h3>
                        <p>{{ __('veacha.access_to_the_most_powerful_tool') }}</p>
                         @if (session('message'))
                        <div class="alert alert-danger">{{ session('message') }}</div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-links">
                                    <a href="#" class="active">{{ __('veacha.login') }}</a>
                                </div>
                            </div>
                            <div class="col-md-6 pull-right">
                                <ul class="ml-auto" style="list-style: none;">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <img src="dist/img/{{ App::getLocale()}}.png" width="30px" height="20x" id="selected-lang"><span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="lang/en" id="en">English <img src="{{asset('dist/img/en.png')}}" width="30px" height="20x"></a>
                                            <a class="dropdown-item" href="lang/kh" id="kh">Khmer <img src="{{asset('dist/img/kh.png')}}" width="30px" height="20x"></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('login')}}">
                        @csrf
                            @if ($errors->has('email'))
                                    <span class="help-block" role="alert">
                                        <smaill style="color: red;">{{ $errors->first('email') }}</smaill>
                                    </span>
                            @enderror
                            <input class="form-control" type="text" placeholder="{{ __('veacha.email') }}"  @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @if ($errors->has('password'))
                                    <span class="help-block" role="alert">
                                        <smaill style="color: red;">{{ $errors->first('password') }}</smaill>
                                    </span>
                            @enderror
                            <input class="form-control" type="password" name="password" placeholder="{{ __('veacha.password') }}" value="{{ old('password') }}" required autocomplete="current-password">
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">{{ __('veacha.login') }}</button> 
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script>
</script>
</body>
</html>