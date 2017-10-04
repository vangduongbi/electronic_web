<?php
  Class Home extends MY_Controller{
    public function __construct(){
      parent::__construct();
    }
    public function index(){
      
       //get list slide

       $this->load->model('slide_model');
       $slide_list = $this->slide_model->get_list();
       $this->data['slide_list'] = $slide_list;
     // get list product new
     $this->load->model('product_model');
     $input = array();
     $input['limit'] = array(3,0);
     $product_new_list = $this->product_model->get_list($input);
     $this->data['product_new_list'] = $product_new_list;
         // get list product buy most
         $this->load->model('product_model');
         $input = array();
         $input['order'] = array('buyed','DESC');
         $input['limit'] = array(3,0);
         $product_buyed_list = $this->product_model->get_list($input);
         $this->data['product_buyed_list'] = $product_buyed_list;
         $message = $this->session->flashdata('message');
         $this->data['message'] = $message;
         $this->data['temp'] = 'site/home/index';
         $this->load->view('site/layout',$this->data);
    }
  }
?>