<div class="d-flex justify-content-center">

<div class="card mb-3" style="max-width: 40rem;">
  <div class="card-header"><?php echo lang('forgot_password_heading');?></div>
  <div class="card-body">

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity,' ','class="form-control"');?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'),'class="btn btn-primary btn-block"');?></p>
      <p><button class="btn btn-danger btn-block" onClick="window.location.href = '../';return false;">Abbrechen</button></p>

<?php echo form_close();?>
</div>
</div>
</div>