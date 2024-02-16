<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-user"></span> List Presenters</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
						<li class="active"><a href="<?php echo base_url('app/coordinator/list_presenters');?>"><span class="glyphicon glyphicon-user"></span> Presenters</a></li>
					</ul>
        </div>

    </div>
</div>


<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Presenter List</li>
	</ol>

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Rate</th>
						<th>Status</th>
						<!-- <th>Action</th> -->
	        </tr>
	        </thead>
	        <tbody>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
							<?php 
							//echo '<pre>'; print_r($list); echo '</pre>';
							foreach($list as $teacher) { ?>
	            <tr>
								<td><a href="javascript:void(0);" title="<?php echo $teacher['id'];?>" class="open_modal"><?php echo $teacher['first_name']." ".$teacher['last_name'];?></a></td>
								<td><?php echo $teacher['email']; ?></td>
								<td><?php echo $teacher['meta']['phone']; ?></td>
								<td><?php if(isset($teacher['meta']['rate'])){ if(strpos($teacher['meta']['rate'], '%')) echo $teacher['meta']['rate']; else echo price_display($teacher['meta']['rate']); } ?></td>
								
								<td><?php echo status_display($teacher['status']);?></td>
<!-- 								<td class="text-nowrap">
									<a href="<?php //echo base_url('app/coordinator/assign_presenter_school_list/'.$teacher['id']);?>" title="Assign Presenter" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> View Presenter</a>
														
								</td> -->
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
          <td colspan="8">
						&nbsp; 
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>

	<?php echo $this->pagination->create_links(); ?>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Presenter Basic Info</h4>
            </div>
            
            <div class="modal-body">


            </div>
            
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>
<!-- Modal -->



<script>
$(document).ready(function () {
	$('.open_modal').on('click', function() {
		var title 	= $(this).attr('title');

		var baseurl = "<?php echo base_url('app/coordinator/view/'); ?>/"+title;
	    $.ajax({
	        url: baseurl,
	        dataType:'html',
	        type: 'post',
	        success: function(data) {
	        	// alert('ugvgv');
				$('.modal-body').html(data);
	        }             
	    });		

		$('#myModal').modal('show');
	});

});
</script>

<?php
	function format_date($str) {
		$str = urldecode($str);
		return str_replace('~', '/', $str);
	}
?>