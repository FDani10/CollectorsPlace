<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OldalController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[OldalController::class,'homePage'])->name('home');
Route::get('/register',[OldalController::class,'registerPage'])->name('register');

Route::post('/hozzaadas',[OldalController::class,'hozzaadas'])->name('hozzaadas');
Route::get('/login',[OldalController::class,'loginPage'])->name('login');
Route::get('/belepes',[OldalController::class,'belepes'])->name('belepes');

Route::get('/logout',[OldalController::class,'logout'])->name('logout');

/* Cserék Routes */
Route::get('/cserek/csereletrehozas',[OldalController::class,'csereletrehoz'])->name('csereletrehoz');
Route::post('/cserek/cserecreate',[OldalController::class,'cserecreate'])->name('cserecreate');

Route::get('/cserek/cserekmegtekintes',[OldalController::class,'cserekmegtekintes'])->name('cserekmegtekintes');

Route::get('/cserek/cseremegtekintes/$id',[OldalController::class,'cseremegtekintes'])->name('cseremegtekintes');

/* Themes Routes */
Route::get('/themes/all',[OldalController::class,'themesall'])->name('themesall');

/* Profile Routes */
Route::get('/profile/changePic',[OldalController::class,'changePic'])->name('changePic');
Route::post('/profile/pictureUpload',[OldalController::class,'pictureUpload'])->name('profile.picupload');
Route::get('/profile/following',[OldalController::class,'friendsListAll'])->name('friends');
Route::get('/profile/ownProfile',[OldalController::class,'ownProfile'])->name('ownProfile');

Route::get('/profile/deleteOffer/{id}',[OldalController::class,'deleteOffer'])->name('deleteOffer');

Route::get('/profile/changeOffer/{id}',[OldalController::class,'changeOffer'])->name('changeOffer');
Route::get('/profile/csereChange/{id}',[OldalController::class,'csereChange'])->name('csereChange');

Route::post('/profile/saveNewData',[OldalController::class,'saveNewData'])->name('saveNewData');

/* Users */
Route::get('/users',[OldalController::class,'allusers'])->name('allusers');
Route::post('/users/ertekeles',[OldalController::class,'ertekeles'])->name('rating');
Route::get('/users/ertekelestorles/{fiokid}',[OldalController::class,'ertekelestorles'])->name('ertekelestorles');

Route::get('/users/detailedUser/{id}',[OldalController::class,'detailedUser'])->name('detaileduser');

Route::get('/friends/add/{fiokid}',[OldalController::class,'barathozzaadas'])->name('kovethozzaadas');
Route::get('/friends/remove/{fiokid}',[OldalController::class,'barattorles'])->name('kovettorles');

/* Messages */

Route::get('/messages/fooldal',[MessagesController::class,'messagesTab'])->name('messagesTab');

Route::get('/messages/{offer_userid}/{offerid}',[MessagesController::class,'erdekel'])->name('erdekel');
Route::get('/getmessage/{id}',[MessagesController::class,'getMessages']);
Route::post('sendmessage',[MessagesController::class,'sendMessage'])->name('sendmessage');

Route::get('/getofferformessage/{id}',[MessagesController::class,'getOfferForMessage']);


/* Admin */
Route::get('/admin',[AdminController::class,'AdminPage'])->name('adminpage');
Route::get('getprofiles',[AdminController::class,'getProfiles'])->name('getprofiles');
Route::get('/deleteprofile/{id}',[AdminController::class,'deleteProfile']);
Route::get('/addadmin/{id}',[AdminController::class,'addAdmin']);
Route::get('/removeadmin/{id}',[AdminController::class,'removeAdmin']);

Route::get('getoffers',[AdminController::class,'getOffers'])->name('getoffers');
Route::get('/deleteoffer/{id}',[AdminController::class,'deleteOffer']);

Route::post('newthemename',[AdminController::class,'newThemeName'])->name('newthemename');

Route::get('getthemes',[AdminController::class,'getThemes'])->name('getthemes');
Route::get('/deletetheme/{id}',[AdminController::class,'deleteTheme']);
