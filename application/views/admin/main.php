<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $this->load->view('admin/head');
  ?>
</head>
<body>
  <div id="left_content">
    <?php $this->load->view('admin/left.php'); ?>
  </div>

  <div id="rightSide">
     <?php $this->load->view('admin/header.php'); ?>
        <!-- content change using layout master -->
        <?php $this->load->view($temp,$this->data);?>

  <?php $this->load->view('admin/footer.php'); ?>

  </div>
  <div class="clear"></div>
</body>
</html>