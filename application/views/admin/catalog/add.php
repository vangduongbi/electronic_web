<!-- load file head -->
<?php 
  $this->load->view('admin/catalog/head',$this->data);
  
?>
<div class="line"></div>

<div class="wrapper">
	<div class="widget">
	
		<div class="title">
      <h6>Thêm mới danh mục sản phẩm</h6>
    </div>
      <form class="form" id="form" action="" method="post" enctype="multipart/form-data">
        <fieldset>
          <div class="formRow">
            <label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
            <div class="formRight">
              <span class="oneTwo"><input name="name" id="param_name" _autocheck="true" type="text" value="<?php echo set_value('name'  );?>"></span>
              <span name="name_autocheck" class="autocheck"></span>
              <div name="name_error" class="clear error"><?php echo form_error('name');?></div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="formRow">
            <label class="formLeft" for="param_sort_order">Danh mục cha:</label>
            <div class="formRight">
              <span class="oneTwo">
                <select name="parent_id" id="param_parent_id" _autocheck="true" >
                  <option value="0">Là danh mục cha</option>
                  <?php foreach($list as $row) :?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                  <?php endforeach ?>
                </select>
              </span>
              <span name="parent_id_autocheck" class="autocheck"></span>
              <div name="parent_id_error" class="clear error"><?php echo form_error('parent_id');?></div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="formRow">
            <label class="formLeft" for="param_sort_order">Thứ tự hiển thị:</label>
            <div class="formRight">
              <span class="oneTwo"><input name="sort_order" id="param_sort_order" _autocheck="true" type="text" value="<?php echo set_value('sort_order');?>"></span>
              <span name="name_autocheck" class="autocheck"></span>
              <div name="sort_order_error" class="clear error"><?php echo form_error('sort_order');?></div>
            </div>
            <div class="clear"></div>
          </div>
        </fieldset>

        <div class="formSubmit">
	          <input type="submit" value="Thêm mới" class="redB">
	      </div>
      </form>
  </div>
</div>