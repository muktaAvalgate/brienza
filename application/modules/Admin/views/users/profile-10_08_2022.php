
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/spectrum.css">
<script src="<?php echo base_url()?>assets/js/spectrum.js"></script>


<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Update Profile &raquo; <small> <?php echo $user->first_name . " " . $user->last_name;?></small></h1>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Update Profile</li>
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

		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('admin/users/edit/'.$user->id), $attributes);
    ?>
    <input type="hidden" name="role_id" id="inputRole" data-token="<?php echo $user->role_token;?>" value="<?php echo $user->role_id;?>">
	<input type="hidden" name="email" value="<?php echo $user->email;?>">
	<input type="hidden" name="status" value="<?php echo $user->status;?>">
	<input type="hidden" name="ref" value="profile">

	<div class="col-sm-6">
		<fieldset>
    		<legend>Basic Info</legend>
	      	<div class="form-group">
		  		<label for="inputRole" class="col-sm-3 control-label">Role</label>
		  		<div class="col-sm-7">
		  			<p class="form-control-static"><?php echo $user->role_name;?></p>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Email address</label>
		  		<div class="col-sm-7">
			  		<p class="form-control-static" id="inputEmail"><?php echo $user->email;?></p>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>

		  	<?php if($user->role_id == '4'){ ?>
				<div class="form-group">
			  		<label for="inputName" class="col-sm-3 control-label"> School Name </label>
			  		<div class="col-sm-7">
			  			<p class="form-control-static" id="inputsName"><?php echo $user->meta['school_name'];?></p>
			  			<input type="hidden" name="meta[school_name]" class="form-control" id="inputName" placeholder="Enter name" value="<?php if(isset($user->meta['school_name'])) {echo $user->meta['school_name'];}?>" required>
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>

				<div class="form-group">
			  		<label for="inputSchool" class="col-sm-3 control-label">School Color </label>
			  		<div class="col-sm-7">
					    <input id="full" class="school_color" name="meta[school_color]" value="<?php echo isset($user->meta['school_color']) ? $user->meta['school_color'] : '#777474';?>" />
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>
		  	<?php } ?>
			
		  	<div class="form-group">
		  		<label for="inputFirstName" class="col-sm-3 control-label">First Name</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="first_name" class="form-control" id="inputFirstName" placeholder="Enter first name" value="<?php echo $user->first_name;?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="inputLastName" class="col-sm-3 control-label">Last Name</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="last_name" class="form-control" id="inputLastName" placeholder="Enter last name" value="<?php echo $user->last_name;?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		  		<label for="inputPassword" class="col-sm-3 control-label">Password</label>
		  		<div class="col-sm-7">
			  		<input type="password" name="password" data-minlength="6" class="form-control" id="inputPassword" placeholder="Enter password" >
			  		<div class="help-block with-errors">Please leave the password blank, if you don't want to update.</div>
			  	</div>
		  	</div>

		  	<div class="form-group">
		  		<label for="inputConfirmPassword" class="col-sm-3 control-label">Confirm Password</label>
		  		<div class="col-sm-7">
		  			<input type="password" name="c_password" class="form-control" id="inputConfirmPassword" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm password" >
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
		</fieldset>
	</div>
	<div class="col-sm-6">
		<fieldset>
    		<legend>Others Info</legend>
    		<?php
    		// echo "<pre>";print_r($user);
    // 		echo "<pre>";print_r($this->session->all_userdata());
				// print "<pre>"; print_r($user_meta); print_r($user->meta); print "</pre>";
    			foreach ($user_meta as $field) {

    				$field_name = $field['name'];
    				$value = '';
    				foreach ($user->meta as $meta_key=>$meta_value) {
    					//print "<pre>"; print_r($data); print "</pre>";
    					if (isset($meta_key) && $meta_key == $field_name) {
    						//$field_name."=".$data->ometa_key."<br>";
    						$value = $meta_value;
    					}
    				}
    				echo render_field($field, $value);
    			}
    		?>

		  	<?php if($user->role_id == '4'){ ?>
				<div class="form-group">
			  		<label for="inputSchool" class="col-sm-3 control-label">Holiday Schedule *</label>
			  		<div class="col-sm-7">
						<select name="meta[holiday_schedule_id]" class="form-control" id="inputSchool" required>
							<option value="" selected>Select Schedule</option>
							<?php foreach ($schedules as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if (isset($user->meta['holiday_schedule_id']) && $user->meta['holiday_schedule_id'] == $item->id) {echo "selected";}?>><?php echo $item->name;?></option>
							<?php }?>
						</select>
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>

				<div class="form-group">
			  		<label for="inputAddress" class="col-sm-3 control-label">Address</label>
			  		<div class="col-sm-7">
				  		<textarea name="meta[address]" class="form-control" id="inputAddress" placeholder="Enter address" ><?php if(isset($user->meta['address'])) {echo $user->meta['address'];}?></textarea>
				  		<div class="help-block with-errors"></div>
				  	</div>
			  	</div>
				
				<div class="form-group">
			  		<label for="inpuCity" class="col-sm-3 control-label">City</label>
			  		<div class="col-sm-7">
			  			<input type="text" name="meta[city]" class="form-control" id="inpuCity" placeholder="Enter city" value="<?php if(isset($user->meta['city'])) {echo $user->meta['city'];}?>" >
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>
				
				<div class="form-group">
			  		<label for="inpuState" class="col-sm-3 control-label">State</label>
			  		<div class="col-sm-7">
			  			<input type="text" name="meta[state]" class="form-control" id="inpuState" placeholder="Enter state" value="<?php if(isset($user->meta['state'])) {echo $user->meta['state'];}?>" >
			  			<div class="help-block with-errors"></div>
			  		</div>
			  	</div>
			  <?php } if($user->role_id == '3'){ ?>

			<div class="form-group">
		  		<label for="inputInfo" class="col-sm-3 control-label">Info</label>
		  		<div class="col-sm-7">
			  		<textarea name="meta[info]" class="form-control" id="inputInfo" placeholder="Enter info"><?php if(isset($user->meta['info'])) {echo $user->meta['info'];}?></textarea>
			  		<div class="help-block with-errors"></div>
			  	</div>
		  	</div>

			<div class="form-group">
		  		<label for="inpuRate" class="col-sm-3 control-label">Hourly Rate *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="meta[rate]" class="form-control" id="inpuRate" placeholder="Enter Rate" value="<?php if(isset($user->meta['rate'])) {echo $user->meta['rate'];}?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			   <?php } ?>
			
    	</fieldset>

    	<fieldset>
    		<legend>Audit Info</legend>
    		<p>
    			<span class="glyphicon glyphicon-info-sign"></span> Last Updated on:
		    	<?php if (!is_null($user->updated_on)) {?>
			    	<small><?php echo datetime_display($user->updated_on);?></small>
			    	by <small><?php echo $user->updated_by_name;?></small>
		    	<?php } else {echo "N/A";}?>
		    </p>

		    <p>
		    	<span class="glyphicon glyphicon-info-sign"></span> Created on:
		    	<?php if (!is_null($user->created_on)) {?>
			    	<small><?php echo datetime_display($user->created_on);?></small>
			    	by <small><?php echo $user->created_by_name;?></small>
			    <?php } else {echo "N/A";}?>
			</p>

		    <p>
		    	<span class="glyphicon glyphicon-info-sign"></span> Last Login on:
		    	<?php if (!is_null($user->last_login)) {?>
		    		<small><?php echo datetime_display($user->last_login);?></small>
		    	<?php } else {echo "N/A";}?>
		    </p>
    	</fieldset>

    	<p>&nbsp;</p>
    	<div class="form-group">
			<div class="col-sm-6">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save Profile</button>
			</div>
		</div>
	</div>
	<?php echo form_close();?>
</div>

<script type="text/javascript">
    
$(function() {

    $("#full").spectrum({
        allowEmpty:true,
        color: "<?php isset($user->meta['school_color']) ? $user->meta['school_color'] : '#777474';?>",
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
</script>