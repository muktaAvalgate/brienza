
<div class="subnav">
	<div class="container-fluid">
    	<h1> Admin Billing & Processing Center</h1>
		
		<div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li>Admin Billing & Processing Center</li>
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
		echo form_open('', $attributes);
	?>

	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">
				
				<div class="form-group">
					<select name="presenter" class="form-control" >
						<option value="" selected>Select a presenter</option>
						<?php foreach ($presenters as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($presenter == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control calender-control" id="" name="billing_due_date" placeholder="Billing Due Date" value="<?php if (isset($filter['billing_due_date']) && $filter['billing_due_date'] != '') {echo date('m/d/Y', strtotime($filter['billing_due_date']));}?>" size="15" >
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="" name="purchase_order_no" placeholder="Purchase Order number" value="<?php if (isset($purchase_order_no)) {echo $purchase_order_no;}?>" size="25" >
				</div>
				<div class="form-group">
                	<button type="button" class="btn btn-default" onclick="window.location=''"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>
	<?php echo form_close();?>

	
	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive table-hover" width="100%">
	    	<thead>
	    		<tr>
	          		<th>Purchase Order No</th>
	          		<th>Work Plan </th>
					<th>School</th>
					<th>Presenter</th>
					<th>Presenter INV#</th>
					<th>Billing Due Date</th>
					<th>INVOICE AMT</th>
					<th>TPD TAG</th>
					<th>ACTION</th>
					
	          	</tr>
	        </thead>
	        <tbody>
	            <?php
	            if(count($billings) > 0){
	            	foreach($billings as $item){
	            ?>
	            <tr>
					<td><?php echo $item->order_no;?></td>
	            	<td><?php echo $item->work_plan_number;?></td>
	            	<td><?php echo $item->school_name;?></td>
					<td><?php echo $item->presenter_name;?></td>
					<td><?php //echo $item->presenters_inv;?></td>
					<td></td>
					<td><?php ?></td>					
					<td><?php ?></td>
	            	<td><button class="btn btn-success btn-xs">Process</button></td>
	            </tr>
	            <?php
	           		}
	            }else{
	            ?>
	            <tr>
					<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php
	            }
	            ?>
	            
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="16">
						
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>

	<?php echo $this->pagination->create_links(); ?>
</div>






