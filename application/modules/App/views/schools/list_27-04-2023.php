<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-building"></span> Manage Schools</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/schools');?>" title="Schools"><span class="fa fa-building"></span> Schools</a></li>
				<li><a href="<?php echo base_url('app/schools/add');?>" title="Add New School"><span class="glyphicon glyphicon-plus-sign"></span> Add New School</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">School Management</li>
	</ol>



	<?php
    //echo $this->input->get('id');die;
        echo validation_errors();
        $searchURL =  base_url('app/schools/search_submit?id='.$this->input->get('id'));
        $attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
        echo form_open($searchURL, $attributes);
    ?>
    <fieldset>
        <legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
        <div class="row">
            <div class="col-md-12">
                
            
                <?php //if ($this->session->userdata('role') == 'administrator') {?>
                <!-- <?php //print_r($search);die;?> -->
                <div class="form-group" >
                    <select name="school" class="form-control" style="width: 20rem;">
                        <option value="" selected>Select a School</option>
                        <?php foreach ($search_school as $school) {?>
                            <?php if(isset($school->meta['school_name']) && ($school->meta['school_name']) !=''){?>
                        <option value="<?php echo $school->id;?>" <?php if ($filter['school'] == $school->id) {echo "selected";}?>><?php echo $school->meta['school_name'];?></option>
                        <?php } }?>
                    </select>
                </div>

                        
                <div class="form-group" >
                    <select name="contact_person" class="form-control" style="width: 20rem;">
                        <option value="" selected>Select a Contact Person</option>
                        <?php foreach ($search as $contact_person) {?>
                            <?php if(((isset($contact_person->first_name) && ($contact_person->first_name) !=''))||((isset($contact_person->last_name) && ($contact_person->last_name) !=''))){?>
                        <option value="<?php echo $contact_person->id;?>" <?php if ($filter['contact_person'] == $contact_person->id) {echo "selected";}?>><?php echo $contact_person->first_name;?> <?php echo $contact_person->last_name;?></option>
                        <?php } }?>
                    </select>
                </div>
                
                


                <div class="form-group" >
                    <select name="email" class="form-control" style="width: 20rem;">
                        <option value="" selected>Select an Email</option>
                        <?php foreach ($search_email as $email) { ?>
                            <?php if(isset($email->email) && ($email->email) !=''){?>
                        <option value="<?php echo $email->id;?>"<?php if ($filter['email'] == $email->id) {echo "selected";}?>><?php echo $email->email;?></option>
                        <?php } }?>
                    </select>
                </div> 

                

                <div class="form-group" style="margin-top:5px;">
                    <button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url(); ?>app/schools'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

                   <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
            
                </div>
                <?php 
                // if(isset($co_id)){
                //      $resetURL =  base_url('app/coordinator/main_orders/?id='.$co_id);
                //  }else{
                        //$resetURL =  base_url('app/presenters/');
                //  }
                ?>

            </div>

        </div>


        <div class="row">
            <div class="col-md-6">&nbsp;</div>
        </div>
    </fieldset>

    <?php echo form_close();?>


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
			$url= $_SERVER['REQUEST_URI']; 
			$url2=explode('/',$url);
			if(isset($url2[5]))
			{
			$page='/index/page/'.$url2[5];
	     	}else{
	     		$page = '';
	     	}
			?>

	<?php
		echo validation_errors();

		$attributes = array('class' => 'form-inline status-form', 'id' => 'product-status-form');
		echo form_open(base_url('app/schools/update_status'.$page), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
	          		<th><input type="checkbox" id="checkall"></th>
	          		<th>School Name</th>
	          		<th>Contact Person</th>
					<th>Email</th>
					<th>Status</th>
	          		<th>Action</th>
	          	</tr>
	        </thead>
	        <tbody>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($list as $school) { ?>
	            <tr>
	            	<td><input type="checkbox" name="item_id[<?php echo $school->id;?>]" class="checkbox-item" value="Y"></td>
					<td><?php if(isset($school->meta['school_name'])){ echo character_limiter($school->meta['school_name'], 50);}?></td>
					<td><?php echo $school->first_name;?> <?php echo $school->last_name;?></td>
					<td><?php echo $school->email;?></td>
					<td><?php echo status_display($school->status);?></td>
					<td class="text-nowrap"><?php echo render_action(array('edit', 'delete'), $school->id);?>	<button type="button" class="btn btn-warning btn-xs" onclick="window.location.href = '<?php echo base_url('app/schools/teacher_report/'.$school->id) ?>'">Teacher Report</button></td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="8">
						<?php echo render_buttons(array('update_status', 'delete'));?>
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php echo $this->pagination->create_links(); ?>
</div>

<?php
	function format_date($str) {
		$str = urldecode($str);
		return str_replace('~', '/', $str);
	}
?>
