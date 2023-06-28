<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/sass/app.scss')
</head>

<body class="bg-primary">
    <div class="container-sm my-5 py-5">
        <div class="row justify-content-center">
            {{-- form login --}}
            <div class="p-5 my-15 bg-light rounded-3 col-xl-4 border">
                <div class="mb-3 text-center mb-5">
                    <i class="bi-hexagon-fill my-2 fs-1 text-primary"></i>
                    <h4 class="fs-5 fw-bold">Employee Data Master</h4>
                </div>
                <div class="form my-3">
                    <hr>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        {{-- enter email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end"></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Your Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- enter password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end"></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Your Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <hr>
                        {{-- submit login --}}
                        <div class="row pt-2">
                            <button type="submit" class="btn btn-primary btn-lg mt-1 ">
                                <i class="bi bi-box-arrow-right"></i> {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
