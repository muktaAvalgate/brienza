<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Manage Coordinator</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/coordinator');?>" title="Coordinator"><span class="glyphicon glyphicon-user" ></span> Coordinator</a></li>
				<li><a href="<?php echo base_url('app/coordinator/add');?>" title="Add Coordinator"><span class="glyphicon glyphicon-plus-sign"></span> Add Coordinator</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Coordinator Management</li>
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

		$attributes = array('class' => 'form-inline status-form', 'id' => 'product-status-form');
		echo form_open(base_url('app/coordinator/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<!-- <th>Rate Type</th> -->
					<th>Rate</th>
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
	            <?php foreach($list as $teacher) { ?>
	            <tr>
	            	<td><input type="checkbox" name="item_id[<?php echo $teacher->id;?>]" class="checkbox-item" value="Y"></td>
								<td><?php echo $teacher->first_name." ".$teacher->last_name;?></td>
								<td><?php echo $teacher->email; ?></td>
								<!-- <td><?php //echo $teacher->meta['phone']; ?></td> -->
								<td><?php echo $teacher->meta['rate_type']; ?></td>
								<td><?php /* if(isset($teacher->meta['rate'])){ if(strpos($teacher->meta['rate'], '%')) echo $teacher->meta['rate']; else echo price_display($teacher->meta['rate']); } */ 

								echo ($teacher->meta['rate_type'] == 'Percentage') ? $teacher->meta['rate'].'%' : '$'.number_format($teacher->meta['rate'], 2) ?>
									
								</td>
								
								<td><?php echo status_display($teacher->status);?></td>
								<td class="text-nowrap">
									<a href="<?php echo base_url('app/coordinator/assign_presenter_school_list/'.$teacher->id);?>" title="Assign Presenter" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Assign Presenter</a>
									<?php echo render_action(array('edit', 'delete'), $teacher->id);?>
									<br />

									<!--
									<a href="<?php echo base_url('app/coordinator/main_orders/?id='.$teacher->id);?>" title="View Orders" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span>Main Orders</a>
									-->

									<a href="<?php echo base_url('app/coordinator/order/'.$teacher->id);?>" title="View Orders" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span>Order</a>						
								</td>
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
