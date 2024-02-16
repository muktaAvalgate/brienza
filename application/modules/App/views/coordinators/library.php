<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Library</h3>
            </div>
			<div class="col-sm-3 col-md-3 userprint hidden-print">
				<a href="javascript:;" onclick="window.print()"><span class="glyphicon glyphicon-print"><span> Print</a>
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
			<table class="table table-striped table-bordered" id="datatable-library" role="grid" width="100%">
				<thead>
					<tr role="row">
						<th>Order number</th>
						<th>Title</th>
						<th>Topics</th>
					</tr>
                </thead>
                <tbody>
					<?php $i = 1;?>
					<?php foreach($libraries as $library) {?>					
						<tr class="gradeA <?php echo ($i%2==0)?'even':'odd'?>" role="row">
							<td><a href="<?php echo base_url('app/presenters/billing/?order_id='.$library->id);?>"><?php echo $library->order_no;?></a></td>
							<td class="sorting_1"><?php echo $library->title_name;?></td>
							<td class="center">
								<?php $counter = 1;?>
								<?php foreach($library->topics as $topic_id=>$topic) {?>	
									<a href="<?php echo base_url('app/presenters/scheduling/?school_id='.$library->school_id.'&order_id='.$library->id.'&topic_id='.$topic_id);?>"><?php echo $topic;?></a><?php if ($counter <> count($library->topics)) { echo ", ";}?>
									<?php $counter++;?>
								<?php }?>
							</td>
							
						</tr>
						<?php $i++;?>
					<?php }?>
					<?php if (count($libraries) == 0) { ?>
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


