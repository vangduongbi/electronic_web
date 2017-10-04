<?php 
Class slide extends MY_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('slide_model');
    $this->load->library('form_validation');
    $this->load->helper('form');
  }
  function index(){
    //phan trang
    // get total slide
    $total_rows = $this->slide_model->get_total();
    $this->data['total_rows'] = $total_rows;
     // thu vien phantrang
    //get list bai vier

    $input = array();
    $list = $this->slide_model->get_list($input);
    $this->data['list'] = $list;

    $message = $this->session->flashdata('message');
    $this->data['message'] =$message;

    //load view
    $this->data['temp'] = 'admin/slide/index';
    $this->load->view('admin/main',$this->data);
  }

  //function add slide
  function add(){
   

       if($this->input->post()){
        $this->form_validation->set_rules('name','name','required|min_length[4]');
        if($this->form_validation->run()){
          //lay ten file image
          $upload_path = './upload/slide';
          $this->load->library('upload_library');
          $upload_data = $this->upload_library->upload($upload_path,'image');
          // pre($upload_data);
          $image_link='';
          if(isset($upload_data['file_name'])){
            $image_link = $upload_data['file_name'];
          }
          $input = array();
          $input = array(
            'name' => $this->input->post('name'),
            'link' =>$this->input->post('link'),
            'info' =>$this->input->post('info'),
            'sort_order' =>$this->input->post('sort_order'),
            'image_link' =>$image_link,

           );
           
          if($this->slide_model->create($input)) {
            $this->session->set_flashdata('message','Thêm bài viết thành công');
          } else {
            $this->session->set_flashdata('message','Không thành công');
          }
          redirect(admin_url('slide/index'));
        }
       
  
      }

    $this->data['temp'] = 'admin/slide/add';
    $this->load->view('admin/main',$this->data);
  }

  function edit(){
    
       $id = $this->uri->rsegment(3);
       $id = intval($id);
       $slide = $this->slide_model->get_info($id);
       if(!$slide)
       {
           //tạo ra nội dung thông báo
           $this->session->set_flashdata('message', 'Không tồn tại slide này');
           redirect(admin_url('slide'));
       }
       $this->data['slide'] = $slide;
       
       if($this->input->post()){
         $this->form_validation->set_rules('name','name','required|min_length[4]');
         if($this->form_validation->run()){
            //lay ten file image
            $upload_path = './upload/slide';
            $this->load->library('upload_library');
            $upload_data = $this->upload_library->upload($upload_path,'image');
            $image_link='';
            if(isset($upload_data['file_name'])){
              $image_link = $upload_data['file_name'];
            }
             $input = array();
             $input = array(
              'name' => $this->input->post('name'),
              'link' =>$this->input->post('link'),
              'info' =>$this->input->post('info'),
              'sort_order' =>$this->input->post('sort_order')
             
  
             );
              if($image_link != ''){
                $input['image_link'] = $image_link;
              }
            
              if($this->slide_model->update($id,$input)){
                $this->session->flashdata('message','Cập nhật thành công');
              } else {
               $this->session->flashdata('message','Cập nhật không thành công');
              }
              redirect(admin_url('slide'));
               }
       }
      
       $this->data['temp'] = 'admin/slide/edit';
       $this->load->view('admin/main',$this->data);
     }
  function del(){
    $id = $this->uri->rsegment(3);
    $this->_delete($id);
    redirect(admin_url('slide'));
  }

  //xoa nhieu + ajax
  function delete_all(){
    $ids = $this->input->post('ids');
    foreach($ids as $id) {
      $this->_delete($id);
    }
  }

  function _delete($id){
    $slide = $this->slide_model->get_info($id);
    if(!$slide)
    {
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Không tồn tại slide này');
        redirect(admin_url('slide'));
    }
    $this->slide_model->delete($id);
    $image_link = './upload/slide/'.$slide->image_link;
    if(file_exists($image_link)) {
      unlink($image_link);
    }
  }
}