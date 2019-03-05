

<div class="d-flex justify-content-center">

<div class="card mb-3" style="max-width: 40rem;">
  <div class="card-header"><?php echo lang('edit_group_heading');?></div>
  <div class="card-body">
  
  <div id="infoMessage"><?php echo $message;?></div>
<?php echo form_open(current_url());?>

      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name,' ','class="form-control"');?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description,' ','class="form-control"');?>
      </p>

      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'),'class="btn btn-primary btn-block"');?></p>
      <p><button class="btn btn-danger btn-block" onClick="window.location.href = '../';return false;">Abbrechen</button></p>

<?php echo form_close();?>
</div>
</div>
</div>