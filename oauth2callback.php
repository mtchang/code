<?php
session_start();

// 啟動要這一行 , 帶入相關的空間變數
include("Bootstrap.php");

$provider = new League\OAuth2\Client\Provider\Google([
    'clientId'      => 'YOUR ',
    'clientSecret'  => 'YOUR',
    'redirectUri'   => 'YOUR  oauth2callback.php',
    'scopes'        => ['email', 'profile' ],
]);


echo 'SESSION<br>';
var_dump($_SESSION);

echo 'POST<br>';
var_dump($_POST);

echo 'GET<br>';
var_dump($_GET);


if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->state;
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $userDetails = $provider->getUserDetails($token);

        // Use these details to create a new profile
        printf('Hello %s!', $userDetails->firstName);
        var_dump($userDetails);

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

	var_dump($token);

    // Use this to interact with an API on the users behalf
    echo $token->accessToken;

    // Use this to get a new access token if the old one expires
    echo $token->refreshToken;

    // Number of seconds until the access token will expire, and need refreshing
    echo $token->expires;
}

?>
