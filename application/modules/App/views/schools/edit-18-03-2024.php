
<style>
.disabledbutton {
    pointer-events: none;
    opacity: 0.6;
}

.basic-info-input-box {
	width: 74.333333%;
}

.titles-list{
	padding: 0px 0px;
}

.titles-list-filed{
	padding: 0px 2px;
}

.form-horizontal .form-group{
	width: 100%;
}

</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/spectrum.css">
<script src="<?php echo base_url()?>assets/js/spectrum.js"></script>


<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-building"></span> Edit School &raquo; <small> <?php if(isset($school->meta['school_name'])) {echo $school->meta['school_name'];}?></small></h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/schools');?>"  title="Schools"><span class="fa fa-building"></span> Schools</a></li>
				<li><a href="<?php echo base_url('app/schools/add');?>"  title="Add New School"><span class="glyphicon glyphicon-plus-sign"></span> Add New School</a></li>
    		</ul>
        </div>
    </div>
</div>

			<?php 
			$url2 = array();
			if(isset($_SERVER['HTTP_REFERER'])){
				$url= $_SERVER['HTTP_REFERER']; 
				$url2=explode('/',$url);
			}
			if(isset($url2[7]))
			{
			$page='/index/page/'.$url2[7];
	     	}else{
	     		$page = '';
	     	}
			?>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/schools');?>">School Management</a></li>
		<li class="active">Edit School</li>
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

		$attributes = array('class' => 'form-horizontal', 'id' => 'editTitle', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/schools/edit/'.$school->id), $attributes);
    ?>
	<div class="col-sm-4">
		<fieldset>
    		<legend>Basic Info</legend>

			<div class="row">

    		<?php if($school->role_id == '4'){ ?>
				<input type="hidden" name="profile_pic" value="<?php if(isset($school->meta['profile_pic'])) {echo $school->meta['profile_pic'];}?>" >
			<?php } ?>

			<div class="form-group basic-info-list">
		  		<label for="inputName" class="col-sm-3 control-label"> School Name *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="text" name="meta[school_name]" class="form-control" id="inputName" placeholder="Enter name" value="<?php if(isset($school->meta['school_name'])) {echo $school->meta['school_name'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group basic-info-list">
				<label for="inputName" class="col-sm-3 control-label">Principal *</label>
                <div class="col-sm-7 basic-info-input-box">
                    <input type="text" name="meta[principal_name]" class="form-control" id="inputName" placeholder="Enter principal name" value="<?php if(isset($school->meta['principal_name'])) {echo $school->meta['principal_name'];}else{ echo 'N/A'; }?>" required>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
			
			<div class="form-group basic-info-list">
		  		<label for="inpuEmail" class="col-sm-3 control-label">Email *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="email" name="email" class="form-control" id="inpuEmail" placeholder="Enter email address" value="<?php echo $school->email; ?>" readonly>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group basic-info-list">
		  		<label for="inpuContact" class="col-sm-3 control-label">First Name *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="text" name="first_name" class="form-control" id="inpuContact" placeholder="Enter first name" value="<?php echo isset($school->first_name) ? $school->first_name : '';?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			<div class="form-group basic-info-list">
		  		<label for="inpuContact" class="col-sm-3 control-label">Last Name *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="text" name="last_name" class="form-control" id="inpuContact" placeholder="Enter last name" value="<?php echo isset($school->last_name) ? $school->last_name : '';?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
		  	
			<div class="form-group basic-info-list">
		  		<label for="inpuPhone" class="col-sm-3 control-label">Phone *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="number" name="meta[phone]" class="form-control" id="inpuPhone" placeholder="Enter phone" maxlength="10" data-minlength="10" value="<?php if(isset($school->meta['phone'])) {echo $school->meta['phone'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group basic-info-list">
		  		<label for="inputAddress" class="col-sm-3 control-label">Address *</label>
		  		<div class="col-sm-7 basic-info-input-box">
			  		<textarea name="meta[address]" class="form-control" id="inputAddress" placeholder="Enter address" required><?php if(isset($school->meta['address'])) {echo $school->meta['address'];}?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>
			
			<div class="form-group basic-info-list">
		  		<label for="inpuCity" class="col-sm-3 control-label">City *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="text" name="meta[city]" class="form-control" id="inpuCity" placeholder="Enter city" value="<?php if(isset($school->meta['city'])) {echo $school->meta['city'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group basic-info-list">
		  		<label for="inpuState" class="col-sm-3 control-label">State *</label>
		  		<div class="col-sm-7 basic-info-input-box">
		  			<input type="text" name="meta[state]" class="form-control" id="inpuState" placeholder="Enter state" value="<?php if(isset($school->meta['state'])) {echo $school->meta['state'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<!-- <div class="form-group">
		  		<label for="inpuContact" class="col-sm-3 control-label">Contact Person</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="first_name" class="form-control" id="inpuContact" placeholder="Enter contact person" value="<?php //echo $school->first_name;?>" >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div> -->

			  <div class="form-group">
		  		<label for="inputSchool" class="col-sm-3 control-label">Holiday Schedule *</label>
		  		<div class="col-sm-9">
					<select name="meta[holiday_schedule_id]" class="form-control" id="inputSchool" required>
						<option value="" selected>Select Schedule</option>
						<?php foreach ($schedules as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if (isset($school->meta['holiday_schedule_id']) && $school->meta['holiday_schedule_id'] == $item->id) {echo "selected";}?>><?php echo $item->name;?></option>
						<?php }?>
					</select>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			
			<div class="form-group">
		  		<label for="inputSchool" class="col-sm-3 control-label">School Color </label>
		  		<div class="col-sm-7">
				    <input id="full" class="school_color" name="meta[school_color]" value="<?php echo isset($school->meta['school_color']) ? $school->meta['school_color'] : '#777474';?>" />
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($school->status != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($school->status == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>

		  	<div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary" id="school-sbmit-btn"><span class="glyphicon glyphicon-ok-sign"></span> Save School</button> or <a href="<?php if(isset($page)) { echo base_url('app/schools'.$page); }else{ echo base_url('app/schools'); }?>">Cancel</a>
			  	</div>
		  	</div>
			
			  </div>
		</fieldset>
	</div>
	<div class="col-sm-5">

	<fieldset>
    		<legend>Participants</legend>
			<div class="row titles-list">
							
								
								<div class="form-group col-sm-10 Participants-area">
									<div class="col-sm-4 titles-list-filed">
									<select class="form-control form-control-Participants"  name= "participant_type[]">
									
										<option value="">Select Participant Type</option>
											<?php foreach($plist as $key => $participant) {?>
											<option value="<?php echo $participant->id;?>"><?php echo $participant->name;?></option>
										<?php } ?>
									</select>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-4 titles-list-filed">
									<select class="form-control form-control-grades" name="grades_type[]">
										<option value="">Select Grade</option>
											<?php foreach($grades as $key => $grade) {?>
											<option value="<?php echo $grade->id;?>"><?php echo $grade->name;?></option>
										<?php } ?>
									</select>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-3 titles-list-filed">
										<input type="text" class="form-control form-control-Participants" name="teacher[]" placeholder="Enter a teacher" value="">
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-1 titles-list-filed">
										<button type="button" class="btn btn-default addButton"><i class="glyphicon glyphicon-plus"></i></button>
									</div>
								</div>


								<!-- Template for row !!DO NOT DELETE!! -->
								<div class="template hide">
									
										<div class="col-sm-4 titles-list-filed">
										<select class="form-control form-control-Participants" name="participant_type[]">
										<option value="">Select Participant Type</option>
											<?php foreach($plist as $key => $participant) {?>
											<option value="<?php echo $participant->id;?>"><?php echo $participant->name;?></option>
										<?php } ?>
									</select>
											<div class="help-block with-errors"></div>
										</div>

										<div class="col-sm-4 titles-list-filed">
										<select class="form-control form-control-grades" name="grades_type[]">
											<option value="">Select Grade</option>
												<?php foreach($grades as $key => $grade) {?>
												<option value="<?php echo $grade->id;?>"><?php echo $grade->name;?></option>
											<?php } ?>
										</select>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-sm-3 titles-list-filed">
											<input type="text" class="form-control form-control-Participants" name="teacher[]" placeholder="Enter a teacher" value="">
											<div class="help-block with-errors"></div>
										</div>
									
								</div>
		</fieldset>

	</div>
	<div class="col-sm-3">
		<fieldset>
			<legend>Audit Info</legend>
			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
				<?php if (!is_null($school->updated_on)) {?>
					<small><?php echo datetime_display($school->updated_on);?></small>
					by <small><?php echo $school->updated_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p>
				<span class="glyphicon glyphicon-info-sign"></span> Created on:
				<?php if (!is_null($school->created_on)) {?>
					<small><?php echo datetime_display($school->created_on);?></small>
					by <small><?php echo $school->created_by_name;?></small>
				<?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the school?')" href="<?php echo base_url('app/schools/delete/'.$school->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this School</a></p>
		</fieldset>
	</div>
<!-- 	<div class="col-sm-2">
		
	</div> -->
	<?php echo form_close();?>
</div>


<script type="text/javascript">
    
 // ======== Start Code By Ahmed on 2019-09-25 ======= //
jQuery(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var add_button      = jQuery(".addButton"); //Add button ID
    
    var x = 1; //initlal text box count
    jQuery(add_button).click(function(e){ //on add input button click
	
		var template = jQuery(this).parent().parent().parent().find('.template');
		// console.log(jQuery(template).html());
		var wrapper = jQuery(this).parent().parent().parent();
		
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            jQuery(wrapper).append('<div class="form-group col-sm-10 col-md-offset-2">' + jQuery(template).html() + '<div class="col-sm-2"><button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button></div></div></div>'); 
			//add input box
        }
		jQuery(".removeButton").on("click", function(e){ //user click on remove text
			e.preventDefault(); jQuery(this).parent().parent().remove(); x--;
		})
		
    });
    
	jQuery(".removeButton").on("click", function(e){ //user click on remove text
		e.preventDefault(); jQuery(this).parent().parent().remove(); x--;
	})
});
 // ======== End of the 2019-09-25 ======= //

$(function() {

    $("#full").spectrum({
        allowEmpty:true,
        color: "<?php isset($school->meta['school_color']) ? $school->meta['school_color'] : '#777474';?>",
        showInput: true,
        containerClassName: "full-spectrum",
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        showAlpha: true,
        maxPaletteSize: 10,
        preferredFormat: "hex",
        localStorageKey: "spectrum.demo",
        move: function (color) {
            var hexColor = "#777474";
		    if(color) {
		        hexColor = color.toHexString();
		    }
		    $("#full.school_name").val(hexColor);
        },
        show: function () {

        },
        beforeShow: function () {

        },
        hide: function (color) {
            var hexColor = "#777474";
		    if(color) {
		        hexColor = color.toHexString();
		    }
		    $("#full.school_name").val(hexColor);
        },

        palette: [
            ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", /*"rgb(153, 153, 153)","rgb(183, 183, 183)",*/
            "rgb(204, 204, 204)", "rgb(217, 217, 217)", /*"rgb(239, 239, 239)", "rgb(243, 243, 243)",*/ "rgb(255, 255, 255)"],
            ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
            "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
            ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
            "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
            "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
            "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
            "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
            "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
            "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
            "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
            /*"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
            "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",*/
            "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
            "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
        ]
    });
});

jQuery(document).ready(function(){
	jQuery('input[type=checkbox]').on('click', function(e){
		if(jQuery(":checkbox:checked").length > 0){
			jQuery('.checkbox').parent().removeClass('has-error has-danger');
			jQuery("#school-sbmit-btn").attr("disabled", false);
		}else{
			jQuery('.checkbox').parent().addClass('has-error has-danger');
			jQuery("#school-sbmit-btn").attr("disabled", true);
		}
	});
	
	jQuery('#school-sbmit-btn').on('click', function(e){
		if(jQuery('input[type=checkbox]').is(':checked')){
			jQuery('.checkbox').parent().removeClass('has-error has-danger');
		}else{
			jQuery('.checkbox').parent().addClass('has-error has-danger');
		}

		e.preventDefault();
		jQuery.ajax({
			url: base_url+'app/schools/grade_teachers_validation',
			data: $("#editTitle").serialize(),
			type: 'post',
			dataType:'json',
			success: function (response) {
				// alert(response);
				if(response == 1){
					$('#editTitle').submit();
				}else{
					alert('Please enter at least one grade & teacher for the selected title.');
					return false;
				}
			}
		});
	});
});

	function assignTitle(title_id){
		var school_id = $('#schoolId').val();
		jQuery.ajax({
			url: base_url+'app/schools/check_title_is_assigned',
			data: { title_id:title_id, school_id:school_id},
			type: 'post',
			dataType:'json',
			success: function (response) {
				// alert(response);
				if(response == 2){
					if(!$('#titleidCheckbox_'+title_id).prop('checked')){
						// alert('This Title has Grade and teacher assigned to it. By clicking off the titlenand saving all these data will be lost.');
						if(confirm("This Title has Grade/s and Teacher/s assigned to it.\nBy Checking 'off' the Title all these data will be deleted.\n\n                                   Do you still want to proceed?")){
							$('#show_teacher_grade_div' + title_id ).addClass("disabledbutton");
						}else{
							$('#titleidCheckbox_'+title_id).prop('checked',true);
							jQuery('.checkbox').parent().removeClass('has-error has-danger');
							jQuery("#school-sbmit-btn").attr("disabled", false);
						}
					}else{
						$('#show_teacher_grade_div' + title_id ).removeClass("disabledbutton");
					}
				}else if(response == 3){
					if(!$('#titleidCheckbox_'+title_id).prop('checked')){
						if(confirm("Checking 'off' this 'Title' will remove the title from this School.\n\n                                   Do you still want to proceed?")){
						}else{
							$('#titleidCheckbox_'+title_id).prop('checked',true);
							jQuery('.checkbox').parent().removeClass('has-error has-danger');
							jQuery("#school-sbmit-btn").attr("disabled", false);
						}
					}
				}else{
					if(!$('#titleidCheckbox_'+title_id).prop('checked')){
                        $('#show_teacher_grade_div' + title_id).addClass("disabledbutton");
                    }else{
                        $('#show_teacher_grade_div' + title_id).removeClass("disabledbutton");
                    }
					return false;
				}
			}
		});

	}
</script>