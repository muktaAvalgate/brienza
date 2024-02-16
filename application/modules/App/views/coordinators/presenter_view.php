<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th></th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Info</th>
					<th>Hourly Rate</th>
					<th>Company Name</th>
					<th>Address</th>
					
	        </tr>
	        </thead>
	        <tbody>
	            <?php
//echo "<pre>";print_r($presenter_list);die;
	             if (count($presenter_list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($presenter_list as $teacher) { ?>
	            <tr>
	            	<td></td>
								<td><?php echo $teacher->first_name." ".$teacher->last_name;?></td>
								<td><?php if(isset($teacher->email)) { echo $teacher->email; } ?></td>
								<td><?php echo $teacher->meta['phone']; ?></td>
								<td><?php echo $teacher->meta['info']; ?></td>
								<td><?php /* if(isset($teacher->meta['rate'])){ if(strpos($teacher->meta['rate'], '%')) echo $teacher->meta['rate']; else echo price_display($teacher->meta['rate']); } */ echo $teacher->meta['rate']; ?></td>
								
								<td><?php if(isset($teacher->meta['company_name'])) { echo $teacher->meta['company_name']; } ?></td>
								<td><?php if(isset($teacher->meta['address'])) {echo $teacher->meta['address']; } ?></td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				<tr>
                	<td colspan="8">
						<?php //echo render_buttons(array('update_status', 'delete'));?>
					</td>
				</tr>
			</tfoot>
	    </table>
	</div>