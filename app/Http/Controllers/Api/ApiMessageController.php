<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ApiMessageController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
    }


     /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $data = $request->all();

        // Salvataggio del messaggio nel database
        $message = new Message();
        $message->apartment_id = $data['apartment_id'];
        $message->email = $data['email'];
        $message->content = $data['content'];
       
        $message->save();

        // risposta
        return response()->json(['response' => true, 'message' => 'messaggio inviato con successo']);
    }


}