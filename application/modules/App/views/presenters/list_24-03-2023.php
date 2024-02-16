<style>
.log_template{
    position: absolute;
    right: 33px;
    top: 255px;

}
</style>

<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="fa fa-user-plus"></span> Manage Presenters</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
				<li class="active"><a href="<?php echo base_url('app/presenters');?>"><span class="fa fa-user-plus"></span> Presenters</a></li>
				<li><a href="<?php echo base_url('app/presenters/add');?>"><span class="glyphicon glyphicon-plus-sign"></span> Add Presenter</a></li>
			</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Presenter Management</li>
	</ol>


	<?php
	//echo $this->input->get('id');die;
		echo validation_errors();
		$searchURL =  base_url('app/presenters/search_submit?id='.$this->input->get('id'));
		$attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
		echo form_open($searchURL, $attributes);
	?>
	<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">
				
			
				<?php //if ($this->session->userdata('role') == 'administrator') {?>
				
				<div class="form-group" >
					<select name="presenter" id="presenter" class="form-control" >
						<option value="" selected>Select a Presenter</option>
						<?php foreach ($search as $presenter) { ?>
							<?php if(isset($presenter->presenter) && ($presenter->presenter) !=''){?>
						<option value="<?php echo $presenter->id;?>" <?php if ($filter['presenter'] == $presenter->id) {echo "selected";}?>><?php echo $presenter->presenter;?></option>
						<?php } }?>
					</select>
				</div>

						
				<div class="form-group" >
					<select name="company" id="company" class="form-control" >
						<option value="" selected>Select a Company</option>
						<?php foreach ($search as $company) {?>
							<?php if(isset($company->meta['company_name'])){?>
						<option value="<?php echo $company->id;?>" <?php if ($filter['company'] == $company->id) {echo "selected";}?>><?php echo $company->meta['company_name'];?></option>
						<?php } }?>
					</select>
				</div>
				<?php //}?>
				<br>
				<div class="form-group" >
                    <select name="email" id="email" class="form-control" >
                        <option value="" selected>Select a email</option>
                        <?php foreach ($search as $email) { ?>
                            <?php if(isset($email->email) && ($email->email) !=''){?>
                        <option value="<?php echo $email->id;?>"<?php if ($filter['email'] == $email->id) {echo "selected";}?>><?php echo $email->email;?></option>
                        <?php } }?>
                    </select>
                </div>
			

				<div class="form-group" style="margin-top:5px;">
					<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url(); ?>app/presenters'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

				   <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;

				   <button type="button" class="btn btn-default" onclick="export_presenters();"><span class="fa fa-download"></span> Export to csv</button>
				  
				</div>
				<?php 
				// if(isset($co_id)){
				// 		$resetURL =  base_url('app/coordinator/main_orders/?id='.$co_id);
				// 	}else{
				 		//$resetURL =  base_url('app/presenters/');
				// 	}
				?>
				

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>

	<?php echo form_close();?>
	<div>
		<button class="btn btn-primary log_template" onclick="window.location='<?php echo base_url('app/presenters/log_template_for_presenters');?>'">Log Templates For Presenters </buttton>
	</div>
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
		echo form_open(base_url('app/presenters/update_status'), $attributes);
	?>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
	          		<th><input type="checkbox" id="checkall"></th>
	          		<th>Name</th>
	          		<th>Email</th>
	          		<th>Info</th>
					<th>Rate</th>
					<th>Company Name</th>
					<th>Header Image</th>
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
					<td><?php echo $teacher->first_name;?></td>
					<td><?php echo $teacher->email;?></td>
					<td><?php if(isset($teacher->meta['info'])){ echo character_limiter($teacher->meta['info'], 50);}?></td>
					<td><?php if(isset($teacher->meta['rate'])){ echo price_display($teacher->meta['rate']);}?></td>
					<td><?php if(isset($teacher->meta['company_name'])){ echo $teacher->meta['company_name'];}else{ echo '--';}?></td>
					<td><?php if(isset($teacher->headerImg) && $teacher->headerImg!=''){ ?>
						<a href="<?php echo base_url('assets/header_image/'.$teacher->headerImg); ?>" target="_blank">
							<img src="<?php echo base_url('assets/header_image/'.$teacher->headerImg); ?>">
						</a>
						<?php }else{ echo '--';} ?>
					</td>
					<td><?php echo status_display($teacher->status);?></td>
					<td class="text-nowrap">
						<a href="javascript:void(0)" class="btn btn-info btn-xs openPopup" title="Upload Header" data-id="<?php echo $teacher->id ?>"><span class="glyphicon glyphicon-upload"></span> Upload Header</a>

						<?php echo render_action(array('edit', 'delete'), $teacher->id);?>
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
        		<div id="imgErr"></div>
				<div class="form-group">
			  		<label for="inputName" class="col-sm-3 control-label">Image *</label>
			  		<div class="col-sm-7">
			  			<input type="file" name="headerImg" class="form-control" id="headerImg" required>
			  			<input type="hidden" name="pId" id="pId" value="">
			  			<div class="help-block">Please choose jpeg, jpg or png file</div>
			  		</div>
			  	</div>
			  	<br/>
			  	<div class="form-group">
			  		<div class="col-sm-12">
			  			
			  		</div>
			  	</div>
      		</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
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
		
		// jQuery('#close').on('click', function(){
		// 	location.reload();
		// });

		jQuery('#hdrsbmtbtn1').on('click', function(e){
			e.preventDefault();
			var presenter_id = jQuery("#pId").val();
			var img = jQuery('#headerImg').val();
			var ext = img.split('.').pop().toLowerCase();
			if(img == ''){
				jQuery('#imgErr').html('<div class="alert alert-danger alert-dismissable">				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please choose an image</div>');
				jQuery("#imgErr").fadeTo(2000, 500).slideUp(500, function() {
			      jQuery("#imgErr").slideUp(500);
			    });
				return false;
			}
			if ($.inArray(ext, ['png','jpg','jpeg']) == -1){
				jQuery('#imgErr').html('<div class="alert alert-danger alert-dismissable">				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please choose correct file type</div>');
				jQuery("#imgErr").fadeTo(2000, 500).slideUp(500, function() {
			    	jQuery("#imgErr").slideUp(500);
			    });
				return false;
			}

			jQuery('#headerImgFrm').submit();
		});
	});


	function export_presenters(){
		var pre = jQuery('#presenter').val();
		var company = jQuery('#company').val();
		var email = jQuery('#email').val();
		document.location.href = base_url+'app/presenters/export_presenters?presenter=' + pre + '&company=' + company + '&email=' + email;
	}

</script>
