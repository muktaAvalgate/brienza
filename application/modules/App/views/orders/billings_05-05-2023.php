<style>
	.table>thead>tr>th {
	    vertical-align: middle;
	    padding: 10px 3px !important;
	    border: 0;
	    font-size: 14px !important;
	    text-align: center;
	}
	.table>tbody>tr>td {
	    text-align: center;
	    font-size: 14px !important;
	}
	.table td img {
		border-radius: 0%;
		border: 0px solid #bfd7ef;
	}

	.sorting_1 .changetagbillAdmin {
    position: absolute;
    left: 1px;
    top: 2px;
    color: #fff;
    padding: 4px 4px;
    font-size: 14px;
}

.sorting_1 .mainAdmin {
    position: absolute;
    left: 1px;
    top: -3px;
    color: #fff;
    padding: 4px 4px;
    font-size: 14px;
	width: 75%;
}


</style>
<div class="subnav">
	<div class="container-fluid">
    	<h1> Admin Billing & Processing Center</h1>
		
		<div id="sub-menu" class="pull-right">
        	<!-- <ul class="nav nav-pills">
			</ul> -->
				<div class="form-group" style="margin-top: 10px;">
					<select name="session" class="form-control" onchange="getsessionids(this.value)">
						<?php foreach ($s_array as $key => $value) {?>
						<option value="<?php echo $key;?>" <?php if ($session == $key) {echo "selected";}?>><?php echo $value;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group" style="margin-top: 10px;">
				<span><b>Total hours assigned : <?php echo $totHoursAssgnd?round($totHoursAssgnd->total_assigned_hours):0;?></b></span>
				</div>
				<div class="form-group" style="margin-top: -10px;">
				<span><b>Total hours scheduled : <?php echo $totHoursSchedule?round($totHoursSchedule->total_scheduled_hours):0;?></b></span>
				</div>
        </div>
    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li>Admin Billing & Processing Center</li>
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
		
		$attributes = array('class' => 'form-inline search-form', 'id' => 'order-search-form', 'role' => 'form');
		echo form_open('app/orders/billings_search', $attributes);
	?>

	<fieldset>
		<!-- <legend><span class="glyphicon glyphicon-filter"></span> Filters</legend> -->
		<legend>
			<div class="row">
				<div class="col-md-1" id="button" style="cursor:pointer;"><span class="glyphicon glyphicon-filter"></span> Filters</div>
				<div class="col-md-11"></div>
			</div>
		</legend>
		<!-- <div class="row"> -->
		<div class="row" id="item" style="display:none";>
		<input type="hidden" id="hdnSession" name="hdnSession" value="<?php echo $session?>">	
			<div class="col-md-12">
				
				<div class="form-group">
					<select name="presenter" class="form-control" id="presenter_id">
						<option value="" selected>Select a presenter</option>
						<?php foreach ($presenters as $item) {?>
						<option value="<?php echo $item->id;?>" <?php if ($presenter == $item->id) {echo "selected";}?>><?php echo $item->first_name." ".$item->last_name;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control calender-control" id="billing_due_date" name="billing_due_date" placeholder="Billing Due Date" value="<?php if (isset($billing_due_date) && $billing_due_date != '') {echo date('m/d/Y', strtotime($billing_due_date));}?>" size="15" >
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="purchase_order_no" name="purchase_order_no" placeholder="Purchase Order number" value="<?php if (isset($purchase_order_no)) {echo $purchase_order_no;}?>" size="25" >
				</div>
				<div class="form-group">
                	<!-- <button type="button" class="btn btn-default" onclick="window.location=''"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
					<!-- <button type="button" class="btn btn-default" onclick="sessionDestroy();"><span class="glyphicon glyphicon-refresh"></span> Reset</button> -->
					<button type="button" class="btn btn-default" onclick="resetForm();"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
		</div>
	</fieldset>
	<?php echo form_close();?>

	
	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive table-hover" width="100%">
	    	<thead>
	    		<tr>
	          		<th>Purchase Order No</th>
	          		<th>Work Plan </th>
					<th>School</th>
					<th>Presenter</th>
					<th>Presenter INV#</th>
					<th>Billing Due Date</th>
					<th>INVOICE AMT</th>
					<th>TPD TAG</th>
					<th>ACTION</th>
					
	          	</tr>
	        </thead>
	        <tbody>
	            <?php
	            if(count($billings) > 0){
	            	foreach($billings as $item){
	            ?>
	            <tr>
				<td class="sorting_1" style="padding-right: 8px;width: 180px;"><?php echo $item->order_no;?>
					<?php if($item->re_upload_change == 1 && $item->late_flag == 1){ ?>
						<div class="latetagbillAdmin" style="top: 2px">Late</div>
						<div class="changetagbillAdmin" style="top: 27px; left: 6px;"><img src=<?php echo base_url('assets/dist/images/hazard.png')?> style="width: 20px; height: 20px;"></div>
					<?php }else{
						if($item->re_upload_change == 1){ ?>
							<div class="changetagbillAdmin" style="top: 20px; left: 6px;"><img src=<?php echo base_url('assets/dist/images/hazard.png')?> style="width: 20px; height: 20px;"></div>
						<?php }
						if($item->late_flag == 1){ ?>
							<div class="latetagbillAdmin" style="top: 2px">Late</div>
                    <?php }} ?>

                    </td>
	            	<td><?php echo $item->work_plan_number;?></td>
	            	<td><?php echo $item->school_name;?></td>
					<td><?php echo $item->presenter_name;?></td>
					<td><?php echo $item->presenter_invoice;?></td>
					<!-- <td><?php //if($item->billing_date != NULL){echo date('m/d/Y', strtotime($item->billing_date));} ?></td> -->
					<td>
						<?php 
							// if($item->public_school_title_status=='checked' && $item->is_old_order == '1'){
							if($item->is_public_title=='checked' && $item->is_old_order == '1'){
								echo 'Next available payroll cycle.';
							}else{if($item->billing_date != NULL){echo date('m/d/Y', strtotime($item->billing_date));}} 
                    	?>
					</td>

					<td>$<?php echo $item->total_amount;?></td>					
					<td><?php echo $item->tpd_tag;?></td>
	            	<td>
	            		<?php if($item->process == 0){?>
	            			<button class="btn btn-success btn-xs" onclick="billingProcess(<?php echo $item->id?>,<?php echo $item->order_id?>)">Process</button>
	            		<?php }else{
	            		?>
	            			<a href="<?php echo base_url().$item->download_document;?>" download id="dwn<?php echo $item->id;?>" style="display: none;">Download</a>
	            			<button class="btn btn-success btn-xs" onclick="tpd_tag_show(<?php echo $item->id;?>, '<?php echo $item->tpd_tag;?>');">Download</button>
	            		<?php } ?>
	            	</td>
	            </tr>
	            <?php
	           		}
	            }else{
	            ?>
	            <tr>
					<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php
	            }
	            ?>
	            
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="16">
						
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>

	<?php echo $this->pagination->create_links(); ?>
</div>
<div id="msgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" style="color:#763199;">Please provide the TPD TAG for your new invoice below.</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="row">
	      		<div class="col-md-10">
	      			<input type="text" name="tpd_tag" id="tpd_tag" class="form-control" minlength="25" maxlength="25" style="color: #763199;font-size: 30px;font-weight: 900;">
	      			<input type="hidden" name="bill_id" id="bill_id">
	      		</div>
	      		<div class="col-md-1">
	      			<button class="btn btn-default" onclick="update_tpd_tag();"><i class="fa fa-pencil" aria-hidden="true"></i></button>
	      		</div>
	      	</div>
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	</div>
</div>
<script type="text/javascript">
	function billingProcess(id,order_id){
		jQuery.ajax({
			url: base_url+'app/orders/billingProcess',
			data: { order_id:order_id, billing_id:id,ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				window.location.href=base_url+'app/orders/billings';
			}
		});
	}
	function tpd_tag_show(id,tpd_tag){
		$('#bill_id').val(id);
		$('#tpd_tag').val(tpd_tag);
		$('#msgModal').modal('show');
	}
	function update_tpd_tag(){
		var d = new Date();
  		var time = d.getTime();
		var btdwn = $('#bill_id').val();
		jQuery.ajax({
			url: base_url+'app/orders/update_tpd_tag',
			data: { tpd_tag:$('#tpd_tag').val(), billing_id:$('#bill_id').val(),ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				var element = document.getElementById("dwn"+btdwn);
                element.setAttribute('download', time);
                element.click();
				location.reload();
				// window.location.href=base_url+'app/orders/billings';
			}
		});
	}

	$( "#button" ).click(function() {
		$( "#item" ).toggle();
	});

	function getsessionids(session){
		$('#hdnSession').val(session);
		$("#order-search-form").submit();
	}
	function resetForm(){
		sessionId = $('#hdnSession').val();
		$('#presenter_id').val('');
		$('#billing_due_date').val('');
		$('#purchase_order_no').val('');
		$("#order-search-form").submit();
	}

	// function sessionDestroy(){
	// 	jQuery.ajax({
	// 		url: base_url+'app/orders/destroySessionFilter',
	// 		success: function (response) {
	// 			window.location.href=base_url+'app/orders/billings';
	// 		}
	// 	});
	// }
</script>




