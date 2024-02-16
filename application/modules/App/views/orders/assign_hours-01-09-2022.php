<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Assign Hours for Order No : <?php echo $order_no; ?></h1>
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-shopping-cart"></span> Orders');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Order');?></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/orders');?>">Order Management</a></li>
		<!-- <li class="active">Allocate hours [Hours ratio (Used hrs / Alloted Hrs) : <?php if(!empty($assignment_det['total_used_hours'])) echo $assignment_det['total_used_hours']; else echo '0'; ?> / <?php echo $alloted_hours; ?> ]</li> -->
		<li class="active hideAfterClick">Allocate hours [Hours ratio (Used hrs / Alloted Hrs) : <?php if(!empty($assignment_det['total_used_hours'])) echo $assignment_det['total_used_hours']; else echo '0'; ?> / <?php echo $alloted_hours; ?> ]</li>
		<li class="active hideAtFirst" style="display:none">Allocate hours [Hours ratio (Used hrs / Alloted Hrs) : <span class="usdHrs"></span> / <?php echo $alloted_hours; ?> ]</li>
	</ol>

	<?php
		if($this->session->flashdata('message_type')) {
			if($this->session->flashdata('message')) {

				echo '<div class="alert alert-'.$this->session->flashdata('message_type').' alert-dismissable">';
				echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				echo $this->session->flashdata('message');
				echo '</div>';
			}
		}
	?>	

	<?php
		//form validation
		// echo validation_errors();

		// $attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		// echo form_open(base_url('app/orders/assign_hours/'.$this->uri->segment(4)), $attributes);
    ?>
  	<fieldset>
		<legend>Assignment Process</legend>

		<!-- 22-07-2022 -->
		<legend>
            <div class="row">
                <div class="col-md-1" id="button" style="cursor:pointer;"><span class="glyphicon glyphicon-filter"></span>Filters</div>
                <div class="col-md-11"></div>
            </div>
        </legend>
		<div class="row" id="item" style="display:none";>
        	<!-- <input type="hidden" id="hdnSession" name="hdnSession" value="<?php echo $session?>">    -->
        	<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
            <div class="col-md-12">
                
                <div class="form-group col-md-6">
                    <select name="presenter_idFilter" class="form-control" id="presenter_idFilter" onchange="getPresenterFilter(this.value)">
                        <option value="" selected>Select a presenter</option>
                        <?php
                        // echo'<pre>'; print_r($presenter_list);
                        foreach ($presenter_full_list as $item) {?>
                        <option value="<?php echo $item['presenter_id'];?>" <?php if(isset($presenterfilter) && ($presenterfilter == $item['presenter_id'])) echo 'selected'; ?> ><?php echo $item['first_name']." ".$item['last_name'];?></option>
                        <?php }?>
                    </select>
                </div>
                
                
                <div class="form-group col-md-6">
                    <!-- <button type="button" class="btn btn-default" onclick="window.location=''"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
                    <!-- <button type="button" class="btn btn-default" onclick="sessionDestroy();"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
                    <button type="button" class="btn btn-default" onclick="resetForm();"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

                    <!-- <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp; -->
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">&nbsp;</div>
        </div>

		<!--  end 22-07-2022 -->
		<!-- modified -->
		<?php
			//form validation
			echo validation_errors();

			$attributes = array('class' => 'form-horizontal', 'id' => 'presenterFilter-search-form', 'role' => 'form', 'data-toggle' => 'validator');
			echo form_open(base_url('app/orders/assign_hours/'.$this->uri->segment(4)), $attributes);
		?>
		<!-- end modified -->

    <?php 
    if(!empty($presenter_list))
    {
    	foreach ($presenter_list as $key => $value) 
    	{
    		// echo "<pre>";print_r($presenter_list);exit;
    		$presenter_id = $value['presenter_id'];
    ?>	
    	<div class="row">
		    <div class="col-sm-1">
		    	<div class="form-group">
					<input class="form-control presenter_chkbox" type="checkbox" name="presenter_id[]" value="<?php echo $value['presenter_id']; ?>" <?php if(!empty($assignment_det) && in_array($value['presenter_id'], $assignment_det['presenters'])) echo 'checked'; ?> data-ordid="<?php echo $this->uri->segment(4); ?>" data-presenter_id="<?php echo $value['presenter_id']; ?>" id="presenter_chkbox_<?php echo $value['presenter_id']; ?>" />
					<input type="hidden" name="hdn_pre_id[]" value="" id="<?php echo $value['presenter_id']; ?>" />
					<input type="hidden" name="is_filter" value="<?php echo $presenterfilter;?>">
		    	</div>
		    </div>

		    <div class="col-sm-1">
		    	<div class="form-group">
		    		<?php echo $value['first_name']." ".$value['last_name']; ?>
		    	</div>
		    </div>
		    <div class="col-sm-2">
		    	<div class="form-group">
		    		<input class="form-control input-sm asgnHrs" type="number" name="assigned_hours[]" id="assign_hours_<?php echo $presenter_id; ?>" placeholder="Enter assign hour(s)" min="0" p_id="<?php echo $presenter_id; ?>" value="<?php if(!empty($assignment_det['assigned_hours'][$presenter_id])) echo $assignment_det['assigned_hours'][$presenter_id]; ?>" data-ordid="<?php echo $this->uri->segment(4); ?>" data-presenter_id="<?php echo $value['presenter_id']; ?>" >
		    	</div>
		    </div>
		    <div class="col-sm-2">
		    	<div class="form-group">
			    	<select class="form-control" name="grade[<?php echo $presenter_id ?>][]" id="grade_<?php echo $presenter_id; ?>" multiple>
			    		<option value="">Choose Grade</option>
			    		<?php 
			    		if(!empty($assignment_det['grade_id'][$presenter_id])){
			    			$assign_grade = explode(',', $assignment_det['grade_id'][$presenter_id]);
			    		}else{
			    			$assign_grade = array();
			    		}
			    		foreach ($grade_list as $gradekey => $gradevalue) 
			    		{
			    		?>
			    			<option value="<?php echo $gradevalue['grade_id']; ?>" <?php if(in_array($gradevalue['grade_id'], $assign_grade)) echo 'selected'; ?> ><?php echo $gradevalue['grade_name']; ?></option>
			    		<?php
			    		}
			    		?>
			    	</select>
		    	</div>
		    </div>
			<div class="col-sm-2">
				<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
				<button type="button" class="btn btn-primary" id="assignbtn_<?php echo $presenter_id; ?>"  onclick=assignHoursSingle(<?php echo $presenter_id; ?>);>Assign</button>
				<button type="button" class="btn btn-primary" id="spinner_btn_<?php echo $presenter_id; ?>" style="display:none;">Please wait<i class="fa fa-spinner fa-spin" style="margin-left: 5px;"></i></button>
			</div>
		</div>
    <?php
    	} 
    ?>

		<div class="form-group">
			<div class="col-sm-6">
			</div>
    	</div>

		<div class="form-group">
			<div class="col-sm-6">
			</div>
    	</div>

		<div class="form-group">
			<div class="col-sm-6">
			</div>
    	</div>


     	<div class="form-group">
    	<div class="col-sm-6">
			<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
			<!-- <a href="<?php echo base_url('app/orders');?>"><button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button> </a> -->
			<div class="pull-right">
			<button type="submit" id="assign_hours" class="btn btn-primary ">Assign Hours</button>or <a href="<?php echo base_url('app/orders');?>" >Cancel</a>
		</div>
	         
    	</div>
    </div>
    <?php	
	}
	else
	{
    ?>
    <div class="col-sm-6">No data available ...</div>
    <?php
    }
    ?>
    </fieldset>	

	<?php echo form_close();?>
