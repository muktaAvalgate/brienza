<style>
.titles-list-filed{
    padding: 0px 2px;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/spectrum.css">
<script src="<?php echo base_url()?>assets/js/spectrum.js"></script>

<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-building"></span> Add New School</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="fa fa-building"></span> Schools');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Add New School');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/schools');?>">School Management</a></li>
		<li class="active">Add New School</li>
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

		$attributes = array('class' => 'form-horizontal', 'id' => 'addTitle', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/schools/add'), $attributes);
      ?>
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Basic Info</legend>

			<div class="row">
							
								
				<div class="form-group col-sm-10 basic-info-area">
			
					<div class="form-group">
						<label for="inputName" class="col-sm-3 control-label">School Name *</label>
						<div class="col-sm-7">
							<input type="text" name="meta[school_name]" class="form-control" id="inputName" placeholder="Enter school name" value="<?php echo set_value('meta[school_name]'); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="inputName" class="col-sm-3 control-label">Principal *</label>
						<div class="col-sm-7">
							<input type="text" name="meta[principal_name]" class="form-control" id="inputName" placeholder="Enter principal name" value="<?php echo set_value('meta[principal_name]'); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail" class="col-sm-3 control-label">Email  *</label>
						<div class="col-sm-7">
							<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email" value="<?php echo set_value('email'); ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"  title="example@gmail.com">
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inpuContact" class="col-sm-3 control-label">First Name *</label>
						<div class="col-sm-7">
							<input type="text" name="first_name" class="form-control" id="inpuContact" placeholder="Enter first name" value="<?php echo set_value('first_name');?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="inpuContact" class="col-sm-3 control-label">Last Name *</label>
						<div class="col-sm-7">
							<input type="text" name="last_name" class="form-control" id="inpuContact" placeholder="Enter last name" value="<?php echo set_value('last_name');?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inpuPhone" class="col-sm-3 control-label">Phone *</label>
						<div class="col-sm-7">
							<input type="text" name="meta[phone]" class="form-control" id="inpuPhone" placeholder="Enter phone" maxlength="10" data-minlength="10" value="<?php echo set_value('meta[phone]');?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputAddress" class="col-sm-3 control-label">Address *</label>
						<div class="col-sm-7">
							<textarea name="meta[address]" class="form-control" id="inputAddress" placeholder="Enter address" required><?php echo set_value('meta[address]');?></textarea>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inpuCity" class="col-sm-3 control-label">City *</label>
						<div class="col-sm-7">
							<input type="text" name="meta[city]" class="form-control" id="inpuCity" placeholder="Enter city" value="<?php echo set_value('meta[city]'); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inpuState" class="col-sm-3 control-label">State *</label>
						<div class="col-sm-7">
							<input type="text" name="meta[state]" class="form-control" id="inpuState" placeholder="Enter state" value="<?php echo set_value('meta[state]')?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="inpuZip" class="col-sm-3 control-label">Zip code *</label>
						<div class="col-sm-7">
							<input type="text" name="meta[zip]" class="form-control" id="inpuZip" placeholder="Enter Zip code" value="<?php echo set_value('meta[zip]')?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="inpuBeds" class="col-sm-3 control-label">BEDS</label>
						<div class="col-sm-7">
							<input type="text" name="meta[beds]" class="form-control" id="inpuBeds" placeholder="Enter BEDS" value="<?php echo set_value('meta[beds]')?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="inpuNpsis" class="col-sm-3 control-label">NPSIS</label>
						<div class="col-sm-7">
							<input type="text" name="meta[npsis]" class="form-control" id="inpuNpsis" placeholder="Enter NPSIS" value="<?php echo set_value('meta[npsis]')?>" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>

					<div class="form-group">
						<label for="inputSchool" class="col-sm-3 control-label">Holiday Schedule *</label>
						<div class="col-sm-7">
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
								<input type="radio" name="status" id="checkboxActive" value="active" checked>
								Active
							</label>
							</div>
							<div class="radio">
							<label for="checkboxinactive">
								<input type="radio" name="status" id="checkboxinactive" value="inactive" >
								In-active
							</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<button type="submit" class="btn btn-primary" id="school-sbmit-btn"><span class="glyphicon glyphicon-ok-sign"></span> Save School</button> or <a href="<?php echo base_url('app/schools');?>">Cancel</a>
						</div>
					</div>
				</div>
			</div>
			
			<!-- <div class="form-group">
		  		<label for="inpuContact" class="col-sm-3 control-label">Contact Person</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="first_name" class="form-control" id="inpuContact" placeholder="Enter contact person" value="<?php //echo isset($school->first_name) ? $school->first_name : '';?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div> -->
			
		  	<!-- <div class="form-group">
		  		<div class="col-sm-offset-3 col-sm-6">
			  		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save School</button> or <a href="<?php //echo base_url('app/schools');?>">Cancel</a>
			  	</div>
		  	</div> -->
    	</fieldset>
	</div>


	
	<div class="col-sm-6">

      	<fieldset>
    		<legend>Participants</legend>
			<div class="row">
							
								
								<div class="form-group col-sm-10 Participants-area">
									<div class="col-sm-4 titles-list-filed
">
									
									<select class="form-control form-control-Participants"  name= "participant_type[]">
									
										<option value="">Select Participant Type</option>
											<?php foreach($plist as $key => $participant) {?>
											<option value="<?php echo $participant->id;?>"><?php echo $participant->name;?></option>
										<?php } ?>
									</select>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-4 titles-list-filed
">
									<select class="form-control form-control-grades" name="grades_type[]">
										<option value="">Select Grade</option>
											<?php foreach($grades as $key => $grade) {?>
											<option value="<?php echo $grade->id;?>"><?php echo $grade->name;?></option>
										<?php } ?>
									</select>
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-3 titles-list-filed
">
										<input type="text" class="form-control form-control-Participants" name="teacher[]" placeholder="Enter a participant" value="">
										<div class="help-block with-errors"></div>
									</div>
									<div class="col-sm-1 titles-list-filed">
										<button type="button" class="btn btn-default addButton"><i class="glyphicon glyphicon-plus"></i></button>
									</div>
								</div>


								<!-- Template for row !!DO NOT DELETE!! -->
								<div class="template hide">
									
										<div class="col-sm-4 titles-list-filed">
										<select class="form-control form-control-Participants"  name= "participant_type[]" >
										<option value="">Select Participant Type</option>
											<?php foreach($plist as $key => $participant) {?>
											<option value="<?php echo $participant->id;?>"><?php echo $participant->name;?></option>
										<?php } ?>
									</select>
											<div class="help-block with-errors"></div>
										</div>

										<div class="col-sm-4 titles-list-filed
">
										<select class="form-control form-control-grades" name="grades_type[]">
											<option value="">Select Grade</option>
												<?php foreach($grades as $key => $grade) {?>
												<option value="<?php echo $grade->id;?>"><?php echo $grade->name;?></option>
											<?php } ?>
										</select>
											<div class="help-block with-errors"></div>
										</div>
										<div class="col-sm-3 titles-list-filed
">
											<input type="text" class="form-control form-control-Participants" name="teacher[]" placeholder="Enter a participant" >
											<div class="help-block with-errors"></div>
										</div>
									
								</div>
		</fieldset>
	</div>
							
								
				
				
	
	
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
		console.log(jQuery(template).html());
		var wrapper = jQuery(this).parent().parent().parent();
		
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            jQuery(wrapper).append('<div class="col-sm-2"></div><div class="form-group col-sm-10 col-md-offset-2">' + jQuery(template).html() + '<div class="col-sm-1 titles-list-filed"><button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button></div></div></div>'); 
			//add input box
        }
		
		jQuery(".removeButton").on("click", function(e){ //user click on remove text
			e.preventDefault(); jQuery(this).parent().parent().remove(); x--;
		})
    });
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
	
	jQuery('#').on('click', function(e){
		if(jQuery('input[type=checkbox]').is(':checked')){
			jQuery('.checkbox').parent().removeClass('has-error has-danger');
		}else{
			jQuery('.checkbox').parent().addClass('has-error has-danger');
		}

		e.preventDefault();
		jQuery.ajax({
			//url: base_url+'app/schools/grade_teachers_validation',
			data: $("#addTitle").serialize(),
			type: 'post',
			dataType:'json',
			success: function (response) {
				// alert(response);
				if(response == 1){
					$('#addTitle').submit();
				}else{
					alert('Please enter at least one grade & teacher for the selected title.');
					return false;
				}
			}
		});
	});
});
</script>