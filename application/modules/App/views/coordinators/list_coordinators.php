<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> Manage Coordinator</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/coordinator/list_coordinators');?>"><span class="glyphicon glyphicon-user"></span> Coordinator</a></li>
			</ul>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Coordinators</li>
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
					<!-- <th><input type="checkbox" id="checkall"></th> -->
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Status</th>
					<th>Permission</th>
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
				//echo '<pre>'; print_r($list); echo '</pre>'; exit();
				foreach($list as $teacher) { ?>
	            <tr>
	            	<!-- <td><input type="checkbox" name="item_id[<?php echo $teacher->id;?>]" class="checkbox-item" value="Y"></td> -->
					<td><?php echo $teacher->first_name." ".$teacher->last_name;?></td>
					<td><?php echo $teacher->email; ?></td>
					<td><?php echo $teacher->meta['phone']; ?></td>
					
					<td><?php echo status_display($teacher->status);?></td>
					<td class="text-nowrap">
						<?php if(empty($teacher->permissions['has_order_permission']) || (!empty($teacher->permissions['has_order_permission']) && $teacher->permissions['has_order_permission'] == 0)) { ?>
						<a href="<?php echo base_url('app/coordinator/permission_manage/add/'.$teacher->id.'/'.$school_id);?>" title="Add Permission" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit">Add</span></a>
						<?php } else { ?>
						<a href="<?php echo base_url('app/coordinator/permission_manage/revoke/'.$teacher->id.'/'.$school_id);?>" title="Revoke Permission" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit">Revoke</span></a>
						<?php } ?>
					</td>
					 <td><a href="javascript:void(0);"  title="<?php echo $teacher->id;?>" class="btn btn-primary btn-xs open_modal"><span class="fa fa-eye">View Presenters</span></a></td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="8">
						
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


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Presenter list</h4>
            </div>
            
            <div class="modal-body">


            </div>
            
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>
<!-- Modal -->


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

<script>
$(document).ready(function () {
	$('.open_modal').on('click', function() {
		var title 	= $(this).attr('title');

		var baseurl = "<?php echo base_url('app/coordinator/presenter_view/'); ?>/"+title;
	    $.ajax({
	        url: baseurl,
	        dataType:'html',
	        type: 'post',
	        success: function(data) {
	        	// alert('ugvgv');
				$('.modal-body').html(data);
	        }             
	    });		

		$('#myModal').modal('show');
	});

});
</script>

