<!DOCTYPE html>
<html lang="en">
<head>
 <?php $this->load->view('site/head.php'); ?>
</head>
<body>
  <a href="#" id="back_to_top">
	 <img src="<?php echo public_url('site/images/top.png');?>" />
  </a>
  <div class="wraper">
    <div class="header">
      <?php $this->load->view('site/header.php');?>
    </div>
    <div class="container">
      <div class="left">
        <?php $this->load->view('site/left.php',$this->data);?> 
      </div>
      <div class="content">
      <?php if(isset($message)) :?>
          <p style="color:red;font-size:18px;"><?php echo $message ?></p>
      <?php endif?>
        <?php $this->load->view('site/content.php');
          $this->load->view($temp);
        ?>
        
      </div>
      <div class="right">
        <?php $this->load->view('site/right.php',$this->data);?>
      </div>
       <!-- End right -->
        <div class="clear"></div>
      <center>
		  	<img src="<?php echo public_url('site/images/bank.png'); ?>" /> 
		  </center>
			<div class="footer">
        <!-- The box-footer-->
        <?php $this->load->view('site/footer.php');?>
     <div class='clear'></div><!-- clear float --> 		        <!-- End box-footer -->
      </div>
    </div>
  </div>
</body>
</html>