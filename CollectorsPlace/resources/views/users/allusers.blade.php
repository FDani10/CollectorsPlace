@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Felhasználók"</script>
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
    @endif

    <div class="row d-flex justify-content-center">
        <div class="card" style="width: 22rem">
            <div class="card-body text-center justify-content-center">
                <h3 class="card-title">Keresés név szerint</h3>
                <i style="font-size: 0.81rem">Hagyd üresen, ha minden eredményt látni szeretnél!</i>
                <input class="form-control mt-2" type="text" name="usernameSearch" id="usernameSearch" style="margin-left: auto;margin-right: auto">
                <a href="#" class="btn btn-info mt-2" onclick="userKereses()">Keresés</a>
            </div>
        </div>
    </div>

<div class="row" style="height: auto">
    @foreach($adatok as $adat)
        <div class="col-7 col-md-6 col-lg-4 usersCards">
            <div class="card mt-3" style="width: 18rem">
                <div class="card-body text-center mt-2">
                    <div>

                    </div>
                    <img src="{{asset('profilepics/'.$adat->user_profilepic)}}" class="profilePicCsere">
                    <div>
                        <h5 class="card-title usernevekCards" style="display: inline-block">{{$adat->user_username}}</h5>
                        @if(in_array($adat->user_id,$followofuser))
                            <a href="{{route('kovettorles',$adat->user_id)}}" style="margin-right: auto">
                                <button type="button" class="btn btn-danger friendDiv" title="Követés törlése">
                                    <label class="fa fa-minus" style="color: darkred;"></label>
                                </button>
                            </a>
                        @else
                            <a href="{{route('kovethozzaadas',$adat->user_id)}}" style="margin-right: auto">
                                <button type="button" class="btn btn-success friendDiv" title="Követés">
                                    <label class="fa fa-plus" style="color: darkgreen;"></label>
                                </button>
                            </a>
                        @endif
                    </div>
                    <h6 class="card-subtitle mb-2 text-muted">({{$adat->user_location}})</h6>
                    <p class="card-text mt-3">
                    @foreach($rating as $rate)
                        @if($rate->rated == $adat->user_id)
                                Átlag értékelés: <br>
                            @for($i = 0; $i < $rate->atlag_rating; $i++)
                                    <label class="fa fa-star" style="color: #fd4;"></label>
                            @endfor
                            @for($i = 0; $i < 5-$rate->atlag_rating; $i++)
                                    <label class="fa fa-star"></label>
                            @endfor
                            {{$rate->atlag_rating_tizedes}}/5
                            <br>
                            <p class="ertekeles_szam">({{$rate->szam_rating}} értékelés)</p>
                        @endif
                    @endforeach
                    @foreach($nincsratingje as $nincs)
                        @if($nincs->user_id == $adat->user_id)
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <br>
                                Ezt a felhasználót még nem értékelték!
                        @endif
                    @endforeach
                    </p>
                    <a href="{{route('detaileduser',$adat->user_id)}}" class="card-link"><button class="btn btn-primary mb-2">Részletek a felhasználóról</button></a>
                     @if(in_array($adat->user_id,$marrated))
                        <a href="{{route('ertekelestorles',$adat->user_id)}}"><button type="button" class="btn btn-danger">Értékelésem törlése</button></a>
                     @else
                        <button type="button" id="idButton" onclick="openPopup('{{$adat->user_id}}','{{$adat->user_username}}')" class="btn btn-warning">Értékelés</button>
                     @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
    <div class="unclickable" id="unclickable" onclick="closePopup()">
    </div>
<div class="popup" id="popup">
    <h3 id="szovegNevvel" class="mt-2">Értékelje ezt a felhasználót: !</h3>
    <form action="{{route('rating')}}" method="POST">
        @csrf
        @method('POST')
        <div class="star-widget">
            <input type="text" name="szovegInput" id="szovegInput" style="visibility: hidden">
            <input type="radio" name="rate" id="rate-5" value="5">
            <label for="rate-5" class="fa fa-star"></label>
            <input type="radio" name="rate" id="rate-4" value="4">
            <label for="rate-4" class="fa fa-star"></label>
            <input type="radio" name="rate" id="rate-3" value="3">
            <label for="rate-3" class="fa fa-star"></label>
            <input type="radio" name="rate" id="rate-2" value="2">
            <label for="rate-2" class="fa fa-star"></label>
            <input type="radio" name="rate" id="rate-1" value="1">
            <label for="rate-1" class="fa fa-star"></label>
        </div>
        <button type="submit" name="submit" class="btn btn-warning">Értékelés</button>
    </form>
</div>
@endsection

<script>
    $( document ).ready(function() {
        let popup = document.getElementById('popup');
        let unclickable = document.getElementById('unclickable');
    });

    function openPopup(text,nev){
        document.getElementById('szovegInput').value = `${text}`;
        document.getElementById('szovegNevvel').innerHTML = `Értékelje a felhasználót: ${nev}`;
        popup.classList.add("open-popup");
        unclickable.classList.add("fadeinpls");
    }

    function closePopup(){
        popup.classList.remove("open-popup");
        unclickable.classList.remove("fadeinpls");
    }

    function userKereses(){
        let usernames = document.getElementsByClassName('usernevekCards');
        let keresendo = document.getElementById('usernameSearch').value.toLowerCase();
        let usersCards = document.getElementsByClassName('usersCards');
        if(keresendo == ""){
            for(let i = 0; i < usernames.length; i++){
                    $(usersCards[i]).css("display","block");
            }
        }
        else{
            for(let i = 0; i < usernames.length; i++){
                console.log(keresendo);

                console.log(usernames[i].innerHTML.toLowerCase());
                if (usernames[i].innerHTML.toLowerCase().includes(keresendo)){
                    $(usersCards[i]).css("display","block");
                }
                else{
                    $(usersCards[i]).css("display","none");
                }
            }
        }
    }
</script>
