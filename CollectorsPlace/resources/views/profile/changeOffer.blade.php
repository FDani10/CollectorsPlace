@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Csere szerkesztése"</script>
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4 ">
                                <img src="{{asset('img/logoTrans.png')}}" alt="" class="logoRegister">
                            </div>
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Csere szerkesztése</h3>
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
                            <form action="{{route('csereChange',[$offer[0]->offer_id])}}" method="GET">
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-6">
                                        <label for="theme_name" class="form-label">Kártya témája:</label>
                                        <select id="theme_name" class="form-select" name="theme_name" required>
                                            @foreach($adatok as $adat)
                                                <option value="{{$adat->theme_id}}" @if($adat->theme_id == $offer[0]->offer_themeid) selected @endif>{{$adat->theme_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-6">
                                        <p><label for="offer_offcards">Kínált kártyák</label></p>
                                        <textarea class="form-control textarea_cards" id="offer_offcards" name="offer_offcards" required>{{$offer[0]->offer_offcards}}</textarea>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-6">
                                        <p><label for="offer_receivecards">Keresett kártyák</label></p>
                                        <textarea class="form-control textarea_cards" id="offer_receivecards" name="offer_receivecards" required>{{$offer[0]->offer_receivecards}}</textarea>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-6">
                                        <p><label for="offer_desc">Egyéb megjegyzés</label></p>
                                        <textarea class="form-control textarea_cards" id="offer_desc" name="offer_desc">{{$offer[0]->offer_desc}}</textarea>
                                    </div>
                                </div>
                                <div class="pt-2 text-center">
                                    <input class="btn btn-warning" type="submit" value="Csere szerkesztése" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        dselect(document.querySelector('#theme_name'), {
            search: true
        })
    </script>
@endsection

