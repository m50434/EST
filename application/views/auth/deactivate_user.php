<div class="d-flex justify-content-center">

<div class="card mb-3" style="max-width: 40rem;">
  <div class="card-header"><?php echo lang('deactivate_heading');?></div>
  <div class="card-body">


<?php echo form_open("auth/deactivate/".$user->id);?>

  <p>
  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', lang('deactivate_submit_btn'),'class="btn btn-primary btn-block"');?></p>
  <p><button class="btn btn-danger btn-block" onClick="window.location.href = '../';return false;">Abbrechen</button></p>

<?php echo form_close();?>
</div>
</div>
</div>