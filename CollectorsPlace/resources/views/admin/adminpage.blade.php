@extends('layout')
@section('content')
    <script> document.title = "Collectors Place | Admin"</script>

    <div class="row">
        <div class="col-3">
            <h3>Funkciók</h3>
            <a href="#" class="btn adminFunction" onclick="profilesShow()"><i>Felhasználó funkciók</i></a><br>
            <a href="#" class="btn adminFunction" onclick="offersShow()"><i>Hirdetés funkciók</i></a><br>
            <a href="#" class="btn adminFunction" onclick="newTheme()"><i>Új téma hozzáadása</i></a><br>
            <a href="#" class="btn adminFunction" onclick="showThemes()"><i>Téma törlése</i></a><br>
        </div>
        <div class="col-9" id="adminPanel">
            <table id="adminTable" class="table table-striped"></table>
            <form id='ajax' class='form-horizontal' style="display: none">
                @csrf
                <label for='newthemename'>Új téma neve:</label>
                <input type='text' name='newthemename' id='newthemename'>
                <button class='btn btn-primary'>Hozzáadás</button>
            </form>
        </div>
    </div>

    <script src="{{asset('js/adminfunctions.js')}}"></script>
@endsection

<script>

    let newTheme = () => {
        document.getElementById('adminTable').innerHTML = "";
        $('#ajax').css("display","block");
    }

    window.onload = function() {
        $(document).ready(function () {
            $("#ajax").on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "post",
                    url: "{{route('newthemename')}}",
                    dataType: "json",
                    data: $('#ajax').serialize(),
                    success: function () {
                        toastr.success("Sikeresen hozzáadott egy új témát!","Siker!");
                        document.getElementById("ajax").reset();
                    }
                });
            });
        });
    }
</script>
