<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="shortcut icon" href="assets/favicon.ico">
	    <title><?php echo $page_title;?></title>
		
		<!--<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH."";?>" type="text/css" />-->
		<style>
            
        
            .button_template{
                background-color: rgb(117, 48, 153);
                color: white;
                /* font-size: 12px;
                padding: 12px 11px; */
                font-size: 14px;
                padding: 8px 8px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border-radius: 8px;
                border: none;
                box-shadow: 2px 2px #888888;
                min-width: 12rem;
                font-family:'Ubuntu', sans-serif;
            }
            .table_align_top{
                
                font-family:'Ubuntu', sans-serif;
                width: 101%;
                margin-left: -5px;
            }
            .table_align_bottom{
                border:solid 1px;
                font-family:'Ubuntu', sans-serif;
                width:100%;
            }
            .table_align{
                border:solid 1px;
                font-family:'Ubuntu', sans-serif;
                width:50%;
            }
            .vertical-align {
                display: flex;
                /* justify-content: center; */
                flex-direction: row;
            }

            .search-result{
                width: 100%;
                overflow-y: scroll;
                list-style-type: none;
                padding: 0;
                margin: 0;
            }
            .search-result li{
                width: auto;
                padding: 10px;
                font-size: 16px;
                color: #392781;
                cursor: pointer;
            }

            .selected {
            background-color:grey;
            }


           
        </style>
  	</head>
<body>

                   

