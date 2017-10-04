
  
         <?php
         $this->load->view('site/slide',$this->data);

         ?>

         
  <!-- lay san pham moi nhat -->  
    <div class="box-center"><!-- The box-center product-->
        <div class="tittle-box-center">
           <h2>Sản phẩm mới</h2>
        </div>
          <div class="box-content-center product"><!-- The box-content-center -->
          <?php foreach($product_new_list as $product_new): ?>
		        <div class='product_item'>
                  <h3>
                    <a  href="<?php echo base_url('product/view/'.$product_new->id);?>" title="Sản phẩm"> <?php echo $product_new->name  ?> </a>
                  </h3>
                <div class='product_img'>
                      <a  href="<?php echo base_url('product/view/'.$product_new->id);?>" title="Sản phẩm">
                        <img src="<?php echo base_url('upload/product/').$product_new->image_link ;?>" alt=''/>
                    </a>
                </div>
                <p class='price'>
                  
                    <?php if($product_new->discount > 0)  : ?>
                       <?php echo number_format($product_new->price - $product_new->discount).' đ'?>
                         <span class="price_old"> <?php echo number_format($product_new->price).' đ'?></span>
                    <?php else: ?>
                         <?php echo number_format($product_new->price).' đ'?>
                    <?php endif ?>
                  </p>
                <center>
                  <div class='raty' style='margin:10px 0px' id='9' data-score='4'></div>
                </center>
                <div class='action'>
                    <p style='float:left;margin-left:10px'>Lượt xem: <b><?php echo $product_new->view  ?></b></p>
                    <a class='button' href="#" title='Mua ngay'>Mua ngay</a>
                  <div class='clear'></div>
                </div>
          </div>    <!-- end product_item -->
               <?php endforeach ?>
		            <div class='clear'></div>
       </div><!-- End box-content-center -->
       
    </div>	<!-- End box-center product-->	    

            
  <!-- lay san pham mua nhieu nhat -->  
  <div class="box-center"><!-- The box-center product-->
        <div class="tittle-box-center">
           <h2>Sản phẩm mua nhiều nhất</h2>
        </div>
          <div class="box-content-center product"><!-- The box-content-center -->
          <?php foreach($product_buyed_list as $product_buyed): ?>
		        <div class='product_item'>
                  <h3>
                    <a  href="<?php echo base_url('product/view/'.$product_buyed->id);?>" title="Sản phẩm"> <?php echo $product_buyed->name  ?> </a>
                  </h3>
                <div class='product_img'>
                      <a  href="<?php echo base_url('product/view/'.$product_buyed->id);?>" title="Sản phẩm">
                        <img src="<?php echo base_url('upload/product/').$product_buyed->image_link ;?>" alt=''/>
                    </a>
                </div>
                <p class='price'>
                  
                    <?php if($product_buyed->discount > 0)  : ?>
                       <?php echo number_format($product_buyed->price - $product_buyed->discount).' đ'?>
                         <span class="price_old"> <?php echo number_format($product_buyed->price).' đ'?></span>
                    <?php else: ?>
                         <?php echo number_format($product_buyed->price).' đ'?>
                    <?php endif ?>
                  </p>
                <center>
                  <div class='raty' style='margin:10px 0px' id='9' data-score='4'></div>
                </center>
                <div class='action'>
                    <p style='float:left;margin-left:10px'>Lượt mua: <b><?php echo $product_buyed->buyed  ?></b></p>
                    <a class='button' href="#" title='Mua ngay'>Mua ngay</a>
                  <div class='clear'></div>
                </div>
          </div>    <!-- end product_item -->
               <?php endforeach ?>
		            <div class='clear'></div>
       </div><!-- End box-content-center -->
       
    </div>	<!-- End box-center product-->	    