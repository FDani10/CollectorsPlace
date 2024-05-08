let profilesShow = () => {
    $('#ajax').css("display","none");

    $.ajax({
        url: 'getprofiles',
        type: 'get',
        dataType: 'json',
        success: function (response){
            var len = 0;
            if(response['data'] != 0){
                len = response['data'].length;
            }

            if(len > 0) {
                let panel = document.getElementById('adminTable');
                let string = "";
                string += "<thead><th>Id</th><th>Felhasználónév</th><th>Email</th><th>Családnév</th><th>Keresztnév</th><th>Település</th><th>Admin</th><th>Funkciók</th></thead>";
                string += "<tbody>";
                panel.innerHTML = string;

                for(var i=0;i<len;i++){
                    var id = response['data'][i].user_id;
                    var username = response['data'][i].user_username;
                    var email = response['data'][i].user_email;
                    var familyname = response['data'][i].user_familyname;
                    var lastname = response['data'][i].user_lastname;
                    var location = response['data'][i].user_location;
                    var admin = response['data'][i].user_admin;
                    let string = "";
                    string += "<tr><td>"+id+"</td><td>"+username+"</td><td>"+email+"</td><td>"+familyname+"</td><td>"+lastname+"</td><td>"+location+"</td><td>"+admin+"</td><td><button class='btn btn-danger' onclick='deleteProfile("+id+")'>Törlés</button>";
                    if (admin == 0){
                        string += "<button class='btn btn-success' style='margin-left: 20px' onclick='addAdmin("+id+")'>Admin+</button>";
                    }
                    else if(admin == 1){
                        string += "<button class='btn btn-danger' style='margin-left: 20px' onclick='removeAdmin("+id+")'>Admin-</button>";
                    }
                    string += "</td></tr>";
                    string += "</tbody>";
                    panel.innerHTML += string;
                }
            }
        }
    });
};

let deleteProfile = (id) => {
    $.ajax({
        url: '/deleteprofile/'+id,
        type: 'get',
        dataType: 'json',
        success: function () {
            toastr.success("Sikeresen törölte a felhasználót!","Siker!");
            profilesShow();
        }
    });
}

let addAdmin = (id) => {
    $.ajax({
        url: '/addadmin/'+id,
        type: 'get',
        dataType: 'json',
        success: function () {
            toastr.success("Sikeresen jogokat adott a felhasználónak!","Siker!");
            profilesShow();
        }
    });
}

let removeAdmin = (id) => {
    $.ajax({
        url: '/removeadmin/'+id,
        type: 'get',
        dataType: 'json',
        success: function () {
            toastr.success("Sikeresen törölte a jogokat a felhasználótól!","Siker!");
            profilesShow();
        }
    });
}

let offersShow = () => {
    $('#ajax').css("display","none");

    $.ajax({
        url: 'getoffers',
        type: 'get',
        dataType: 'json',
        success: function (response){
            var len = 0;
            if(response['data'] != 0){
                len = response['data'].length;
            }

            if(len > 0) {
                let panel = document.getElementById('adminTable');
                let string = "";
                string += "<thead><th>Id</th><th>Felhasználónév</th><th>Téma</th><th>Keresett</th><th>Kínált</th><th>Megjegyzés</th><th>Funkció</th></thead>";
                string += "<tbody>";
                panel.innerHTML = string;

                for(var i=0;i<len;i++){
                    var id = response['data'][i].offer_id;
                    var username = response['data'][i].user_username;
                    var themeName = response['data'][i].theme_name;
                    var offcards = response['data'][i].offer_offcards;
                    var receivecards = response['data'][i].offer_receivecards;
                    var desc = response['data'][i].offer_desc;
                    let string = "";
                    string += "<tr><td>"+id+"</td><td>"+username+"</td><td>"+themeName+"</td><td>"+offcards+"</td><td>"+receivecards+"</td><td>"+desc+"</td><td><button class='btn btn-danger' onclick='deleteOffer("+id+")'>Törlés</button>";
                    string += "</td></tr>";
                    string += "</tbody>";
                    panel.innerHTML += string;
                }
            }
        }
    });
}

let deleteOffer = (id) => {
    $.ajax({
        url: '/deleteoffer/'+id,
        type: 'get',
        dataType: 'json',
        success: function () {
            toastr.success("Sikeresen törölte a hirdetést!","Siker!");
            offersShow();
        }
    });
}

let showThemes = () => {
    $('#ajax').css("display", "none");

    $.ajax({
        url: 'getthemes',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            var len = 0;
            if (response['data'] != 0) {
                len = response['data'].length;
            }

            if (len > 0) {
                let panel = document.getElementById('adminTable');
                let string = "";
                string += "<thead><th>Id</th><th>Téma neve</th><th>Csereajánlatok száma</th><th>Funkció</th></thead>";
                string += "<tbody>";
                panel.innerHTML = string;

                for (var i = 0; i < len; i++) {
                    var id = response['data'][i].theme_id;
                    var themeName = response['data'][i].theme_name;
                    var offersNum = response['data'][i].offers_num;
                    let string = "";
                    string += "<tr><td>" + id + "</td><td>" + themeName + "</td><td>" + offersNum + "</td><td><button class='btn btn-danger' onclick='deleteTheme(" + id + ")'>Törlés</button>";
                    string += "</td></tr>";
                    string += "</tbody>";
                    panel.innerHTML += string;
                }
            }
        }
    });
}

let deleteTheme = (id) => {
    $.ajax({
        url: '/deletetheme/'+id,
        type: 'get',
        dataType: 'json',
        success: function () {
            toastr.success("Sikeresen törölte a témát!","Siker!");
            showThemes();
        }
    });
}
