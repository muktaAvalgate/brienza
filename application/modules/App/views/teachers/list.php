<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-education"></span> Manage Assign Title</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/teachers');?>"><span class="glyphicon glyphicon-education"></span> Titles</a></li>
				<li><a href="<?php echo base_url('app/schools/titles');?>"><span class="glyphicon glyphicon-plus-sign"></span> Assign Title</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Assign Title</li>
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
		echo form_open(base_url('app/teachers/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
	          		<!-- <th><input type="checkbox" id="checkall"></th> -->
	          		<th></th>
					<th>School Name</th>
					<!-- <th>Title</th>
					<th>Grade</th>
	          		<th>Name</th> -->
	          		<!--<th>Email</th>
					<th>Phone</th>-->
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
	            <?php foreach($list as $teacher) {?>
	            <tr>
	            	<!-- <td><input type="checkbox" name="item_id[<?php echo $teacher->id;?>]" class="checkbox-item" value="Y"></td> -->
	            	<td></td>
					<td>
						<a class="assignTitleList" href="javascript:void(0)" data-school-id="<?php echo $teacher->school_id;?>"><?php echo $teacher->school_name;?></a>
					</td>

					<!-- <td><?php //echo $teacher->title_name;?></td>
					<td><?php //echo $teacher->grade_name;?></td>
					<td><?php //echo $teacher->name;?></td> -->
					<!--<td><?php //echo $teacher->email;?></td>
					// <td><?php //echo $teacher->phone;?></td>-->
					<td><?php echo status_display($teacher->status);?></td>
					<td><a href="<?php echo base_url('app/teachers/edit/'.$teacher->school_id); ?>" title="Edit assign title and grade" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<!-- <tfoot>
				<tr>
                	<td colspan="8">
						<?php //echo render_buttons(array('update_status', 'delete'));?>
					</td>
				</tr>
			</tfoot> -->
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


<!-- Confirm log Modal -->
<div class="modal fade" id="assignTitleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Assign Title & Grade</h4>
			</div>
			<div class="modal-body" id="assignTitle">
				...
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	jQuery(document).ready(function() {

		jQuery('.assignTitleList').on('click', function(){
			var schoolId = jQuery(this).attr('data-school-id');
			jQuery.ajax({
				type: "POST",
				url: base_url+'app/teachers/get_assign_title_grade',
				data: { school_id:schoolId },
				async: true,
				success: function(response){
					jQuery('#assignTitle').html(response);
					jQuery('#assignTitleModal').modal('show');
				}
			});
		});
	});

</script>