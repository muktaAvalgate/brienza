<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-time"></span> Manage Payment Schedule</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/payroll');?>"><span class="glyphicon glyphicon-time"></span> Payment Schedule</a></li>
				<li><a href="<?php echo base_url('app/payroll/payment_schedules_add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add Payment Schedule</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Payment Schedule Management</li>
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
		echo validation_errors();

		$attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
		echo form_open(base_url('app/payroll'), $attributes);
	?>

	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<input type="text" class="form-control calender-control" id="" name="session_start_date" placeholder="Session Start Date" value="<?php if (isset($_POST['session_start_date'])) {echo $_POST['session_start_date'];}?>" size="15" >
					<input type="text" class="form-control calender-control" id="" name="session_end_date" placeholder="Session End Date" value="<?php if (isset($_POST['session_end_date'])) {echo $_POST['session_end_date'];}?>" size="15" >
				</div>
				
				<div class="form-group">
					<select name="month" class="form-control" >
						<option value="" selected>Select Month</option>
					    <?php
						    for ($i = 1; $i <= 12; $i++) 
						    {
						        $time 	= mktime(0, 0, 0, $i);   
						        $label 	= date('F', $time);   
						        $value 	= date('n', $time);

						        if(isset($_POST['month']) && $_POST['month'] == $value)
						        	echo "<option value='$value' selected>$label</option>";
						        else
						        	echo "<option value='$value'>$label</option>";
						    }
					    ?>
					</select>
				</div>
				
				<div class="form-group">
					<select name="year" class="form-control" >
						<option value="" selected>Select Year</option>
					    <?php
						    for ($j = 2018; $j <= date('Y', strtotime('+1 year')); $j++) 
						    {
						        if(isset($_POST['year']) && $_POST['year'] == $j)
						        	echo "<option value='$j' selected>$j</option>";
						        else
						        	echo "<option value='$j'>$j</option>";						    	
						    }
					    ?>						
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
					<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('app/payroll');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>
	<?php echo form_close();?>	

	<?php
		echo validation_errors();

		$attributes = array('class' => 'form-inline status-form', 'id' => 'product-status-form');
		echo form_open(base_url('app/coordinator/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th>Sl No #</th>
					<th>Year</th>
					<th>Session From</th>
					<th>Session To</th>
					<th>Billing Date</th>
					<th>Payment Date</th>
					<th>Action</th>
	        </tr>
	        </thead>
	        <tbody>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php 
	            foreach($list as $key=>$schedules) 
	            { 
	            	$key = $key + 1;
	            ?>
	            <tr>
					<td><?php echo $key;?></td>
					<td><?php echo $schedules->year; ?></td>
					<td><?php echo date('dS F', strtotime($schedules->session_from)); ?></td>
					<td><?php echo date('dS F', strtotime($schedules->session_to)); ?></td>
					<td><?php if($schedules->billing_date == '0000-00-00'){echo "";}else{echo date('dS F', strtotime($schedules->billing_date));}  ?></td>
                    <td><?php if($schedules->payment_date == '0000-00-00'){echo "";}else{echo date('dS F', strtotime($schedules->payment_date));}  ?></td>

					<td class="text-nowrap">
						<?php //echo render_action(array('edit', 'delete'), $schedules->pshedule_id);?>

						<?php echo  anchor('app/payroll/payment_schedules_edit/'.$schedules->pshedule_id, '<span class="glyphicon glyphicon-edit"></span> Edit', array('title' => 'Edit', 'class' => 'btn btn-primary btn-xs')); ?>
						
						<?php echo  anchor('app/payroll/show_payable_schedules/'.$schedules->pshedule_id, '<span class="glyphicon glyphicon-eye-open"></span> Payroll', array('title' => 'Payroll Schedules', 'class' => 'btn btn-primary btn-xs')); ?>						

						<?php
                            if($schedules->session_to >= date("Y-m-d") && $schedules->record !=1){
                        ?>
                            <?php echo anchor('app/payroll/payment_schedules_delete/'.$schedules->pshedule_id, '<span class="glyphicon glyphicon-trash"></span> Delete', array('title' => 'Delete', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm(\'Are you sure you want to delete this?\')')); ?>
                        <?php
                            }
                        ?>
					</td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="8">
						<?php //echo render_buttons(array('update_status', 'delete'));?>
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php //echo $this->pagination->create_links(); ?>
</div>

<!-- Header Modal -->
<div class="modal fade" id="headerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Upload Header Image</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
       <form action="#" method="POST" id="headerImgFrm" enctype="multipart/form-data">
      		<div class="modal-body">
        	
				<div class="form-group">
			  		<label for="inputName" class="col-sm-3 control-label">Image *</label>
			  		<div class="col-sm-7">
			  			<input type="file" name="headerImg" class="form-control" id="headerImg">
			  			<input type="hidden" name="pId" id="pId" value="">
			  		</div>
			  	</div>
			  	<br/>
			  	<div class="form-group">
			  		<div class="col-sm-12">
			  			
			  		</div>
			  	</div>
      		</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" id="hdrsbmtbtn1" class="btn btn-primary">Save changes</button>
	      	</div>
        </form>
    </div>
  </div>
</div>