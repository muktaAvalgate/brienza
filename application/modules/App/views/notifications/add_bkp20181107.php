<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-envelope"></span> Inbox</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/notifications');?>"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
    			<li <?php if($folder=="inbox") {echo "class='active'";}?>><a href="<?php echo base_url('app/notifications/add');?>"><span class="glyphicon glyphicon-pencil"></span> Compose</a></li>
				
				<?php if ($this->session->userdata('role') == 'administrator') {?>
				<li <?php if($folder=="announcement") {echo "class='active'";}?>><a href="<?php echo base_url('app/notifications/add/?folder=announcement');?>"><span class="glyphicon glyphicon-bullhorn"></span> Announce</a></li>
				<?php }?>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/notifications');?>">Inbox</a></li>
		<li class="active">
			<?php 
				if($folder=="inbox") {
					echo "Compose";
				} else {
					echo "Announce";
				}
			?>
		</li>
	</ol>

	<?php
		//form validation
		echo validation_errors();

		$attributes = array('class' => 'form-horizontal', 'id' => 'send-notify-form', 'role' => 'form', 'data-toggle' => 'validator');
		echo form_open(base_url('app/notifications/add/?folder='.$folder), $attributes);
	?>

	<div class="col-sm-8">
		
		<?php if ($folder <> "announcement") {?>
      	<fieldset>
    		<legend>Basic Details</legend>

			<div class="form-group">
				<label for="inputType" class="col-sm-2 control-label">Audience Type</label>
				<div class="col-sm-8">
			  		<label class="radio-inline">
			  			<input type="radio" name="type" id="inlineTypeAdmin" value="admin" checked> Administrators
					</label>
					<?php if ($this->session->userdata('role') == "administrator") {?>
					<label class="radio-inline">
					  	<input type="radio" name="type" id="inlineTypePresenter" value="presenter"> Presenters
					</label>
					<label class="radio-inline">
					  	<input type="radio" name="type" id="inlineTypeSchool" value="school" > Schools
					</label>
					<!--<label class="radio-inline">
					  	<input type="radio" name="type" id="inlineTypeTeacher" value="teacher" > Teachers
					</label>-->
					<?php }?>
				</div>
		  	</div>
		</fieldset>
		<p>&nbsp;</p>
		<?php }?>
		
		<fieldset>
    		<legend>Compose	Message / Announcement</legend>

			<div class="form-group">
				<label for="inputSubject" class="col-sm-2 control-label">Subject</label>
				<div class="col-sm-9">
		  			<input type="text" name="subject" class="form-control" id="inputSubject" placeholder="Email subject" value="" required>
					<div class="help-block with-errors"></div>
				</div>
		  	</div>

		  	<div class="form-group">
				<label for="inputDesc" class="col-sm-2 control-label">Message</label>
				<div class="col-sm-10">
		  			<textarea class="form-control" name="description" id="inputDesc" placeholder="Compose your message .." rows="15" required ></textarea>
					<div class="help-block with-errors"></div>
				</div>
		  	</div>

		</fieldset>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-9">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Send</button> or <a href="<?php echo base_url('app/notifications');?>">Cancel</a>
			</div>
		</div>

	</div>
	
	<?php if ($folder <> "announcement") {?>
	<div class="col-sm-4">
		<fieldset>
    		<legend>Selected Audience</legend>
			<div id="usersPreview"></div>
		</fieldset>
	</div>
	<?php }?>
	
	<?php echo form_close();?>
</div>

<script>
	jQuery('#inputDesc').wysihtml5();
</script>
