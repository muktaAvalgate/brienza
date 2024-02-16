<div class="subnav">
	<div class="container-fluid">
		<h1><span class="glyphicon glyphicon-education"></span> Edit  Title &raquo; <small> <?php echo $title->name;?></small></h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><?php echo render_link('index', '<span class="glyphicon glyphicon-education"></span>  Titles');?></li>
				<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Title');?></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/titles');?>">Titles</a></li>
		<li class="active">Edit Title</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/titles/edit/'.$title->id), $attributes);
   	?>

	<div class="col-sm-6">

		<fieldset>
    		<legend>Basic Info</legend>

			<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Name *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="name" class="form-control" id="inputName" placeholder="Enter name" value="<?php echo $title->name; ?>" required >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			  	<input type="hidden" id="getTitleId" value="<?php echo $title->id; ?>" >
				<input type="hidden" id="get_grade_teachers" value="<?php echo $title->grade_teachers; ?>" >
			<div class="form-group">
		  		<label for="inputTopic" class="col-sm-3 control-label">Grades and Teachers</label>
		  		<div class="col-sm-7">
			  		<div class="radio">
					  <label for="checkboxRequired">
					    <input type="radio" name="grade_teachers" id="checkboxRequired" value="1" <?php if($title->grade_teachers != "0") echo "checked";?>>
					    Required
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxNotRequired">
					    <input type="radio" name="grade_teachers" id="checkboxNotRequired" value="0" <?php if($title->grade_teachers == "0") echo "checked";?>>
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
					    <input type="radio" name="status" id="checkboxActive" value="active" <?php if($title->status != "inactive") echo "checked";?>>
					    Active
					  </label>
					</div>
					<div class="radio">
					  <label for="checkboxinactive">
					    <input type="radio" name="status" id="checkboxinactive" value="inactive" <?php if($title->status == "inactive") echo "checked";?>>
					    In-active
					  </label>
					</div>
				</div>
			</div>

			<div class="form-group">
                <label for="" class="col-sm-3 control-label">Public School Title</label>
                <div class="col-sm-7" style="top: 7px">
                    <input type="checkbox" id="" name="public_school_title" value="checked" <?php if($title->public_school_title_status != "unchecked") echo "checked";?>>
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
				<?php if (empty($title->topics)) {?>
					<div class="col-sm-11">
						<div class="col-sm-5">
							<input type="hidden" class="form-control" name="topic_title_id[]" value="new">
							<input type="text" class="form-control" name="topics[]" placeholder="Enter a topic" value="" maxlength="50" id="limit">
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
				<?php } else { ?>
					<?php $i=0;?>
					<?php foreach($title->topics as $key=>$value) {?>
						<div class="col-sm-11 <?php if ($i>0) {?>col-sm-offset-1<?php }?>">
							<div class="col-sm-5">
								<input type="hidden" class="form-control" name="topic_title_id[]" value="<?php echo $value->id;?>">
								<input type="text" class="form-control" name="topics[]" placeholder="Enter a topic" value="<?php echo $value->topic;?>"  id="limit_<?php echo $i;?>" maxlength="50" onkeyup="limitcheck('<?php echo $i;?>')">
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-sm-6">
								<textarea class="form-control" name="description[]" placeholder="Enter description" rows="1"><?php echo $value->description;?></textarea>
								<div class="help-block with-errors"></div>
							</div>
							<div class="col-sm-1">
								<?php if ($i == 0) {?>
									<button type="button" class="btn btn-default addButton"><i class="glyphicon glyphicon-plus"></i></button>
								<?php } else {?>
									<button type="button" class="btn btn-default removeButton" onclick="removeTopic(<?php echo $value->id ?>);" ><i class="glyphicon glyphicon-minus"></i></button>
								<?php }?>
							</div>
							<div class="help-block with-errors"></div>
						</div>
						<?php $i++;?>
					<?php }?>
				<?php }?>
		  	</div>
		</fieldset>
		
		<fieldset>
    		<legend>Audit Info</legend>
    		<p>
    			<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
		    	<?php if (!is_null($title->updated_on)) {?>
			    	<small><?php echo datetime_display($title->updated_on);?></small>
			    	by <small><?php echo $title->updated_by_name;?></small>
		    	<?php } else {echo "N/A";}?>
		    </p>

		    <p>
		    	<span class="glyphicon glyphicon-info-sign"></span> Created on:
		    	<?php if (!is_null($title->created_on)) {?>
			    	<small><?php echo datetime_display($title->created_on);?></small>
			    	by <small><?php echo $title->created_by_name;?></small>
			    <?php } else {echo "N/A";}?>
			</p>

			<p><a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')" href="<?php echo base_url('app/titles/delete/'.$title->id);?>"><span class="glyphicon glyphicon-trash"></span> Delete this Title</a></p>
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
            jQuery(wrapper).append('<div class="col-sm-offset-1 col-sm-11"><div class="col-sm-5"><input type="hidden" class="form-control" name="topic_title_id[]" value="new"><input type="text" class="form-control" name="topics[]" placeholder="Enter a topic" value="" id="limit_plus" maxlength="50"><div class="help-block with-errors"></div></div><div class="col-sm-6"><textarea class="form-control" name="description[]" placeholder="Enter description" rows="1"></textarea><div class="help-block with-errors"></div></div><div class="col-sm-1"><button type="button" class="btn btn-default removeButton"><i class="glyphicon glyphicon-minus"></i></button></div><div class="help-block with-errors"></div></div>'); 
			//add input box
        }
		$("#limit_plus").on('input', function() {
			if($(this).val().length >=50) {
				alert(' Oops! The character limit for a topic is 50.');       
			}
		});
    });
    
    jQuery(wrapper).on("click",".removeButton", function(e){ //user click on remove text
        e.preventDefault(); jQuery(this).parent('div').parent('div').remove(); x--;
    })
});
function removeTopic(id){
    // alert(id);
    // if(id==''){
    //  alert('no id');
    // }else{
    //  alert(id);
    // }
    $.ajax({
        type:'POST',
        url: base_url+"app/titles/remove_titles",
        dataType: "json",
        data:{id: id},
        success:function(response){
            
        }
    });
}

$("#limit").on('input', function() {
    if($(this).val().length >=50) {
        alert(' Oops! The character limit for a topic is 50.');       
    }
});
function limitcheck(i){
	var topicvalue = $('#limit_'+i).val();
	var topic_length = topicvalue.length;
	if(topic_length >= 50){
		alert(' Oops! The character limit for a topic is 50.'); 
	}
}

// Select the radio button by its ID
var radioBtn = document.getElementById("checkboxNotRequired");

// Add an event listener for the "click" event
radioBtn.addEventListener("click", function() {
	var grade_teachers = $('#get_grade_teachers').val();
	if(grade_teachers == 0){
		$('#checkboxNotRequired').prop('checked', true);
	}else{
		// Code to execute when the radio button is clicked
		var title_id = $('#getTitleId').val();
		$('#checkboxNotRequired').prop('checked', false);
		$('#checkboxRequired').prop('checked', true);
		$.ajax({
			type:'POST',
			url: base_url+"app/titles/check_title_assigned_to_school",
			dataType: "json",
			data:{title_id: title_id},
			success:function(response){
				if(response == 1){
					alert('Oops!  This title cannot change to a not-required title as it is already assigned to a school.');
					// return false;
				}else{
					$('#checkboxNotRequired').prop('checked', true);
					// return true;
				}
			}
		});
	}
});

</script>
