<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
			<div class="col-sm-9 col-md-9 page-name">
                <h3>Library</h3>
            </div>
			<div class="col-sm-3 col-md-3 userprint hidden-print">
				<button type="button" class="btn btn-success btn-xs btn-lg"  data-dismiss="modal" data-toggle="modal" data-target="#myModal">Favourites</button>

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
						<th>Order No</th>
						<th>Work Plan No</th>
						<th>Title</th>
						<th>Topics</th>
					</tr>
                </thead>
                <tbody>
					<?php $i = 1;?>
					<?php foreach($libraries as $library) {?>					
						<tr class="gradeA <?php echo ($i%2==0)?'even':'odd'?>" role="row">
							<td><a href="<?php echo base_url('app/presenters/billing/?order_id='.$library->id);?>"><?php echo $library->order_no;?></a></td>
							<td><?php echo ($library->work_plan_number != '') ? $library->work_plan_number : 'N/A'; ?></td>
							<td class="sorting_1"><?php echo $library->title_name;?></td>
							<td class="center">
								<?php $counter = 1;?>
								<?php foreach($library->topics as $topic_id=>$topic) {
									//echo "<pre>";print_r(count($library->topics));
									?>	
									<?php //foreach($library->description as $topic_id=>$description) {?>
									<span title="<?php echo $topic['topic_des']; ?>">
										<!-- <a href="<?php //echo base_url('app/presenters/scheduling/?school_id='.$library->school_id.'&order_id='.$library->id.'&topic_id='.$topic_id);?>"> -->
											<?php echo $topic['topic_name'];?><?php if ($counter <> count($library->topics) && $topic['topic_name'] !='') { echo ", ";}?>
									<?php $counter++;?></span>
								<?php } ?>
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



<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Favourite Topics</h4>
        </div>
        <div class="modal-body">
        	<?php foreach($favourites_topic as $topic){?>
          <p style="margin-left:40px;  "><?php echo $topic->topic; ?></p>
      <?php } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


