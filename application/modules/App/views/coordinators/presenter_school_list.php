<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Assigned Presenters &raquo; <small> <?php echo character_limiter($teacher->first_name, 50);?></small> </h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li><a href="<?php echo base_url('app/coordinator');?>"><span class="glyphicon glyphicon-user"></span>Coordinator</a></li>
				<li class="active"><a href="<?php echo base_url('app/coordinator/assign_presenter_school_list/'.$coordinator_id);?>"><span class="glyphicon glyphicon-user"></span>Assigned Presenters</a></li>
				<li><a href="<?php echo base_url('app/coordinator/assign_presenter_school/'.$coordinator_id);?>"><span class="glyphicon glyphicon-plus-sign"></span>Presenter Assignment</a></li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('app/coordinator');?>">Coordinator Management</a></li>
		<li class="active">Assigned Presenters</li>
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
						<th>Presenter</th>
						<th>Schools</th>
						<th>From Date</th>
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
								<td><?php echo $teacher['first_name']." ".$teacher['last_name'];?></td>
								<td><?php echo $teacher['school_name']; ?></td>
								<td><?php echo $teacher['from_date']; ?></td>
								<td class="text-nowrap">

								<a href="<?php echo base_url('app/coordinator/assign_presenter_school_edit/'.$teacher['coordinator_id'].'/'.$teacher['presenter_id']);?>" title="Edit" class="btn btn-primary btn-xs" data-id="<?php //echo $teacher['id'] ?>" ><span class="glyphicon glyphicon-edit"></span> Edit</a>	
								
								<a href="#" title="Delete" class="btn btn-danger btn-xs openPopup" data-id="<?php echo $teacher['cps_id'] ?>" ><span class="glyphicon glyphicon-edit"></span> Delete</a>
								<?php //echo render_action(array('edit', 'delete'), $teacher->id);?>						
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
        <h4 class="modal-title" id="exampleModalLongTitle">Set Effective Date</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
       <form action="<?php echo base_url('app/coordinator/delete_assigned_presenter'); ?>" method="POST" enctype="multipart/form-data">
      		<div class="modal-body">
        	
				<div class="form-group">
			  		<label for="inputName" class="col-sm-3 control-label">Effective Date *</label>
			  		<div class="col-sm-7">
							<input type="text" name="effective_date" class="form-control calender-control" id="inputBDate" placeholder="Enter effective date" value="" autocomplete="off" required>
			  			<input type="hidden" name="pId" id="pId" value="">
							<input type="hidden" name="coordinator_id" value="<?php echo $coordinator_id; ?>">
			  		</div>
			  	</div>
			  	<br/>
			  	<div class="form-group">
			  		<div class="col-sm-12">
			  			&nbsp;
			  		</div>
			  	</div>
      		</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" id="hdrsbmtbtn1" class="btn btn-primary">Delete</button>
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
<script type="text/javascript">
	$('#inputBDate').keypress(function(event){
	      event.preventDefault();
	});
</script>