<?php

Class admin extends MY_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('admin_model');
  }
  function index(){
    $input = array();
    $list = $this->admin_model->get_list($input);
    $this->data['list'] = $list;
    $total = $this->admin_model->get_total();
    $this->data['total'] = $total;
    $message = $this->session->flashdata('message');
    $this->data['message'] = $message;
    $this->data['temp'] = 'admin/admin/index';
    $this->load->view('admin/main',$this->data);
  }
  //check username trung lap
  function checkusername(){
    $username = $this->input->post('username');
    $where = array('username'=> $username);
    if($this->admin_model->check_exists($where)) {
      $this->form_validation->set_message(__FUNCTION__,'Tài khoản đã tồn tại');
      return false;
    } 
      return true;
    
  } 
  //them moi quan tri vien
  function add(){
    $this->load->library('form_validation');
    $this->load->helper('form');
    //neu co data post len thi kiem tra 
    if($this->input->post()){
      $this->form_validation->set_rules('name','name','required|min_length[4]');
      $this->form_validation->set_rules('username','Username','required|min_length[4]|callback_checkusername');
      $this->form_validation->set_rules('password','Mật khẩu','required|min_length[8]');
      $this->form_validation->set_rules('re_password','Nhập lại mật khẩu','matches[password]');
      //neu ko co loii
      if($this->form_validation->run()){
        //them vao csdl
        $name = $this->input->post('name');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $data = array(
          'name' => $name,
          'username' => $username,
          'password' => md5($password)

        );
        if($this->admin_model->create($data)){
          $this->session->set_flashdata('message','Thêm mới admin thành công'); //messae flash thong bao
        } else {
          $this->session->set_flashdata('message','Có lỗi xảy ra');
        }
        //chuyen toi danh sach quan tri
        redirect(admin_url('admin/index'));
      }
    }
    $this->data['temp'] = 'admin/admin/add';
    $this->load->view('admin/main',$this->data);
  }
  //edit quan tri vien
  function edit(){
    $this->load->library('form_validation');
    $this->load->helper('form');
    $id = $this->uri->rsegment(3);
    $id = intval($id);
   echo $id;
    $info = $this->admin_model->get_info($id);
    $this->data['info'] = $info;
    if(!$info) {
      $this->session->set_flashdata('message',"Không có trong danh sách quản trị");
      redirect('admin/admin/index');
    }
    if($this->input->post()){
      $this->form_validation->set_rules('username','Username','required|min_length[4]|callback_checkusername');
      $password = $this->input->post('password');
      if($password){
        $this->form_validation->set_rules('password','Mật khẩu','required|min_length[8]');
        $this->form_validation->set_rules('re_password','Nhập lại mật khẩu','matches[password]');
      }
      if($this->form_validation->run()){
        //them vao csdl
        $name = $this->input->post('name');
        $username = $this->input->post('username');
        if($password) 
        {
          $this->data['password'] = md5($password);
        }
        $data = array(
          'name' => $name,
          'username' => $username
        );
        if($this->admin_model->update($id,$data)){
          $this->session->set_flashdata('message','Cập nhật admin thành công'); //messae flash thong bao
        } else {
          $this->session->set_flashdata('message','Có lỗi xảy ra');
        }
        //chuyen toi danh sach quan tri
        redirect(admin_url('admin/index'));
      }
    }
    $this->data['temp'] = 'admin/admin/edit';
    $this->load->view('admin/main',$this->data);
  }
  //delete item
  function delete(){
    $id = $this->uri->rsegment(3);
    $id = intval($id);
    $info = $this->admin_model->get_info($id);
    $this->data['info'] = $info;
    if(!$info) {
      $this->session->set_flashdata('message',"Không có trong danh sách quản trị");
      redirect('admin/admin/index');
    }
    if($this->admin_model->delete($id)) {
      $this->session->set_flashdata('message','Xóa thành công');
    }
    else {
      $this->session->set_flashdata('message','Xóa ko thành công');
    }
    redirect(admin_url('admin/index'));
  }
  //dang xuat
  function logout(){
    if($this->session->userdata('login')){
      $this->session->unset_userdata('login');
      redirect(admin_url('login'));
    }
    
  }
}