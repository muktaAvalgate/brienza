<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-object-align-bottom"></span> Manage Titles &raquo; </small></h1>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Titles</li>
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
		echo form_open_multipart(base_url('app/schools/titles/'), $attributes);
    ?>
	<div class="col-sm-12">
		<fieldset>
    		<legend>Basic Info</legend>

			<?php if ($this->session->userdata('role') == "administrator") {?>
			<div class="form-group">
		  		<label for="inputSchool" class="col-sm-2 control-label">School *</label>
		  		<div class="col-sm-4">
					<select name="school_id" class="form-control" id="inputSchool" required onchange="changeSchoolTitle(this.value)">
						<option value="" selected>Select School</option>
						<?php foreach ($schools as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($school_id == $item->id) {echo "selected";}?>><?php echo $item->meta['school_name'];?></option>
						<?php }?>
					</select>
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
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="titles[]" <?php if(isset($school_titles[$title->id])) {echo "checked";}?> value="<?php echo $title->id;?>"> <?php echo $title->name;?>
									</label>
								</div>
							</div>
							<?php if ($title->grade_teachers == 1) {?>
								<?php if(isset($school_titles[$title->id])) { ?>
									<div class="form-group col-sm-10">
										<div class="help-block with-errors"></div>
										<?php foreach ($titleData as $tkey => $tval) {
											foreach ($tval as $ikey => $ival) { 
											if($ival['title_id'] == $title->id){ 
											?>
										<div class="col-sm-5">
											<?php echo ($ival['grade_name']!='')?$ival['grade_name']:'--' ?>
										</div>
										<div class="col-sm-5">
											<?php echo ($ival['teacher_name']!='')?$ival['teacher_name']:'--' ?>
										</div>
									<?php }}} ?>

										<div class="help-block with-errors"></div>
									</div>
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
							<?php } else {?>
								<div class="form-group col-sm-10" style="height:40px;"></div>
							<?php }?>
						</div>	
						<p class="help-block"></p>
					<?php }?>
				</div>
			</div>

			<p>&nbsp;</p>

		  	<div class="form-group">
				<div class="col-sm-2"></div>
				<div class="col-sm-10">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save</button> 
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
});

function changeSchoolTitle(school_id) {
	if (school_id != "") {
		location.href = base_url + "app/schools/titles/" + school_id;
	}
}
</script>
