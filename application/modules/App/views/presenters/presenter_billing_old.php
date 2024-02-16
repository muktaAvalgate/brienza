
<link href="<?php echo HTTP_CSS_PATH;?>/jquery.signaturepad.css" rel="stylesheet">
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="<?php echo HTTP_JS_PATH;?>/plugins/numeric-1.2.6.min.js"></script> 
<script src="<?php echo HTTP_JS_PATH;?>/plugins/bezier.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/jquery.signaturepad.js"></script> 
		
<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script src="<?php echo HTTP_JS_PATH;?>/plugins/json2.min.js"></script>




<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Billing</h3>
            </div>
            <!--<div class="col-sm-3 col-md-3 usersearch">
				<form action="javascript:void(0);" method="post">
					<input type="search" name="" id="" placeholder="Search">
					<button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
			</div>-->
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
			//print "<pre>"; print_r($orders);
		?>
	
		<div class="row">
			<table class="table table-bordered" id="datatable-order" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<thead>
					<tr role="row">
						<th>School</th>
						<th>Title</th>
						<th>Order number</th>
						<th>Hours to confirm</th>
						<th>Billing Period</th>
						<th>Billing due date</th>
						<th></th>
					</tr>
                </thead>
                <tbody>
				


					<tr style="border-top:1px solid;">
						<td>Xaviers</td>
						<td>Test1</td>
						<td data-toggle="collapse" data-target="#odrNo1" aria-expanded="false" style="cursor:pointer;">ODRNO12345</td>
						<td>2/2 hours to confirm</td>
						<td>3/01/21 to 03/15/21</td>
						<td>05/01/21</td>
						<td class="center">
							<button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal"  odrId="" >Submit Invoice</button>
							<!-- <button type="button" class="btn prvbtn" onclick="window.open('../../assets/teachers/brienza_smpl.pdf', '_blank')" >Download Invoice</button> -->
						</td>
					</tr>
					<tr class="collapse" id="odrNo1">
						<td colspan="7" width="100%">
						<table class="table table-striped table-responsive table-hover sub-order" width="100%">
								<tr>
									<th>Date Of Service</th>
									<th>Total Hours</th>
									<th>Status</th>
									<th></th>
								</tr>
							
								<tr>
									<td style="border:2px solid #763199;">03/08/2021 @ 07:15 am to 09:15 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
										<select class="form-control">
											<option selected>Confirm Hours</option>
											<option value="1">Create log</option>
										</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<!-- <button type="button" class="btn prvbtn" data-toggle="modal" data-target="#signModal" id="preview_invoice" odrId="" >View History</button> -->
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
								<tr>
									<td style="border:2px solid #763199;">03/10/2021 @ 07:00 am to 09:00 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
										<select class="form-control">
											<option selected>Approved</option>
											<option value="1">Confirm</option>
										</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
								<tr>
									<td style="border:2px solid #763199;">03/12/2021 @ 07:15 am to 09:15 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
									<select class="form-control">
										<option selected>Approved</option>
										<option value="1">Confirm</option>
									</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
							
						</table>
						<button type="submit" class="btn btn-primary" id="orderUpdateStatus"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button>
						</td>
					</tr>

					<tr style="border-top:1px solid;">
						<td>Xaviers</td>
						<td>Test1</td>
						<td data-toggle="collapse" data-target="#odrNo12" aria-expanded="false" style="cursor:pointer;">ODRNO12345</td>
						<td>2/2 hours to confirm</td>
						<td>3/15/21 to 03/31/21</td>
						<td>05/15/21</td>
						<td class="center">
							<!-- <button type="button" class="btn prvbtn" data-toggle="modal" data-target="#signModal" id="preview_invoice" odrId="" >Submit Invoice</button> -->
							<button type="button" class="btn dwnbtnnew" onclick="window.open('../../assets/teachers/brienza_sampl.pdf', '_blank')" >Download Invoice</button>
						</td>
					</tr>
					<tr class="collapse" id="odrNo12">
						<td colspan="7" width="100%">
						<table class="table table-striped table-responsive table-hover sub-order" width="100%">
								<tr>
									<th>Date Of Service</th>
									<th>Total Hours</th>
									<th>Status</th>
									<th></th>
								</tr>
							
								<tr>
									<td style="border:2px solid #763199;">03/16/2021 @ 07:15 am to 09:15 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
										<select class="form-control">
											<option selected>Approved</option>
											<option value="1">Confirm</option>
										</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<!-- <button type="button" class="btn prvbtn" data-toggle="modal" data-target="#signModal" id="preview_invoice" odrId="" >View History</button> -->
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
								<tr>
									<td style="border:2px solid #763199;">03/20/2021 @ 07:00 am to 09:00 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
										<select class="form-control">
											<option selected>Approved</option>
											<option value="1">Confirm</option>
										</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
								<tr>
									<td style="border:2px solid #763199;">03/24/2021 @ 07:15 am to 09:15 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
									<select class="form-control">
										<option selected>Approved</option>
										<option value="1">Confirm</option>
									</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
							
						</table>
						<button type="submit" class="btn btn-primary" id="orderUpdateStatus"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button>
						</td>
					</tr>
					
					<tr style="border-top:1px solid;">
						<td class="sorting_1">Modern High School<div class="latetag">Late</div></td>
						<td>Test2</td>
						<td data-toggle="collapse" data-target="#odrNo2" style="cursor:pointer;">ODRNO12346</td>
						<td>4/4 hours to confirm</td>
						<td>05/01/21 to 05/15/21</td>
						<td>11/07/21</td>
						<td class="center">
							<button type="button" class="btn subbtn" data-toggle="modal" data-target="#signModal" id="preview_invoice" odrId="">Submit Invoice</button>
							<!-- <button type="button" class="btn prvbtn" onclick="window.open('../../assets/teachers/brienza_smpl.pdf', '_blank')" >Download Invoice</button> -->
						</td>
					</tr>
					<tr>
						<td class="sorting_1" colspan="7"><div class="late">This invoice has not been submitted on time, admin has been notified.</div></td>
					</tr>
					<tr class="collapse" id="odrNo2">
						<td colspan="7" width="100%">
						<table class="table table-striped table-responsive table-hover sub-order" width="100%">
								<tr>
									<th>Date Of Service</th>
									<th>Total Hours</th>
									<th>Status</th>
									<th></th>
								</tr>
							
								<tr>
									<td style="border:2px solid #763199;">05/04/2021 @ 07:15 am to 09:15 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
									<select class="form-control">
										<option selected>Approved</option>
										<option value="1">Confirm</option>
									</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
								<tr>
									<td style="border:2px solid #763199;">05/06/2021 @ 07:00 am to 09:00 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
									<select class="form-control">
										<option selected>Approved</option>
										<option value="1">Confirm</option>
									</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
								<tr>
									<td style="border:2px solid #763199;">05/08/2021 @ 07:15 am to 09:15 am with Miss R.B, Grade - 1st Grade, Topic -testing11-06</td>
									<td style="border:2px solid #763199;background-color:#fff;">2</td>
									<td width="20%" style="border:2px solid #763199;">
									<select class="form-control">
										<option selected>Approved</option>
										<option value="1">Confirm</option>
									</select>
									</td>
									<td width="20%" style="border:2px solid #763199;">
										<button type="button" class="btn prvbtn" data-toggle="modal" data-target="#historyModal" style="margin-top: 4px;">View History</button>
									</td>
								</tr>
							
						</table>
						<button type="submit" class="btn btn-primary" id="orderUpdateStatus"><span class="glyphicon glyphicon-ok-sign"></span> Update Status</button>
						</td>
					</tr>

		
				</tbody>
			</table>      
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
	<?php //echo $this->pagination->create_links(); ?>
