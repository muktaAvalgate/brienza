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
		<li class="active">Allocate hours [Hours ratio (Used hrs / Alloted Hrs) : <?php if(!empty($assignment_det['total_used_hours'])) echo $assignment_det['total_used_hours']; else echo '0'; ?> / <?php echo $alloted_hours; ?> ]</li>
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
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/orders/assign_hours/'.$this->uri->segment(4)), $attributes);
    ?>
  	<fieldset>
		<legend>Assignment Process</legend>
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
		    	</div>
		    </div>

		    <div class="col-sm-1">
		    	<div class="form-group">
		    		<?php echo $value['first_name']." ".$value['last_name']; ?>
		    	</div>
		    </div>
		    <div class="col-sm-2">
		    	<div class="form-group">
		    		<input class="form-control input-sm asgnHrs" type="number" name="assigned_hours[]" placeholder="Enter assign hour(s)" min="0" p_id="<?php echo $presenter_id; ?>" value="<?php if(!empty($assignment_det['assigned_hours'][$presenter_id])) echo $assignment_det['assigned_hours'][$presenter_id]; ?>" data-ordid="<?php echo $this->uri->segment(4); ?>" data-presenter_id="<?php echo $value['presenter_id']; ?>" >
		    	</div>
		    </div>
		    <div class="col-sm-2">
		    	<div class="form-group">
			    	<select class="form-control" name="grade[<?php echo $presenter_id ?>][]" multiple>
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
		</div>
    <?php
    	} 
    ?>
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
	
</script>

