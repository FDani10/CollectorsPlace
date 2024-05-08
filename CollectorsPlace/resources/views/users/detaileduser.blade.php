@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Saját profil"</script>
    <div class="row profileData">
        @foreach($fiokadat as $data)
            <div class="col-3 text-center">
                <div class="crop-img mt-3 mb-2">
                    <img src="{{asset('profilepics/'.$data->user_profilepic)}}" alt="" class="profilePicOwnProfile">
                </div>
                <h2 style="color: black">{{$data->user_username}}</h2>
                @foreach($ratings as $rate)
                    @if($rate->rated == $data->user_id)
                        Átlag értékelés: <br>
                        @for($i = 0; $i < $rate->atlag_rating; $i++)
                            <label class="fa fa-star" style="color: #fd4;"></label>
                        @endfor
                        @for($i = 0; $i < 5-$rate->atlag_rating; $i++)
                            <label class="fa fa-star"></label>
                        @endfor
                        {{$rate->atlag_rating_tizedes}}/5
                        <br>
                        <p>({{$rate->szam_rating}} értékelés)</p>
                    @endif
                @endforeach
                @foreach($nincsratingje as $nincs)
                    @if($nincs->user_id == $data->user_id)
                        <label class="fa fa-star"></label>
                        <label class="fa fa-star"></label>
                        <label class="fa fa-star"></label>
                        <label class="fa fa-star"></label>
                        <label class="fa fa-star"></label>
                        <br>
                        Ezt a felhasználót még nem értékelték!
                    @endif
                @endforeach
            </div>
            <div class="col-9 userDatas mt-3">
                <div class="row text-center"><h3 class="text-white">Fiók adatai:</h3></div>
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mt-2" style="color: black">Vezetéknév:</h5>
                            <input style="background-color: #3f3f3f" type="text" name="user_familyname" id="user_familyname" disabled class="form-control text-secondary userInfoInputField" value="{{$data->user_familyname}}">
                        </div>
                        <div class="col-6">
                            <h5 class="mt-2" style="color: black">Keresztnév:</h5>
                            <input style="background-color: #3f3f3f" type="text" name="user_lastname" id="user_lastname" disabled class="form-control text-secondary userInfoInputField" value="{{$data->user_lastname}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 style="color: black">Email:</h5>
                            <input style="background-color: #3f3f3f" type="text" name="user_email" id="user_email" disabled class="form-control text-secondary userInfoInputField" value="{{$data->user_email}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5 style="color: black">Város:</h5>
                            <input style="background-color: #3f3f3f" type="text" name="user_email" id="user_email" disabled class="form-control text-secondary userInfoInputField" value="{{$data->user_location}}">
                        </div>
                        <div class="col-6">
                            <h5 style="color: black">Neme:</h5>
                            <input style="background-color: #3f3f3f" type="text" name="user_sex" id="user_sexInput" disabled class="form-control text-secondary userInfoInputField" value="@if($data->user_sex == "F") Férfi @else Nő @endif">
                        </div>
                    </div>
            </div>
        @endforeach
    </div>
    <h2 class="mt-5 ms-3">Fiók cserehirdetései:</h2>
    @foreach($adatok as $adat)
        <div class="idk mt-3">
            <div class="row mt-2">
                <h2>{{$adat->theme_name}}</h2>
            </div>
            <hr>
            <div class="row rowMeg">
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
    @endforeach
    @if($adatok == null)
        <h1 style="margin-left: 10rem; margin-top: 5rem; text-decoration: underline">Ennek a fióknak nincsenek cserehirdetései!</h1>
    @endif
@endsection

