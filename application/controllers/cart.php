<?php
Class Cart extends MY_Controller{
  function __construct(){
    parent::__construct();
  
  }
  //phuong thuc them sp vao gio hang
  function add(){
    // lay sp muon them vao gio hang
    $this->load->model('product_model');
    $id = intval($this->uri->rsegment(3));
    $product = $this->product_model->get_info($id);
    if(!$product){
      redirect();
    } 


    $qty = 1;
    $price = $product->price;
    if($product->discount > 0 ){
      $price = $product->price - $product->discount;
    }
    $data = array();
    $data['id'] = $product->id;
    $data['qty'] = $qty;
    $data['name'] = url_title($product->name);
    $data['image_link'] = $product->image_link;
    $data['price'] = $price;
    $this->cart->insert($data);
    //chuyen toi trang ds sp trong gio hang
    redirect(base_url('cart'));
   }
//hien thi ds sp trong gio hang
   function index() {
     $carts = $this->cart->contents();
     $total_items = $this->cart->total_items();
     $this->data['carts'] = $carts;
     $this->data['total_items'] = $total_items;
     $this->data['temp'] = 'site/cart/index';
     $this->load->view('site/layout',$this->data);
     


    }
    function update() {
      $carts = $this->cart->contents();
      $data = array();
      foreach($carts as $key=>$cart){
        $total_qty = $this->input->post('qty_'.$cart['id']);
        $data['rowid'] = $key;
        $data['qty'] = $total_qty;
        $this->cart->update($data);
      
      }
      redirect('cart');
    }

    function delete() {
     $id = intval($this->uri->rsegment(3));
      if($id >0 ){
        $carts = $this->cart->contents();
        $data = array();
        foreach($carts as $key=>$cart){
         if($cart['id'] == $id ){
          $data['rowid'] = $key;
          $data['qty'] = 0;
          $this->cart->update($data);
         }
          
        }
       
      } else{
        $this->cart->destroy();
       
    }
    redirect('cart');
      }
    }

       

