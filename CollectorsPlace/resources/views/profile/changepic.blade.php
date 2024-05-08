@extends('layout')
@section('content')
    <script>document.title = "Collectors Place | Profilkép csere"</script>
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
    <section class="gradient-custom">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Profilkép megváltoztatása</h2>
                                <form method="POST" action="{{ route('profile.picupload') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="profilePicShower mt-3">
                                        <p><img id="output" width="200" class="profilePicImg"/></p>
                                        <p class="profilePicP" id="imgP">Itt fog megjelenni  a kiválasztott képed!</p>
                                    </div>
                                    <div class="image mt-3">
                                        <label class="form-label" for="image"><h4>Kép kiválasztása</h4></label>
                                        <p><input type="file"  accept="image/*" name="image" id="file" onchange="loadFile(event)" class="form-control" required></p>
                                    </div>
                                    <div class="post_button">
                                        <button type="submit" class="btn btn-success">Feltöltés</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            var textp = document.getElementById('imgP');
            textp.style.display = 'none';
        };
    </script>
@endsection
