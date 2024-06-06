<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        return redirect()->away($client->createAuthUrl());
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Calendar::CALENDAR);

        if ($request->get('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
            $client->setAccessToken($token);

            $service = new Google_Service_Calendar($client);
            // Here you can create a Google Meet event
            $event = new Google_Service_Calendar_Event([
                'summary' => 'Google Meet Meeting',
                'start' => [
                    'dateTime' => '2024-06-06T10:00:00-07:00',
                    'timeZone' => 'America/Los_Angeles',
                ],
                'end' => [
                    'dateTime' => '2024-06-06T11:00:00-07:00',
                    'timeZone' => 'America/Los_Angeles',
                ],
                'conferenceData' => [
                    'createRequest' => [
                        'requestId' => 'sample123',
                        'conferenceSolutionKey' => [
                            'type' => 'hangoutsMeet'
                        ]
                    ]
                ]
            ]);

            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

            return view('google_event', ['event' => $event]);
        }

        return redirect('/');
    }
}
