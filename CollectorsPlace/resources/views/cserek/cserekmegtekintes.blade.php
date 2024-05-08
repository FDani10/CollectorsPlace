@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Cserék"</script>
    @if($valasztott != null)
        <script>
            $(document).ready( function () {
                getSzures();
            });
        </script>
    @endif


    <div class="row">
        <p>
            <a class="btn btn-dark" data-bs-toggle="collapse" href="#szurokCollapse" role="button" aria-expanded="false" aria-controls="szurokCollapse">Szűrők</a>
        </p>
        <div class="col">
            <div class="collapse multi-collapse" id="szurokCollapse">
                <div class="card card-body" style="width: 50rem">
                    <i class="text-center mt-0 mb-2">Hagyja üresen mindet, ha minden eredményt látni akar!</i>
                    <div class="row">
                        <div class="col-3">
                            <h3>Téma szerint:</h3>
                            <input type="text" name="searchTheme" id="searchTheme" class="form-control" @if($valasztott != null) value="{{$valasztott}}" @endif>
                        </div>
                        <div class="col-3">
                            <h3>Város szerint:</h3>
                            <input type="text" name="searchTown" id="searchTown" class="form-control">
                        </div>
                        <div class="col-3">
                            <h3>Kinál szerint:</h3>
                            <input type="text" name="searchKinal" id="searchKinal" class="form-control">
                        </div>
                        <div class="col-3">
                            <h3>Keres szerint:</h3>
                            <input type="text" name="searchKeres" id="searchKeres" class="form-control">
                        </div>
                        <div class="mt-2 text-center">
                            <button type="button" onclick="getSzures()" class="btn btn-info">Szűrés</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@foreach($adatok as $adat)
        <div class="idk">
            <div class="row rowMeg">
                <div class="col-3 align-middle mt-1">
                    <p class="themename">{{$adat->theme_name}}</p>
                    <img src="{{asset('profilepics/'.$adat->profilepic)}}" class="profilePicCsere mt-3">
                    <p class="stars">
                        @foreach($rating as $rate)
                            @if($rate->rated == $adat->user_id)
                                @for($i = 0; $i < $rate->atlag_rating; $i++)
                                    <label class="fa fa-star" style="color: #fd4;"></label>
                                @endfor
                                @for($i = 0; $i < 5-$rate->atlag_rating; $i++)
                                    <label class="fa fa-star"></label>
                                @endfor
                            @endif
                        @endforeach
                    </p>
                    <p class="profileName">{{$adat->username}}</p>
                    <p class="telepules">({{$adat->location}})</p>
                </div>
                <div class="col">
                    <h4>Kínál:</h4>
                    <p class="kinal">{{$adat->offcards}}</p>
                </div>
                <div class="col">
                    <h4>Keres:</h4>
                    <p class="keres">{{$adat->receivecards}}</p>
                </div>
            </div>
            @if($adat->offer_desc != null)
                <hr>
                <div class="row">
                    <div class="col">
                        <p style="margin-top: 0px">Megjegyzés:</p>
                        <i style="font-size: 1rem">{{$adat->offer_desc}}</i>
                    </div>
                </div>
            @endif
            <hr>
            <div class="erdekelButtonDiv">
                @if(in_array($adat->offerid,$marerd))
                    <p style="font-size: 2vh">Ez a csere már érdekel téged! <a href="{{route('messagesTab',)}}"><button type="button" class="btn btn-primary">Üzenetek</button></a></p>
                @else
                    <a href="{{route('erdekel',['offer_userid'=>$adat->user_id,'offerid'=>$adat->offerid])}}"><button type="button" class="btn btn-primary">Érdekel</button></a>
                @endif
            </div>
        </div>

        <script>
                    function getSzures(){
                        let tema = document.getElementById('searchTheme').value.toLowerCase();
                        let varos = document.getElementById('searchTown').value.toLowerCase();
                        let keres = document.getElementById('searchKeres').value.toLowerCase();
                        let kinal = document.getElementById('searchKinal').value.toLowerCase();

                        let temak = document.getElementsByClassName('themename');
                        let varosok = document.getElementsByClassName('telepules');
                        let kereses = document.getElementsByClassName('keres');
                        let kinalatok = document.getElementsByClassName('kinal');

                        let divek = document.getElementsByClassName('idk');

                        if(tema == "" && varos == "" && keres == "" && kinal == ""){
                            for(let i = 0; i < divek.length; i++){
                                $(divek[i]).css("display","block");
                            }
                        }
                        else{
                            for(let i = 0; i < divek.length; i++){
                                let joe = true;
                                if(tema != ""){
                                        if(!temak[i].innerHTML.toLowerCase().includes(tema)){
                                            joe = false;
                                        }
                                }
                                if(varos != ""){
                                        if(!varosok[i].innerHTML.toLowerCase().includes(varos)){
                                            joe = false;
                                        }
                                }
                                if(keres != ""){
                                        if(!kereses[i].innerHTML.toLowerCase().includes(keres)){
                                            joe = false;
                                        }
                                }
                                if(kinal != ""){
                                        if(!kinalatok[i].innerHTML.toLowerCase().includes(kinal)){
                                            joe = false;
                                        }
                                }
                                if(joe == true){
                                    $(divek[i]).css("display","block");
                                }
                                if(joe == false){
                                    $(divek[i]).css("display","none");
                                }
                            }
                        }
                    }
        </script>
@endforeach
@endsection
