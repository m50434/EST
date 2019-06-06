



</br>


<div class="d-flex">
  <div class="p-2">
  
        <div>
        Willkommen bei Ihrer Elternsprechtagswahl. 
        </br>
        <h6><small>Ihre registrierten Kinder: <?php echo htmlspecialchars($usersx->children,ENT_QUOTES,'UTF-8');?></small></h6>
        </div>
  
  </div>

</div>





<?php if($message_user !="") echo "
<div class=\"alert alert-danger alert-dismissable\" role=\"alert\">
<button  aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
    $message_user
</div>";
?> 


<!-- <?php echo htmlspecialchars($usersx->username,ENT_QUOTES,'UTF-8');?> -->








<div class="card mb-3" >
  <div class="card-header">Gesprächstermine: 
  </div>
  <div class="card-body">
    




        <div class="row">

        	   <div class="col-sm-12 ">
        	   
        	    <table id="for_parent_result" class="table table-striped table-hover table-bordered" style="width:100%">
        		
                	<thead>
                	<tr class="table-light">
                		<th>Lehrkraft</th>
                		<th>Kürzel</th>
                		<th>Priorität</th>
                		<th>Termin</th>
                		<th>Raum</th>

                		
                	</tr>
                	<thead>
                	<tbody>
					<?php foreach ($parent_results as $result):?>
					
					<tr class="teacher_tr t_tr<?php echo htmlspecialchars($result->ID,ENT_QUOTES,'UTF-8');?>  id="<?php echo htmlspecialchars($result->ID,ENT_QUOTES,'UTF-8');?>">
					        <td><?php echo (strcmp(trim($result->gender),"m")==0 ? "Herr" : "Frau");?> <?php echo htmlspecialchars($result->surname,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($result->shortcode,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($result->Priority,ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($result->Day,ENT_QUOTES,'UTF-8');?>, <?php echo htmlspecialchars($result->Time,ENT_QUOTES,'UTF-8');?> Uhr</td>
                            <td><?php echo htmlspecialchars($result->roomnumber,ENT_QUOTES,'UTF-8');?></td>

                		</tr>
                		
					<?php endforeach;?>
					</tbody>
					</table>	
        	   </div>
        	
			


        </div>
  </div> 
</div>




</br>








