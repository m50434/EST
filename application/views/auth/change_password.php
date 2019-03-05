</br>

<div class="d-flex justify-content-center">

<div class="card mb-3" style="max-width: 30rem;">
  <div class="card-header"><?php echo lang('change_password_heading');?></div>
  <div class="card-body">
  
  		<div id="infoMessage"><?php echo $message;?></div>

        <?php echo form_open("auth/change_password");?>
        
              <p>
                    <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
                    <?php echo form_input($old_password,'','class="form-control"');?>
              </p>
        
              <p>
                    <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
                    <?php echo form_input($new_password,'','class="form-control"');?>
              </p>
        
              <p>
                    <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
                    <?php echo form_input($new_password_confirm,'','class="form-control"');?>
              </p>
        
              <?php echo form_input($user_id);?>
              <p><?php echo form_submit('submit', lang('change_password_submit_btn'),'class="btn btn-primary btn-block"');?></p>
              <p><button class="btn btn-danger btn-block" onClick="window.location.href = '../';return false;">Abbrechen</button></p>
        
        <?php echo form_close();?>
  
  
  
  </div>
</div>



</div>
