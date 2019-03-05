



</br>
<div class="d-flex justify-content-center">
	<div id="infoMessage"><?php echo $message;?></div>
</div>
</br>

<div class="d-flex justify-content-center">

<div class="card mb-3" style="max-width: 40rem;">
  <div class="card-header"><?php echo lang('login_heading');?></div>
  <div class="card-body">
  
  		  <?php echo form_open("auth/login");?>

          <p class="form-group">
            <?php echo lang('login_identity_label', 'identity');?>
            <?php echo form_input($identity,' ','class="form-control"');?>
          </p>
        
          <p class="form-group">
            <?php echo lang('login_password_label', 'password');?>
            <?php echo form_input($password,'','class="form-control"');?>
          </p>
        <!-- 
          <p class="form-group">
            <?php echo lang('login_remember_label', 'remember');?>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
          </p>
         -->
        
          <p><?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-primary btn-block"');?></p>
        
        <?php echo form_close();?>
        
        <!-- <a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p> -->
  
  
  
  </div>
</div>



</div>
