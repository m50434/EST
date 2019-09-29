
<ul class="nav nav-tabs" id="adminTab">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#parents">Eltern</a>
  </li>
  <li class="nav-item ">
    <a class="nav-link" data-toggle="tab" href="#teachers">Lehrer</a>
  </li>
  
  <li class="nav-item ">
    <a class="nav-link" data-toggle="tab" href="#parents_choice">Elternwahl</a>
  </li>
  
  <li class="nav-item ">
    <a class="nav-link" data-toggle="tab" href="#parents_results">Elternergebnisse</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#teachers_choice">Lehrerwahl</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#teachers_results">Lehrerergebnisse</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#rooms">Raumdaten</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#users">Benutzer</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#prefs">Einstellungen</a>
  </li>

</ul>
<div id="myTabContent" class="tab-content">



  <div class="tab-pane fade show active" id="parents">
        </br>
        <?php if($message_parents !="") echo "
        <div class=\"alert alert-light alert-dismissable\" id=\"infoMessage\" role=\"alert\">
        <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
            $message_parents
        </div>";
        ?> 

     	<h3>Eltern</h3>
		<p></p>
		
	    <div id="edit_parents"  class="row collapse">
      
 
              <div class="col-sm-6">
                <div class="card text-white bg-info mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Daten importieren</h5>
                    <p class="card-text">
                    		<p>Die CSV-Datei muss folgendem Aufbau entsprechen: </p>
                    		<p class="font-italic">ID; Benutzername; Passwort; Kind1[,Kind2,...,Kindn]</p>
                                  	    <?php echo form_open_multipart('auth/insert_csv_parents');?>
             
                            
                            <label class="btn btn-secondary btn-sm" for="my-file-selector">
                                <input id="my-file-selector" name="file" type="file" style="display:none" 
                                onchange="$('#upload-file-info').html(this.files[0].name)">
                                Datei auswählen
                            </label>
                			 <span class='label label-info' id="upload-file-info"></span></br>
                     
                                <div class="custom-control custom-checkbox">       
                    			<input type="checkbox" class="form-check-input" name="edit_headline">
                                <label class="form-check-label" >Kopfzeile ignorieren</label>
                                </div>
                                
                                <!-- 
                                Führt nur zur Fehler bei der Simulation. Daher auskommentiert.
                                Theoretisch funktioniert es aber.
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_delete">
                                <label class="form-check-label" >Vorhandene Daten löschen</label>
                                </div> -->
                                
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate">
                                <label class="form-check-label" >Import lediglich simulieren</label>
                                </div>
                            
                           
                            
                        
                    
                    </p>
                    Bitte haben Sie beim Hochladen ein wenig Geduld!
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Daten hochladen" />
                       </form>	
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
              <?php echo form_open('auth/delete_parents');?>
                <div class="card text-white bg-danger mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Daten löschen</h5>
                    <p class="card-text">Achtung, es werden auch sämtliche Elternwahlen und Elternergebnisse gelöscht.</p>
                                 <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate">
                                <label class="form-check-label" >Löschen lediglich simulieren!</label>
                                </div>                   
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Ja, ich will das wirklich." />
                  </form>
                  </div>
                </div>
              </div>

      
       
      	
        </div>

   		<div class="row">
           	<div class="col-10">
	            <input class="form-control mr-sm-2" type="text" id="parents_search" placeholder="Suche" style="max-width: 15rem;">
            </div>

            <div class="col-2">
            <div class="float-sm-right">
				<i data-toggle="collapse" data-target="#edit_parents" class="fa fa-cog fa-2x"></i>
			</div>
           	</div>
        </div>
    
        
        
        <table id="table_parents" class="table table-striped table-hover table-bordered" style="width:100%" >
        	<thead>
        	<tr class="table-active">
        	    <th scope="col">Elternteil</th>
        		<th>Kinder</th>
        		<th>Letzter Login</th>

        	</tr>
        	<thead>
        	<tbody>
        	<?php 
        	$date = date_create();
        	foreach ($parents as $parent):
        	date_timestamp_set($date, $parent->last_login);?>
        		<tr class="table-light">
        			<th scope="row"><?php echo htmlspecialchars($parent->username,ENT_QUOTES,'UTF-8');?></th>
                    <td><?php echo htmlspecialchars($parent->children,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo date_format($date, 'd.m.Y - H:i:s');?></td>

        		</tr>
        	<?php endforeach;?>
        	</tbody>
        </table>
  </div>
  
  
  
  
   <div class="tab-pane fade show" id="teachers">
        </br>
        <?php if($message_teachers!="") echo "
        <div class=\"alert alert-light alert-dismissable\" id=\"infoMessage\" role=\"alert\">
        <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
            $message_teachers
        </div>";
        ?> 

     	<h3>Lehrer</h3>
        <p></p>
      
      
	    <div id="edit_teachers"  class="row collapse">
      
 
              <div class="col-sm-6">
                <div class="card text-white bg-info mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Daten importieren</h5>
                    <p class="card-text">
                    		<p>Die CSV-Datei muss folgendem Aufbau entsprechen: </p>
                    		<p class="font-italic">ID; Nachname; Kürzel; Geschlecht; Datum1, Uhrzeiten; Datum2, Uhrzeiten</p>
                                  	    <?php echo form_open_multipart('auth/insert_csv_teachers');?>
             
                            
                            <label class="btn btn-secondary btn-sm" for="my-file-selector_teachers">
                                <input id="my-file-selector_teachers" name="file_teachers" type="file" style="display:none" 
                                onchange="$('#upload-file-info_teachers').html(this.files[0].name)">
                                Datei auswählen
                            </label>
                			 <span class='label label-info' id="upload-file-info_teachers"></span></br>
                     
                                 <div class="custom-control custom-checkbox">       
                    			<input type="checkbox" class="form-check-input" name="edit_headline_teachers">
                                <label class="form-check-label" >Kopfzeile ignorieren</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_delete_teachers">
                                <label class="form-check-label" >Vorhandene Daten löschen</label>
                                </div>
                                
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate_teachers">
                                <label class="form-check-label" >Import lediglich simulieren</label>
                                </div>

                    </p>
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Daten hochladen" />
                       </form>	
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
              <?php echo form_open('auth/delete_teachers');?>
                <div class="card text-white bg-danger mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Daten löschen</h5>
                    <p class="card-text">Achtung, es werden auch sämtliche Elternwahlen und Elternergebnisse gelöscht.</p>
                                 <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate_teachers">
                                <label class="form-check-label" >Löschen lediglich simulieren!</label>
                                </div>                   
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Ja, ich will das wirklich." />
                  </form>
                  </div>
                </div>
              </div>

      
       
      	
        </div>

   		<div class="row">
           	<div class="col-10">
	            <input class="form-control mr-sm-2" type="text" id="teachers_search_auth" placeholder="Suche" style="max-width: 15rem;">
            </div>

            <div class="col-2">
            <div class="float-sm-right">
				<i data-toggle="collapse" data-target="#edit_teachers" class="fa fa-cog fa-2x"></i>
			</div>
           	</div>
        </div>
    
                          <table id="table_teachers_auth" class="table table-striped table-hover table-bordered" style="width:100%">
                        	<thead>
                        	<tr class="table-active">
                        		<th>Kürzel</th>
                        		<th>Name</th>
                        		<th>Zeitabschnitt 1</th>
                        		<th>Zeitabschnitt 2</th>
                        		
                        	</tr>
                        	<thead>
                        	<tbody>
                        	<?php foreach ($teachers as $teacher):
                        	    ?>
                        		
                        		<tr class="teacher_tr table-light" id="<?php echo htmlspecialchars($teacher->ID,ENT_QUOTES,'UTF-8');?>">
                        		    <td class="shortcode"><?php echo htmlspecialchars(trim($teacher->shortcode),ENT_QUOTES,'UTF-8');?></td>
                                    <td class="surname"><?php echo (strcmp(trim($teacher->gender),"m")==0 ? "Herr" : "Frau");?> <?php echo htmlspecialchars($teacher->surname,ENT_QUOTES,'UTF-8');?></td>
                                    <td class="section1"><?php echo htmlspecialchars($teacher->section1,ENT_QUOTES,'UTF-8');?></td>
                                    <td class="section2"><?php echo htmlspecialchars($teacher->section2,ENT_QUOTES,'UTF-8');?></td>
                                  
                        		</tr>
                        	<?php endforeach;?>
                        	</tbody>
                        </table>
        

  </div>
  
  

  
  
  <div class="tab-pane fade " id="parents_choice">
       </br>

     	<h3>Elternwahl</h3>
        <p></p>        
    
     	<div class="row">
           	<div class="col-sm-8">

            <input class="form-control mr-sm-2" type="text" id="parents_choice_search" placeholder="Suche" style="max-width: 15rem;">
            </div>
            <div class="col-sm-4">
         
            	<div class="float-sm-right"><?php echo anchor('auth/exportCSV/options', 'CSV-EXPORT Optionen','class="btn btn-secondary btn-sm"')?></div>
            </div>
        </div>
 
    
    	<table id="table_parents_choices" class="table table-striped table-hover table-bordered" style="width:100%">
        	<thead>
        	<tr class="table-active">
        	    <th scope="col">Elterndaten</th>
        		<th>Gesprächswünsche</th>
        		<th>Optionen</th>
        	</tr>
        	<thead>
        	<tbody>
        	
        	
        	
        	<?php 
        	
        	if(!empty($parent_choices[0])){
        	foreach ($parent_choices as $choice):
        	//print_r($choice);
        	$teachers = "";
        	$option = "";
        	echo "<tr class=\"table-light\">
                    <th scope=\"row\">" . htmlspecialchars($choice[0]->username,ENT_QUOTES,'UTF-8') . "</br>
                    " . htmlspecialchars($choice[0]->children,ENT_QUOTES,'UTF-8') . "</th>";
        	
        	   foreach($choice as $inner_choice):

        	   $teachers .= "<li class=\"list-group-item\">" . (strcmp(trim($inner_choice->gender),"m")==0 ? "Herr " : "Frau ") . htmlspecialchars($inner_choice->surname,ENT_QUOTES,'UTF-8') . 
        	   " (".htmlspecialchars($inner_choice->shortcode,ENT_QUOTES,'UTF-8') .")" . "<div class=\"float-right\">" . (intval($inner_choice->Priority)+1). "</div></li>";

        	   endforeach;
        	   
        	   
        	   for ($i = 0; $i < intval(count($parent_option)) ; $i++) {
        	       if(isset($choice[0]->options[$i]) && $choice[0]->options[$i] ==1)
        	       $option .= "<li>".$parent_option[$i]."</li>";
        	       //print_r($choice[0]->options);
        	   }
        	   
        	   echo "<td><ul class=\"list-group\">" . $teachers . "</ul></td>
                    <td><ul>" . $option . "</ul></td>
                    </tr>";
        	   endforeach;}?>
        	</tbody>
        </table>  	
     	

  </div>
  
  
  
  
  
  
  
  
  
  
  
    <div class="tab-pane fade show" id="parents_results">
        </br>


     	<h3>Elternergebnisse</h3>
        <p></p>
      
      
	    <div id="edit_teachers"  class="row collapse">
      

           	<div class="col-12">
           	<div class="alert alert-light alert-dismissable" id="infoMessage" role="alert">
        
            Hinweis: Das Importieren der Ergebnisse und Räume erfolgt über den Reiter "Lehrerergebnisse"!
        	</div>
              
			</div>
	
      
       
      	
        </div>

   	<div class="row">
           	<div class="col-10">
	            <input class="form-control mr-sm-2" type="text" id="parents_results_search_auth" placeholder="Suche" style="max-width: 15rem;">
            </div>

            <div class="col-2">
            <div class="float-sm-right">
				<i data-toggle="collapse" data-target="#edit_teachers" class="fa fa-cog fa-2x"></i>
			</div>
           	</div>
        </div>
    
                          <table id="table_parents_results_auth" class="table table-striped table-hover table-bordered" style="width:100%">
                        	<thead>
                        	<tr class="table-active">
                        		<th>Kürzel</th>
                        		<th>Lehrkraft</th>
                        		<th>Eltern</th>
                        		<th>Zeit</th>
                        		<th>Raum</th>
                        		
                        	</tr>
                        	<thead>
                        	<tbody>
                        	<?php // print_r($parents_results);?>
                        	<?php foreach ($parents_results as $parent_result):
                        	    ?>
                        		
                        		<tr class="table-light" id="<?php echo htmlspecialchars($parent_result->ID,ENT_QUOTES,'UTF-8');?>">
                        		    <td class="shortcode"><?php echo htmlspecialchars(trim($parent_result->shortcode),ENT_QUOTES,'UTF-8');?></td>
                                    <td class="surname"><?php echo (strcmp(trim($parent_result->gender),"m")==0 ? "Herr" : "Frau");?> <?php echo htmlspecialchars($parent_result->surname,ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($parent_result->username),ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($parent_result->Day),ENT_QUOTES,'UTF-8');?>, <?php echo htmlspecialchars(trim($parent_result->Time),ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($parent_result->roomnumber),ENT_QUOTES,'UTF-8');?> </td>
                                  
                        		</tr>
                        	<?php endforeach;?>
                        	</tbody>
                        </table>
        

  </div>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <div class="tab-pane fade" id="teachers_choice">
    </br>

     	<h3>Lehrerwahl</h3>
        <p></p>
     	<div class="row">
           	<div class="col-sm-10">
  
            <input class="form-control mr-sm-2" type="text" id="teachers_choice_search" placeholder="Suche" style="max-width: 15rem;">
            </div>
            <div class="col-sm-2">
       
            	<div class="float-sm-right"><?php echo anchor('auth/exportCSV', 'CSV-EXPORT','class="btn btn-secondary btn-sm"')?></div>
            </div>
        </div>
 
    
    	<table id="table_teachers_choices" class="table table-striped table-hover table-bordered" style="width:100%">
        	<thead>
        	<tr class="table-active">
        	    <th scope="col">Lehrerdaten</th>
        		<th>Gesprächswünsche</th>


        	</tr>
        	<thead>
        	<tbody>
        	
        	
        	
        	<?php 

        	if(!empty($teacher_choices[0])){
        	foreach ($teacher_choices as $choice):
        	$output = "";
        	echo "<tr class=\"table-light\">
                    <th scope=\"row\">" . htmlspecialchars($choice[0]->shortcode,ENT_QUOTES,'UTF-8') . "</th>";
        	
        	   foreach($choice as $inner_choice):

        	       $output .= "<li class=\"list-group-item\">" . htmlspecialchars($inner_choice->username,ENT_QUOTES,'UTF-8') . " - " . 
        	       htmlspecialchars($inner_choice->children,ENT_QUOTES,'UTF-8') . "<div class=\"float-right\">" . (intval($inner_choice->Priority)+1). "</div></li>";

        	   endforeach;
        	   echo "<td><ul class=\"list-group\">" . $output . "</ul></td></tr>";
        	   endforeach;}?>
        	</tbody>
        </table>
        
  </div>
  
  
  
  
  
  
  
  
  
  
  <div class="tab-pane fade show" id="teachers_results">
        </br>
        <?php if($message_teachers_results!="") echo "
        <div class=\"alert alert-light alert-dismissable\" id=\"infoMessage\" role=\"alert\">
        <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
            $message_teachers_results
        </div>";
        ?> 

     	<h3>Lehrerergebnisse</h3>
        <p></p>
      
      
	    <div id="edit_teachers_results"  class="row collapse">
      
 
              <div class="col-sm-6">
                <div class="card text-white bg-info mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Ergebnisdaten importieren</h5>
                    <p class="card-text">
                    		<p>
                    		Bitte darauf achten, dass bereits Raumdaten importiert sind !!! </br>
                    		Die CSV-Datei muss folgendem Aufbau entsprechen: </p>
                    		<p class="font-italic">ElternID; LehrerID; Datum; Zeit</p>
                                  	    <?php echo form_open_multipart('auth/insert_csv_results');?>
             
                            
                            <label class="btn btn-secondary btn-sm" for="my-file-selector_teacher_results">
                                <input id="my-file-selector_teacher_results" name="file" type="file" style="display:none" 
                                onchange="$('#upload-file-info_teacher_results').html(this.files[0].name)">
                                Datei auswählen
                            </label>
                			 <span class='label label-info' id="upload-file-info_teacher_results"></span></br>
                     
                                 <div class="custom-control custom-checkbox">       
                    			<input type="checkbox" class="form-check-input" name="edit_headline_teachers_results">
                                <label class="form-check-label" >Kopfzeile ignorieren</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_delete_teachers_results">
                                <label class="form-check-label" >Vorhandene Daten löschen</label>
                                </div>
                                
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate_teachers_results">
                                <label class="form-check-label" >Import lediglich simulieren</label>
                                </div>

                    </p>
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Daten hochladen" />
                       </form>	
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
              <?php echo form_open('auth/delete_teachers_results');?>
                <div class="card text-white bg-danger mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Daten löschen</h5>
                    <p class="card-text">Achtung, es werdensämtliche Gesprächstermine gelöscht.</p>
                                 <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate_teachers_results">
                                <label class="form-check-label" >Löschen lediglich simulieren!</label>
                                </div>                   
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Ja, ich will das wirklich." />
                  </form>
                  </div>
                </div>
              </div>

       
      	
        </div>

   	<div class="row">
           	<div class="col-10">
	            <input class="form-control mr-sm-2" type="text" id="teachers_results_search_auth" placeholder="Suche" style="max-width: 15rem;">
            </div>

            <div class="col-2">
            <div class="float-sm-right">
				<i data-toggle="collapse" data-target="#edit_teachers_results" class="fa fa-cog fa-2x"></i>
			</div>
           	</div>
        </div>
    
                          <table id="table_teachers_results_auth" class="table table-striped table-hover table-bordered" style="width:100%">
                        	<thead>
                        	<tr class="table-active">
                        		<th>Kürzel</th>
                        		<th>Lehrkraft</th>
                        		<th>Eltern</th>
                        		<th>Zeit</th>
                        		<th>Raum</th>
                        		
                        	</tr>
                        	<thead>
                        	<tbody>
                        	<?php // print_r($teachers_results);?>
                        	<?php foreach ($teachers_results as $teacher_result):
                        	    ?>
                        		
                        		<tr class="teacher_tr table-light" id="<?php echo htmlspecialchars($teacher_result->ID,ENT_QUOTES,'UTF-8');?>">
                        		    <td class="shortcode"><?php echo htmlspecialchars(trim($teacher_result->shortcode),ENT_QUOTES,'UTF-8');?></td>
                                    <td class="surname"><?php echo (strcmp(trim($teacher_result->gender),"m")==0 ? "Herr" : "Frau");?> <?php echo htmlspecialchars($teacher_result->surname,ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($teacher_result->username),ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($teacher_result->Day),ENT_QUOTES,'UTF-8');?>, <?php echo htmlspecialchars(trim($teacher_result->Time),ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($teacher_result->roomnumber),ENT_QUOTES,'UTF-8');?> </td>
                                  
                        		</tr>
                        	<?php endforeach;?>
                        	</tbody>
                        </table>
        

  </div>
  
  
  
  
  
  
  
          <div class="tab-pane fade show" id="rooms">
        </br>
        <?php if($message_rooms!="") echo "
        <div class=\"alert alert-light alert-dismissable\" id=\"infoMessage\" role=\"alert\">
        <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
            $message_rooms
        </div>";
        ?> 

     	<h3>Raumdaten</h3>
        <p></p>
      
      
	    <div id="edit_rooms"  class="row collapse">
      
 
              <div class="col-sm-6">
                <div class="card text-white bg-info mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Raumdaten importieren</h5>
                    <p class="card-text">
                    		<p>Die CSV-Datei muss folgendem Aufbau entsprechen: </p>
                    		<p class="font-italic">LehrerID; Raum</p>
                                  	    <?php echo form_open_multipart('auth/insert_csv_rooms');?>
             
                            
                            <label class="btn btn-secondary btn-sm" for="my-file-selector_rooms">
                                <input id="my-file-selector_rooms" name="file" type="file" style="display:none" 
                                onchange="$('#upload-file-info_rooms').html(this.files[0].name)">
                                Datei auswählen
                            </label>
                			 <span class='label label-info' id="upload-file-info_rooms"></span></br>
                     
                                 <div class="custom-control custom-checkbox">       
                    			<input type="checkbox" class="form-check-input" name="edit_headline_rooms">
                                <label class="form-check-label" >Kopfzeile ignorieren</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_delete_rooms">
                                <label class="form-check-label" >Vorhandene Daten löschen</label>
                                </div>
                                
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate_rooms">
                                <label class="form-check-label" >Import lediglich simulieren</label>
                                </div>

                    </p>
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Daten hochladen" />
                       </form>	
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
              <?php echo form_open('auth/delete_rooms');?>
                <div class="card text-white bg-danger mb-3">
                  <div class="card-body">
                    <h5 class="card-title">Daten löschen</h5>
                    <p class="card-text">Achtung, es werden sämtliche Raumdaten gelöscht.</p>
                                 <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input" name="edit_simulate_rooms">
                                <label class="form-check-label" >Löschen lediglich simulieren!</label>
                                </div>                   
                    <input class="float-right btn btn-primary btn-sm" type="submit" value="Ja, ich will das wirklich." />
                  </form>
                  </div>
                </div>
              </div>

      
       
      	
        </div>
     	<div class="row">
           	<div class="col-10">
	            <input class="form-control mr-sm-2" type="text" id="rooms_search" placeholder="Suche" style="max-width: 15rem;">
            </div>

            <div class="col-2">
            <div class="float-sm-right">
				<i data-toggle="collapse" data-target="#edit_rooms" class="fa fa-cog fa-2x"></i>
			</div>
           	</div>
        </div>
    
                          <table id="table_rooms" class="table table-striped table-hover table-bordered" style="width:100%">
                        	<thead>
                        	<tr class="table-active">
								<th>Kürzel</th>
                        		<th>Lehrkraft</th>
                        		<th>Raumnummer</th>
                        		
                        	</tr>
                        	<thead>
                        	<tbody>
                        	<?php // print_r($teachers_results);?>
                        	<?php foreach ($rooms as $room):
                        	    ?>
                        		
                        		<tr class="teacher_tr table-light">
                        		    <td class="shortcode"><?php echo htmlspecialchars(trim($room->shortcode),ENT_QUOTES,'UTF-8');?></td>
                        		    <td class="shortcode"><?php echo htmlspecialchars(trim($room->surname),ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars(trim($room->roomnumber),ENT_QUOTES,'UTF-8');?></td>
                                 
                        		</tr>
                        	<?php endforeach;?>
                        	</tbody>
                        </table>
        

  </div>
  
  
  
  
  
  
    <div class="tab-pane fade" id="users">
   
   		</br>  

     	<?php if($message!="") echo "
        <div class=\"alert alert-light alert-dismissable\" id=\"infoMessage\" role=\"alert\">
        <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">X</button>
            $message
        </div>";
        ?> 


     	<h3>Benutzer</h3>
        <p></p>

        <div class="float-sm-right"><p><?php echo anchor('auth/create_user', lang('index_create_user_link'),'class="btn btn-secondary btn-sm"')?> 
        <?php echo anchor('auth/create_group', lang('index_create_group_link'),'class="btn btn-secondary btn-sm"')?></p></div>
  

        <table id="table_users" class="table table-striped table-hover table-bordered" >
        	<thead>
        	<tr class="table-active">
        		<th scope="col">ID</th>
        	    <th scope="col"><?php echo lang('index_identity');?></th>
        	    <th>Kinder</th>
        		<th><?php echo lang('index_fname_th');?></th>
        		<th><?php echo lang('index_lname_th');?></th>
        		<th><?php echo lang('index_email_th');?></th>
        		<th><?php echo lang('index_lastlogin_th');?></th>
        		<th><?php echo lang('index_groups_th');?></th>
         		<th ><?php echo lang('index_status_th');?></th>
        		<th ><?php echo lang('index_action_th');?></th>
        		
        	</tr>
        	<thead>
        	<tbody>
        	<?php 
        	
        	$date = date_create();
        	foreach ($users as $user):
        	date_timestamp_set($date, $user->last_login);?>
        		<tr class="table-light">
        		    <th scope="row"><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></th>
        			<th scope="row"><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></th>
        			<td><?php echo htmlspecialchars($user->children,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo date_format($date, 'd.m.Y - H:i:s');?></td>
        			<td>
        				<?php foreach ($user->groups as $group):?>
        					<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
                        <?php endforeach?>
        			</td>
        			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'),'class="btn btn-success btn-sm"') : anchor("auth/activate/". $user->id, lang('index_inactive_link'),'class="btn btn-danger btn-sm"');?></td>
        			<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit','class="btn btn-warning btn-sm"') ;?></td>
        			
        		</tr>
        	<?php endforeach;?>
        	</tbody>
        </table>
  </div>
  
  
  
  <div class="tab-pane fade" id="prefs">
   
   		</br>  
   		
   		<?php if($message_prefs!="") echo "
        <div class=\"alert alert-success alert-dismissable\" id=\"infoMessage\" role=\"alert\">
        <button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\"><p class=\"text-secondary\">X</p></button>
            $message_prefs
        </div>";
        ?> 
   		
   		
     	<h3>Einstellungen</h3>
        <p></p>

		<div class="row">
        <div class="col-md-6">
        <?php echo form_open("auth/edit_prefs");?>

                    <div class="card border-light mb-3">
                      <div class="card-header">Seiteneinstellungen</div>
                      <div class="card-body">
                    
                              <p>
                                    <?php echo "Titel Browserfenster <br />";?>
                                    <?php echo form_input('title',$prefs[0]->title,'class="form-control"');?>
                              </p>
                        
                              <p>
                                    <?php echo "Überschrift";?> <br />
                                    <?php echo form_input('school',$prefs[0]->school,'class="form-control"');?>
                              </p>
                              
                             <p>
                                    <?php echo "Footer";?> <br />
                                    <?php echo form_input('footer',$prefs[0]->footer,'class="form-control"');?>
                              </p>
                              
                              <p>
                                    <?php echo "Hauptfarbe";?> <br />
                                    <?php echo form_input('navbarcolor',$prefs[0]->navbarcolor,'id="navbarcolor" class="form-control"');?>
                                    	<button class="jscolor {valueElement:'navbarcolor', onFineChange:'setTextColor(this,\'navbarcolor\')'}">
											Farbe wählen
										</button>
                              </p>
                              
                                                            <p>
                              <?php echo "Textfarbe";?> <br />
                                    <?php echo form_input('textnavbarcolor',$prefs[0]->textnavbarcolor,'id="textnavbarcolor" class="form-control"');?>
                                    	<button class="jscolor {valueElement:'textnavbarcolor', onFineChange:'setTextColor(this,\'textnavbarcolor\')'}">
											Farbe wählen
										</button>
                              </p>
                              
                              <?php echo "Linkfarbe";?> <br />
                                    <?php echo form_input('linknavbarcolor',$prefs[0]->linknavbarcolor,'id="linknavbarcolor" class="form-control"');?>
                                    	<button class="jscolor {valueElement:'linknavbarcolor', onFineChange:'setTextColor(this,\'linknavbarcolor\')'}">
											Farbe wählen
										</button>
                              </p>
                              
                    
                      </div>
                      
                    </div>
                    
                    
                   <div class="card border-light mb-3">
                      <div class="card-header">Anleitung für Eltern</div>
                      <div class="card-body">
                              <p>
                                     <?php echo form_textarea('manual',$prefs[0]->manual,'class="form-control"');?>
                              </p>
                      </div>
                      
                    </div>  	
   		
            </div>
            
            
            
            <div class="col-md-6">        			
            
            		<div class="card border-light mb-3">
                      <div class="card-header">Elternwahl/Elternansicht</div>
                      <div class="card-body">
                      
                                <?php
                                $radio1 = "";
                                $radio2 = "";
                                $radio3 = "";
                       	    	if($prefs[0]->choice_on==1){
                       	    	    $radio1 = "checked";
                               }
                               else if($prefs[0]->choice_on==0){
                                $radio2 = "checked";
                              }
                       	    	else{
                       	    	    $radio3 = "checked";
                       	    	}
                       	    	?>

                      		<label class="radio-inline"><input type="radio" name="choice_on" value="on" <?php echo $radio1;?>> aktiviert </label>
							            <label class="radio-inline"><input type="radio" name="choice_on" value="off" <?php echo $radio2;?>> deaktiviert </label>
                          <label class="radio-inline"><input type="radio" name="choice_on" value="erg" <?php echo $radio3;?>> Ergebnisse anzeigen </label>

                      </div>
                    </div>
            
                    
                    <div class="card border-light mb-3">
                      <div class="card-header">Anzahl wählbarer Lehrkräfte bei 1 Kind, 2 Kindern, mehr als 2 Kindern</div>
                      <div class="card-body">
                              <p>
                                     <?php echo form_input('choice_children1',$prefs[0]->choice_children1,'class="form-control"');?>
                                     <?php echo form_input('choice_children2',$prefs[0]->choice_children2,'class="form-control"');?>
                                     <?php echo form_input('choice_children3',$prefs[0]->choice_children3,'class="form-control"');?>
                              </p>
                      </div>
                      
                       </div>  
                    
                
                   <div class="card border-light mb-3">
                      <div class="card-header">Datum 1, Datum 2 des Elternsprechtages</div>
                      <div class="card-body">
                              <p>
                                     <?php echo form_input('datum1',$prefs[0]->datum1,'class="form-control"');?>
                                     <?php echo form_input('datum2',$prefs[0]->datum2,'class="form-control"');?>
                              </p>
                      </div>
                      
                    </div>
                      
                    	
                    <div class="card border-light mb-3">
                      <div class="card-header">Wählbare Optionen</div>
                      <div class="card-body">
                               <p>
                                     <?php echo form_input('option1',$prefs[0]->option1,'class="form-control"');?>
                                     <?php echo form_input('option2',$prefs[0]->option2,'class="form-control"');?>
                                     <?php echo form_input('option3',$prefs[0]->option3,'class="form-control"');?>
                                     <?php echo form_input('option4',$prefs[0]->option4,'class="form-control"');?>
                                     <?php echo form_input('option5',$prefs[0]->option5,'class="form-control"');?>
                                     <?php echo form_input('option6',$prefs[0]->option6,'class="form-control"');?>
                              </p>
                      </div>
                    </div>

            </div>
    		</div>
    		
    		<div class="row">
    		<div class="col-sm-10"></div>
    		<div class="col-sm-2">
    		   <?php echo form_submit('submit', 'Speichern','class="btn btn-primary btn-block"');?>
               <?php echo form_close();?>
            </div>
    		</div>
   

  </div>
  
</div>


