<?php

class Upload extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url'));
    }
    public function index()
    {
        $this->load->view('upload_form',array('error'=>''));
    }


    public function counts()
    {
        $this->load->library('upload');
        $dataInfo=array();
        $files =$_FILES;
        $cpt = count($_FILES['userfile']['name']);
        for($i=0;$i<$cpt;$i++)
        {
            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];
            
            $this->upload->initialize($this->doUpload());
            //$this->upload->do_upload();
            if(!$this->upload->do_upload())
        {
            $error =array('error' =>$this->upload->display_errors());
            $this->load->view('upload_form',$error);
        }
        else{
                $data =array('upload_data'=>$this->upload->data());
                $this->load->view('upload_success',$data);
            }
            $dataInfo[] = $this->upload->data();

        }
        $data = array(
            'name'=>$this->input->post('pd_name'),
            'prod_image'=>$dataInfo[0]['file_name'],
            'prod_image1'=>$dataInfo[1]['file_name'],
            //'prod_image2'=>$dataInfo[2]['file_name'],
            'created_time'=>date('Y-m-d H:i:s')
        );
     
    }
    public function doUpload()
    {
        $config=array();
        $config['file_name']='new.jpg';
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = FALSE;
        $config['max_size'] = 1000;
        $config['max_width']= 1024;
        $config['max_height'] = 768;
        $this->load->library('upload',$config); 
        // if(!$this->upload->do_upload('userfile'))
        // {
        //     $error =array('error' =>$this->upload->display_errors());
        //     $this->load->view('upload_form',$error);
        // }
        // else{
        //     $data =array('upload_data'=>$this->upload->data());
        //     $this->load->view('upload_success',$data);
        // }
        return $config;
    }
}
?>