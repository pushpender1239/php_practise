<?php
function social_login_authUrl() {
    $CI =& get_instance();
    $CI->load->library('Facebook');
    include_once APPPATH . "libraries/google-api-php-client/Google_Client.php";
    include_once APPPATH . "libraries/google-api-php-client/contrib/Google_Oauth2Service.php";

    //create google login and registration authentication url..
    $clientId = '474830604768-7q864jnrfq1le81lfke1eoo66g1uefkv.apps.googleusercontent.com';
    $clientSecret = 'EEWRosjc0oIf3ozdSJpYJFp4';
    $redirectUrl = "http://app.egyanshala.com/egyan/egyanshala_project/index.php/HomeMain/g_test";
    $gClient = new Google_Client();
    $gClient->setApplicationName('Login to app.egyanshala.com');
    $gClient->setClientId($clientId);
    $gClient->setClientSecret($clientSecret);
    $gClient->setRedirectUri($redirectUrl);
    $google_oauthV2 = new Google_Oauth2Service($gClient);
    $data['google_authUrl'] = $gClient->createAuthUrl();
    // $data['google_authUrl'] = $gClient->createAuthUrl();
    //create facebook login and registration authentication url..
    $data['facebook_authUrl'] = $CI->facebook->login_url();
    return ($data) ? $data : false;
}
