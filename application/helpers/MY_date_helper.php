<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
function get_date($time,$fulltime =true){
  $format = '%d-%m-%Y';
  if($fulltime){
    $format = $format.'_ %H:%i:%s';
  }
  $date= mdate($format,$time);
  return $date;
}
?>