<?php 
Class catalog extends MY_Controller{
  public function __construct(){
    parent::__construct();
    $this->load->model('catalog_model');
  }
  //lay danh sach danh muc sp
  function index(){
    $list = $this->catalog_model->get_list();
    $this->data['list'] = $list;
    //lay tong so
    $total = $this->catalog_model->get_total();
    $this->data['total'] = $total;
    //lay noi dung bien message
    $message = $this->session->flashdata('message');
    $this->data['message'] = $message;
    $this->data['temp'] = 'admin/catalog/index';
    $this->load->view('admin/main',$this->data);

  }
  function add(){
    //load thu vien 
    $this->load->library('form_validation');
    $this->load->helper('form');
    if($this->input->post()){
      $this->form_validation->set_rules('name','name','required|min_length[4]');
      if($this->form_validation->run()){
        $name = $this->input->post('name');
        $sort_order = $this->input->post('sort_order');
        $parent_id = $this->input->post('parent_id');
        $data = array(
          'name' => $name,
          'sort_order' => intval($sort_order),
          'parent_id' => $parent_id
        );
        if($this->catalog_model->create($data)) {
          $this->session->set_flashdata('message','Thêm mới danh mục thành công');
        } else {
          $this->session->set_flashdata('message','Thêm mới danh mục không thành công');
        }
        redirect(admin_url('catalog/index'));
      }
   
    }
    // lay danh sach danh mục cha
    $input = array();
    $input['where'] = array('parent_id' => 0);
    $list = $this->catalog_model->get_list($input);
    $this->data['list'] = $list;
    $this->data['temp'] = 'admin/catalog/add';
    $this->load->view('admin/main',$this->data);
  }
  // cap nhat du lieu
  function edit(){
    $this->load->library('form_validation');
    $this->load->helper('form');
    $id = $this->uri->rsegment(3);
    $id= strtolower($id);
    $info = $this->catalog_model->get_info($id);
    $this->data['info'] = $info;
    if(!$info) {
      $this->session->flashdata('message','Không tồn tại danh mục này');
      redirect(admin_url('catalog/index'));
    }
    if($this->input->post()){
      $this->form_validation->set_rules('name','name','required|min_length[4]');
      if($this->form_validation->run()){
        $name = $this->input->post('name');
        $parent_id = $this->input->post('parent_id');
        $sort_order = $this->input->post('sort_order');
        $input = array();
        $input = array(
          'name' => $name,
          'sort_order' => $sort_order,
          'parent_id' => $parent_id
        );
        if($this->catalog_model->update($id,$input)) {
          $this->session->set_flashdata('message','Cập nhật thành công');
        } else {
          $this->session->set_flashdata('message','Cập nhật không thành công');
        }
        redirect(admin_url('catalog/index'));
      }
     

    }
    $input = array();
    $input['where'] = array('parent_id' => 0);
    $list = $this->catalog_model->get_list($input);
    $this->data['list'] = $list;
    $this->data['temp'] = 'admin/catalog/edit';
    $this->load->view('admin/main',$this->data);
  }

  //delete
  function delete(){
    
    $id = $this->uri->rsegment(3);
    $id = strtolower($id);
    $this->_delete($id);
    redirect(admin_url('catalog/index'));
  }
  //dalete
  private function _delete($id){
    $this->load->library('form_validation');
    $this->load->helper('form');
    $info = $this->catalog_model->get_info($id);
    $this->data['info'] = $info;
    if(!$info) {
      $this->session->set_flashdata('message','Không tồn tại');
      redirect(admin_url('catalog/index'));
    }
    $this->load->model('product_model');
    $product = $this->product_model->get_info_rule(array('catalog_id'=>$id),'id');
    if($product) {
      $this->session->set_flashdata('message','Danh mục '.$info->name.' này có sản phẩm nên không thể xóa! Bạn cần xóa sản phẩm trước');
      redirect(admin_url('catalog/index'));
    }
    if($this->catalog_model->delete($id)) {
      $this->session->set_flashdata('message','Xóa thành công!');
    } else {
      $this->session->set_flashdata('message','Xóa không thành công');
    }
  }
   function delete_all(){
    $ids = $this->input->post('ids');
    foreach($ids as $id){
      $this->_delete($id);
    }

  }
}
?>