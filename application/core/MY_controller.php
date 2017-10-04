<?php
Class My_Controller extends CI_Controller{
  public $data = array(); //gui data sang view
  public function __construct(){
    parent::__construct();
    $controller = $this->uri->segment(1);
    switch ($controller) {
      case 'admin': 
        //load helper admin
        $this->load->helper('admin_helper');
        $this->_check_login();
        break;
      default:
      //trang client
      //danh muc san pham left
        $this->load->model('catalog_model');
        $input=array();
        $input['where'] = array('parent_id' => 0);
        $catalog_list = $this->catalog_model->get_list($input);
        foreach($catalog_list as $catalog) {
          $input['where'] = array('parent_id' => $catalog->id );
          $subs = $this->catalog_model->get_list($input);
          $catalog->subs = $subs;
        }
        $this->data['catalog_list'] = $catalog_list;
      // danh muc bai viet right
      $input = array();
      $input['limit'] = array(4,0); //get 4 news from position 0
      $this->load->model('news_model');

      $news_list = $this->news_model->get_list($input);
      $this->data['news_list'] = $news_list;
      //kiem tra thanh vien da dang nhap chua
      $user_id_login = $this->session->userdata('user_id_login');
      $this->data['user_id_login'] = $user_id_login;
      if($user_id_login){
        $this->load->model('user_model');
       $user_info =  $this->user_model->get_info($user_id_login);
       $this->data['user_info'] = $user_info;
      }
      //cart 
      $this->load->library('cart');
      $this->data['total_items'] = $this->cart->total_items();
    }
  }
  private function _check_login(){
    $controller = $this->uri->rsegment('1');
    $controller = strtolower($controller);
    $login = $this->session->userdata('login');
    if(!$login && $controller != 'login') {
      redirect(admin_url('login'));
    } 
    if($login && $controller == 'login') {
      redirect(admin_url('home'));
    }
  }
}
?>