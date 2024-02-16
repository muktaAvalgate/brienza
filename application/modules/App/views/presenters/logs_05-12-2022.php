<div class="subnav">
	<div class="container-fluid">
    	<h1>Logs</h1>

    </div>
</div>

<div class="container-fluid main">
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
		echo form_open(base_url('app/presenters/search_logs'), $attributes);
	?>

	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" id="" name="order_no" placeholder="Order number" value="<?php if (isset($filter['order_no'])) {echo $filter['order_no'];}?>" size="25" >
				</div>

				<?php if ($this->session->userdata('role') == 'administrator') {?>
					<div class="form-group">
						<select name="presenter" class="form-control" >
							<option value="" selected>Select a presenter</option>
							<?php foreach ($presenters as $item) {?>
							<option value="<?php echo $item->id;?>" <?php if ($filter['presenter'] == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
							<?php }?>
						</select>
					</div>
				<?php }?>

				<div class="form-group">
					<select name="school" class="form-control" >
						<option value="" selected>Select a school</option>
						<?php foreach ($schools as $item) {?>
						<option value="<?php echo $item->school_id;?>" <?php if ($filter['school'] == $item->school_id) {echo "selected";}?>><?php echo $item->school_name;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group">
                    <select name="topic" class="form-control" >
                        <option value="" selected>Select a topic</option>
                        <?php foreach ($topics as $topic) {?>
                        <option value="<?php echo $topic->id;?>" <?php if ($filter['topic'] == $topic->id) {echo "selected";}?>><?php echo $topic->topic;?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control calender-control" id="" name="date" placeholder="Select a date" value="<?php if (isset($filter['date']) && $filter['date'] != '') {echo date('m/d/Y', strtotime($filter['date']));}?>" size="15" >
                </div>
				<div class="form-group">
                	<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('app/presenters/logs');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>
	<?php echo form_close();?>

	<?php
		$attributes = array('class' => 'form-inline status-form', 'id' => 'product-status-form');
		echo form_open(base_url('app/presenters/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
	          		<th>Order Number</th>
	          		<th>School</th>
					<th>Schedule Date</th>
					<th>Schedule Time</th>
					<th>Topic</th>
	          		<th>Action</th>
	          	</tr>
	        </thead>
	        <tbody>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($list as $log) { ?>
	            <tr>
					<td><?php echo $log->order_no;?></td>
					<td><?php echo $log->school_name;?></td>
					<td><?php echo date('d/m/Y', strtotime($log->start_date));?></td>
					<td><?php echo date('h:i a', strtotime($log->start_date))." to ".date('h:i a', strtotime($log->end_date));?></td>
					<td><?php echo $log->topic;?></td>
					<td class="text-nowrap">
						<a href="<?php echo base_url('app/presenters/log_download/'.$log->id); ?>"><img src="<?php echo base_url('assets/dist/images/attachment-icon.png'); ?>" border="0" alt="" title="Click here to download log"></a>
					</td>
	            </tr>
	            <?php } ?>
	        </tbody>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php echo $this->pagination->create_links(); ?>
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
<?php
	function format_date($str) {
		$str = urldecode($str);
		return str_replace('~', '/', $str);
	}
?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.openPopup').on('click', function(){
			jQuery('#pId').val(jQuery(this).attr('data-id'));
			var action_url = base_url+"app/presenters/upload_header/"+jQuery(this).attr('data-id');
			jQuery('#headerImgFrm').attr('action', action_url);
			jQuery('#headerModal').modal('show');
		});
	});
</script>
