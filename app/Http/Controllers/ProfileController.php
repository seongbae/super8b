<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Google_Client;
use Google_Service_Calendar;
use URL;
//use GoogleCalendarHelper;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function getAuthUser ()
    {
        
    }

    public function updateAuthUser (Request $request)
    {
        
    }

    public function show()
    {
        $client = new Google_Client();
        // Set the application name, this is included in the User-Agent HTTP header.
        $client->setApplicationName('Calendar integration');
        // Set the authentication credentials we downloaded from Google.
        $client->setAuthConfig(storage_path('keys/google_calendar_client_secret.json'));
        // Setting offline here means we can pull data from the venue's calendar when they are not actively using the site.
        $client->setAccessType("offline");
        // This will include any other scopes (Google APIs) previously granted by the venue
        $client->setIncludeGrantedScopes(true);
        // Set this to force to consent form to display.
        $client->setApprovalPrompt('force');
        // Add the Google Calendar scope to the request.
        $client->addScope(Google_Service_Calendar::CALENDAR);
        // Set the redirect URL back to the site to handle the OAuth2 response. This handles both the success and failure journeys.
        $client->setRedirectUri(URL::to('/') . '/oauth2callback');

        $user = Auth::user();
        $client->setState($user->id);
        // The Google Client gives us a method for creating the 
        $authUrl = $client->createAuthUrl();

    	return view('profile')->with('authurl', $authUrl);
    }

    public function showDeveloper()
    {
        return view('developer');
    }

    public function updateAuthUserPassword(Request $request)
    {
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function handleOAuth2Callback(Request $request)
    {
        // Get all the request parameters
        $input = $request->all();

        // Attempt to load the venue from the state we set in $client->setState($venue->id);
        $user = User::findOrFail($input['state']);

        // If the user cancels the process then they should be send back to
        // the venue with a message.
        if (isset($input['error']) &&  $input['error'] == 'access_denied') {
            \Session::flash('global-error', 'Authentication was cancelled. Your calendar has not been integrated.');
            return redirect()->route('user.profile');

        } elseif (isset($input['code'])) {
            // Else we have an auth code we can use to generate an access token

            // This is the helper we added to setup the Google Client with our             
            // application settings
            //$gcHelper = new GoogleCalendarHelper($venue);

            // This helper method calls fetchAccessTokenWithAuthCode() provided by 
            // the Google Client and returns the access and refresh tokens or 
            // throws an exception
            //$accessToken = $gcHelper->getAccessTokenFromAuthCode($input['code']);

            $client = new Google_Client();
            $client->setApplicationName('Calendar integration');
            $client->setAuthConfig(storage_path('keys/google_calendar_client_secret.json'));
            $client->setAccessType("offline");
            $client->setIncludeGrantedScopes(true);
            $client->setApprovalPrompt('force');
            $client->addScope(Google_Service_Calendar::CALENDAR);
            $client->setRedirectUri(URL::to('/') . '/oauth2callback');

            $accessToken = $client->fetchAccessTokenWithAuthCode($input['code']);
            $client->setAccessToken($accessToken);

            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }

            //Log::info('accessToken: '.json_encode($accessToken));
            //Log::info('User: '.json_encode($user));
            // We store the access and refresh tokens against the venue and set the 
            // integration to active.
            $user->gcalendar_credentials = $accessToken['access_token'];
            $user->gcalendar_integration_active = 1;
            $user->save();

            \Session::flash('global-success', 'Google Calendar integration enabled.');
            return redirect()->route('user.profile');
        }
    }
    
}
