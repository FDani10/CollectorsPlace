@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Témák"</script>
    <div class="row">
        <h3>Keressen témát:</h3>
        <input type="text" name="searchTheme" id="searchTheme" class="form-control">
    </div>
    <div class="row mt-3">
        @foreach($adatok as $adat)
            <div class="col-7 col-md-6 col-lg-4 col-xl-3 themeDivs">
                <div class="card text-white bg-secondary mb-3 text-center" style="height: 14rem" id="card">
                    <div class="card-header align-middle"  style="height: 7rem"><h3 class="card-title" style="overflow: hidden;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;">{{$adat->theme_name}}</h3></div>
                    <div class="card-body">
                        <h5>Csereajánlatok száma: {{$adat->offers_num}}</h5>
                        <form action="{{route('cserekmegtekintes')}}">
                            <input type="hidden" name="theme_name" id="theme_name" value="{{$adat->theme_name}}">
                            <p class="card-text"><button class="btn btn-primary">Összes csere megtekintése</button></p>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center" id="talaltZero" style="display: none">
        <h2>Hoppá! Nincs ilyen téma!</h2>
        <h5>Nem lehet hogy valamit elirtál?</h5>
    </div>
    <script>

        $(document).ready(function(){
            $("#searchTheme").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                let divek = document.getElementsByClassName('themeDivs');
                let hotok = document.getElementsByClassName('card-title');
                let talalt = 0;
                if(value == ""){
                    talalt = 1;
                    for (var i = 0; i < divek.length; i++){
                        $(divek[i]).css('display','block');
                    }
                }
                else{
                    for(var i = 0; i < hotok.length; i++) {
                        if(hotok[i].innerHTML.toLowerCase().includes(value)){
                            $(divek[i]).css('display','block');
                            talalt++;
                        }
                        else{
                            $(divek[i]).css('display','none');
                        }
                    }
                }
                if(talalt == 0){
                    $('#talaltZero').css('display','block');
                }
                else{
                    $('#talaltZero').css('display','none');
                }
            });
        });
    </script>
@endsection