</div>



<!-- model -->
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


	<!-- Modal -->
	<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Log History</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<table>
			<tr>
				<td colspan="2">Tuesday, March 8, 2021 @ Miss. P.G 09:45 am-11:45 am</td>
				<td colspan="2"></td>
				<td colspan="2">Awaiting Review</td>
				<td colspan="2"><a href="<?php echo base_url('assets/teachers/log_attachment-sample.pdf');?>" download=""><img src="../../assets/dist/images/attachment-icon.png" style="height:3rem"/></a></td>
			</tr>
			<tr>
				<td colspan="2">Tuesday, March 8, 2021 @ Miss. P.G 09:45 am-11:45 am</td>
				<td colspan="2"></td>
				<td colspan="2">Log sent - awaiting principal signature</td>
				<td colspan="2"><a href="<?php echo base_url('assets/teachers/log_attachment-sample.pdf');?>" download=""><img src="../../assets/dist/images/attachment-icon.png" style="height:3rem"/></a></td>
			</tr>
			<tr>
				<td colspan="2">Tuesday, March 8, 2021 @ Miss. P.G 09:45 am-11:45 am</td>
				<td colspan="2"></td>
				<td colspan="2">Approved</td>
				<td colspan="2"><a href="<?php echo base_url('assets/teachers/log_attachment-sample.pdf');?>" download=""><img src="../../assets/dist/images/attachment-icon.png" style="height:3rem"/></a></td>
			</tr>
			<tr>
				<td colspan="2">Tuesday, March 8, 2021 @ Miss. P.G 09:45 am-11:45 am</td>
				<td colspan="2"></td>
				<td colspan="2">Draft Attached</td>
				<td colspan="2"><a href="<?php echo base_url('assets/teachers/log_attachment-sample.pdf');?>" download=""><img src="../../assets/dist/images/attachment-icon.png" style="height:3rem"/></a></td>
			</tr>
			</table>
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
		</div>
		</div>
	</div>
	</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.invoiceSignArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		// console.log("Hey");
	});

	

</script>