</div>

<div id="loader_img1" style="display:none;"> </div>
<style type="text/css">
  #loader_img1 {
    position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?php echo base_url('assets/images/loader.gif'); ?>) center no-repeat #fff;
	opacity: .6;
  }
</style>

<script>
    $(function () {
        $("#assign_hours").click(function () {

            $("[type='checkbox']").each(function () {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
					/*
                    var txt = $(this).parent().next().find("input[type='text']").val();
                    if (txt == "") {
                        $(this).parent().siblings().eq(1).text("it is required!");
					}
					*/
					var pre_id = $(this).val();
                    $('#'+pre_id).val(pre_id);

					var txt = $(this).parent().siblings().next().find("input[type='number']").val();
					//alert(txt);
					

                }
            });
        });
		$('.presenter_chkbox').change(function () {
			var odrid = $(this).data('ordid');
            var presenter_id = $(this).data('presenter_id');
            var id = $(this).attr('id');
            // alert(id);
            jQuery.ajax({
                url: base_url+'app/orders/check_schedules',
                data: { odrid:odrid, presenter_id:presenter_id},
                type: 'post',
                dataType:'json',
                success: function (response) {
                    // alert(response); 
                    // alert(response[0].presenter_name);
                    // alert(response[0]);
                    // response = JSON.parse(response);
                    // alert(response.presenter_name);
                    // console.log("pre id is: " + response.presenter_name);
                    // $(response).each(function(index, value) { 
                    //  alert(value.total_hours_scheduled);
                    // });
                    if(response != 0){
                        alert(response.presenter_name+"has already scheduled "+response.total_hours_scheduled+" hrs for this order.");
                        $('#presenter_chkbox_'+presenter_id).prop('checked', true);
                    }
                }
            });
		});
		//checking for invoice , if presenter already submitted the invoice.
        // $('.check_invoice').change(function () {
        //     // alert('works?'); die();
        //     var odrid = $(this).data('ordid');
        //     var presenter_id = $(this).data('presenter_id');
        //     // var id = $(this).attr('id');
        //     // // alert(id);
        //     jQuery.ajax({
        //         url: base_url+'app/orders/check_submit_invoice',
        //         data: { odrid:odrid, presenter_id:presenter_id},
        //         type: 'post',
        //         success: function (response) {
        //             // alert(response); die();
        //             if(response != 0){
		// 				alert(response+" has already submitted the invoice for this order.");
        //                 window.location.href=base_url+'app/orders/assign_hours/'+odrid;
        //             }
        //         }
        //     });
        // });
    });

	function assignHoursSingle(presenter_id) {
		// jQuery('#loader_img1').show();
		// loader on button
		$('#assignbtn_'+presenter_id).css("display","none");
		$('#spinner_btn_'+presenter_id).css("display","block");
		var assign_hours = $('#assign_hours_'+presenter_id).val();
		if($("#presenter_chkbox_"+presenter_id).prop('checked') && assign_hours != ''){
			var order_id = $('#order_id').val();
			var assign_hours = $('#assign_hours_'+presenter_id).val();
			var grade = $('#grade_'+presenter_id).val();
			$.ajax({
				url: base_url+'app/orders/assign_hours_specific',
				data: { presenter_id:presenter_id , order_id:order_id , assign_hours:assign_hours , grade:grade },
				type: 'post',
				async: true,
				// beforeSend: function() {
				// 	$('#loader_img1').show();
				// },
				success: function (response) {
					// $('#loader_img1').hide();
					// loader on button
					$('#assignbtn_'+presenter_id).css("display","block");
					$('#spinner_btn_'+presenter_id).css("display","none");
					if(response.assignForOneHour == 5){
						alert('Oops! 1 hour can only be given if left hour will be 1.');
						var g = response.grade_id;
						var arrg = g.split(',');
						$('#assign_hours_'+presenter_id).val(response.assigned_hours);
						if(g == ''){
							$('#grade_'+presenter_id).val([]);
						}else{
							$('#grade_'+presenter_id).val(arrg);
						}
						$('#presenter_chkbox_'+presenter_id).prop('checked', true);

					}else if(response == 13){
						alert('Oops! 1 hour can only be given if left hour will be 1.');
						$('#assign_hours_'+presenter_id).val('');
						$('#grade_'+presenter_id).val([]);
						$('#presenter_chkbox_'+presenter_id).prop('checked', false);
					}else if(response == 6){
						alert('Oops! Total submitted hours are more than allowed hours for the order.');
						// $('#assign_hours_'+presenter_id).val('');
						// $('#grade_'+presenter_id).val([]);
						// $('#presenter_chkbox_'+presenter_id).prop('checked', false);
					}else if(response.assigndetailsOfExists == 12){
						alert('Oops! Total submitted hours are more than allowed hours for the order.');
						var g = response.grade_id;
						var arrg = g.split(',');
						$('#assign_hours_'+presenter_id).val(response.assigned_hours);
						if(g == ''){
							$('#grade_'+presenter_id).val([]);
						}else{
							$('#grade_'+presenter_id).val(arrg);
						}
						$('#presenter_chkbox_'+presenter_id).prop('checked', true);
					}else if(response.toCheckScheduleHours == 11){
						alert(response.presenter_name+' has already scheduled '+response.schedule_hours+' hrs for this order.');
						var g = response.gradeIds;
						var arrg = g.split(',');
						$('#assign_hours_'+presenter_id).val(response.schedule_hours);
						$('#grade_'+presenter_id).val(arrg);
						$('#presenter_chkbox_'+presenter_id).prop('checked', true);
					}else if(response == 9){
						alert('Something went wrong.');
					}else if(response.tocheckExistence == 10){
						alert('Well done! Hours are successfully assigned to presenter(s).');
						var g = response.grade_id;
						var arrg = g.split(',');
						$('#assign_hours_'+presenter_id).val(response.assigned_hours);
						if(g == ''){
							$('#grade_'+presenter_id).val([]);
						}else{
							$('#grade_'+presenter_id).val(arrg);
						}
						
						
						$('#presenter_chkbox_'+presenter_id).prop('checked', true);
						// var used_hrs = response.used_hours;
						$('.hideAfterClick').hide();
						$('.usdHrs').html(response.used_hours);
						$('.hideAtFirst').show();
						
					}else{
						alert('Something went wrong.');
					}
				}
			});
		}else if($("#presenter_chkbox_"+presenter_id).prop('checked') == false && assign_hours == ''){
			// alert('blank');
			var order_id = $('#order_id').val();
			jQuery.ajax({
                url: base_url+'app/orders/check_is_assigned',
				data: { presenter_id:presenter_id , order_id:order_id },
				type: 'post',
				async: true,
                success: function (response) {
                    $('#assignbtn_'+presenter_id).css("display","block");
					$('#spinner_btn_'+presenter_id).css("display","none");
					if(response.unassignHrs == 21){
						alert('The presenter has been successfully unassigned.');
						$('#assign_hours_'+presenter_id).val('');
						$('#grade_'+presenter_id).val([]);
						$('#presenter_chkbox_'+presenter_id).prop('checked', false);
						$('.hideAfterClick').hide();
						$('.usdHrs').html(response.used_hours);
						$('.hideAtFirst').show();
					}else{
						alert('Oops! The "assign hour(s)" field cannot be zero or empty and also the presenter name must be selected as respectively for the "assigned hour(s)" field.');
						$('#assign_hours_'+presenter_id).val('');
						$('#grade_'+presenter_id).val([]);
						$('#presenter_chkbox_'+presenter_id).prop('checked', false);
					}
                }
            });

			
		}else{
			var order_id = $('#order_id').val();
			jQuery.ajax({
                url: base_url+'app/orders/get_hrs',
				data: { presenter_id:presenter_id , order_id:order_id },
				type: 'post',
				async: true,
                success: function (response) {
                    $('#assignbtn_'+presenter_id).css("display","block");
					$('#spinner_btn_'+presenter_id).css("display","none");
					if(response == 22){
						alert('Oops! The "assign hour(s)" field cannot be zero or empty and also the presenter name must be selected as respectively for the "assigned hour(s)" field.');
						$('#assign_hours_'+presenter_id).val('');
						$('#grade_'+presenter_id).val([]);
						$('#presenter_chkbox_'+presenter_id).prop('checked', false);
					}else{
						alert('Oops! The "assign hour(s)" field cannot be zero or empty and also the presenter name must be selected as respectively for the "assigned hour(s)" field.');
						var g = response.grade_id;
						var arrg = g.split(',');
						$('#assign_hours_'+presenter_id).val(response.assigned_hours);
						if(g == ''){
							$('#grade_'+presenter_id).val([]);
						}else{
							$('#grade_'+presenter_id).val(arrg);
						}
						$('#presenter_chkbox_'+presenter_id).prop('checked', true);
					}
                }
            });
		}
		

	}

	$( "#button" ).click(function() {
        $( "#item" ).toggle();
    });

     function resetForm(){
        $('#presenter_idFilter').val('');
		var order_id = $('#order_id').val();
        // $("#order-search-form").submit();
		window.location.href = base_url+"App/orders/assign_hours/"+order_id;
    }

	function getPresenterFilter(pid){
		var order_id = $('#order_id').val();
		window.location.href = base_url+"App/orders/assign_hours_filters/"+order_id+"/"+pid;
	}
	
</script>

