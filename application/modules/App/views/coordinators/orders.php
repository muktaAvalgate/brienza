<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Orders</h3>
            </div>
            <div class="col-sm-3 col-md-3 usersearch">
				<form action="javascript:void(0);" method="post">
					<input type="search" name="" id="" placeholder="Search">
					<button type="submit" class="btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
			</div>
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
			<table class="table table-striped table-bordered" id="datatable-order" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;" width="100%">
				<thead>
					<tr role="row">
						<th>School</th>
						<th>Title</th>
						<th>Order number</th>
						<th>Hours to schedule</th>
						<th>Last day scheduled</th>
						<th><?php ($billing==true) ? 'Click to billing' : 'Click to schedule'; ?></th>
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
									<a href="<?php echo base_url('app/presenters/billing/?order_id='.$order->id);?>"><?php echo $order->order_no;?> </a>
								<?php } ?>
							</td>
							<td class="center"><?php echo ($order->hours-$order->total_hours_scheduled);?>/<?php echo $order->hours;?> hours to schedule</td>
							<td class="center"><?php echo ($order->last_day_scheduled)?"Last Day ".date_display($order->last_day_scheduled):"No Schedule"?></td>
							<td class="center">
								<?php if($billing==true){ ?>
									<a href="<?php echo base_url("app/presenters/billing/?order_id=".$order->id);?>" class="btn btn-success" target="_blank">Billing</a>
								<?php } else{ ?>
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


