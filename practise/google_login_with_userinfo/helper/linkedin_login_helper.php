
<?php
        function linkedin_login_helper(){
        $this->load->config('linkedin');
        include_once APPPATH."libraries/linkedin-oauth-client/http.php";
        include_once APPPATH."libraries/linkedin-oauth-client/oauth_client.php";
        
            $client = new oauth_client_class;
            $client->client_id = $this->config->item('linkedin_api_key');
            $client->client_secret = $this->config->item('linkedin_api_secret');
            $client->redirect_uri = base_url().$this->config->item('linkedin_redirect_url');
            $client->scope = $this->config->item('linkedin_scope');
            $client->debug = false;
            $client->debug_http = true;
            $application_line = __LINE__;
            $data['linkedoauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1';

            
            //If authentication returns success
        //     if($success = $client->Initialize()){
        //         if(($success = $client->Process())){
        //             if(strlen($client->authorization_error)){
        //                 $client->error = $client->authorization_error;
        //                 $success = false;
        //             }elseif(strlen($client->access_token)){
        //                 $success = $client->CallAPI('http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
        //                 'GET',
        //                 array('format'=>'json'),
        //                 array('FailOnAccessError'=>true), $userInfo);
        //             }
        //         }
        //         $success = $client->Finalize($success);
        //     }
            
        //     if($client->exit) exit;
    
           
        // }
        // }else{
            
        // }
        
        // $data['userData'] = $userData;
        
        // Load login & profile view
        //$this->load->view('user_authentication/index',$data);
    
        }