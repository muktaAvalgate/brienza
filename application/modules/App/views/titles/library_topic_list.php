<!-- For loader -->

			<div class="subnav">
				<div class="container-fluid">
					<h1><span class="glyphicon glyphicon-education"></span> Library Templates</h1>

					<div id="sub-menu" class="pull-right">
						<!-- <ul class="nav nav-pills">
							<li class="active"><?php echo render_link('index', '<span class="glyphicon glyphicon-education"></span> Titles');?></li>
							<li><?php echo render_link('add', '<span class="glyphicon glyphicon-plus-sign"></span> Create New Title');?></li>
						</ul> -->
					</div>
				</div>
			</div>

			
			
				
				<div class="container-fluid main">
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
						<li><a href="<?php echo base_url('app/titles');?>">Titles</a></li>
						<li class="active">Library Templates</li>
					</ol>
						
						<div style="text-align: right; margin-right: -4px;" >
							<button class="btn btn-primary custom_template"   onclick="window.location='<?php echo base_url('app/titles/add_library_template_for_admin/'.$title_id);?>'">Add Template</buttton>
						</div>

						<div class="flash_message">
							<?php if($this->session->flashdata('message_type')) {
								if($this->session->flashdata('message')) {
								echo '<div class="alert alert-'.$this->session->flashdata('message_type').' alert-dismissable">';
								echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
								echo $this->session->flashdata('message');
								echo '</div>';
								}
								}?>
						</div>
						<div class="table-responsive align">
							<!-- Table -->
							<table class="table table-striped table-responsive ">
								<thead>
									<tr>
										<!-- <th><input type="checkbox" id="checkall"></th> -->
										<th width="44%">Topic</th>
										<th width="42%">Template </th>
										<!-- <th>Message </th> -->
										<th>Actions</th>
										
									</tr>
								</thead>

								<tbody>
									<?php if ($admin_library_list == false) { ?>
									<tr>
										<td colspan="100%">Sorry!! No Records found.</td>
									</tr>
									<?php } else { ?>
									
									<?php foreach($admin_library_list as $list) { //print_r($list); ?>
									<tr>

										
												
											<td><?php if(isset($list->topic)) { echo $list->topic; } ?> </td>
											<td><a onclick="viewTemplateModal(<?php if(isset($list->id)){ echo $list->id;} ?>)" title="view_template" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span>  View Template</a></td>

											<!-- <a href="<?php //echo base_url('controller_name/method_name/'.$var1.'/'.$var2.'/'.$var3); ?>">Click here</a> -->

										
										<td class="text-nowrap">
											<a href="<?php echo site_url('app/titles/library_template_edit/'.$list->id.'/'.$list->title_id);?>" title="Edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>
											<!-- <?php //echo '<pre>'; print_r($list); die; ?> -->
											<a href="<?php echo site_url('app/titles/library_template_delete/'.$list->id.'/'.$list->title_id);?>" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this?')"> <span class="glyphicon glyphicon-trash"> </span> Delete </a>
											<!-- <?php //echo render_action(array('edit', 'delete'), $list->id);?> -->
										</td>
									</tr>
									<?php } } ?>
						
									</tbody>
								
							</table>
						</div>
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


<div class="modal fade" id="viewTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
	  <div class="modal-header">
				<div class="row">
					<div class="col-sm-10">
						<h4 class="topic_name"></h4>
					</div>
					<div class="col-sm-2">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>

			</div>
      		<div class="modal-body">
				
				<div class="form-group">
			  		<span class="view_message" ></span>
			  	</div>
			  	<br/>
			  	<div class="form-group">
			  		<div class="col-sm-12">
			  			
			  		</div>
			  	</div>
      		</div>
	      	<!-- <div class="modal-footer">
		        
	      	</div> -->
    </div>
  </div>
</div>



<script type="text/javascript">
	

	function viewTemplateModal(id){
		// alert(id);
		// var id = jQuery('#id').val();
		// $('#viewTemplateModal').modal('show');
        jQuery.ajax({
            url: base_url+'app/titles/viewTemplateModal',
            data: {id:id, ajaxCall:true},
            type: 'post',
            async: false,
            success: function (response) {
                // window.location.reload();
				// alert(response);
				
				// $('.view_message').html(response);
				// $('#viewTemplate').modal('show');
				$('.view_message').html(response.final_message);
				$('.topic_name').html(response.topic);
				$('#viewTemplate').modal('show');
            }
        });
    
 	}




</script>
