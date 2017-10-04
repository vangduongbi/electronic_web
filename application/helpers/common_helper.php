<?php
   function public_url($url =''){
    return base_url('public/'.$url);
  }
  function pre($list,$exist = true){
    echo '<pre>';
    print_r($list);
    echo '</pre>';
    if($exist){
      die();
    }
  }
?>