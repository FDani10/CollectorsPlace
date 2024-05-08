<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class MessagesController extends Controller
{
    public function messagesTab(){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;
            $data = DB::select("SELECT * FROM users
                                    WHERE users.user_id IN (
                                    SELECT
                                    CASE WHEN message_from = '$userid' THEN message_to
                                    ELSE  message_from
                                    END
                                    AS 'masikfiokid'
                                    FROM `messages`
                                    WHERE message_from = '$userid' OR message_to = '$userid'
                                    GROUP BY message_offer_id);");

            $lastmessages = [];

            foreach ($data as $dat) {
                $mess = DB::select("SELECT *
                                FROM `messages`
                                WHERE message_to = '$userid' AND message_from = '$dat->user_id' or message_to = '$dat->user_id' and message_from = '$userid'
                                ORDER BY message_time DESC
                                LIMIT 1;");

                array_push($lastmessages, $mess);
            }

            return view('messages/fooldal', ['chats' => $data, 'lasts' => $lastmessages]);
        }
        else{
            return to_route('register');
        }
    }

    public function erdekel($offeruserid,$offerid){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            DB::insert("INSERT INTO `messages`(`message_from`, `message_to`, `message_text`, `message_offer_id`,`message_time`,`message_autogenerated`)
                            VALUES ('$userid','$offeruserid','Szia! Érdekelne az alábbi csereajánlatod!','$offerid','" . date('Y-m-d H:i:s') . "','1')");

            return back()->with('success', 'Mostantól érdekel ez a csereajánlat!');
        }
        else{
            return to_route('register');
        }
    }

    public function getMessages($id){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;
            $data = DB::select("SELECT *,DATE_FORMAT(message_time, '%H:%i') AS message_time_hm, DAYOFWEEK(message_time)-1 AS message_day,
                                               DATE_FORMAT(message_time, '%Y.%m.%d') AS message_date_ymd FROM messages
                                      WHERE message_from = '$userid' AND message_to = '$id' OR message_from = '$id' AND message_to = '$userid' ORDER BY id");

            $messageData['data'] = $data;

            echo json_encode($messageData);
            exit;
        }
        else{
            return to_route('register');
        }
    }

    public function sendMessage(Request $request){
        if (session()->has('user')) {
            foreach (session()->get('user') as $user)
                $userid = $user->user_id;

            DB::insert("INSERT INTO `messages`(`message_from`, `message_to`, `message_text`, `message_offer_id`,`message_time`,`message_autogenerated`)
                            VALUES ('$userid','$request->otherUserId','$request->messagetext','$request->offerId','" . date('Y-m-d H:i:s') . "','0')");

            return response()->json(['status' => "success"]);
        }
        else{
            return to_route('register');
        }
    }

    public function getOfferForMessage($id){
        if (session()->has('user')) {
            $data = DB::select("SELECT offers.offer_offcards AS offcards,offers.offer_receivecards AS receivecards,themes.theme_name as theme_name FROM `offers`
                                        INNER JOIN themes ON themes.theme_id = offers.offer_themeid
                                        WHERE offers.offer_id LIKE '$id'");

            $messageData['data'] = $data;

            echo json_encode($messageData);
            exit;
        }
        else{
            return to_route('register');
        }
    }
}
