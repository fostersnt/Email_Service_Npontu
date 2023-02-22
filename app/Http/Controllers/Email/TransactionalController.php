<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailModel\EmailActions;

class TransactionalController extends Controller
{
    public function sendTransactionalEmail(Request $req)
    {
        $method         =   'post';
        $api_key        =   config('sendinblue.api_key'); //This should come from the Deywuro Code
        $endpoint       =   'email';
        $feedback       =   '';
        
        $body_param = [
            'sender'        =>      ['name'     => $req->senderName,    'email' => $req->senderEmail],
            'to'            =>      [['name'    => $req->recipientName, 'email' => $req->recipientEmail]],
            'subject'       =>      $req->subject,
            'htmlContent'   =>      '<h1>'. $req->emailContent .'</h1>'
        ];

        $response   =   EmailActions::apiCall($method, $api_key, $endpoint, $body_param);

        $data       =   json_decode($response, true);

        

        //return $body_param['to'][0]['email'];

        if(array_key_exists('messageId', $data)){
            
            $feedback = 'Email is successfully sent to ' . $body_param['to'][0]['email'];

        }
        else {
            $feedback = 'Sorry, we encountered a problem. Contact administrator for assistance.';
        }

        return response()->json(
            $result   =     [$data, $feedback],
            $status   =     200 
        );
    }
}
