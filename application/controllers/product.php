<?php 
Class product extends MY_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('product_model');
  }
  function catalog(){
    $id = intval($this->uri->rsegment(3));

    //lay thong tin the loai
    $this->load->model('catalog_model');
   
    $catalog = $this->catalog_model->get_info($id);
    if(!$catalog) {
      redirect();
    }
    $this->data['catalog'] = $catalog;
    $input = array();
    //kiem tra neu la danh muc cha
    if($catalog->parent_id == 0) {
      $input_catalog = array();
     
      $input_catalog['where'] = array('parent_id' => $id);
      $catalog_subs = $this->catalog_model->get_list($input_catalog);
      if(!empty($catalog_subs)){ //neu co danh muc con
        $catalog_subs_id = array();
        foreach($catalog_subs as $row){
          $catalog_subs_id[] =  $row->id;
        }
        //lay tat ca cac sp thuoc cac dm con do
    
           $this->db->where_in('catalog_id',$catalog_subs_id);
         
      } else{ // neu k co danh muc con thi lay toan bo sp thuoc danh muc do'
        $input['where'] = array('catalog_id' =>$id);
      }
    } else {
      $input['where'] = array('catalog_id' =>$id);
    }
    //phan trang
    // get total product
   

    $total_rows = $this->product_model->get_total($input);
    $this->data['total_rows'] = $total_rows;
     // thu vien phantrang
     $this->load->library('pagination');
    $config = array();
    $config['total_rows'] =  $total_rows; //tong tat ca san pham csdl
    
    // get base_url display product
    $config['base_url'] = base_url('product/catalog/'.$id); //link hien thi ra ds sp
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
    $input['limit'] = array($config['per_page'],$segment);
    if(!empty($catalog_subs_id)){
      $this->db->where_in('catalog_id',$catalog_subs_id);
    }
    //get ds sp
    $list = $this->product_model->get_list($input);
    $this->data['list'] = $list;

    $this->data['temp'] = 'site/product/catalog';
    $this->load->view('site/layout',$this->data);
  }

  function view(){
    $id = intval($this->uri->rsegment(3));
    $product = $this->product_model->get_info($id);
    if(!$product) redirect();
    $this->data['product'] = $product;
    $catalog = $this->catalog_model->get_info($product->catalog_id);
    $this->data['catalog'] = $catalog;
    
    //cap nhat lai so lan view sp
    $view = $product->view + 1;
    $data = array();
    $data['view'] = $view;
    $this->product_model->update($id,$data);
    $image_list = @json_decode($product->image_list);
    $this->data['image_list'] = $image_list;
    $this->data['temp'] = 'site/product/view';
    $this->load->view('site/layout',$this->data);
  }

  // tim kiem theo ten sp
  function search(){
    if(intval($this->uri->rsegment(3) == 1)){
      //dung autocomplete search $key thong qua bien term(bat buoc)
      $key = $this->input->get('term');
      
    } else {
      $key = $this->input->get('key-search');
    }
   
    $this->data['key'] = trim($key);
   $input = array();
   $input['like'] = array('name',$key);
   $list= $this->product_model->get_list($input);
   $this->data['list'] = $list;
   if(intval($this->uri->rsegment(3) == 1)){
     //dung autocomplete search
      $result = array();
      foreach($list as $row){
        $item = array();
        $item['id'] = $row->id;
        $item['label'] = $row->name;
        $item['value'] = $row->name;
        $result[] = $item;
      }
      //du lieu tra ve duoi dang json
      die(json_encode($result ));
   } else {
    $this->data['temp'] = 'site/product/search';
    $this->load->view('site/layout',$this->data);
   }
   
  }

  function search_price(){
    $price_from = intval($this->input->get('price_from'));
    $price_to = intval($this->input->get('price_to'));
    $input= array();
    $input['where'] = array('price >=' => $price_from,'price <=' => $price_to);
    $list = $this->product_model->get_list($input);
    $this->data['list'] = $list;
    $this->data['price_from'] = $price_from;
    $this->data['price_to'] = $price_to;
    $this->data['temp'] = 'site/product/search';
    $this->load->view('site/layout',$this->data); 
  }
}