<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailModel\EmailActions;
use Exception;
use Illuminate\Support\Facades\Log;

class TransactionalController extends Controller
{
    public function sendTransactionalEmail(Request $req)
    {
        $method           =   'POST';
        $api_key          =   config('sendinblue.api_key'); //This should come from the Deywuro Code
        $endpoint         =   'smtp/email';
        $feedback         =   [];
        
        $body_param = [
            'sender'      =>  ['name'     => $req->senderName,    'email' => $req->senderEmail],
            'to'          =>  [['name'    => $req->recipientName, 'email' => $req->recipientEmail]],
            'subject'     =>  $req->subject,
            'htmlContent' =>  '<h1>'. $req->emailContent .'</h1>'
        ];
        
        try {

            //API CALL HERE
            $response   =   EmailActions::apiCall($method, $api_key, $endpoint, $body_param);

            $data       =   json_decode($response, true);

            if(array_key_exists('messageId', $data)){
            
                $feedback['message']    = 'Email is successfully sent to ' . $body_param['to'][0]['email'];

            }
            else {
                $feedback['code']       = $data['code'];
                $feedback['message']    = $data['message'];
            }

            return response()->json(
                $feedback,
                $status   =     200, 
            );

        } catch (Exception $ex) {
            
            Log::emergency($ex->getMessage());

            return ['error' => 'Sorry, an error has occured'];

        }
    }
}
