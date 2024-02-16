<?php if($this->session->userdata('role') == 'school_admin' || $this->session->userdata('role') == 'teacher') {?>
<link href="<?php echo HTTP_CSS_PATH;?>/jquery.signaturepad.css" rel="stylesheet">
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="<?php echo HTTP_JS_PATH;?>/plugins/numeric-1.2.6.min.js"></script> 
<script src="<?php echo HTTP_JS_PATH;?>/plugins/bezier.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/jquery.signaturepad.js"></script> 
		
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/json2.min.js"></script>
<?php }?>

<div class="container clearfix">
	<div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Billing</h3>
            </div>
            
			<!--<div class="col-sm-3 col-md-3" style="text-align: right;">
				<?php if($remaining_schedule_hrs == 0 && $isBilling == 0){
					?>
				<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#signModal" id="preview_invoice">Submit Billing</button>
			<?php
			}
			?>
			</div>-->
		</div>
		
		
        <div class="row">
			
			<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-scheduling" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<tr class="gradeA even" role="row">
					<td><b><?php echo $order->school_name;?></b></td>
					<td><b><?php echo $order->order_no;?></b></td>
					<td><?php echo $order->work_plan_number?></td>
					<td>Total Hours Confirmed : <?php echo round($scheduled_hr);?></td>
					<td>Balance of Hours : <?php echo $remaining_schedule_hrs;?></td>
				</tr>
				<tr>
					<td colspan="5">
						<table class="table table-responsive table-hover sub-order" width="100%" >
					    	<thead>
					    		<tr style="border:2px solid #763199;">
									<th>Dates of Service</th>
					          		<th>Total Hours</th>
					          		<th>Rate Per Hour</th>
									<th>Amount Due</th>
									<th></th>
					          	</tr>
					        </thead>
					        <tbody>
					        	<?php 

					        	if(count($schedules)> 0){
					        		$sum = 0;
					        		foreach ($schedules as $row) {
					        			$sum+=$row->hourly_rate*$row->total_hours;
					        	?>
					        	<tr style="background-color: #e9e9e9">
					        		<td style="border:2px solid #763199;"><?php echo date_display($row->start_date, "m/d/Y");?> @ <?php echo time_display($row->start_date, true);?> to <?php echo time_display($row->end_date, true);?> with <?php echo $row->teacher.', Grade - '.$row->grade_name; ?>, Topic -<?php echo $row->topic_name; ?></td>
					        		<td style="border:2px solid #763199;background-color: #fff;"><?php echo round($row->total_hours);?></td>
					        		<td style="border:2px solid #763199;background-color: #51c03de3;"><span class="span">$<?php echo $row->hourly_rate;?>.00</span></td>
					        		<td style="border:2px solid #763199;background-color: #51c03de3;"><span class="span">$<?php echo $row->hourly_rate*$row->total_hours;?>.00</span></td>
					        		<td style="border:2px solid #763199;">
					        		<a href="javascript:;"  class="btn revbtn"  data-id="<?php echo $row->id ?>">Review Log</a>
					        		</td>
					        	</tr>
					        	<tr  style="display: none;"  class="show_log_<?php echo $row->id ?> ">
					             <td colspan="5">
					               <table width="100%" cellpadding="0" cellspacing="0" border="0" class="sub-sub-order"> 
								<?php foreach ($row->order_log as $k1 => $order_log) {?>
					            
									<tr>
										<?php if($order_log->new_status != 'Create invoice'){ ?>
										<td style="padding:15px 0;"><p><?php echo date_display($row->start_date, "l, F j, Y");?> @ <?php echo $row->teacher;?> <?php echo time_display($row->start_date, true);?>-<?php echo time_display($row->end_date, true);?></p>
											
										</td>
										<td>
											<?php
											if($order_log->new_status == 'Invoice created'){
												echo "Invoice created";
											}elseif ($order_log->new_status == 'Awaiting Review') {
												echo "Awaiting Review";
											}elseif($order_log->new_status == 'Log sent - awaiting principal signature'){
												echo "Log sent - awaiting principal signature";
											}elseif($order_log->new_status == 'Confirm hours'){
												echo "Hours Confirmed";
											}elseif($order_log->new_status == 'Approved'){
												echo "Approved";
											}elseif($order_log->new_status == 'Draft attached'){
												echo "Draft attached";
											}
											?>
										</td>
										<td>
											<?php
											if($order_log->new_status != 'Confirm hours'){
												if($order_log->attachment && $order_log->attachment != NULL){
													if($order_log->new_status == 'Invoice created'){
														echo ' <a href="'.base_url('app/orders/download/'.$order_log->id.'/'.$order_log->new_status).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"></a>';
													}else{
														echo ' <div id="file_attach_'. $order_log->id.'"><a href="'.base_url('app/orders/download/'.$order_log->id.'/'.$order_log->new_status).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
													}
												}if($order_log->content){
													echo ' <a href="'.base_url('app/orders/display_log/'.$row->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
												}
											}else{
												echo "--";
											}
											?>
										</td>
										<?php } ?>

									</tr>
					            
					            
								<?php } ?>
								 </table>
					             
					             </td>
					            </tr>
					        	<?php
					        		}
					        	?>
					        	<tr>
					        		<td colspan="3" style="text-align: right;color:#763199;">Total:</td>
					        		<td style="border:2px solid #763199;">$<?php echo $sum;?>.00</td>
					        		<td></td>
					        	</tr>
					        	<?php
					        	}else{
					        	?>
					        	<tr><td colspan="5">No Record Found</td></tr>
					        	<?php
					        	}
					        	?>
					    	</tbody>
						</table>
					</td>
				</tr>
			</table>
		</div>        
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
		<div class="row">
			<div class="col-lg-9 col-md-8"></div>
			<div class="col-lg-3 col-md-4 text-right">
				<div class="panel panel-success">
					<div class="panel-heading">
						Is something not right? <a href="javascript:;" data-toggle="modal" data-target="#adminMessageModal">Click here</a>
                    </div>
				</div>
			</div>
        </div>
	</div>
</div>
<!-- Modal -->
<div id="signModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" style="color:#763199;">Please provide your signature and submit to complete your billing</h4>
	      </div>
	      <div class="modal-body">
	        <div class="invoiceSignArea" >
				<div class="sig sigWrapper" style="height:auto;">
					<div class="typed"></div>
					<canvas class="sign-pad" id="invoice-sign-pad" width="300" height="100"></canvas>
					<input type="hidden" name="output" class="output invoice-sign-output">
				</div>
			</div>
			<button type="button" class="btn mybtn" id="savebtn">Submit</button>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	</div>
</div>
<div id="msgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <!-- <h4 class="modal-title">Please provide your signature and submit to complete your billing</h4> -->
	      </div>
	      <div class="modal-body">
	        <h4 class="modal-title">Process Successfully Done.</h4>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	</div>
</div>
<script type="text/javascript">
	
	jQuery(document).ready(function() {
		jQuery('.revbtn').click(function(){
			var id = jQuery(this).data('id');
			jQuery('.show_log_'+id).slideToggle();
		});
		jQuery('.invoiceSignArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
	});
	jQuery("#savebtn").click(function(e){
		var order_id = '<?php echo $this->input->get('order_id') ?>';
		var total_amount = '<?php echo $sum;?>';
		var output = jQuery('.invoice-sign-output').val();
		if(output == ''){
			alert('Please sign before submission');
			return false;
		}
		html2canvas([document.getElementById('invoice-sign-pad')], {
			onrendered: function (canvas) {
				var canvas_img_data = canvas.toDataURL('image/png');
				var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
				// ajax call to save image inside folder
				jQuery.ajax({
					url: base_url+'app/orders/save_sign',
					data: { img_data:img_data },
					type: 'post',
					dataType: 'json',
					async: false,
					success: function (response) {
						//alert(response.file_name);
						save_invoice_for_biling(order_id, total_amount,response.file_name);
					}
				});
			}
		});
	});
	function save_invoice_for_biling(order_id, total_amount, content ){
		//alert(content);
		jQuery.ajax({
			url: base_url+'app/orders/save_billing',
			data: { order_id:order_id, total_amount:total_amount, content:content, ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				$('#signModal').modal('hide');
				$('#msgModal').modal('show');
				setTimeout(function(){ window.location.href=base_url+'app/orders/preview_invoice/?order_id='+order_id; }, 4000);
				
			}
		});
	};
</script>