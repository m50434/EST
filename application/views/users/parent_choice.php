

<?php 
$teacher_helper = array();
$choice_for_children = 1; // Init
if ($number_of_children == 1) {
    $choice_for_children = $choice_for_children1;
} elseif ($number_of_children == 2) {
    $choice_for_children = $choice_for_children2;
} elseif ($number_of_children > 2) {
    $choice_for_children = $choice_for_children3;
}

	for ($i = 0; $i < $choice_for_children ; $i++) {
	    
	    if(isset($choices[$i])){
	        
	        array_push($teacher_helper, $choices[$i]->teachers_ID);
	    }
	}
?>

</br>


<div class="d-flex">
  <div class="p-2">
  
        <div>
        Willkommen bei Ihrer Elternsprechtagswahl. 
        </br>
        <h6><small>Ihre registrierten Kinder: <?php echo htmlspecialchars($usersx->children,ENT_QUOTES,'UTF-8');?></small></h6>
        </div>
  
  </div>
  <div class="ml-auto p-2">
  
  		<?php if($prefs[0]->choice_on != 0){
	    
	    echo "
                   	<button id=\"store1\" type=\"button\" class=\"disabled btn btn-success btn-sm\">Änderungen speichern</button>";
                    	//<!-- <button id=\'discard\' type=\"button\" class=\"disabled btn btn-danger btn-sm\">Änderungen verwerfen</button> 
    	}
    	
        
    ?>
  
  </div>
</div>





<?php if($message_user !="") echo "
<div class=\"alert alert-danger alert-dismissable\" role=\"alert\">
<button  aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
    $message_user
</div>";
?> 


<!-- <?php echo htmlspecialchars($usersx->username,ENT_QUOTES,'UTF-8');?> -->

<?php if($parent_option[0]!="")
{
    
    echo "
    <div class=\"card mb-3\" >
      <div class=\"card-header\">Wählen Sie ggf. eine Option</div>
      <div class=\"card-body\">

    ";
}
?>


	<?php 
		for ($i = 0; $i < intval(count($parent_option)) ; $i++) {
		    
		    if($parent_option[$i]!=""){
		        $checked = "";
		        if(isset($options[$i])){
		            $options[$i] == 1 ? $checked="checked=\"checked\"" : $checked="";
		        }
		        
                  echo "<div class=\"custom-control custom-checkbox\">
                    <input class=\"parent_option_checkbox custom-control-input\" type=\"checkbox\" id=\"parent_option_checkbox". $i . "\" ". $checked . ">
                    <label class=\"custom-control-label\" for=\"parent_option_checkbox". $i . "\">"
                        .$parent_option[$i] .    
                    "</label>
          		  </div>";
		    }
  		  
		}
	   ?>
    
<?php if($parent_option[0]!=""){
    echo " </div>
</div>";
}
?>


<div class="alert alert-dismissible alert-secondary" id="alertManual">
    <div class="row"> <!-- add no-gutters to make it narrower -->
    <button id="buttonAlertManual" type="button" class="close" data-dismiss="alert">&times;</button>
        <div class="col-auto align-self-start"> <!-- or align-self-center -->
            <i class="fa-3x fa fa-info" aria-hidden="true"></i>
        </div>
        <div class="col">
 			 <?php echo $prefs[0]->manual; ?>
        </div>
    </div>
</div>

