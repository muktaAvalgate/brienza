<style>
.log_template{
    position: absolute;
    right: 50px;
    top: 150px;

}
</style>

<div class="container clearfix">
    <div class="main-content">
	<div class="row">
			<div class="col-sm-10 col-md-10 page-name">
            </div>
			<div class="col-sm-2 col-md-2 page-name">
				<div class="form-group" style="margin-top: 10px;">
				
				</div>
            </div>
		</div>
		<div class="row page-heading">
			<div class="col-sm-10 col-md-10 page-name">
                <h3 style="margin-top: 40px;">Log List </h3>
            </div>
		</div>

        <div>
          <button class="btn btn-primary log_template" onclick="window.location.href = '<?php echo base_url('app/presenters/create_log_templates/') ?>'">Add Log Template</button>
	    </div>
	
	
		<div class="row">
			<table class="table table-striped table-bordered" id="datatable-order" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<thead>
					<tr role="row">
						<th>School</th>
						<th>Title</th>
						<th>Order number</th>
						<th>Hours to confirm</th>						
						<th></th>
					</tr>
                </thead>
                <tbody>
					<?php $i = 1;?>
					<?php foreach($orders as $order) {?>					
						<tr class="gradeA <?php echo ($i%2==0)?'even':'odd'?>" role="row">
							<td class="sorting_1"><?php echo $order->school_name;?><?php if (!$order->total_hours_scheduled){?><div class="new">New</div><?php }?></td>
							<td><?php echo $order->title_name;?></td>
							<td>
								<?php if($billing==true){  
									echo $order->order_no;
									?>
								<?php }else{ ?>
									<a href="<?php echo base_url('app/presenters/billing_pre/?order_id='.$order->id);?>"><?php echo $order->order_no;?> </a>
								<?php } ?>
							</td>
							<td class="center">
								<?php
								echo number_format($order->assigned_hours - $order->c_hours).'/'.$order->assigned_hours.' hours to confirm';
								 ?>
							</td>
							<td class="center">
								<?php   
									if(($order->assigned_hours - $order->total_hours_scheduled) > 0){
								?>
									<a href="<?php echo base_url("app/presenters/scheduling/?school_id=".$order->school_id."&order_id=".$order->id);?>" class="btn btn-success">Schedule hours</a>
									
								<?php } ?>
							</td>
						</tr>
						<?php $i++;?>
					<?php }?>
					<?php if (count($orders) == 0) { ?>
						<tr class="gradeA">
							<td colspan="100%">Sorry!! No Records found.</td>
						</tr>
					<?php } ?>
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

<script>
	function getPreOdrDtls(session){
		jQuery.ajax({
			url: base_url+'app/presenters/order',
			data: { session:session, ajaxCall:true },
			type: 'post',
			async: false,
			success: function (response) {
				window.location.href = base_url+"app/presenters/order/?pre_session_id="+session;
			}
		});
	}
</script>

