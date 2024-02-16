<style>
	
    .log-view-tab-wrapper ul li a {
        font-size: 17px;
        font-weight: 300;
        font-family: 'Campton-Medium.otf';
    }
    .log-view-tab-wrapper ul li a.active {
        border-bottom: 2px solid #392781;
        font-weight: 700 ;
        font-family: 'Campton-Medium.otf';
    }
    .log-view-tab-wrapper {
        margin-bottom: 15px;
        -webkit-box-shadow: 4px 0px 10px -4px rgb(57 39 129 / 40%);
    }



    .log-view-tab-wrapper{
        background: white;
        margin-bottom: 10px;
    }
    .log-view-tab-wrapper ul{
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .log-view-tab-wrapper ul li{
        display: inline-block;
        padding:0 40px;
    }
    .log-view-tab-wrapper ul li a{
        padding:20px 0;
        font-size: 20px;
        font-weight: 900;
        /* color: #392781; */
        display: block;
        position: relative;
        border-bottom: 2px solid #ffffff;
    }
    .log-view-tab-wrapper ul li a.active{
        border-bottom: 2px solid #392781;
    }
    .log-view-tab-wrapper ul li a:hover{
        border-bottom: 2px solid #392781;
    }
	/* .loader_img {
      position: relative;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(<?php //echo base_url('assets/images/loader.gif'); ?>) center no-repeat #fff;
    opacity: .6;
  } */
</style>

<!-- For loader -->
<!-- <div class="loader_img" style="display:none;"> </div> -->





<div class="subnav">
	<div class="container-fluid">
    	<h1>Logs</h1>

    

			<div class="row  log-view-tab-wrapper">
                <div class="col-md-12">
                    <ul>
                        <?php if($logStatus == 'log_writing_room' || $logStatus == '' || $logStatus == 'page'){ ?>
                            <li style="padding: 0 15px;"><a href="<?php echo base_url('app/presenters/logs/'.'log_writing_room');?>" id="log-writing-room" class="active" >Log Writing Room</a></li>
                        <?php }else{ ?>
                            <li style="padding: 0 15px;"><a href="<?php echo base_url('app/presenters/logs/'.'log_writing_room');?>" id="log-writing-room" >Log Writing Room</a></li>
                        <?php } ?>
                        
                        <?php if($logStatus == 'submitted_logs'){ ?>
                            <li><a  href="<?php echo base_url('app/presenters/logs/'.'submitted_logs');?>" id="submitted-logs" class="active">Submitted Logs</a></li>
                        <?php }else{ ?>
                            <li><a  href="<?php echo base_url('app/presenters/logs/'.'submitted_logs');?>" id="submitted-logs" >Submitted Logs</a></li>
                        <?php } ?>  
                    </ul>
                </div>
            </div>

			<?php if($logStatus == 'log_writing_room' || $logStatus == '' || $logStatus == 'page'){ ?>
                <div class="tab-container" id="log-writing-room">
                    <!-- <h2> log writing room</h2> -->

					<!-- <div class="subnav">
						<div class="container-fluid">
							<h1><span class="fa fa-user-plus"></span> Custom Template</h1>
						
						</div>
					</div> -->

					<div class="container-fluid main">
							<!-- <ol class="breadcrumb">
								<li><a href="<?php //echo base_url('dashboard');?>">Dashboard</a></li>
								<li><a href="<?php //echo base_url('app/presenters/logs');?>">Logs</a></li>
								<li class="active">Template Management</li>
							</ol> -->
							
							<div style="text-align: right; margin-right: -4px;" >
								<button class="btn btn-primary favorite_template" onclick="window.location='<?php echo base_url('app/presenters/favorite_template');?>'">Add Favorite Template</buttton>

									<button class="btn btn-primary custom_template"   onclick="window.location='<?php echo base_url('app/presenters/custom_template_for_admin');?>'">Add Custom Template</buttton>
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
							<div class="table-responsive align width">
								<!-- Table -->
								<table class="table table-striped table-responsive ">
									<thead>
										<tr>
											<!-- <th><input type="checkbox" id="checkall"></th> -->
											<th>Topic</th>
											<th>Template </th>
											<!-- <th>Message </th> -->
											<th>Actions</th>
											
										</tr>
									</thead>

									<tbody>
										<?php if ($tem_list == false) { ?>
										<tr>
											<td colspan="100%">Sorry!! No Records found.</td>
										</tr>
										<?php } else { ?>
										
										<?php foreach($tem_list as $list) { //print_r($list); ?>
										<tr>
											<!-- <td><input type="checkbox" name="item_id[<?php echo $list->id;?>]" class="checkbox-item" value="Y"></td> -->

											
													
												<td><?php if(isset($list->topic)) { echo $list->topic; } ?> </td>  

												<!-- <td class="table_width"> <?php //echo (strlen($list->tmp_name)>60) ? substr($list->tmp_name,0,60).'....': $list->tmp_name; ?> </td> -->

												<!-- <td class="table_width2"><?php //echo (strlen($list->message)>120) ? substr($list->message,0,120).'....': $list->message ; ?> </td> -->

												<td><a onclick="viewTemplateModal(<?php if(isset($list->template_id)){ echo $list->template_id;} ?>)" title="view_template" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span>  View Template</a></td>

											
											
											
											<td class="text-nowrap">
												<a href="<?php echo site_url('app/presenters/custom_template_edit/'.$list->template_id);?>" title="Edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>

												<a href="<?php echo site_url('app/presenters/custom_template_delete/'.$list->template_id);?>" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this?')"> <span class="glyphicon glyphicon-trash"> </span> Delete </a>
												<!-- <?php echo render_action(array('edit', 'delete'), $list->id);?> -->
											</td>
										</tr>
										<?php } } ?>
							
										</tbody>
									
								</table>
    						</div>
							<?php echo $this->pagination->create_links(); ?>
					</div>
             </div>
            <?php } ?>

				<?php if($logStatus == 'submitted_logs'){ ?>
				
                	<div class="tab-container" id="submitted-logs">

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
					</div>
            	<?php } ?>

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
        <!-- <h4 class="modal-title" id="exampleModalLongTitle">Upload Header Image</h4> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

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

		$("#log-writing-room").click(function(){
            $('#submitted-logs').removeClass('active');
            $('#log-writing-room').addClass('active');
        });

        $("#submitted-logs").click(function(){
            $('#log-writing-room').removeClass('active');
            $('#submitted-logs').addClass('active');
			// var url      = window.location.href; 
			// alert(url);
        });

		// jQuery("#submitted-logs").on( "click", function(e) {
		// e.preventDefault();
		
		// jQuery('.loader_img').show();
		
		// });
		// jQuery("#submitted-logs").on( "click", function(e) {
		// 	e.preventDefault();
		
		// 	// var topics = $("input[name='topics[]']").serializeArray(); 
		// 	/*if (topics.length === 0) 
		// 	{ 
		// 		alert('Please select a topic');
		// 		return false;
		// 	} */
			
		// 	// var data = jQuery("#frm_place_order_confirm").serialize();
		// 	//console.log(data);
		// 	// href="<?php //echo base_url('app/presenters/logs/'.'submitted_logs');?>"
		// 	jQuery('.loader_img').show();
			
		// 		jQuery.ajax({
		// 			type: "POST",
		// 			url: base_url+"app/presenters/logs/submitted_logs",
		// 			data: data,
		// 			async: true,
		// 			success: function(response){
		// 				// alert(response.msg);
		// 				// if (response.success)
		// 				// {
		// 				// 	location.href = base_url+'app/orders';
		// 				// }
		// 			}
		// 		});
			
		// });

	});

	function viewTemplateModal(template_id){
		// alert(template_id);
		// var template_id = jQuery('#template_id').val();
		// $('#viewTemplateModal').modal('show');
        jQuery.ajax({
            url: base_url+'app/presenters/viewTemplateModal',
            data: {template_id:template_id, ajaxCall:true},
            type: 'post',
            async: false,
            success: function (response) {
                // window.location.reload();
				// alert(response);
				
				$('.view_message').html(response);
				$('#viewTemplate').modal('show');
            }
        });
    
 	}




</script>