<div class="container">
      <div class="row vertical-align">
        <div class="col-xs-6 col-md-8" style = "font-size: 13.5px; font-family: 'Calibri', sans-serif;">


            <?php
                $attributes = array('class' => '', 'id' => 'saveClosesubmit', 'role' => 'form');
                echo form_open(base_url('app/orders/presenter_billing/?order_id='.$order->id), $attributes);
            ?>
            <table  cellpadding="5" cellspacing="0" border="0" class="table_align_top">
                <tr>
                    <th style=" float: left;"><?php echo $schedule->worktype_name;?> Sign- In Log</th>
                    <td><img src="<?php echo base_url('assets/images/logo.png');?>" style = "width: 36%; float: right;"></td>

                </tr>
                <tr>
                    <th style="margin-top: 1rem; float: left;">Vendor: Brienza’s Academic Advantage</th>
                    <th align="right" style=" "><strong>Total Hours of Service:</strong> <span style = "color: #51c03de3; font-size: 33px;"><u><?php echo number_format($schedule->total_hours, 1);?></u> </span> </th>
                </tr>
                <tr>
                    <td colspan="2" style="" style=" float: left;"><strong>PRESENTER:</strong> [ <?php echo $schedule->first_name." ".$schedule->last_name;?>]  </td>
                    
                </tr>
                <tr>
                    <td align="left" colspan="2" style=""><strong>School:</strong> [<?php echo $order->school_name;?>] </td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style=""><strong>Purchase Order:</strong> [<?php echo $order->order_no;?>] </td>
                </tr>
            
            </table>
            <table  cellpadding="5" cellspacing="0" border="0" class="table_align_bottom">
                <tr style="height:40px;">
                    <td  colspan="2" style="">
                        <table style="width: 100%;"  style = "  border: 1px solid black; border-collapse: collapse">
                            <tr>
                                <td style = "text-align: center; border-right: 1px solid;"> <strong>Date of Service:</strong> <br>  <?php echo date("j/n/Y", strtotime($schedule->start_date)); ?></td>
                                <td style = "text-align: center; border-right: 1px solid;"><strong>Teacher(s) Name and Grade</strong> <br> 
                                [<?php echo $schedule->teacher; ?>], [<?php echo $schedule->grade_name; ?>]</td>
                                <td style = "text-align: center;"><strong>Session Time:</strong> </br> <?php echo time_display($schedule->start_date, true);?> <span> to </span> <?php echo time_display($schedule->end_date, true);?> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="border-top:solid 1px;">
                        <textarea cols="110" rows="15" name="content" class="view_message row_limit" id="template_descp" onkeyup="word_limit()" required></textarea>
                    </td>
                </tr>

                <tr>
                    <td align="left" style="height:30px; border-top:solid 1px; width: 52%; border-right: 1px solid;"><strong>Teacher’s Name:</strong> [<?php echo $schedule->teacher; ?>]</td>
                    <td align="left" style="height:30px; border-top:solid 1px;"><strong>Teacher’s Signature:</strong>____________________</td>
                </tr>

                <tr>
                    <?php if(isset($principal_name)){ ?>
                        <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> 
                            <input type="text" name="principal_nameForLog" class="form-control" id="inputName"  placeholder="Enter name" value="<?php if(isset($principal_name)) {echo $principal_name->meta_value;}?>" required>
                        </td>
                    <?php }else{ ?>
                        <td align="left" style="height:30px;  width: 52%; border-right: 1px solid;"><strong>Principal’s Name: </strong> 
                            <input type="text" name="principal_nameForLog" class="form-control" id="inputName"  placeholder="Enter name" value="<?php echo 'N/A' ?>" required>
                        </td>
                    <?php } ?>
                    <td align="left" style="height:30px; "><strong>Principal’s Signature:</strong></td>
                    <!-- <td align="left" style="height:50px; border-top:solid 1px;"></td> -->
                </tr>

                    <tr>
                        <td align="right" colspan="2" style="height:50px; border-top:solid 1px;">
                            
                            <input type="button"  class="btn btn-primary principal_sign"  value="Save as custom template" style="padding: 7px;" onclick="save_custom_template();">

                            <input type="hidden" id="topic_id" value="<?php if(isset($schedule->topic_id)){ echo $schedule->topic_id; } ?>">

                            <input type="hidden" id="template_message" value="<?php if(isset($topic_text_final)){ echo $topic_text_final;}?>">

                            <button type="submit" class="btn btn-primary principal_sign" style="padding: 7px;" id="saveClose">Save & Close</button>
                            
                            <input type="hidden" name="status[<?php echo $schedule->id?>]" value="Log sent - awaiting principal signature" />   
                            <input type="hidden" name="old_status[<?php echo $schedule->id?>]" value="Create log" />    
                        </td>
                    </tr>
            </table>
            <?php echo form_close();?>
        </div>
            <div class="col-xs-6 col-md-4" style=" margin-left: 1rem;">
            <button type="button" class=" button_template" data-toggle="tooltip" data-placement="bottom" title="This will display the template saved by admin in the library under this topic." onclick="use_library_topic(<?php if(isset($schedule->topic_id)){ echo $schedule->topic_id;} ?>)">Use Library Topic</button>
            <br><br>
            <button type="button" class="button_template" data-toggle="tooltip" data-placement="bottom" title="This will display the template added by presenter in the log writing room under this topic" onclick="use_custom_template(<?php if(isset($schedule->topic_id)){ echo $schedule->topic_id;} ?>)">Use Custom Template</button>
            <br><br>
            <button type="button" class="button_template" data-toggle="tooltip" data-placement="bottom" title="This will display the favorite template added by presenter in the log writing room" onclick="use_favorite_template()">Use Favorite Template</button>
            <br><br>

            <!-- <select class="button_template"  name="topic" class="form-control" id="topic_template" style="width:14%">
                <option  value="">View Brienza Templates</option>

                <?php// foreach ($tem_list as $item) {?>


                    <option class='short' data-limit='67' value="<?php //echo $item->id;?>" > <?php //echo $item->tmp_name;?></option>
                    
                <?php// }?>
            </select> -->


            <div id="first_button">
					<div>
						<input type="button" class="button_template" value="View Brienza Templates" id="View_brienza_templates"> </input>
					</div>
				
					<div class="row" id="list" style="display:none; background-color: rgb(117, 48, 153);">
						<ul class="search-result" id="get_user_list">
						<?php foreach ($tem_list as $item) {
						?>
							<li>
								<a href="#" onclick="" style="font-size: 14px;font-family:'Ubuntu', sans-serif; text-decoration: none; color: white;" id="<?php echo $item->id;?>" ><?php echo $item->tmp_name; ?></a>
							</li>
						<?php }?>
						</ul>
					</div>
				</div>


				<div id="secondary_button" style="display:none;">
					<div>
						<input type="button" class="button_template" value="View Brienza Templates" id="View_brienza_templates_second"> </input>
					</div>
					<div class="row" id="list_2" style="display:none; background-color: rgb(117, 48, 153);">
						<ul class="search-result" id="get_user_list_after">
						
						</ul>
					</div>
				</div>


        </div>
    </div>
