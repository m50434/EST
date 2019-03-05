

<div class="d-flex justify-content-center">

<div class="card mb-3" style="max-width: 40rem;">
  <div class="card-header"><?php echo lang('create_user_heading');?></div>
  <div class="card-body">



<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>

      <p>
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name,' ','class="form-control"');?>
      </p>

      <p>
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name,' ','class="form-control"');?>
      </p>
      
      <?php
      if($identity_column!=='email') {
          echo '<p>';
          echo lang('create_user_identity_label', 'identity');
          echo '<br />';
          echo form_error('identity');
          echo form_input($identity,' ','class="form-control"');
          echo '</p>';
      }
      ?>

      <!--<p>
            <?php echo lang('create_user_company_label', 'company');?> <br />
            <?php echo form_input($company,' ','class="form-control"');?>
      </p>-->

      <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email,' ','class="form-control"');?>
      </p>

      <!--<p>
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone,' ','class="form-control"');?>
      </p>-->

      <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password,' ','class="form-control"');?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm,' ','class="form-control"');?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn'),'class="btn btn-primary btn-block"');?></p>
      <p><button class="btn btn-danger btn-block" onClick="window.location.href = '../';return false;">Abbrechen</button></p>

<?php echo form_close();?>
</div>
</div>
</div>