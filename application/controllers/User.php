<?php 
Class user extends MY_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('user_model');
    $this->load->library('form_validation');
    $this->load->helper('form');
  }

  //check email trung lap
  function checkemail(){
    $email = $this->input->post('email');
    $where = array('email'=> $email);
    if($this->user_model->check_exists($where)) {
      $this->form_validation->set_message(__FUNCTION__,'Email này đã tồn tại');
      return false;
    } 
      return true;
    
  } 
  function _get_user_info(){
    $this->load->model('user_model');
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $password = md5($password);
    $where = array(
      'email'=>$email,
      'password'=>$password
    );
    $user = $this->user_model->get_info_rule($where);
    return $user; 
  }
  function check_login(){
    $user = $this->_get_user_info();
    if($user){
      return true;
    }
    $this->form_validation->set_message(__FUNCTION__,'Tên đăng nhập hoặc mật khẩu sai!');
    return false;
  }
//dang ky thanh vien

  function register() {

    if($this->input->post()) {
      $this->form_validation->set_rules('name','name','required|min_length[4]');
      $this->form_validation->set_rules('email','email','required|valid_email|callback_checkemail');
      $this->form_validation->set_rules('password','Password','required');
      $this->form_validation->set_rules('re_password','Password','matches[password]');
      $this->form_validation->set_rules('address','address','required');
      $this->form_validation->set_rules('phone','phone','required|is_natural');
      if($this->form_validation->run()){
        $input = array();
        $input = array(
          'name' => $this->input->post('name'),
          'email' => $this->input->post('email'),
          'password' => md5($this->input->post('password')),
          'phone' => $this->input->post('phone'),
          'address' => $this->input->post('address'),
          'created' => now()
        );
        if($this->user_model->create($input)){
          $this->session->set_flashdata('message','Đăng ký thành công');
        } else{
          $this->session->set_flashdata('message','Đăng ký không thành công');
        }
        redirect(base_url());
      }
    }
    $this->data['temp'] = 'site/user/register';
    $this->load->view('site/layout',$this->data);
  }

  // kiem tra dang nhap

  function login(){
    if($this->input->post()) {
      $this->form_validation->set_rules('login','login','callback_check_login');
      $this->form_validation->set_rules('email','email','required|valid_email');
      $this->form_validation->set_rules('password','Password','required');
      // $this->form_validation->set_rules('password','password');
      if($this->form_validation->run()){
        $user = $this->_get_user_info();
        $this->session->set_userdata('user_id_login',$user->id);
        $this->session->set_flashdata('message','Đăng nhập thành công');
        redirect();
      }
    }
    $this->data['temp'] = 'site/user/login';
    $this->load->view('site/layout',$this->data);

  }

  function logout(){
  
    if($this->session->userdata('user_id_login')){
      $this->session->unset_userdata('user_id_login');
    }
    redirect();
  }
}