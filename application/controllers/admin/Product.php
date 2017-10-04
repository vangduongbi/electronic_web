<?php 
Class product extends MY_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('product_model');
  }
  function index(){
    //phan trang
    // get total product
    $total_rows = $this->product_model->get_total();
    $this->data['total_rows'] = $total_rows;
     // thu vien phantrang
     $this->load->library('pagination');
    $config = array();
    $config['total_rows'] =  $total_rows; //tong tat ca san pham csdl
    
    // get base_url display product
    $config['base_url'] = admin_url('product/index');
    //product/page
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
    $name = $this->input->get('name');
    $name=strtolower($name);
    $input=array();
    if($name != ''){
      $input['like'] = array('name',$name);
    }
    $catalog_id = $this->input->get('catalog');
    $catalog_id = intval($catalog_id);
    $input= array();
    if($catalog_id>0){
      $input['where'] =array('catalog_id'=>$catalog_id);
    }
    $list = $this->product_model->get_list($input);
    $this->data['list'] = $list;
    $input=array();
    //get list catalog 
    $this->load->model('catalog_model');
    $input = array();
    $input['where'] = array('parent_id'=>0);
    $catalog = $this->catalog_model->get_list($input);
    foreach($catalog as $row) {
      $input['where'] = array('parent_id' => $row->id);
      $subs = $this->catalog_model->get_list($input);
      $row->subs = $subs;
    }
  
    $this->data['catalog'] = $catalog;
  

    $message = $this->session->flashdata('message');
    $this->data['message'] =$message;

    //load view
    $this->data['temp'] = 'admin/product/index';
    $this->load->view('admin/main',$this->data);
  }

  //function add product
  function add(){
       //get list catalog 
       $this->load->model('catalog_model');
       $input = array();
       $input['where'] = array('parent_id'=>0);
       $catalogs = $this->catalog_model->get_list($input);
       foreach($catalogs as $row) {
         $input['where'] = array('parent_id' => $row->id);
         $subs = $this->catalog_model->get_list($input);
         $row->subs = $subs;
       }
     
       $this->data['catalogs'] = $catalogs;
       $this->load->library('form_validation');
       $this->load->helper('form');
       if($this->input->post()){
        $this->form_validation->set_rules('name','name','required|min_length[4]');
        $this->form_validation->set_rules('catalog','Style','required');
        $this->form_validation->set_rules('price','Price','required');
        if($this->form_validation->run()){
          $name = $this->input->post('name');
          $catalog_id = $this->input->post('catalog');
          $price = $this->input->post('price');
          $price = str_replace(',','',$price);
          $discount = $this->input->post('discount');
          $discount = str_replace(',','',$discount);
          //lay ten file image
          $upload_path = './upload/product';
          $this->load->library('upload_library');
          $upload_data = $this->upload_library->upload($upload_path,'image');
          // pre($upload_data);
          $image_link='';
          if(isset($upload_data['file_name'])){
            $image_link = $upload_data['file_name'];
          }
          //upload anh kem theo , multi
          $image_list = array();
          $image_list= $this->upload_library->upload_multi($upload_path,'image_list');
          $image_list = json_encode($image_list); 
    
          $input = array();
          $input = array(
            'name' => $name,
            'catalog_id' => $catalog_id,
            'price' => $price,
            'image_link' =>$image_link,
            'image_list' =>$image_list,
            'discount'   =>$discount,
            'warranty'   => $this->input->post('warranty'),
            'gifts'      => $this->input->post('gifts'),
            'site_title' => $this->input->post('site_title'),
            'meta_desc'  => $this->input->post('meta_desc'),
            'content'    => $this->input->post('content'),
            'created'    => now()
           );
           
          if($this->product_model->create($input)) {
            $this->session->set_flashdata('message','Thêm sản phẩm thành công');
          } else {
            $this->session->set_flashdata('message','Không thành công');
          }
          redirect(admin_url('product/index'));
        }
       
  
      }

    $this->data['temp'] = 'admin/product/add';
    $this->load->view('admin/main',$this->data);
  }

  function edit(){
 
    $id = $this->uri->rsegment(3);
    $id = intval($id);
    $product = $this->product_model->get_info($id);
    if(!$product)
    {
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
        redirect(admin_url('product'));
    }
    $this->data['product'] = $product;
    $this->load->model('catalog_model');
    $input = array();
    $input['where'] = array('parent_id'=>0);
    $catalogs = $this->catalog_model->get_list($input);
    foreach($catalogs as $row) {
      $input['where'] = array('parent_id' => $row->id);
      $subs = $this->catalog_model->get_list($input);
      $row->subs = $subs;
    }
    $this->data['catalogs'] = $catalogs;
    $this->load->library('form_validation');
    $this->load->helper('form');
    if($this->input->post()){
      $this->form_validation->set_rules('name','name','required|min_length[4]');
      $this->form_validation->set_rules('catalog','Style','required');
      $this->form_validation->set_rules('price','Price','required');
      if($this->form_validation->run()){
        $name = $this->input->post('name');
        $catalog_id = $this->input->post('catalog');
        $price = $this->input->post('price');
        $price = str_replace(',','',$price);
        $discount = $this->input->post('discount');
        $discount = str_replace(',','',$discount);
         //lay ten file image
        
         $this->load->library('upload_library');
         $upload_path = './upload/product';
         $upload_data = $this->upload_library->upload($upload_path,'image');
         $image_link='';
         if(isset($upload_data['file_name'])){
           $image_link = $upload_data['file_name'];
         }
          //upload anh kem theo , multi
          $image_list = array();
          $image_list= $this->upload_library->upload_multi($upload_path,'image_list');
          $image_list_json = json_encode($image_list);
          $input = array();
          $input = array(
            'name' => $name,
            'catalog_id' => $catalog_id,
            'price' => $price,
            'discount'   =>$discount,
            'warranty'   => $this->input->post('warranty'),
            'gifts'      => $this->input->post('gifts'),
            'site_title' => $this->input->post('site_title'),
            'meta_desc'  => $this->input->post('meta_desc'),
            'content'    => $this->input->post('content')
           );
           if($image_link != ''){
             $input['image_link'] = $image_link;
           }
           if(!empty($image_list)){
            $input['image_list'] = $image_list_json;
          }
           if($this->product_model->update($id,$input)){
             $this->session->flashdata('message','Cập nhật thành công');
           } else {
            $this->session->flashdata('message','Cập nhật không thành công');
           }
           redirect(admin_url('product'));
            }
    }
   
    $this->data['temp'] = 'admin/product/edit';
    $this->load->view('admin/main',$this->data);
  }
  function del(){
    $id = $this->uri->rsegment(3);
    $this->_delete($id);
    redirect(admin_url('product'));
  }

  //xoa nhieu + ajax
  function delete_all(){
    $ids = $this->input->post('ids');
    foreach($ids as $id) {
      $this->_delete($id);
    }
  }

  function _delete($id){
    $product = $this->product_model->get_info($id);
    if(!$product)
    {
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
        redirect(admin_url('product'));
    }
    $this->product_model->delete($id);
    $image_link = './upload/product/'.$product->image_link;
    if(file_exists($image_link)) {
      unlink($image_link);
    }
    //xoa anh kem theo
    $image_list = json_decode($product->image_list);
    if(is_array($image_list)){
      foreach($image_list as $img){
        $image_link='./upload/product/'.$img;
        if(file_exists($image_link)){
          unlink($image_link);
        }
      }
    }
  }
}