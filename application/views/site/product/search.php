
 
  <div class="box-center"><!-- The box-center product-->
        <div class="tittle-box-center">
           <h2><?php if(isset($key)){echo $key.' '; } else echo ''; ?>có <?php echo count($list).' sản phẩm'; ?></h2>
        </div>
          <div class="box-content-center product"><!-- The box-content-center -->
          <?php foreach($list as $item): ?>
		        <div class='product_item'>
                  <h3>
                    <a  href="<?php echo base_url('product/view/'.$item->id);?>" title="Sản phẩm"> <?php echo $item->name  ?> </a>
                  </h3>
                <div class='product_img'>
                      <a  href="<?php echo base_url('product/view/'.$item->id);?>" title="Sản phẩm">
                        <img src="<?php echo base_url('upload/product/').$item->image_link ;?>" alt=''/>
                    </a>
                </div>
                <p class='price'>
                  
                    <?php if($item->discount > 0)  : ?>
                       <?php echo number_format($item->price - $item->discount).' đ'?>
                         <span class="price_old"> <?php echo number_format($item->price).' đ'?></span>
                    <?php else: ?>
                         <?php echo number_format($item->price).' đ'?>
                    <?php endif ?>
                  </p>
                <center>
                  <div class='raty' style='margin:10px 0px' id='9' data-score='4'></div>
                </center>
                <div class='action'>
                    <p style='float:left;margin-left:10px'>Lượt xem: <b><?php echo $item->view  ?></b></p>
                    <a class='button' href="<?php echo base_url('cart/add/'.$item->id) ?>" title='Mua ngay'>Mua ngay</a>
                  <div class='clear'></div>
                </div>
          </div>    <!-- end product_item -->
               <?php endforeach ?>
		            <div class='clear'></div>
       </div><!-- End box-content-center -->
       
    </div>	<!-- End box-center product-->	    