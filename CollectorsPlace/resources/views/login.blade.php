@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Bejelentkezés"</script>
    @if(Session::has('error'))
        <div class="alert alert-success" role="alert">
            <li>{{Session::get('error')}}</li>
        </div>
    @endif
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Bejelentkezés</h2>
                                <p class="mb-5">Kérlek add meg email címed és jelszavad!</p>
                                <form action="{{route('belepes')}}" method="GET">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="user_email" class="form-control form-control-lg" name="user_email" required/>
                                        <label class="form-label" for="user_email">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="user_password" class="form-control form-control-lg" name="user_password" required/>
                                        <label class="form-label" for="user_password">Jelszó</label>
                                    </div>

                                    <button class="btn btn-outline-success btn-lg px-5" type="submit">Belépés</button>

                                </form>

                            </div>

                            <div>
                                <p class="mb-0">Még nincs fiókod? <a href="{{route('register')}}" class="fw-bold">Regisztrálj</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
