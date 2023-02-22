<?php

namespace App\Models\EmailModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class EmailActions extends Model
{
    use HasFactory;

    public static function apiCall($method, $api_key, $endpoint, $body_param = [], $query_param = [],
    )
    {
        $response = Http::withHeaders([

            'api-key' => $api_key,
            'content-type' => 'application/json',
            'accept' => 'application/json',

        ])->$method('https://api.sendinblue.com/v3/smtp/'. $endpoint, $body_param);
        
        //$data = json_decode($response); //this is done for testing

        return $response;
       
    }
}
