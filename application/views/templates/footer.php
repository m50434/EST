</div>	
</br>
</br>
<p class="text-center" >&copy; <?php echo date("Y"); ?> <?php echo $prefs[0]->footer;?></p>

    <script>



    
	function setTextColor(picker,id) {
		$('#'+id).val(picker.toString());

	}
	
	
    var table_teachers = $('#table_teachers').DataTable( {  
    	 "ordering": false,     
    	"sDom": 't',
        scrollY:        250,
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        scrollX: "100%"
        } );


	$('#teacher_search').on( 'keyup', function () {
	    table_teachers.search( this.value ).draw();
	} );





    var table_teachers_mobile = $('#table_teachers_mobile').DataTable( {  
   	   "ordering": false,     
   		"sDom": 't',
       scrollY:        250,
       scrollCollapse: true,
       paging:         false,
       deferRender:    true,
       scrollX: "100%"
       } );

	$('#teacher_search_mobile').on( 'keyup', function () {
	    table_teachers_mobile.search( this.value ).draw();
	} );

	

    var table_teachers_choices = $('#table_teachers_choices').DataTable( {       

    	"sDom": 't<"bottom"i>',
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        "language": {
            "sInfo": "_TOTAL_ Einträge"
            }
        
        } );


	$('#teachers_choice_search').on( 'keyup', function () {
	    table_teachers_choices.search( this.value ).draw();
	} );
	


    var table_rooms = $('#table_rooms').DataTable( {       

    	"sDom": 't<"bottom"i>',
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        "language": {
            "sInfo": "_TOTAL_ Einträge"
            }
        
        } );



	$('#rooms_search').on( 'keyup', function () {
		table_rooms.search( this.value ).draw();
	} );

	

    var table_teachers_auth = $('#table_teachers_auth').DataTable( {       

    	"sDom": 't<"bottom"i>',
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        "language": {
            "sInfo": "_TOTAL_ Einträge"
            }
        
        } );

	$('#teachers_search_auth').on( 'keyup', function () {
	    table_teachers_auth.search( this.value ).draw();
	} );

    
    var table_teachers_results_auth = $('#table_teachers_results_auth').DataTable( {       

    	"sDom": 't<"bottom"i>',
        scrollCollapse: true,
        paging:         false,
        orderFixed: [[0, 'asc']],
        rowGroup: {
            dataSrc: 1,
            endRender: function ( rows, group ) {
                var count = rows.count();
 
               // return 'Anzahl der Gespräche: '+
                //    count;
                return $('<tr>')
                .append( '<td style="text-align:right; background-color:#FFFFFF;" colspan="3">Anzahl der Gespräche: ' + count + '</td>')
                .append('</tr>');
            }
        },
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false
            }
        ],
        deferRender:    true,
        "language": {
            "sInfo": "_TOTAL_ Einträge"
            }
        
        } );

    

	$('#teachers_results_search_auth').on( 'keyup', function () {
		table_teachers_results_auth.search( this.value ).draw();
	} );


	

    var table_parents_choices = $('#table_parents_choices').DataTable( {       

        
    	"sDom": 't<"bottom"i>',
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        "language": {
            "sInfo": "_TOTAL_ Einträge"
            }
        
        } );


	$('#parents_choice_search').on( 'keyup', function () {
	    table_parents_choices.search( this.value ).draw();
	} );




    var table_parents = $('#table_parents').DataTable( {       

    	"sDom": 't<"bottom"i>',
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        "language": {
            "sInfo": "_TOTAL_ Einträge"
            }
        
        } );


	$('#parents_search').on( 'keyup', function () {
	    table_parents.search( this.value ).draw();
	} );




 var table_parents_results_auth = $('#table_parents_results_auth').DataTable( {       

 	"sDom": 't<"bottom"i>',
     scrollCollapse: true,
     paging:         false,
     deferRender:    true,
     orderFixed: [[2, 'asc']],
     rowGroup: {
         dataSrc: 2,
         endRender: function ( rows, group ) {
             var count = rows.count();

            // return 'Anzahl der Gespräche: '+
             //    count;
             return $('<tr>')
             .append( '<td style="text-align:right; background-color:#FFFFFF;" colspan="4">Anzahl der Gespräche: ' + count + '</td>')
             .append('</tr>');
         }
     },
     "columnDefs": [

         {
             "targets": [ 2 ],
             "visible": false
         }
     ],
     "language": {
         "sInfo": "_TOTAL_ Einträge"
         }
     
     } );



	$('#parents_results_search_auth').on( 'keyup', function () {
		table_parents_results_auth.search( this.value ).draw();
	} );



	
    $('#table_users').DataTable({
    	"sDom": 't<"bottom"i>',
        //scrollY:        350,
        scrollCollapse: true,
        paging:         false,
        deferRender:    true,
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Keine Daten vorhanden",
            "sInfo": "_TOTAL_ Einträge",
            "infoEmpty": "Keine Daten vorhanden",
            "infoFiltered": "",
            "search":         "Suche:",
            "paginate": {
                "first":      "Erste",
                "last":       "Letzte",
                "next":       "Nächste",
                "previous":   "Vorherige"
            },
        }
    } );



    $('#for_parent_result').DataTable({
    	"sDom": 'Bt<"bottom"i>',
		//scrollY:        350,
		"order": [[ 2, "asc" ]],
        paging:         false,
        buttons: [
            'copy',
            {
                extend: 'pdf',
                messageTop: "Ihre Gesprächstermine beim Elternsprechtag am MPG: ",
				filename: "ESTamMPG",
				customize: function (doc) {
						//Remove the title created by datatTables
						doc.content.splice(0,1);
						//Create a date string that we use in the footer. Format is dd-mm-yyyy
						var now = new Date();
						var jsDate = now.getDate()+'.'+(now.getMonth()+1)+'.'+now.getFullYear();
						var school = '<?php echo $prefs[0]->school;?>';
					
						// margin: [left, top, right, bottom]
						doc.pageMargins = [40,110,20,30];
						// Set the font size fot the entire document
						doc.defaultStyle.fontSize = 12;
						// Set the fontsize for the table header
						doc.styles.tableHeader.fontSize = 12;

						doc.styles.tableHeader = {
						color: 'black',
						bold:!0,
						fillColor: '#cccccc',
                        alignment: 'left'
                	    },
						doc['header']=(function() {
							return {
								columns: [
									{
										alignment: 'left',
										italics: true,
										text: 'Elternsprechtag',
										fontSize: 18,

									},

									{
										alignment: 'right',
										fontSize: 14,
										text: school
									}
								],
								margin: 40
							}
						});
						// Create a footer object with 2 columns
						// Left side: report creation date
						// Right side: current page and total pages
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Erstellt: ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['Seite ', { text: page.toString() },	' von ',	{ text: pages.toString() }]
									}
								],
								// margin: [left, top, right, bottom]
								margin: [ 20, 2, 20, 50 ]
							}
						});

						      // Styling the table: create style object
							  var objLayout = {};
							// Horizontal line thickness
							objLayout['hLineWidth'] = function(i) { return .5; };
							// Vertikal line thickness
							objLayout['vLineWidth'] = function(i) { return .5; };
							// Horizontal line color
							objLayout['hLineColor'] = function(i) { return '#aaa'; };
							// Vertical line color
							objLayout['vLineColor'] = function(i) { return '#aaa'; };
							// Left padding of the cell
							objLayout['paddingLeft'] = function(i) { return 24; };
							// Right padding of the cell
							objLayout['paddingRight'] = function(i) { return 24; };
							// Inject the object in the document
							doc.content[1].layout = objLayout;

				},
                title: "Elternsprechtag am MPG",
                text: "PDF"
            },
            {
                extend: 'print',
				messageTop: "Ihre Gesprächstermine beim Elternsprechtag am MPG: ",
                filename: "ESTamMPG",
                title: "Elternsprechtag am MPG",
                text: "Drucken"
            }
            
        ],

        deferRender:    true,
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Keine Gesprächswünsche gewählt.",
            "sInfo": "_TOTAL_ Gesprächstermine",
            "infoEmpty": "Keine Daten vorhanden",
            "infoFiltered": "",
      
        }
    } );
    </script>
    
    

  <script>
  $( function() {

	 
	  var $number_of_children = '<?php if(isset($number_of_children))echo $number_of_children; ?>'; 
	  var $stored_choices = '<?php if(isset($stored_choices)) echo $stored_choices; ?>'; 
	  var $storeArray = new Array();

	  $choice_for_children = 1; // Init
	  if ($number_of_children == 1) {
		    $choice_for_children = '<?php if(isset($choice_for_children1))echo $choice_for_children1; ?>'; 
		} else if ($number_of_children == 2) {
		    $choice_for_children = '<?php if(isset($choice_for_children2))echo $choice_for_children2; ?>'; 
		} else if ($number_of_children > 2) {
		    $choice_for_children = '<?php if(isset($choice_for_children3))echo $choice_for_children3; ?>'; 
		}
	 
	  
	  
	  var stored = false;
	  var userinput = false;
	    
     window.onbeforeunload = function () {
        if (userinput && !stored) {
           
          return true;
        }
      }

	  
	  // Store Tabs in Admin-Panel
	  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
			
	        localStorage.setItem('activeTab', $(e.target).attr('href'));

	    });

	    var activeTab = localStorage.getItem('activeTab');

	    if(activeTab){

	        $('#adminTab a[href="' + activeTab + '"]').tab('show');

	    }

	    if( $.cookie('alertManual') === 'closed' ){

	        $('#alertManual').hide();

	    }

	    $('#buttonAlertManual').on('click', function( e ){

	        // Do not perform default action when button is clicked
	        e.preventDefault();

	        /* If you just want the cookie for a session don't provide an expires
	         Set the path as root, so the cookie will be valid across the whole site */
	         //console.log("Alertclose");
	        $.cookie('alertManual', 'closed');

	    });

	    
		  
	  $('#store1, #store2').on('click', function() {
		  if(!$(this).hasClass( "disabled" )){
		   stored = true;
		   //console.log($storeArray);
		   storeParentChoices();
		  }
	   })

	  // Diesen Button gibts nicht mehr 
	  $('#discard').on('click', function() {
		  if(!$(this).hasClass( "disabled" )){
		 	 location.reload(); 
		  }
	   })

	   
	   
	   
	  $('.parent_option_checkbox').change(function() {
		userinput = true;
		stored = false;
		$('#store1').removeClass("disabled");
		$('#store2').removeClass("disabled");
		$('#discard').removeClass("disabled");  
		
        if($(this).is(":checked")) {
            //alert($(this).attr("id"));
            //console.log($(this).attr("id"));
        }
        else{
			//console.log("unchecked");
        }  

        // teacherArray must be filled
        updateTeacherList();      
      }); 


	  $( ".verfuegbar").click(function(event) {
		 
			
			$id=$(this).attr("data-id");
			//console.log($id);
			if($("#"+$id).hasClass("collapse")){
				$("#"+$id).removeClass("collapse")
			}
			else{
				$("#"+$id).addClass("collapse")
			}
			event.stopPropagation();
	  });	
	  
	  $( ".teacher_tr, .teacher_tr_mobile ").click(function(event) {

		  userinput = true;
		  stored = false;
	
		  $teachers_id = $(this).attr('id');

		  
		  //Falls bereits die maximale Anzahl an Lehrkräften gewählt wurde
		  if($(this).find(".arrowright").hasClass("collapse")){ 

			  
			  /*
	    	    bootbox.alert({
	    	        message: "Sie haben diese Lehrkraft bereits ausgewählt.",
	    	        size: 'small'
	    	    });
	    	  */  
		  }

		  else if($stored_choices<$choice_for_children){ 

		  //$(this).css("display","none");
		  //console.log($(this));
		  //console.log($(this).attr('id'));
		  
		  $(".t_tr"+$teachers_id).removeClass( "table-light");
		  $(".t_tr"+$teachers_id).find(".arrowcheck").removeClass("collapse");
		  $(".t_tr"+$teachers_id).find(".arrowright").addClass("collapse");

		  $(".t_tr_m"+$teachers_id).removeClass( "table-light");
		  $(".t_tr_m"+$teachers_id).find(".arrowcheck").removeClass("collapse");
		  $(".t_tr_m"+$teachers_id).find(".arrowright").addClass("collapse");
	
		  

		  
		 
		  var $surname = $( this ).find(".surname").html();
		  var $shortcode = $( this ).find(".shortcode").html();
	
		  var $lis = $( "#parent_choice" ).children('li');
          $lis.each(function() {
              
              if($(this).find(".picked_teacher").is(':empty')){

            	  $(this).attr('data-teacherid', $teachers_id); 
            	  $(this).find(".picked_teacher").html($surname + " (" + $shortcode + ")");
            	  $(this).find(".teacher_remove_icon").removeClass("collapse");
            	  
            	  $(this).removeClass( "disabled");
            	  updateTeacherList();
            	  return false; 
              }

              
          });
	      }
	      else{

	    	    bootbox.alert({
	    	        message: "Sie haben bereits die maximale Anzahl an Lehrkräften ausgewählt.",
	    	        size: 'small'
	    	    });

	      }	
         
		});



	$( ".teacher_remove_icon" ).click(function() {

		userinput = true;
		removeTeacher($(this));

    });



	function storeParentChoices(){
		$('#store1').addClass("disabled");
		$('#store2').addClass("disabled");
		$('#discard').addClass("disabled");

		
	    waitingDialog.show('Änderungen speichern...',{
	    	dialogSize: 'sm',
	    	headerSize: 6
	    });

		// For Checkboxes
		var $cb = $('.parent_option_checkbox');
        var $cb_string = "";       
        $cb.each(function() {
        		if($(this).is(":checked")){
        			$cb_string += "1,";
        		}
        		else{
        			$cb_string += "0,";
        		}
            });
         $cb_string = $cb_string.slice(0,-1);
         //console.log($cb_string);   

		

		// For Choices
		var arrayJson = JSON.stringify($storeArray);
		//console.log(arrayJson);
		//console.log("store");
		//alert(res);

		
		$.ajax({
		type: "POST",
		url: "Users/storeParentChoices",
		data: {parent_choices: arrayJson, parent_checkboxes: $cb_string},
        error: function(res) {
        	setTimeout(function () {
    			 waitingDialog.hide();
   			}, 1000);
            bootbox.alert({
    	        message: "Leider ist ein Fehler aufgetreten. Die Änderungen wurden nicht gespeichert.",
    	        size: 'small'
    	    });


         },
		success: function(res) {
			setTimeout(function () {
	 			 waitingDialog.hide();
				}, 1000);
		    bootbox.alert({
    	        message: "Ihre Änderungen wurden gespeichert.",
    	        size: 'small'
    	    });
		
		}
		});
		
	}

		
	function removeTeacher($item){

		//console.log($item.parents('li').attr('data-teacherid'));
		//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").show();
		$teachers_id = $item.parents('li').attr('data-teacherid');
		//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").addClass( "table-light");
		//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").find(".arrowcheck").addClass("collapse");
		//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").find(".arrowright").removeClass("collapse");
		$(".t_tr"+$teachers_id).addClass( "table-light");
		$(".t_tr"+$teachers_id).find(".arrowcheck").addClass("collapse");
		$(".t_tr"+$teachers_id).find(".arrowright").removeClass("collapse");

		$(".t_tr_m"+$teachers_id).addClass( "table-light");
		$(".t_tr_m"+$teachers_id).find(".arrowcheck").addClass("collapse");
		$(".t_tr_m"+$teachers_id).find(".arrowright").removeClass("collapse");

		
		
		$item.addClass("collapse");
		$item.parents('li').find(".picked_teacher").html("");
		$item.parents('li').addClass( "disabled");
		$('#parent_choice').sortable('option','update')();

		
	}

	
	function updateTeacherList(){

		$('#store1').removeClass("disabled");
		$('#store2').removeClass("disabled");
		$('#discard').removeClass("disabled");

		userinput = true;
		
        var $lis = $('#parent_choice').children('li');
        var $teacher_arr = new Array();
        var $teacher_arrid = new Array();
        $storeArray = [];
        
        $lis.each(function() {
			    if(!$(this).find(".picked_teacher").is(':empty')){
            	$teacher_arr.push($(this).find(".picked_teacher").html());
            	$teacher_arrid.push($(this).attr('data-teacherid'));
            	$(this).find(".picked_teacher").empty();
            }
            
        });


      
         $lis.each(function() {
               var $li = $(this);
               var newVal = $(this).index() + 1;
               
               var teacherid;

               $(this).find('.sortable-number').html(newVal + ".");
               if(!jQuery.isEmptyObject($teacher_arr)){
                   //console.log(newVal);


                        $storeArray.push([parseInt($teacher_arrid[0]),newVal-1]);

            	   		
                    	$(this).find(".picked_teacher").html($teacher_arr.shift());
                    	$(this).attr('data-teacherid', $teacher_arrid.shift()); 
                    	$(this).find(".teacher_remove_icon").removeClass("collapse");
                    	$(this).removeClass( "disabled");
                        
                        
               }
               else{
                    	$(this).addClass( "disabled");
                    	$(this).find(".teacher_remove_icon").addClass("collapse");
               }
                   
                });

         $stored_choices = $storeArray.length;
         //console.log($storeArray);
      
	}  
	outside = true;
    $('#parent_choice').sortable({
        
    	items: "li:not(.disabled)",
    	cancel:".disabled",
    	cursor: "move",
    	revert: false,
    	over: function (event, ui) {
    	    outside = false;
    	    //console.log(outside);
    	},
    	out: function (event, ui) {
    	    outside = true;
    	    //console.log(outside);
    	},
    	beforeStop: function (event, ui) {
    		   if (outside) {
        		   //console.log("outside");
    			    
					$item = ui.item.find(".teacher_remove_icon");
					
					//console.log($item.parents('li').attr('data-teacherid'));
					//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").show();
					$teachers_id = $item.parents('li').attr('data-teacherid');
					//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").addClass( "table-light");
					//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").find(".arrowcheck").addClass("collapse");
					//$('#'+$item.parents('li').attr('data-teacherid')).closest("tr").find(".arrowright").removeClass("collapse");
					$(".t_tr"+$teachers_id).addClass( "table-light");
					$(".t_tr"+$teachers_id).find(".arrowcheck").addClass("collapse");
					$(".t_tr"+$teachers_id).find(".arrowright").removeClass("collapse");

					$(".t_tr_m"+$teachers_id).addClass( "table-light");
					$(".t_tr_m"+$teachers_id).find(".arrowcheck").addClass("collapse");
					$(".t_tr_m"+$teachers_id).find(".arrowright").removeClass("collapse");
					
    				$item.addClass("collapse");
    				$item.parents('li').find(".picked_teacher").html("");
    				$item.parents('li').addClass( "disabled");
    		   }
    		},

    	stop: function(event, ui) {
    			updateTeacherList();
        	},	
        	
        update: function(event, ui) {
        	if(outside){
            	updateTeacherList();
        	//console.log("update");
        	}

        }
    });
    $( "#parent_choice" ).disableSelection();

  } );
  
  </script>
  </body>
</html>