<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-time"></span> Edit Payment Schedule</h1>
        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-time"></span> Payment Schedules');?></li>
				<li><a href="<?php echo base_url('app/payroll/payment_schedules_add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add Payment Schedule</a></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/payroll');?>">Payment Schedule Management</a></li>
		<li class="active">Edit Payment Schedule</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open_multipart(base_url('app/payroll/payment_schedules_edit/'.$id), $attributes);
      ?>
      
	<div class="col-sm-8">

      	<fieldset>
    		<legend>Schedule Info</legend>
			
		  	<div class="form-group">
		  		<label for="inputName" class="col-sm-3 control-label">Session Period Start Date *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="session_from" class="form-control" id="session_from_fixed" placeholder="Enter Session Start date" value="<?php echo (!empty($schedule['session_from'])) ? date('m/d/Y', strtotime($schedule['session_from'])) : date('m/d/Y'); ?>" readonly required />
		  			<div class="help-block with-errors"></div>
		  		</div>
		  		<!-- <div class="col-sm-4">
		  			<input type="text" name="session_to" class="form-control" id="session_to" placeholder="Enter Session End date" value="<?php //if(!empty($schedule['session_to'])) //echo $schedule['session_to']; ?>" required>
		  			<div class="help-block with-errors"></div>
		  		</div>	 -->	  		
		  	</div>
			
		  	<div class="form-group">
		  		<label for="session_from" class="col-sm-3 control-label">Session Period End Date *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="session_to" class="form-control" id="session_to_fixed" placeholder="Enter Session End date" value="<?php echo (!empty($schedule['session_to'])) ? date('m/d/Y', strtotime($schedule['session_to'])) : date('m/d/Y'); ?>" readonly required />
		  			<div class="help-block with-errors"></div>
		  		</div>		  		
		  	</div>

			<div class="form-group">
		  		<label for="inputEmail" class="col-sm-3 control-label">Billing Date  *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="billing_date" class="form-control calender-control" id="billing_date" placeholder="Enter Billing Date" value="<?php if($schedule['billing_date'] != '0000-00-00'){echo date('m/d/Y', strtotime($schedule['billing_date']));} ?>" required />
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>
			
			<div class="form-group">
		  		<label for="inpuPhone" class="col-sm-3 control-label">Payment Date *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="payment_date" class="form-control calender-control" id="payment_date" placeholder="Enter Payment Date" value="<?php if($schedule['payment_date'] != '0000-00-00'){echo date('m/d/Y', strtotime($schedule['payment_date']));} ?>" required />
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>

			<div class="form-group">
		  		<label for="inpuPhone" class="col-sm-3 control-label">Reminder Email Date *</label>
		  		<div class="col-sm-7">
		  			<input type="text" name="email_remonder_date" class="form-control calender-control" id="email_remonder_date" placeholder="Enter Email Reminder Date" value="<?php if($schedule['email_remonder_date'] != '0000-00-00'){echo date('m/d/Y', strtotime($schedule['email_remonder_date']));} ?>" required />
		  			<div class="help-block with-errors"></div>
		  		</div>
		  	</div>		  	

			<p>&nbsp;</p>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-6">
					<button type="submit" class="btn btn-primary" onclick="return dateValidate();"><span class="glyphicon glyphicon-ok-sign"></span> Save Payment Schedule</button> or <a href="<?php echo base_url('app/payroll');?>">Cancel</a>
				</div>
			</div>			

    	</fieldset>
	</div>

	<?php echo form_close();?>
</div>

<script type="text/javascript">
	$("input[type=text]").keypress(function(event){
	      event.preventDefault();
	});
	function dateValidate(){
		var sessionEndDate = new Date($('#session_to_fixed').val());
		var emailRemonderDate = new Date($('#email_remonder_date').val());
		var billingDate = new Date($('#billing_date').val());
		var paymentDate = new Date($('#payment_date').val());
		var currentDate = new Date();
		if(sessionEndDate >= billingDate){
			alert('Billing date must be greater than session period end date.');
			$('#billing_date').focus();
			return false;
		}else if(sessionEndDate >= paymentDate){
			alert('Payment date must be greater than session period end date.');
			$('#payment_date').focus();
			return false;
		}else if(sessionEndDate >= emailRemonderDate){
			alert('Reminder email date must be greater than session period end date.');
			$('#email_remonder_date').focus();
			return false;
		}else if(billingDate >= paymentDate){
			alert('Payment date must be greater than billing date.');
			$('#payment_date').focus();
			return false;
		}else if(emailRemonderDate >= billingDate){
			alert('Billing date must be greater than reminder email date.');
			$('#billing_date').focus();
			return false;
		}else if(currentDate >= billingDate){
			alert('Billing date must be greater than current date.');
			$('#billing_date').focus();
			return false;
		}else if(currentDate >= paymentDate){
			alert('Payment date must be greater than current date.');
			$('#payment_date').focus();
			return false;
		}else{
			return true;
		}
		return true;
	}
</script>