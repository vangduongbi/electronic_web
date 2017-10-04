<?php 
Class News extends MY_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('News_model');
    $this->load->library('form_validation');
    $this->load->helper('form');
  }
  function index(){
    //phan trang
    // get total news
    $total_rows = $this->News_model->get_total();
    $this->data['total_rows'] = $total_rows;
     // thu vien phantrang
     $this->load->library('pagination');
    $config = array();
    $config['total_rows'] =  $total_rows; //tong tat ca san pham csdl
    
    // get base_url display news
    $config['base_url'] = admin_url('news/index');
    //news/page
    $config['per_page'] = 4; 
    //phan doan hien thi so sp tren url
    $config['uri_segment'] = 4;
    $config['next_link'] = 'Trang kế tiếp';
    $config['pre_link'] = 'Trang trước';
    //khoi tao cau hinh phan trang
    $this->pagination->initialize($config);
    $segment = $this->uri->segment(4);
    $segment = intval($segment);
    $input = array();
    $input['limit'] = array($config['per_page'],$segment);
      //kiem tra co loc du lieu hay ko
    $id = $this->input->get('id');
    $id = intval($id);
    $input= array();
    if($id>0){
    
      $input['where'] =array('id'=>$id);
    }
    $title = $this->input->get('title');
    $title=strtolower($title);
    $input=array();
    if($title != ''){
      $input['like'] = array('title',$title);
    }
    //get list bai vier
    $list = $this->News_model->get_list($input);
    $this->data['list'] = $list;

    $message = $this->session->flashdata('message');
    $this->data['message'] =$message;

    //load view
    $this->data['temp'] = 'admin/news/index';
    $this->load->view('admin/main',$this->data);
  }

  //function add news
  function add(){
   

       if($this->input->post()){
        $this->form_validation->set_rules('title','title','required|min_length[4]');
        $this->form_validation->set_rules('content','Content','required');
        if($this->form_validation->run()){
          $title = $this->input->post('title');
         
          //lay ten file image
          $upload_path = './upload/news';
          $this->load->library('upload_library');
          $upload_data = $this->upload_library->upload($upload_path,'image');
          // pre($upload_data);
          $image_link='';
          if(isset($upload_data['file_name'])){
            $image_link = $upload_data['file_name'];
          }
          $input = array();
          $input = array(
            'title' => $this->input->post('title'),
            'image_link' =>$image_link,
            'meta_desc'  => $this->input->post('meta_desc'),
            'content'    => $this->input->post('content'),
            'created'    => now()
           );
           
          if($this->News_model->create($input)) {
            $this->session->set_flashdata('message','Thêm bài viết thành công');
          } else {
            $this->session->set_flashdata('message','Không thành công');
          }
          redirect(admin_url('news/index'));
        }
       
  
      }

    $this->data['temp'] = 'admin/news/add';
    $this->load->view('admin/main',$this->data);
  }

  function edit(){
 
    $id = $this->uri->rsegment(3);
    $id = intval($id);
    $news = $this->News_model->get_info($id);
    if(!$news)
    {
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
        redirect(admin_url('news'));
    }
    $this->data['news'] = $news;
    
    if($this->input->post()){
      $this->form_validation->set_rules('title','title','required|min_length[4]');
      $this->form_validation->set_rules('content','Content','required');
      if($this->form_validation->run()){
         //lay ten file image
         $upload_path = './upload/news';
         $this->load->library('upload_library');
         $upload_data = $this->upload_library->upload($upload_path,'image');
         $image_link='';
         if(isset($upload_data['file_name'])){
           $image_link = $upload_data['file_name'];
         }
          $input = array();
          $input = array(
            'title' => $this->input->post('title'),
            'meta_desc'  => $this->input->post('meta_desc'),
            'content'    => $this->input->post('content'),
            'created'    => now()
           );
           if($image_link != ''){
             $input['image_link'] = $image_link;
           }
         
           if($this->News_model->update($id,$input)){
             $this->session->flashdata('message','Cập nhật thành công');
           } else {
            $this->session->flashdata('message','Cập nhật không thành công');
           }
           redirect(admin_url('news'));
            }
    }
   
    $this->data['temp'] = 'admin/news/edit';
    $this->load->view('admin/main',$this->data);
  }
  function del(){
    $id = $this->uri->rsegment(3);
    $this->_delete($id);
    redirect(admin_url('news'));
  }

  //xoa nhieu + ajax
  function delete_all(){
    $ids = $this->input->post('ids');
    foreach($ids as $id) {
      $this->_delete($id);
    }
  }

  function _delete($id){
    $news = $this->News_model->get_info($id);
    if(!$news)
    {
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
        redirect(admin_url('news'));
    }
    $this->News_model->delete($id);
    $image_link = './upload/news/'.$news->image_link;
    if(file_exists($image_link)) {
      unlink($image_link);
    }
  }
}