<div class="card mb-3" >
  <div class="card-header">Mit welchen Lehrkräften wünschen Sie ein Gespräch: 
  </div>
  <div class="card-body">
    

       <div class="row">
       	<div class="col">
        	<input class="d-none d-sm-block form-control mr-sm-2" type="text" id="teacher_search" placeholder="Suche" style="max-width: 100%;">
        	<input class="d-block d-sm-none form-control mr-sm-2" type="text" id="teacher_search_mobile" placeholder="Suche" style="max-width: 100%;">
        	</br>
        	</div>
		</div>


        <div class="row">

        	   <div class="col-sm-8 ">
        		
        		<div class="d-none d-sm-block">	
                <table id="table_teachers" class="table" style="width:100%">
                	<thead>
                	<tr class="table-light">
                		<th>Kürzel</th>
                		<th>Name</th>
                		<th><?php echo $prefs[0]->datum1; ?></th>
                		<th><?php echo $prefs[0]->datum2; ?></th>
                		<th></th>
                		
                	</tr>
                	<thead>
                	<tbody>
                	<?php foreach ($teachers as $teacher):
                	if(in_array($teacher->ID, $teacher_helper)) {$collapsecheck=""; $collapseright="collapse"; $tablelight="";} else {$collapsecheck="collapse"; $collapseright=""; $tablelight="table-light";}
                	    ?>
                		
                		<tr class="teacher_tr t_tr<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?> <?php echo $tablelight;?>" id="<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?>">
                		    <td class="shortcode"><?php echo htmlspecialchars(trim($teacher->shortcode),ENT_QUOTES,'UTF-8');?></td>
                            <td class="surname"><?php echo (strcmp(trim($teacher->gender),"m")==0 ? "Herr" : "Frau");?> <?php echo htmlspecialchars($teacher->surname,ENT_QUOTES,'UTF-8');?></td>
                            <td class="section1"><?php echo htmlspecialchars($teacher->section1,ENT_QUOTES,'UTF-8');?></td>
                            <td class="section2"><?php echo htmlspecialchars($teacher->section2,ENT_QUOTES,'UTF-8');?></td>
                            <td>
                            	<div><button class="arrowcheck <?php echo $collapsecheck;?>" style="border:none; background-color: #FFFFFF;"><span><i class="text-success fa fa-check fa-lg"></i></span></button></div>
                            	<div><button class="arrowright <?php echo $collapseright;?>" style="border:none; background-color: #FAFAFA;"><span><i class="fa fa-arrow-right fa-lg"></i></span></button></div>
                            </td>
                		</tr>
                	<?php endforeach;?>
                	</tbody>
                </table>
               </div>
               
               
               <!-- Für Smartphones -->
               <div class="d-block d-sm-none">
                 <table id="table_teachers_mobile" class="table" style="width:100%">
                	<thead>
                	<tr class="table-light">
                		<th>Lehrkärfte</th>
                	</tr>
                	<thead>
                	<tbody>
                	<?php foreach ($teachers as $teacher): 
                	if(in_array($teacher->ID, $teacher_helper)) {$collapsecheck=""; $collapseright="collapse"; $tablelight="";} else {$collapsecheck="collapse"; $collapseright=""; $tablelight="table-light";}
                	?>
                	 	<tr class="teacher_tr_mobile t_tr_m<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?> <?php echo $tablelight;?>" id="<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?>">
                    	 	<td>
                    	 			<span class="shortcode"><?php echo htmlspecialchars(trim($teacher->shortcode),ENT_QUOTES,'UTF-8');?></span> - 
                    	 			<span class="surname"><?php echo (strcmp(trim($teacher->gender),"m")==0 ? "Herr" : "Frau");?> <?php echo htmlspecialchars($teacher->surname,ENT_QUOTES,'UTF-8');?> </span>
                    	 		</br>
                    	 		
                    	 		<a class="verfuegbar" data-id="verfuegbar<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?>"><span><i class="fa fa-calendar-alt fa-lg"></i></span></a>
                                      <div id="verfuegbar<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?>" class="collapse">
                            	 		<?php echo $prefs[0]->datum1; ?>: <?php echo htmlspecialchars($teacher->section1,ENT_QUOTES,'UTF-8');?>
                            	 		</br>
                            	 		<?php echo $prefs[0]->datum2; ?>: <?php echo htmlspecialchars($teacher->section2,ENT_QUOTES,'UTF-8');?>
                                </div>
  
                	 			<div class="float-right"><button class="arrowcheck <?php echo $collapsecheck;?>" style="border:none; background-color: #FFFFFF;"><span><i class="text-success fa fa-check fa-lg"></i></span></button></div>
                            	<div class="float-right"><button class="arrowright <?php echo $collapseright;?>" style="border:none; background-color: #FAFAFA;"><span><i class="fa fa-arrow-down fa-lg"></i></span></button></div>
                            	
                	 		
                	 		</td>
                	 	</tr>
                	 <?php endforeach;?>
                	</tbody>
                </table>
                </br></br>
               </div>
        	</div>
        	
			
        	
        	<div class="col-sm-4">

        		<h6 class="card-header"><b>Gewählte Lehrkräfte</b></h6>
        		<ul id="parent_choice" class="list-group movecursor">
        
        		
        		<?php 

        		for ($i = 0; $i < $choice_for_children ; $i++) {
        		    
        		    if(isset($choices[$i])){
        		        
        		        array_push($teacher_helper, $choices[$i]->teachers_ID);
        		        // <button style=\"border:none; background-color: #FFFFFF;\"><span><i class=\"fa fa-arrows\"></i></span></button>
                        echo "
                        <li data-teacherid=\"" . $choices[$i]->teachers_ID . "\" class=\"list-group-item\">
                        
        		        <span class=\"sortable-number\">" . ($i+1) . ".</span>
        		        <span class=\"picked_teacher\">". (strcmp(trim($choices[$i]->gender),"m")==0 ? "Herr" : "Frau") . " " . $choices[$i]->surname . " (" . trim($choices[$i]->shortcode) . ")</span>
        		        <span class=\"teacher_remove_icon pull-right\">";
        		        
        		    }
        		    else{
        
        		        echo "
                        <li data-teacherid=\"\" class=\"list-group-item disabled\">
        		        <span class=\"sortable-number\">" . ($i+1) . ".</span>
        		        <span class=\"picked_teacher\"></span>
        		        <span class=\"teacher_remove_icon collapse pull-right\">";
        		    }
        		    
        		    
        		    
        		    
        		    echo "
        	               
        		        
                        <div class=\"float-right\"><button class=\"d-none d-sm-block\" style=\"border:none; background-color: #FFFFFF;\"><span><i class=\"text-danger fa fa-times fa-lg\"></i></span></button></div>
                         
        		
        		         </span>
        		         </li>";
                    }
                    
        
                ?>
        
                </ul>
        	</div>
        </div>
    
	
  </div>
  
  
  
</div>


<?php if($prefs[0]->choice_on != 0){
	    
	    echo "

             <div class=\"d-flex justify-content-end\">
               	<div class=\"ml-auto p-2\">
                    	<button id=\"store2\" type=\"button\" class=\"disabled btn btn-success btn-sm\">Änderungen speichern</button>";
                    	//<!-- <button id=\'discard\' type=\"button\" class=\"disabled btn btn-danger btn-sm\">Änderungen verwerfen</button> 
                    	
	    echo "
                </div>	
               </div>	


        ";
	    
	}
	
    ?>

</br>








