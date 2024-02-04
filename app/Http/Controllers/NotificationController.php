<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{

    public function send(Request $request)
    {
        $deviceToken = $request->device_token;
        $title = $request->title;
        $body = $request->body;
        $data = $request->data??[];

        $this->sendNotification($deviceToken, $title, $body, $data=[]);
    }

    function sendNotification($deviceToken, $title, $body, $data)
    {
        $messaging = app('firebase.messaging');

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::fromArray([
                'title' => $title,
                'body' => $body
            ])) // optional
            ->withData($data); // optional

        $messaging->send($message);
    }
}
