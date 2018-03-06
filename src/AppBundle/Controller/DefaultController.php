<?php

namespace AppBundle\Controller;

use AppBundle\Structs\FbBot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $token = $request->get('hub_verify_token');
        $hubVerifyToken = 'cloudwaysschool';
        $challange = $request->get('hub_challenge');
        $accessToken = 'EAACUluVis4kBAPrD4ieX6m5ZAZCas2L3OQ8p8eVLds2o9gH2cBMMD77uO6zgYUKjpioeFQscjS9GdougKQZAeEy8kU5mKNBTwtYhCjT9nSAsoiRZCe7WjllHzLDjzY4a8RPNZBsuLLa834bzahugjCbblpngOLN4HTtYApDM2TTD9Nri6g8gN';
        $bot = new FbBot();
        $bot->setHubVerifyToken($hubVerifyToken);
        $bot->setaccessToken($accessToken);
        echo $bot->verifyTokken($token,$challange);
        $input = json_decode(file_get_contents('php://input'), true);
        $message = $bot->readMessage($input);
        $textmessage = $bot->sendMessage($message,$accessToken);
        $textmessage = $bot->sendMessage($message,$accessToken);
        return new Response('');
    }
}
