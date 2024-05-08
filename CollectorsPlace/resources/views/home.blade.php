@extends('layout')
@section('content')

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style="width: 100vw;margin-left: 0px">
            <div class="carousel-item active">
                <img src="{{asset('img/paninicards.jpg')}}" alt="..." class="homeImg">
                <div class="centeredSzovegImage text-center">
                    <h1 style="font-size: 50px; color: white">Üdvözöllek a <i style="color: yellow;">Collectors Place</i> weboldalon!</h1>
                    <h4 style="color: white">Magyarország egyetlen weboldala, ahol gyűjthető kártyákat lehet cserélni!</h4>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('img/paninicards2.jpg')}}" alt="..." class="homeImg">
                <div class="centeredSzovegImage text-center">
                    <h1 style="font-size: 50px; color: white">Keresés!</h1>
                    <h4 style="color: white">Keresés funkciónkkal gyorsan megtalálod, ami kell!</h4>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('img/paninicards3.jpg')}}" alt="..." class="homeImg">
                <div class="centeredSzovegImage text-center">
                    <h1 style="font-size: 50px">Üzenetküldés!</h1>
                    <h4>Az üzenetküldéses funkciónkkal egyszerűbb cserélni, mint valaha!</h4>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-5" style="width: 100%">
        <h1 class="homeSzoveg text-center" style="color: lightblue; font-size: 70px">HOGY MIÉRT MINKET VÁLASSZ?</h1>
        <div class="row text-center mt-4 d-flex justify-content-center">
            <div class="col-7 col-md-3">
                <h4 class="homeSzoveg"><i class="fa-solid fa-bolt" aria-hidden="true" style="color: yellow"></i> Gyors</h4>
                <p class="homeSzovegP">
                    A weboldalon gyorsan és egyszerűen meg lehet találni a keresendő kártyákat, matricákat!
                </p>
            </div>
            <div class="col-7 col-md-3">
                <h4 class="homeSzoveg"><i class="fa-solid fa-pencil" aria-hidden="true" style="color: blue"></i> Modern</h4>
                <p class="homeSzovegP">
                    Modern és letisztult dizájnával könnyen kezelni lehet az oldalt még az új felhasználóknak is!
                </p>
            </div>
            <div class="col-7 col-md-3">
                <h4 class="homeSzoveg"><i class="fa-solid fa-user" aria-hidden="true" style="color: white"></i> Egyedi</h4>
                <p class="homeSzovegP">
                    Magyarországon csakis a mi oldalunk foglalkozik gyűjthető kártyák cserélésével és gyüjtésével!
                </p>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('containerDiv').classList.remove('container');
        document.getElementById('containerDiv').style.marginTop = 0;
    </script>
@endsection

