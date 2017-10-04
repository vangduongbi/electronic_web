<?php
Class Upload extends MY_Controller
{
    function index()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('upload_library');
            $upload_path = './upload/user';
            $data = $this->upload_library->upload($upload_path, 'image');
        }
        $this->data['temp'] = 'admin/upload/index';
        $this->load->view('admin/main', $this->data);
    }
    
    function upload_multi()
    {
        if($this->input->post('submit'))
        {
           $this->load->library('upload_library');
           $upload_path = './upload/user';
           $data = $this->upload_library->upload_multi($upload_path, 'image_list');
           pre($data);
        }
        
        $this->data['temp'] = 'admin/upload/upload_multi';
        $this->load->view('admin/main', $this->data);
    }
    
}