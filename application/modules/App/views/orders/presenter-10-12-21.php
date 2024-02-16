<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-shopping-cart"></span> Presenters</h1>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Orders</li>
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

	?>
	
	<?php foreach($list as $item) { ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $item->first_name. " ". $item->last_name;?></h3>
		</div>
		<div class="panel-body">
			<p><?php echo $item->meta['info'];?><p>
			
			<!--<p><strong>Hourly Rate: <?php echo price_display($item->meta['rate']);?></strong></p>-->
		</div>
		<div class="panel-footer">
			<?php
				$attributes = array('class' => 'form-inline frm_place_order', 'id' => '', 'role' => 'form', 'data-toggle' => 'validator');
				echo form_open('', $attributes);
			?>
				<button type="submit" class="btn btn-success">Place Order</button>
				<input type="hidden" name="presenter_id" value="<?php echo $item->id;?>" />
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">for</span>
						<input type="number" name="hour" value="1" class="form-control" min="1" placeholder="Enter hours" required>
						<span class="input-group-addon">hour(s)</span>
					</div>
				</div>
				<!--<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">on</span>
						<input type="text" name="booking_date" value="" class="form-control calender-control-futureonly" placeholder="Choose booking date" autocomplete="off" required>
						<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					</div>
				</div>-->
				
				<div class="form-group">
					<div class="input-group">
						<select name="title_id" class="form-control" required>
							<option value="" selected>Select Title</option>
							<?php foreach ($titles as $item) {?>
								<option value="<?php echo $item->id;?>" <?php if (set_value('title_id') == $item->id) {echo "selected";}?>><?php echo $item->name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			<?php echo form_close();?>
			  
		</div>
	</div>
	<?php }?>
	

	<?php //echo $this->pagination->create_links(); ?>
</div>

<!-- Topic Modal -->
<div class="modal fade" id="topicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<?php
			$attributes = array('class' => 'form-inline', 'id' => 'frm_place_order_confirm', 'role' => 'form', 'data-toggle' => 'validator');
			echo form_open('', $attributes);
		?>
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Choose Topic (optional)</h4>
		    </div>
		    <div class="modal-body">
				
			</div>
		    <div class="modal-footer">
				<input type="hidden" name="title_id" id="title_id">
				<input type="hidden" name="hour" id="hour">
				<input type="hidden" name="booking_date" id="booking_date">
				<input type="hidden" name="presenter_id" id="presenter_id">
				
				<button type="submit" class="btn btn-primary" id="btn_place_order">Confirm Order</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		</div>
		<?php echo form_close();?>
	</div>
</div>
