<?php

namespace App\Http\Controllers;

use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Symfony\Component\Console\Input\Input;
use function Sodium\add;

class OldalController extends Controller
{
    public function homePage(){
        return view('home');
    }

    public function registerPage(){
        $sql_data = DB::select("SELECT DISTINCT telepules FROM telepulesek");

        return view('register',['adatok' => $sql_data]);
    }

    public function hozzaadas(Request $request){
        $data = $request -> validate(
            [
                'user_username' => 'required|string|min:5|unique:users,user_username',
                'user_password' => 'required|string|min:5|regex:/^.*(?=.{4,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                'user_email' => 'required|email|unique:users,user_email',
                'user_familyname' => 'required|string',
                'user_lastname' => 'required|string',
                'user_location' => 'required|string',
                'user_sex' => 'required'
            ],
            [
                'user_username.min' => 'A felhasználónévnek minimum 5 karakterből kell állnia!',
                'user_username.required' => 'Kötelező felhasználónevet adnia!',
                'user_username.string' => 'A felhasználónévnek szövegnek kell lennie!',
                'user_password.required' => 'Kötelező jelszót adnia!',
                'user_password.min' => 'A jelszónak minimum 5 karakterből kell állnia!',
                'user_password.regex' => 'A jelszóban legalább 1 kisbetűnek, 1 nagybetűnek, 1 számnak és 1 speciális karakternek kell lennie!',
                'user_email.required' => 'Kötelező emailt adnia!',
                'user_familyname.required' => 'Kötelező családnevet adnia!',
                'user_lastname.required' => 'Kötelező keresztnevet adnia!',
                'user_location.required' => 'Kérem válasszon ki egy települést!',
                'user_sex.required' => 'Kérem válasszon nemet!',
                'user_username.unique' => 'Ez a felhasználónév már foglalt!',
                'user_email.unique' => 'Ez az email már foglalt!'
            ]
        );

        DB::table('users')->insert(
            [
                "user_username" => $request->user_username,
                "user_email" => $request->user_email,
                "user_password" => Hash::make($request->user_password),
                "user_familyname" => $request->user_familyname,
                "user_lastname" => $request->user_lastname,
                "user_location" => $request->user_location,
                "user_sex" => $request->user_sex,
                "user_profilepic" => "defaultProfilePic.png",
                "user_admin" => 0
            ]
        );

        return back()->with('success','Sikeres regisztráció!');
    }
    public function loginPage(){
        return view('login');
    }

    public function belepes(Request $request){
        $data = $request -> validate(
            [
                'user_password' => 'required',
                'user_email' => 'required'
            ],
            [
                'user_password.required' => 'Kötelező jelszót megadnia!',
                'user_email.required' => 'Kötelező emailt megadnia!'
            ]
        );

        $adat = DB::select("SELECT user_password FROM users WHERE user_email LIKE '$request->user_email'");

        if (!empty($adat)){
            $database_password = $adat[0]->user_password;

            if (Hash::check($request->user_password,$database_password)){
                $user = DB::select("SELECT * FROM users WHERE users.user_email LIKE '$request->user_email'");
                if ($user[0]->user_admin == 0){
                    $user[0]->user_admin = false;
                }
                else{
                    $user[0]->user_admin = true;
                }
                $request->session()->put('user',$user);
                return to_route('home');
            }
            else{
                return back()->with('error','Az email cím és a jelszó nem egyezik!');
            }
        }
        else{
            return back()->with('error','Nincs felhasználó ilyen email címmel!');
        }
    }

    public function logout(){
        session()->forget('user');
        return view('home');
    }



    /* Csere Functionok */
    public function csereletrehoz(){
        if (session()->has('user')){
            $adatok = DB::select("SELECT * FROM themes");

            return view('cserek/csereletrehoz',['adatok' => $adatok]);
        }
        else{
            return to_route('register');
        }
    }

