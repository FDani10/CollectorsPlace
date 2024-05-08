<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Collectors Place | Főoldal</title>

    {{-- JQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/f8e03dbb0b.js" crossorigin="anonymous"></script>

    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

    <!-- Toastr for Javascript -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <link rel="stylesheet" href="{{asset('css/oldal.css')}}">

    <link rel="icon" type="image/x-icon" href="{{asset('img/logoicon.png')}}">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="transition: 500ms ease" id="navbar">
        <div class="container-fluid">
            <img src="{{asset('img/logoTransInvert.png')}}" alt="Logo" title="Logo" class="navbar-brand logoBig">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Főoldal</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cserék
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="margin-left: -3rem">
                            <li><a class="dropdown-item" href="{{route('csereletrehoz')}}">Csere létrehozása</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{route('cserekmegtekintes')}}">Összes csere megtekintése</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('themesall')}}">Témák</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('allusers')}}">Felhasználók</a>
                    </li>
                </ul>
            </div>
            <div class="justify-content-end" style="margin-right: 1.5vw">
                <ul class="navbar-nav">
                    @if(session()->has('user'))
                        @foreach(session()->get('user') as $data)
                            @if($data->user_admin == true)
                                <li class="nav-item">
                                    <div class="messagesIcon">
                                        <a href="{{route('adminpage')}}" title="Admin felület"><i class="fas fa-2x fa-users-cog" style="color: black; margin-right: 0.5rem"></i></a>
                                    </div>
                                </li>
                            @endif
                            <li class="nav-item">
                                <div class="messagesIcon">
                                    <a href="{{route('messagesTab')}}" title="Üzenetek"><i class="fa fa-2x fa-comment"></i></a>
                                </div>
                            </li>
                        <li class="nav-item">
                            <div class="crop-img">
                                <img src="{{asset('profilepics/'.$data->user_profilepic)}}" alt="" class="profilePic">
                            </div>
                        </li>
                        <li class="nav-item dropdown" style="margin-right: 1.5vw">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{$data->user_username}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="margin-left: -5rem">
                                <li><a class="dropdown-item" href="{{route('ownProfile')}}">Saját profil</a></li>
                                <li><a class="dropdown-item" href="{{route('changePic')}}">Profilkép módosítása</a></li>
                                <li><a class="dropdown-item" href="{{route('friends')}}">Követések</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{route('logout')}}">Kijelentkezés</a></li>
                            </ul>
                        </li>
                        @endforeach
                    @else
                        <li class="nav-item" style="margin-right: 1vw">
                            <a class="btn bejelentkezesButton" href="{{route('login')}}" role="button">Bejelentkezés</a>
                        </li>
                        <li class="nav-item" style="margin-right: 1vw">
                            <a class="btn regisztracioButton" href="{{route('register')}}" role="button">Regisztráció</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
<div class="container mb-5" style="margin-top: 120px" id="containerDiv">
    @yield('content')
</div>
    <script>
        $(document).ready(function(){
            window.addEventListener("scroll", () => {
                if (window.scrollY > 25){
                    document.getElementById('navbar').classList.add("navbar_scrolled");
                    document.getElementById('navbar').classList.remove("navbar_not_scrolled");
                }
                else {
                    document.getElementById('navbar').classList.remove("navbar_scrolled");
                    document.getElementById('navbar').classList.add("navbar_not_scrolled");
                }
            })
        })
    </script>
</body>
</html>
