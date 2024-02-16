<style>
.disabledbutton {
    pointer-events: none;
    opacity: 0.6;
}
</style>
<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-education"></span> Manage Titles &raquo; </small><?php echo $school;?></h1>

    	 <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/teachers');?>"><span class="glyphicon glyphicon-education"></span> Titles</a></li>
				<li class="active"><a href="<?php echo base_url('app/schools/titles');?>"><span class="glyphicon glyphicon-plus-sign"></span> Assign Title</a></li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/teachers');?>">Manage Titles</a></li>
		<li class="active">Edit Titles</li>
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

		$attributes = array('class' => 'form-horizontal', 'id' => 'addTitleschl', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/teachers/edit/'.$this->uri->segment(4)), $attributes);
    ?>
	<div class="col-sm-12">
		<fieldset>
    		<legend>Basic Info</legend>

			<?php if ($this->session->userdata('role') == "administrator") {?>
			<div class="form-group">
		  		<label for="inputSchool" class="col-sm-2 control-label">School *</label>
		  		<div class="col-sm-4">
					<input type="text" class="form-control" name="school_id" value="<?php echo $school;?>" readonly="true" />
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			<?php } else {?>
			<input type="hidden" name="school_id" value="<?php echo $school_id;?>" />
			<?php }?>
			
			<div class="form-group">
				<label for="inputTitle" class="col-sm-2 control-label">Titles *</label>
				<div class="col-sm-6">
					<?php foreach($titles as $title) {?>
						<div class="row">
							<div class="col-sm-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="titleidCheckbox_<?php echo $title->id; ?>" onclick="assignTitle(<?php echo $title->id; ?>);" name="titles[]" <?php if(isset($school_titles[$title->id])) {echo "checked";}?> value="<?php echo $title->id;?>"> <?php echo $title->name;?>
										<input type="hidden" id="schoolId" value="<?php echo $school_id; ?>" >
									</label>
								</div>
							</div><br/><br/></div>
							<div class="row <?php if(!isset($school_titles[$title->id])) {echo "disabledbutton";}?>" id="show_teacher_grade_div<?php echo $title->id; ?>">
							<?php if ($title->grade_teachers == 1) {?>
								<?php if(isset($school_titles[$title->id])) { ?>
									<?php foreach ($titleData as $tkey => $tval) {
										foreach ($tval as $ikey => $ival) { 
											if($ival['title_id'] == $title->id){ 
											?>
									<div class="form-group col-sm-10">
										<div class="col-sm-5">
											<select class="form-control" name="grades[<?php echo $title->id;?>][]">
												<option value="">Select Grade</option>
												<?php foreach($grades as $key => $grade) {?>
												<option value="<?php echo $grade->id;?>" <?php echo ($grade->id == $ival['grade_id'])? "selected": ""?>><?php echo $grade->name;?></option>
												<?php }?>
											</select>
											<?php //echo ($ival['grade_name']!='')?$ival['grade_name']:'--' ?>
										</div>
										<div class="col-sm-5">
											<input type="text" class="form-control" name="teachers[<?php echo $title->id;?>][]" value="<?php echo $ival['teacher_name'];?>" />
											<?php //echo ($ival['teacher_name']!='')?$ival['teacher_name']:'--' ?>
										</div>
										<div class="col-sm-2">
											<button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button>
										</div>
										<div class="help-block with-errors"></div>
									</div>
								<?php }}} ?>

								<?php } ?>

								<div class="form-group col-sm-10">
									<div class="col-sm-5">
										<select class="form-control" name="grades[<?php echo $title->id;?>][]">
											<option value="">Select Grade</option>
											<?php foreach($grades as $key => $grade) {?>
											<option value="<?php echo $grade->id;?>"><?php echo $grade->name;?></option>
											<?php }?>
										</select>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-5">
										<input type="text" class="form-control" name="teachers[<?php echo $title->id;?>][]" placeholder="Enter a teacher" value="">
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-default addButton"><i class="glyphicon glyphicon-plus"></i></button>
									</div>
								</div>
								
								<!-- Template for row !!DO NOT DELETE!! -->
								<div class="template hide">
									
										<div class="col-sm-5">
											<select class="form-control" name="grades[<?php echo $title->id;?>][]" >
												<option value="">Select Grade</option>
												<?php foreach($grades as $key => $grade) {?>
												<option value="<?php echo $grade->id;?>"><?php echo $grade->name;?></option>
												<?php }?>
											</select>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-sm-5">
											<input type="text" class="form-control" name="teachers[<?php echo $title->id;?>][]" placeholder="Enter a teacher" value="">
											<div class="help-block with-errors"></div>
										</div>
									
								</div>
							<?php } ?>
						</div>	
						<p class="help-block"></p>
					<?php }?>
				</div>
			</div>

			<p>&nbsp;</p>

		  	<div class="form-group">
				<div class="col-sm-2"></div>
				<div class="col-sm-10">
					<button type="submit" class="btn btn-primary" id="school-sbmit-btn"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
					<?php if($this->session->userdata('role') == 'administrator'){ ?>
						 or <a href="<?php echo base_url('app/teachers');?>">Cancel</a>
					<?php } ?>
				</div>
		  	</div>

		</fieldset>

	</div>
	<?php echo form_close();?>
</div>
<script>
jQuery(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var add_button      = jQuery(".addButton"); //Add button ID
    
    var x = 1; //initlal text box count
    jQuery(add_button).click(function(e){ //on add input button click
    
        var template = jQuery(this).parent().parent().parent().find('.template');
        console.log(jQuery(template).html());
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
			data: $("#addTitleschl").serialize(),
			type: 'post',
			dataType:'json',
			success: function (response) {
				// alert(response);
				if(response == 1){
					$('#addTitleschl').submit();
				}else{
					alert('Please enter at least one grade & teacher for the selected title.');
					return false;
				}
			}
		});
	});
});

function changeSchoolTitle(school_id) {
	if (school_id != "") {
		location.href = base_url + "app/schools/titles/" + school_id;
	}
}

function assignTitle(title_id){
	var school_id = $('#schoolId').val();
	jQuery.ajax({
		url: base_url+'app/teachers/check_title_is_assigned',
		data: { title_id:title_id, school_id:school_id},
		type: 'post',
		dataType:'json',
		success: function (response) {
			// alert(response);
			if(response == 2){
				if(!$('#titleidCheckbox_'+title_id).prop('checked')){
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
