<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-education"></span> Create New Title</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-education"></span> Titles');?></li>
				<li class="active"><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Title');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/titles');?>">Titles</a></li>
		<li class="active">Create Title</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/titles/add/'), $attributes);
   	?>

	<div class="col-sm-6">

      	<fieldset>
			<legend>Basic Info</legend>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo set_value('name'); ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inputTopic" class="col-sm-3 control-label">Grades and Teachers</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxRequired">
					    <input type="radio" name="grade_teachers" id="checkboxRequired" value="1" <?php if(set_value('grade_teachers') != "0") echo "checked";?>>
					    Required
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxNotRequired">
					    <input type="radio" name="grade_teachers" id="checkboxNotRequired" value="0" <?php if(set_value('grade_teachers') == "0") echo "checked";?>>
					    Not Required
					  </label>
					</div>
			  	</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="" class="col-sm-3 control-label">Status</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxActive">
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if(set_value('status') != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if(set_value('status') == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>
			
			<div class="form-group">
                <label for="" class="col-sm-3 control-label">Public School Title</label>
                <div class="col-sm-7" style="top: 7px">
                    <input type="checkbox" id="" name="public_school_title" value="checked">
                </div>
            </div>
			
			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Title</button> or <a href="<?php echo base_url('app/titles');?>">Cancel</a>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-6">

		<fieldset>
    		<legend>Other Info</legend>    		
			<div class="form-group input_fields_wrap">
		  		<label for="inputTopic" class="col-sm-1 control-label">Topic</label>
		  		<div class="col-sm-11">
					<div class="col-sm-5">
						<input type="text" id="limit" class="form-control" name="topics[]" placeholder="Enter a topic" value="" maxlength="50">
						<div class="help-block with-errors"></div>
					</div>
					<div class="col-sm-6">
						<textarea class="form-control" name="description[]" placeholder="Enter description" rows="1"></textarea>
						<div class="help-block with-errors"></div>
					</div>
					<div class="col-sm-1">
						<button type="button" class="btn btn-default addButton"><i class="glyphicon glyphicon-plus"></i></button>
					</div>
		  			<div class="help-block with-errors"></div>
		  		</div>
				
		  	</div>
    	</fieldset>

	</div>

	<?php echo form_close();?>
</div>
<script>
jQuery(document).ready(function() {
    var max_fields      = 1000; //maximum input boxes allowed
    var wrapper         = jQuery(".input_fields_wrap"); //Fields wrapper
    var add_button      = jQuery(".addButton"); //Add button ID
    
    var x = 1; //initlal text box count
    jQuery(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            jQuery(wrapper).append('<div class="col-sm-offset-1 col-sm-11"><div class="col-sm-5"><input type="text" id="limit_plus"  class="form-control" name="topics[]" placeholder="Enter a topic" maxlength="50" value=""><div class="help-block with-errors"></div></div><div class="col-sm-6"><textarea class="form-control" name="description[]" placeholder="Enter description" rows="1"></textarea><div class="help-block with-errors"></div></div><div class="col-sm-1"><button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button></div><div class="help-block with-errors"></div></div>'); 
			//add input box
        }
		$("#limit_plus").on('input', function() {
			if($(this).val().length >=50) {
				alert('Oops! The character limit for a topic is 50.');       
			}
		});
    });
    
    jQuery(wrapper).on("click",".removeButton", function(e){ //user click on remove text
        e.preventDefault(); jQuery(this).parent('div').parent('div').remove(); x--;
    })
});
$("#limit").on('input', function() {
    if($(this).val().length >=50) {
        alert('Oops! The character limit for a topic is 50.');       
    }
});
</script>