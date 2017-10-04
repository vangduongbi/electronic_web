    <style>
      #cart_table {
      
      }
      #cart_table td {
        padding:10px;
        border:solid 1px #ccc;
      }
      thead{
        
        border:solid 1px #ccc;
      }
    </style>
 
<div class="box-center"><!-- The box-center product-->
        <div class="tittle-box-center">
           <h2>Thông tin giỏ hàng(Có <?php echo $total_items.' sản phẩm)'; ?></h2>
        </div>
          <div class="box-content-center product"><!-- The box-content-center -->
         <?php if($total_items) : ?>
          <form action="<?php echo base_url('cart/update');?>" method='post'>
            <table id="cart_table">
              <thead>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng giá</th>
                <th>Xóa</th>
              </thead>
              <tbody>
                <?php $total_amount = 0 ?>
                <?php foreach($carts as $cart) : ?>
                <?php $total_amount +=$cart['subtotal'] ?>
                <tr>
                  <td><?php echo $cart['name'] ?></td>  
                  <td><?php echo number_format($cart['price']) ?></td> 
                  <td><input name='qty_<?php echo $cart['id'] ?>' type="text" value="<?php echo $cart['qty'] ?>"> </td> 
                  <td><?php echo number_format($cart['subtotal']) ?></td> 
                  <td><a href="<?php echo base_url('cart/delete/'.$cart['id']) ?>">Xoá</a></td> 
                </tr>
                <?php endforeach ?>
               
                <tr>
                  <td colspan='5'>Tổng số tiền thanh toán : <b style = "color:red"><?php echo number_format($total_amount) ?></b>   <a href="<?php echo base_url('cart/delete') ?>">---Xoá toàn bộ</a> </td>
                
                </tr>
                <tr>
                  <td colspan='5'> <button type='submit' >Cập nhật</button> </td>
                </tr>
              </tbody>
            </table>
          </form>
      
          <?php else: ?>
          <h3>Không có sản phẩm trong giỏ hàng</h3>
          <?php endif ?>
          </div>
</div>