</div>

</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


    <script>


       

        $(document).ready(function(){
            var count = 0;
			$("#saveClose").click(function(){
				count++;
				// alert("button");
				if(count>0)
					$('#saveClose').prop('disabled', true);
					$("#saveClosesubmit").submit();
			});
        });

		function use_custom_template(topic_id){
            // alert(topic_id);
            $("#list").hide();
            $("#list_2").hide();

            is_open_list = 0;
			is_open_list_2 = 0;

			// place this within dom ready function
			function showpanel() {  
                let description_val = jQuery('#template_descp').val();
                if (description_val != '')
                {
                    if (confirm("By selecting this template, all data previously entered in the log text box will be deleted.")) {
                
                        jQuery.ajax({
                            url: '<?php echo base_url('app/presenters/use_custom_template/');?>',
                            
                            data: {topic_id:topic_id},
                            type: 'post',
                            // ajaxCall:true,
                            async: false,
                            success: function (response) {
                                // alert(response);
                                if(response == false){
                                    alert('No template saved for this topic. ');
                                }else{
                                    $('.view_message').val(response);
                                    $("#deselect").removeClass("selected");
                                }
                            }
                        });
                    }
                }else{
                    jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_custom_template/');?>',
                        
                        data: {topic_id:topic_id},
                        type: 'post',
                        // ajaxCall:true,
                        async: false,
                        success: function (response) {
                            // alert(response);
                            // $('.view_message').val(response);
                            if(response == false){
                            alert('No template saved for this topic. ');
                        }else{
                            $('.view_message').val(response);
                            $("#deselect").removeClass("selected");
                        }
                            
                        }
                    });
                }
            }

            // use setTimeout() to execute
            setTimeout(showpanel, 60);
        }

        function use_favorite_template(){
            $("#list").hide();
            $("#list_2").hide();

            is_open_list = 0;
			is_open_list_2 = 0;

			// place this within dom ready function
			function showpanel() {  
                let description_val = jQuery('#template_descp').val();
                if (description_val != '')
                {
                    if (confirm("By selecting this template, all data previously entered in the log text box will be deleted.")) {
                
                        jQuery.ajax({
                            url: '<?php echo base_url('app/presenters/use_favorite_template/');?>',
                            
                            data: {},
                            type: 'post',
                            // ajaxCall:true,
                            // async: false,
                            success: function (response) {
                                // alert(response);
                                if(response == false){
                                    alert('No favorite template saved in library ');
                                }else{
                                    $('.view_message').val(response);
                                    $("#deselect").removeClass("selected");
                                
                                }
                            }
                        });
                    }
                }else{

                    jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_favorite_template/');?>',
                        
                        data: {},
                        type: 'post',
                        // ajaxCall:true,
                        // async: false,
                        success: function (response) {
                            // alert(response);
                            if (response == ''){
                                alert('No favorite template saved in library');
                            }else{
                                $('.view_message').val(response);
                                $("#deselect").removeClass("selected");
                            }
                            
                        }
                    });
                }
            }

            // use setTimeout() to execute
            setTimeout(showpanel, 60);
            
        }

		function use_library_topic(topic_id){
            $("#list").hide();
            $("#list_2").hide();

            is_open_list = 0;
			is_open_list_2 = 0;

			// place this within dom ready function
			function showpanel() {  
                let description_val = jQuery('#template_descp').val();
                if (description_val != '')
                {
                    if (confirm("By selecting this template, all data previously entered in the log text box will be deleted.")) {
                
                        jQuery.ajax({
                            url: '<?php echo base_url('app/presenters/use_library_topic/');?>',
                            
                            data: {topic_id:topic_id},
                            type: 'post',
                            // ajaxCall:true,
                            async: false,
                            // success: function (response) {
                            //     // alert(response);
                            //     $('.view_message').val(response);
                            //     $("#deselect").removeClass("selected");
                                
                            // }

                            
                            success: function (response) {
                                // alert(response);
                                if (response == ''){
                                    alert('No template saved by admin for this topic');
                                }else{
                                    $('.view_message').val(response);
                                    $("#deselect").removeClass("selected");
                                }
                            }

                        });
                    }
                }else{
                    jQuery.ajax({
                            url: '<?php echo base_url('app/presenters/use_library_topic/');?>',
                            
                            data: {topic_id:topic_id},
                            type: 'post',
                            // ajaxCall:true,
                            async: false,
                            // success: function (response) {
                            //     // alert(response);
                            //     $('.view_message').val(response);
                            //     $("#deselect").removeClass("selected");
                                
                            // }

                            
                            success: function (response) {
                                // alert(response);
                                if (response == ''){
                                    alert('No template saved by admin for this topic');
                                }else{
                                    $('.view_message').val(response);
                                    $("#deselect").removeClass("selected");
                                }
                            }


                        });
                }
            }

            // use setTimeout() to execute
            setTimeout(showpanel, 60);
        }

        function save_custom_template(){
            $("#list").hide();
            $("#list_2").hide();

            is_open_list = 0;
			is_open_list_2 = 0;

			// place this within dom ready function
			function showpanel() {  
                var message = jQuery('#template_message').val();
                var topic_id = jQuery('#topic_id').val();
                // alert(message);die;
                let description_val = jQuery('#template_descp').val();
                if(description_val == ''){
                    alert("Oops! The custom template cannot be blank.");
                }else{
                    if(message != ''){
                        if (confirm("You already have a template saved for this topic, would you like to replace it ?")) {
                            jQuery.ajax({
                                        url: '<?php echo base_url('app/presenters/save_custom_template/');?>',
                                        
                                        data: {topic_id:topic_id,description_val:description_val},
                                        type: 'post',
                                        // ajaxCall:true,
                                        async: false,
                                        success: function (response) {
                                            alert("Well done... The custom template has been saved successfully.");
                                            $('.view_message').val(response);
                                            $("#deselect").removeClass("selected");
                                            
                                        }
                                    });
                        }

                    }else{
                        jQuery.ajax({
                                        url: '<?php echo base_url('app/presenters/save_custom_template/');?>',
                                        
                                        data: {topic_id:topic_id,description_val:description_val},
                                        type: 'post',
                                        // ajaxCall:true,
                                        async: false,
                                        success: function (response) {
                                            alert("Well done... The custom template has been saved successfully.");
                                            $('.view_message').val(response);
                                            $("#deselect").removeClass("selected");
                                            
                                        }
                                    });
                    }
                }
            }

            // use setTimeout() to execute
            setTimeout(showpanel, 60);
        }

        function shortString(selector) {
            const elements = document.querySelectorAll(selector);
            const tail = '...';
            if (elements && elements.length) {
                for (const element of elements) {
                    let text = element.innerText;
                    if (element.hasAttribute('data-limit')) {
                        if (text.length > element.dataset.limit) {
                        element.innerText = `${text.substring(0, element.dataset.limit - tail.length).trim()}${tail}`;
                        }
                    } else {
                        throw Error('Cannot find attribute \'data-limit\'');
                    }
                }
            }
        }

        // window.onload = function() {
        //     shortString('.short');
        // };


        function resetSelect(e) {
			this.selectedIndex = 0;
		}

		window.onload = function() {
			shortString('.short');
			document.querySelector('select').addEventListener('change', resetSelect, false);
		}

        // function View_brienza_templates(){
		// 	$("#list").toggle();
		// }
		
		// function View_brienza_templates_second(){
		// 	$("#list_2").toggle();
		// }

        // $(document).ready(function(){ 
            var is_open_list = 0;

            $('#View_brienza_templates').live('click', function () {
                if(is_open_list != 0){
                    $("#list").hide(); 
                    is_open_list =0;
                }else{
                    is_open_list =1;
                    $("#list").show(); 
                }
            });

            var is_open_list_2 = 0;

            $('#View_brienza_templates_second').live('click', function () {
                if(is_open_list_2 != 0){
                    $("#list_2").hide(); 
                    is_open_list_2 =0;
                }else{
                    is_open_list_2 =1;
                    $("#list_2").show(); 
                }
            });
        // });

        $(document).mouseup(function(e){
           
           var View_brienza_templates = $("#View_brienza_templates");
           if (!View_brienza_templates.is(e.target) && View_brienza_templates.has(e.target).length === 0){
               var container = $("#list");

               // if the target of the click isn't the container nor a descendant of the container
               if (!container.is(e.target) && container.has(e.target).length === 0) 
               {
                   container.hide();
                   is_open_list = 0;
               }
           }

           var View_brienza_templates_second = $("#View_brienza_templates_second");
           if (!View_brienza_templates_second.is(e.target) && View_brienza_templates_second.has(e.target).length === 0){
               var container = $("#list_2");

               // if the target of the click isn't the container nor a descendant of the container
               if (!container.is(e.target) && container.has(e.target).length === 0) 
               {
                   container.hide();
                   is_open_list_2 = 0;
               }
           }
       });


        $('#get_user_list li').live('click', function () {
			$('#first_button').hide();
			$('#secondary_button').show();
			
			var div = document.createElement("div");
			div.innerHTML = $(this).find('a').attr('id');
			var user_search_id = div.innerText;
			
				let brienza_template_id = user_search_id;
				let description_val = jQuery('#template_descp').val();
				if (description_val != '' && brienza_template_id != '')
				{
					if (confirm("By selecting this template, all data previously entered in the log text box will be deleted")) {

						if(brienza_template_id != ''){
							jQuery.ajax({
								url: '<?php echo base_url('app/presenters/brienza_template/');?>',
								
								data: {brienza_template_id:brienza_template_id},
								type: 'post',
								async: false,
								success: function (response) {
									if(response == false){
										alert('No template saved for this topic. ');
										// $('#list').hide();
										// $('#list_2').show();
										$('#get_user_list_after').html(response.option);
                                        $("#list").toggle();

										
										
									}else{
										// $('#list').hide();
										// $('#list_2').show();
										$('.view_message').val(response.val);
										$('#get_user_list_after').html(response.option);
                                        $("#list").toggle();
									
									}
								}
							});
						}
					}
				}else{
					if(brienza_template_id != ''){
						jQuery.ajax({
							url: '<?php echo base_url('app/presenters/brienza_template/');?>',
							
							data: {brienza_template_id:brienza_template_id},
							type: 'post',
							async: false,
							success: function (response) {
								if(response == false){
									alert('No template saved for this topic. ');
									// $('#list').hide();
									// $('#list_2').show();
									$('#get_user_list_after').html(response.option);
                                    $("#list").toggle();
								}else{
									// $('#list').hide();
									// $('#list_2').show();
									$('.view_message').val(response.val);
									$('#get_user_list_after').html(response.option);
                                    $("#list").toggle();
								}
							}
						});
					}
				}
		});

		$('#get_user_list_after li').live('click', function () {
			var div = document.createElement("div");
			div.innerHTML = $(this).find('a').attr('id');
			var user_search_id = div.innerText;
				let brienza_template_id = user_search_id;
				let description_val = jQuery('#template_descp').val();
				if (description_val != '' && brienza_template_id != '')
				{
					if (confirm("By selecting this template, all data previously entered in the log text box will be deleted")) {

						if(brienza_template_id != ''){
							jQuery.ajax({
								url: '<?php echo base_url('app/presenters/brienza_template/');?>',
								
								data: {brienza_template_id:brienza_template_id},
								type: 'post',
								async: false,
								success: function (response) {
									if(response == false){
										alert('No template saved for this topic. ');
										$('#get_user_list_after').html(response.option);
                                        if(is_open_list_2 == 1){
											is_open_list_2 = 0;
										}
                                        $("#list_2").toggle();
									}else{
										$('.view_message').val(response.val);
										$('#get_user_list_after').html(response.option);
                                        if(is_open_list_2 == 1){
											is_open_list_2 = 0;
										}
                                        $("#list_2").toggle();
									
									}
								}
							});
						}
					}
				}else{
					if(brienza_template_id != ''){
						jQuery.ajax({
							url: '<?php echo base_url('app/presenters/brienza_template/');?>',
							
							data: {brienza_template_id:brienza_template_id},
							type: 'post',
							async: false,
							success: function (response) {
								if(response == false){
									alert('No template saved for this topic. ');
									$('#get_user_list_after').html(response.option);
                                    if(is_open_list_2 == 1){
                                        is_open_list_2 = 0;
                                    }
                                    $("#list_2").toggle();
								}else{
									$('.view_message').val(response.val);
									$('#get_user_list_after').html(response.option);
                                    if(is_open_list_2 == 1){
                                        is_open_list_2 = 0;
                                    }
                                    $("#list_2").toggle();
								}
							}
						});
					}
				}
			
		});

    </script>

</html>