    public function cserecreate(Request $request){
        $data = $request->validate(
            [
                'theme_name' => 'required|string',
                'offer_offcards' => 'required|string',
                'offer_receivecards' => 'required|string'
            ],
            [
                'theme_name.required' => 'A téma kiválasztása kötelező!',
                'offer_offcards.required' => 'A kínált kártyák kitöltése kötelező!',
                'offer_receivecards.required' => 'A keresett kártyák kitöltése kötelező'
            ]
        );

        foreach (session()->get('user') as $user)
        $userid = $user->user_id;

        DB::table('offers')->insert([
            "offer_userid" => $userid,
            "offer_offcards" => $request->offer_offcards,
            "offer_receivecards" => $request->offer_receivecards,
            "offer_desc" => $request->offer_desc,
            "offer_themeid" => $request->theme_name
        ]);

        return back()->with('success','Sikeresen létrehozott egy cserét!');
    }

    public function cserekmegtekintes(Request $request){
        if (session()->has('user')){
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            $valasztott = $request->theme_name;

            $adatok = DB::select("SELECT user_id,offer_desc,users.user_username AS username,offers.offer_id AS offerid,offers.offer_offcards AS offcards,offers.offer_receivecards AS	receivecards,offers.offer_desc AS description,users.user_profilepic as profilepic,users.user_location as location,themes.theme_name as theme_name FROM `offers`
INNER JOIN users ON users.user_id = offers.offer_userid
INNER JOIN themes ON themes.theme_id = offers.offer_themeid
WHERE users.user_id NOT LIKE '$userid'");

            $ratings = DB::select("SELECT rating_to AS rated, ROUND(AVG(rating_num),0) AS 'atlag_rating' FROM ratings WHERE rating_to NOT LIKE '$userid' GROUP BY rating_to");

            $erdekelt = DB::select("SELECT DISTINCT message_offer_id FROM `messages`
                                                    WHERE message_from = '$userid'");

            $marerd = [];

            foreach ($erdekelt as $mar){
                array_push($marerd,$mar->message_offer_id);
            }
            return view('cserek/cserekmegtekintes',['adatok' => $adatok,'rating' => $ratings,'marerd' => $marerd,'valasztott' => $valasztott]);
        }
        else{
            return to_route('register');
        }
    }

    /* Themes Functions */
    public function themesall(){
        if (session()->has('user')) {
            $adat = DB::select("SELECT themes.theme_id, themes.theme_name, COUNT(offers.offer_id) AS offers_num FROM `themes`
                                    LEFT OUTER JOIN offers ON themes.theme_id = offers.offer_themeid
                                    GROUP BY themes.theme_name
                                    ORDER BY offers_num DESC;");

            return view('themes/themesall', ['adatok' => $adat]);
        }
        else{
            return to_route('register');
        }
    }


    /* Profile Functions */
    public function changePic(){
        if (session()->has('user')){
            return view('profile/changepic');
        }
        else{
            return to_route('register');
        }
    }

    public function pictureUpload(Request $request){
        if (session()->has('user')){
            $data = $request->validate(
                [
                    'image' => 'required|image|max:1024'
                ],
                [
                    'image.required' => 'Kép feltöltése kötelező!',
                    'image.image' => 'Amit feltöltött nem kép fájl!',
                    'image.max' => 'A kép maximum 1 MB lehet'
                ]
            );
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            $eredetikep = DB::select("SELECT user_profilepic FROM users WHERE user_id = '$userid'");
            foreach ($eredetikep as $eredet) {
                if ($eredet->user_profilepic != "defaultProfilePic.png") {
                    $deleted=Storage::disk('public')->delete(public_path('profilepics/'.$eredet->user_profilepic));
                }
            }

            $imgstring = $user->user_username.$request->image->getClientOriginalName();

            DB::table('users')->where('user_id','=',$userid)->update(['user_profilepic' => $imgstring]);
            $user->user_profilepic = $imgstring;

            $request->image->move(public_path('profilepics'), $imgstring);

            return back()->with('success','Kép sikeresen elmentve');
        }
        else{
            return to_route('register');
        }
    }

    public function friendsListAll(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $nowuserid = $user->user_id;

            $adat = DB::select("SELECT u2.* FROM `users`
                                    INNER JOIN followings f1 ON f1.follower = users.user_id
                                    INNER JOIN users u2 ON f1.following = u2.user_id
                                    WHERE f1.follower = '$nowuserid';");

            $ratings = DB::select("SELECT rating_to AS rated,ROUND(AVG(rating_num),1) AS 'atlag_rating_tizedes', ROUND(AVG(rating_num),0) AS 'atlag_rating',COUNT(id) AS 'szam_rating' FROM ratings WHERE rating_to NOT LIKE '$nowuserid' GROUP BY rating_to");

            $nincsratingje = DB::select("SELECT user_id FROM `users` t1
                                                LEFT JOIN ratings t2 ON t2.rating_to = t1.user_id
                                                WHERE t2.rating_to IS null;");

            $felhmarratingelt = DB::select("SELECT DISTINCT rating_to FROM `ratings`
                                                    WHERE rating_from = '$nowuserid'");

            $marrat = [];

            foreach ($felhmarratingelt as $mar) {
                array_push($marrat, $mar->rating_to);
            }


            return view('profile/friends', ['adatok' => $adat, 'rating' => $ratings, 'nincsratingje' => $nincsratingje, 'marrated' => $marrat]);
        }
        else{
            return to_route('register');
        }
    }

    public function ownProfile(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $nowuserid = $user->user_id;

            $adatok = DB::select("SELECT user_id,offer_desc,users.user_username AS username,offers.offer_id AS offerid,offers.offer_offcards AS offcards,offers.offer_receivecards AS	receivecards,offers.offer_desc AS description,users.user_profilepic as profilepic,users.user_location as location,themes.theme_name as theme_name FROM `offers`
INNER JOIN users ON users.user_id = offers.offer_userid
INNER JOIN themes ON themes.theme_id = offers.offer_themeid
WHERE users.user_id LIKE '$nowuserid'");

            $telepulesek = DB::select("SELECT * FROM telepulesek");

            $ratings = DB::select("SELECT rating_to AS rated,ROUND(AVG(rating_num),1) AS 'atlag_rating_tizedes', ROUND(AVG(rating_num),0) AS 'atlag_rating',COUNT(id) AS 'szam_rating' FROM ratings WHERE rating_to LIKE '$nowuserid' GROUP BY rating_to");

            $nincsratingje = DB::select("SELECT user_id FROM `users` t1
                                                LEFT JOIN ratings t2 ON t2.rating_to = t1.user_id
                                                WHERE t2.rating_to IS null;");

            return view('profile/ownprofile', ['adatok' => $adatok, 'telepulesek' => $telepulesek, 'ratings' => $ratings, 'nincsratingje' => $nincsratingje]);
        }
        else{
            return to_route('register');
        }
    }

    public function deleteOffer($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $nowuserid = $user->user_id;

            $offer = DB::select("SELECT * from offers WHERE offer_id = '$id'");

            foreach ($offer as $off) {
                if ($nowuserid == $off->offer_userid) {
                    DB::delete("DELETE FROM offers WHERE offer_id = '$id'");

                    toastr()->success('Ajánlat sikeresen törölve!');
                    return to_route('ownProfile');
                } else {
                    return back()->with('error', "Ez a csere nem a tiéd!");
                }
            }
        }
        else{
            return to_route('register');
        }
    }

    public function changeOffer($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $nowuserid = $user->user_id;

            $offer = DB::select("SELECT * from offers WHERE offer_id = '$id'");

            foreach ($offer as $off) {
                if ($nowuserid == $off->offer_userid) {
                    $adatok = DB::select("SELECT * FROM themes");
                    return view('profile/changeOffer', ['offer' => $offer, 'adatok' => $adatok]);
                } else {
                    return back()->with('error', "Ez a csere nem a tiéd!");
                }
            }
        }
        else{
            return to_route('register');
        }
    }

    public function csereChange($id,Request $request){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $nowuserid = $user->user_id;

            $offer = DB::select("SELECT * from offers WHERE offer_id = '$id'");

            foreach ($offer as $off) {
                if ($nowuserid == $off->offer_userid) {
                    $data = $request->validate(
                        [
                            'theme_name' => 'required|string',
                            'offer_offcards' => 'required|string',
                            'offer_receivecards' => 'required|string'
                        ],
                        [
                            'theme_name.required' => 'A téma kiválasztása kötelező!',
                            'offer_offcards.required' => 'A kínált kártyák kitöltése kötelező!',
                            'offer_receivecards.required' => 'A keresett kártyák kitöltése kötelező'
                        ]
                    );

                    DB::update("UPDATE `offers` SET `offer_themeid`='$request->theme_name',`offer_offcards`='$request->offer_offcards',`offer_receivecards`='$request->offer_receivecards',`offer_desc`='$request->offer_desc' WHERE `offer_id`='$id'");

                    return to_route('ownProfile')->with('success', "Sikeresen szerkesztetted az ajánlatod!");
                } else {
                    return back()->with('error', "Ez a csere nem a tiéd!");
                }
            }
        }
        else{
            return to_route('register');
        }
    }

    public function saveNewData(Request $request){
        foreach (session()->get('user') as $user)
            $nowuserid = $user->user_id;

        $data = $request -> validate(
            [
                'user_email' => 'required|string|unique:users,user_email,'.$nowuserid.',user_id',
                'user_familyname' => 'required|string',
                'user_lastname' => 'required|string',
                'user_location' => 'required|string',
                'user_sex' => 'required'
            ],
            [
                'user_email.required' => 'Kötelező emailt adnia!',
                'user_familyname.required' => 'Kötelező családnevet adnia!',
                'user_lastname.required' => 'Kötelező keresztnevet adnia!',
                'user_location.required' => 'Kérem válasszon ki egy települést!',
                'user_sex.required' => 'Kérem válasszon nemet!',
                'user_email.unique' => 'Ez az email már foglalt!'
            ]
        );

        DB::update("UPDATE `users`
                            SET
                                `user_email`= '$request->user_email',
                                `user_sex`= '$request->user_sex',
                                `user_familyname`= '$request->user_familyname',
                                `user_lastname`='$request->user_lastname',
                                `user_location`='$request->user_location'
                            WHERE
                                `user_id` = '$nowuserid'");

        $user = DB::select("SELECT * FROM users WHERE users.user_id LIKE '$nowuserid'");
        if ($user[0]->user_admin == 0){
            $user[0]->user_admin = false;
        }
        else{
            $user[0]->user_admin = true;
        }
        session()->forget('user');
        $request->session()->put('user',$user);

        return back()->with('success',"Sikeresen megváltoztattad az adataidat!");
    }

    /* User functions */
    public function allusers(){
        if (session()->has('user')){
            foreach (session()->get('user') as $user)
                $nowuserid = $user->user_id;

            $data = DB::select("SELECT * FROM users WHERE users.user_id NOT LIKE '$nowuserid'");

            $ratings = DB::select("SELECT rating_to AS rated,ROUND(AVG(rating_num),1) AS 'atlag_rating_tizedes', ROUND(AVG(rating_num),0) AS 'atlag_rating',COUNT(id) AS 'szam_rating' FROM ratings WHERE rating_to NOT LIKE '$nowuserid' GROUP BY rating_to");

            $nincsratingje = DB::select("SELECT user_id FROM `users` t1
                                                LEFT JOIN ratings t2 ON t2.rating_to = t1.user_id
                                                WHERE t2.rating_to IS null;");

            $felhmarratingelt = DB::select("SELECT DISTINCT rating_to FROM `ratings`
                                                    WHERE rating_from = '$nowuserid'");

            $marrat = [];

            foreach ($felhmarratingelt as $mar){
                array_push($marrat,$mar->rating_to);
            }

            $follows = DB::select("SELECT following FROM followings WHERE follower = '$nowuserid'");
            $followofuser = [];

            foreach ($follows as $mar){
                array_push($followofuser,$mar->following);
            }
            return view('users/allusers',['adatok' => $data,'rating' => $ratings,'nincsratingje' => $nincsratingje,'marrated' => $marrat,'followofuser' => $followofuser]);
        }
        else{

            return to_route('register');
        }
    }

    public function ertekeles(Request $request){
        if (session()->has('user')){
            foreach (session()->get('user') as $user)
                $from = $user->user_id;

            $data = $request->validate(
                [
                    'rate' => 'required|integer|min:1|max:5',
                    'szovegInput' => 'required|string'
                ]
            );

            $rated = $request->szovegInput;

            DB::table('ratings')->insert(
                [
                    "rating_from" => $from,
                    "rating_to" => $rated,
                    "rating_num" => $request->rate
                ]
            );


            return back()->with("success","Sikeresen értékelted a felhasználót!");
        }
        else{
            return to_route('register');
        }

    }

    public function ertekelestorles($fiokid){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $from = $user->user_id;

            DB::delete("DELETE FROM ratings WHERE rating_from = '$from' AND rating_to = '$fiokid'");

            return back()->with('success', "Sikeresen törölte az értékelését!");
        }
        else{
            return to_route('register');
        }
    }

    public function barathozzaadas($fiokid){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            DB::insert("INSERT INTO `followings`(`follower`, `following`) VALUES ('$userid','$fiokid')");

            return back()->with('success', 'Mostantól követed ezt a fiókot!');
        }
        else{
            return to_route('register');
        }
    }
    public function barattorles($fiokid){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            DB::delete("DELETE FROM followings WHERE follower = '$userid' AND following = '$fiokid'");

            return back()->with('success', 'Követés sikeresen eltávolítva!');
        }
        else{
            return to_route('register');
        }
    }

    public function detailedUser($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            if ($userid == $id){
                return to_route('ownProfile');
            }

            $fiokadat = DB::select("SELECT * FROM users WHERE user_id = '$id'");

            $adatok = DB::select("SELECT user_id,offer_desc,users.user_username AS username,offers.offer_id AS offerid,offers.offer_offcards AS offcards,offers.offer_receivecards AS	receivecards,offers.offer_desc AS description,users.user_profilepic as profilepic,users.user_location as location,themes.theme_name as theme_name FROM `offers`
                                        INNER JOIN users ON users.user_id = offers.offer_userid
                                        INNER JOIN themes ON themes.theme_id = offers.offer_themeid
                                        WHERE users.user_id LIKE '$id'");

            $ratings = DB::select("SELECT rating_to AS rated,ROUND(AVG(rating_num),1) AS 'atlag_rating_tizedes', ROUND(AVG(rating_num),0) AS 'atlag_rating',COUNT(id) AS 'szam_rating' FROM ratings WHERE rating_to LIKE '$id' GROUP BY rating_to");

            $nincsratingje = DB::select("SELECT user_id FROM `users` t1
                                                LEFT JOIN ratings t2 ON t2.rating_to = t1.user_id
                                                WHERE t2.rating_to IS null;");

            $erdekelt = DB::select("SELECT DISTINCT message_offer_id FROM `messages`
                                                    WHERE message_from = '$userid'");

            $marerd = [];

            foreach ($erdekelt as $mar){
                array_push($marerd,$mar->message_offer_id);
            }

            return view('users/detaileduser', ['adatok' => $adatok, 'ratings' => $ratings, 'nincsratingje' => $nincsratingje, 'fiokadat' => $fiokadat, 'marerd' => $marerd]);
        }
        else{
            return to_route('register');
        }
    }
}
