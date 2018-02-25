<?php

/**
 * Created by PhpStorm.
 * User: shan
 * Date: 2/25/18
 * Time: 2:29 PM
 */
namespace AppBundle\Structs;

use Symfony\Component\Config\Definition\Exception\Exception;

class FbBot
{


    private $hubVerifyToken = null;
    private $accessToken = null;
    private $tokken = false;
    protected $client = null;
    function __construct()
    {
    }

    public function setHubVerifyToken($value)
    {
        $this->hubVerifyToken = $value;
    }

    public function setAccessToken($value)
    {
        $this->accessToken = $value;
    }

    public

    function verifyTokken($hub_verify_token, $challange)
    {
        try {
            if ($hub_verify_token === $this->hubVerifyToken) {
                return $challange;
            }
            else {
                throw new Exception("Tokken not verified");
            }
        }

        catch(Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function readMessage($input)
    {
        try {
            $payloads = null;
            $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
            $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
            return ['senderid' => $senderId, 'message' => $messageText];
        }

        catch(Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function sendMessage($input)
    {
        $curl = curl_init();
        $recipient = $input['senderid'];
        $message = $input['message'];
        $response = array();
        $response['recipient']['id'] = $recipient;
        $response['message']['text'] = $message;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v2.6/me/messages?access_token=EAACUluVis4kBAPrD4ieX6m5ZAZCas2L3OQ8p8eVLds2o9gH2cBMMD77uO6zgYUKjpioeFQscjS9GdougKQZAeEy8kU5mKNBTwtYhCjT9nSAsoiRZCe7WjllHzLDjzY4a8RPNZBsuLLa834bzahugjCbblpngOLN4HTtYApDM2TTD9Nri6g8gN",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($response),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
