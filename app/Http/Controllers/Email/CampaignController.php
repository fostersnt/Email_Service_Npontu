<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailModel\EmailActions;
use Exception;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{

    //--------CREATE CAMPAIGN EMAIL BEGINS HERE-------------------------------------------------------------------

    public function createCampaignEmail(Request $req)
    {
        $method         =   'POST';
        $api_key        =   config('sendinblue.api_key'); //This should come from the Deywuro Code
        $endpoint       =   'emailCampaigns';
        $feedback       =   [];
        $minutes        =   strval(date('i') + 2);

        $emailCampaigns['tag']                      = $req->tag;
        $emailCampaigns['sender']                   = array('name' => $req->senderName, 'email' => $req->senderEmail);
        $emailCampaigns['name']                     = $req->campaignName;
        $emailCampaigns['htmlContent']              = $req->htmlContent;
        
        $emailCampaigns['unsubscribeLink']              = 'https://www.google.com';
        $emailCampaigns['subject']                  = $req->subject;
        $emailCampaigns['replyTo']                  = $req->senderEmail;
        $emailCampaigns['toField']                  = '{{contact.FIRSTNAME}} {{contact.LASTNAME}}';
        $emailCampaigns['recipients'] =  array(
            'listIds' => array((int)$req->listIds),
        );

        $emailCampaigns['attachmentUrl']  =   'https://www.gstatic.com/webp/gallery3/1.sm.png';//'https://attachment.domain.com/myAttachmentFromUrl.jpg'; // This URL should not be a local url
        
        $emailCampaigns['inlineImageActivation']    = true;
        $emailCampaigns['mirrorActive']             = false;
        $emailCampaigns['recurring']                = false;
        $emailCampaigns['type']                     = 'classic';
        $emailCampaigns['header']                   = $req->emailHeader;
        $emailCampaigns['footer']                   = "To Unsubscribe click <a href='https://www.google.com'>{here}</a>";
        $emailCampaigns['scheduledAt']              = date("Y-m-d\TH:".$minutes.":sP"); //new \DateTime('21-01-01T00:00:00+00:00');
        $emailCampaigns['sendAtBestTime ']          = true;
         
        try {

            $response = EmailActions::apiCall($method, $api_key, $endpoint, $emailCampaigns);  

            //Converting the response from JSON object to PHP object
            $data = json_decode($response, true);

            //Checking whether the result 
            if (array_key_exists("id", $data)) {

                $feedback['id']         =   $data['id'];
                $feedback['message']    =   'You have successfully created new Email Campaign';

            } else {
                $feedback   =   $data;
            }
         
            return $feedback;  

        } catch (Exception $ex) {

            Log::emergency($ex->getMessage());

            return ['error' => 'Sorry, an error has occured'];

        }
    }

//----------SEND CAMPAIGN EMAIL BEGINS HERE----------------------------------------------------------------------

    public function sendCampaignEmail(Request $req)
    {
        $api_key    =   config('sendinblue.api_key');
        $method     =   'POST';
        $endpoint   =   'emailCampaigns/'.(int)$req->campaignId.'/sendNow';

        $emailTo    =   [
            'emailTo'       =>   $req->emailTo,
            'campaignId'    =>   $req->campaignId,
        ];
        
        try {
            
            //API CALL HERE
            $response   =   EmailActions::apiCall($method, $api_key, $endpoint, $emailTo);

            //Converting the response from JSON object to PHP object
            $data       =   json_decode($response, true);

            if ($data == null) {
                
                return ['sent_status'   =>  true];

            } else {
                return $data;
            }
            

        } catch (Exception $ex) {

            Log::emergency($ex->getMessage());

            return ['error' => 'Sorry, an error has occured'];

        }
    }

    //------GET ALL CAMPAIGN EMAILS FROM SENDIN BLUE--------------------------------------------------------------

    public function getCampaignEmails()
    {
        $api_key    =   config('sendinblue.api_key');
        $method     =   'GET';
        $endpoint   =   'emailCampaigns';

        try {
            
            //API CALL HERE
            $response   =   EmailActions::apiCall($method, $api_key, $endpoint);

            //Converting the response from JSON object to PHP object
            $data = json_decode($response);

            return $data;

        } catch (Exception $ex) {
            
            Log::emergency($ex->getMessage());

            return ['error' => 'Sorry, an error has occured'];

        }

    }
    

    //------------GET A SINGLE CAMPAIGN EMAIL---------------------------------------------------------------------

    public function getSingleCampaignEmail($campaignId)
    {
        $api_key    =   config('sendinblue.api_key');
        $method     =   'GET';
        $endpoint   =   'emailCampaigns/'.$campaignId;

        try {

            //API CALL
            $response   =   EmailActions::apiCall($method, $api_key, $endpoint);
            
            $data   =   json_decode($response);

            return $data;
        
        } catch (Exception $ex) {

            Log::emergency($ex->getMessage());

            return ['error' => 'Sorry, an error has occured'];

        }
    }


    //------DELETE EMAIL CAMPAIGN--------------------
    public function deleteCampaignEmail($campaignId)
    {
        $api_key    =   config('sendinblue.api_key');
        $method     =   'DELETE';
        $endpoint   =   'emailCampaigns/'.$campaignId;

        try {

            //API CALL
            $response   =   EmailActions::apiCall($method, $api_key, $endpoint);

            //converting the response to a JSON data
            $data   =   json_decode($response);

            //Checking whether the returned response or data is NULL or not
            if ($data == null) {

                return ['status_of_delete'  =>   'Successful'];

            } else {
                
                return $data;
            }
            
        
        } catch (Exception $ex) {

            Log::emergency($ex->getMessage());

            return ['error' => 'Sorry, an error has occured'];

        }
    }


    //-------UPDATE CAMPAIGN EMAIL----------------------------------------------------------------------------

    public function updateCampaignEmail(Request $req)
    {
        $api_key    =   config('sendinblue.api_key');
        $method     =   'PUT';
        $endpoint   =   'emailCampaigns/'.$$req->campaignId;

        $minutes        =   strval(date('i') + 2);

        $emailCampaigns['tag']                      = $req->tag;
        $emailCampaigns['sender']                   = array('name' => $req->senderName, 'email' => $req->senderEmail);
        $emailCampaigns['name']                     = $req->campaignName;
        $emailCampaigns['htmlContent']              = $req->htmlContent;
        
        $emailCampaigns['unsubscribeLink']              = 'https://www.google.com';
        $emailCampaigns['subject']                  = $req->subject;
        $emailCampaigns['replyTo']                  = $req->senderEmail;
        $emailCampaigns['toField']                  = '{{contact.FIRSTNAME}} {{contact.LASTNAME}}';
        $emailCampaigns['recipients']               =  array('listIds' => array((int)$req->listIds),);

        $emailCampaigns['attachmentUrl']  =   'https://www.gstatic.com/webp/gallery3/1.sm.png';//'https://attachment.domain.com/myAttachmentFromUrl.jpg'; // This URL should not be a local url
        
        $emailCampaigns['inlineImageActivation']    = true;
        $emailCampaigns['mirrorActive']             = false;
        $emailCampaigns['recurring']                = false;
        $emailCampaigns['type']                     = 'classic';
        $emailCampaigns['header']                   = $req->emailHeader;
        $emailCampaigns['footer']                   = "To Unsubscribe click <a href='https://www.google.com'>{here}</a>";
        $emailCampaigns['scheduledAt']              = date("Y-m-d\TH:".$minutes.":sP"); //new \DateTime('21-01-01T00:00:00+00:00');
        $emailCampaigns['sendAtBestTime ']          = true;

        try {

            $response   =   EmailActions::apiCall($method, $api_key, $endpoint, $emailCampaigns);
            
            $data       =   json_decode($response);

            return $data;

        } catch (Exception $ex) {

            Log::emergency($ex->getMessage());

            return ['error' =>  'Sorry, an error has occured'];
        }
    }
}
        