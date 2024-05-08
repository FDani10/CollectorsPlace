<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function AdminPage(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                return view('admin/adminpage');
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function getProfiles(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                foreach (session()->get('user') as $user)
                    $userid = $user->user_id;

                $data = DB::select("SELECT * FROM users WHERE user_id != '$userid'");

                $messageData['data'] = $data;

                echo json_encode($messageData);
                exit;
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function deleteProfile($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                DB::delete("DELETE FROM users WHERE user_id = '$id'");

                return response()->json(['status'=> "success"]);
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function addAdmin($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                DB::update("UPDATE `users` SET `user_admin`='1' WHERE user_id = '$id'");

                return response()->json(['status'=> "success"]);
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function removeAdmin($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                DB::update("UPDATE `users` SET `user_admin`='0' WHERE user_id = '$id'");

                return response()->json(['status'=> "success"]);
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function getOffers(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                $data = DB::select("SELECT offer_id,users.user_username,themes.theme_name,offer_offcards,offer_receivecards,offer_desc FROM offers
    INNER JOIN users ON users.user_id = offers.offer_userid
    INNER JOIN themes on themes.theme_id = offers.offer_themeid");

                $messageData['data'] = $data;

                echo json_encode($messageData);
                exit;
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function deleteOffer($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                DB::delete("DELETE FROM offers WHERE offer_id = '$id'");

                return response()->json(['status'=> "success"]);
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function newThemeName(Request $request){
        if (session()->has('user')) {
            DB::insert("INSERT INTO `themes`(`theme_name`) VALUES ('$request->newthemename')");

            return response()->json(['status' => "success"]);
        }
        else{
            return to_route('register');
        }
    }

    public function getThemes(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                $data = DB::select("SELECT themes.theme_id, themes.theme_name, COUNT(offers.offer_id) AS offers_num FROM `themes`
                                    LEFT OUTER JOIN offers ON themes.theme_id = offers.offer_themeid
                                    GROUP BY themes.theme_name
                                    ORDER BY offers_num DESC;");

                $messageData['data'] = $data;

                echo json_encode($messageData);
                exit;
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }

    public function deleteTheme($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $useradmin = $user->user_admin;
            if ($useradmin == 1){
                DB::delete("DELETE FROM themes WHERE theme_id = '$id'");

                return response()->json(['status'=> "success"]);
            }
            else{
                return back()->with('danger','Ehhez nincs jogosultságod!');
            }
        }
        else{
            return to_route('register');
        }
    }
}
