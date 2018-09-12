
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller
{


    function index()
    {
       
         $config['upload_path']          = 'web_assets/upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);

        $len = count($_FILES);//get all file from ajax..
        for($i=0;$i<$len;$i++)
        {
        if ( !$this->upload->do_upload('SelectedFile'.$i))
                {
                        $error = array('error' => $this->upload->display_errors());
                        print_r($error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        print_r($data) ;
                }   
        }

    }
     function start()
    {
        $this->load->view('home.php');
    }
    
}

?>

