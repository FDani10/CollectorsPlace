@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Regisztráció"</script>
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4 ">
                                <img src="{{asset('img/logoTrans.png')}}" alt="" class="logoRegister">
                            </div>
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Regisztráció</h3>
                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @elseif(Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    <li>{{Session::get('success')}}</li>
                                </div>
                            @elseif(Session::has('nologin'))
                                <div class="alert alert-success" role="alert">
                                    <h1>Ezt a tartalmat csak regisztrált felhasználók láthatják!</h1>
                                    <p>Regisztrálj most!</p>
                                </div>
                            @endif
                            <form action="{{route('hozzaadas')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="user_familyname">Vezetéknév</label>
                                            <input type="text" id="user_familyname" class="form-control form-control-lg" name="user_familyname" required/>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="user_lastname">Keresztnév</label>
                                            <input type="text" id="user_lastname" class="form-control form-control-lg" name="user_lastname" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="user_username">Felhasználónév</label>
                                            <input type="text" id="user_username" class="form-control form-control-lg" name="user_username" required/>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="user_password">Jelszó</label>
                                            <input type="password" id="user_password" class="form-control form-control-lg" name="user_password" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="user_email">Email</label>
                                            <input type="email" id="user_email" class="form-control form-control-lg" name="user_email" required/>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-2 pb-1">Neme: </h6>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="user_sex">Férfi</label>
                                            <input class="form-check-input" type="radio" name="user_sex" id="user_sex required"
                                                   value="F"/>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="user_sex">Nő</label>
                                            <input class="form-check-input" type="radio" name="user_sex" id="user_sex required"
                                                   value="N"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="user_location" class="form-label">Város kiválasztása:</label>
                                        <select id="user_location" class="form-select selectpicker" name="user_location" data-dselect-search="true" required>
                                            @foreach($adatok as $adat)
                                                <option data-tokens="{{$adat->telepules}}" value="{{$adat->telepules}}">{{$adat->telepules}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="pt-2 text-center">
                                    <input class="btn regisztracioButton2" type="submit" value="Regisztráció" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        dselect(document.querySelector('#user_location'), {
            search: true
        })
    </script>

@endsection
