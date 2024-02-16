
<div class="container-fluid main">

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive" width="100%">
	    	<thead>
	    		<tr>
					<th>School</th>
					<th>Title</th>
					<th>Grade</th>
					<th>Teacher Name</th>
	          	</tr>
	        </thead>
	        <tbody>
	            <?php if (count($school_titles) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php 
	            foreach($school_titles as $key => $st_val) {
	            	foreach($titleData[$key] as $k => $val) {
	           	?>
		            <tr>
						<td><?php echo ucfirst($val['school_name']); ?></td>
						<td><?php echo ucfirst($val['title_name']); ?></td>
						<td><?php echo ucfirst($val['grade_name']); ?></td>
						<td><?php echo ($val['teacher_name'] != '') ? ucfirst($val['teacher_name']) : "--"; ?></td>
		            </tr>
	            <?php } } ?>
	        </tbody>
	    </table>
	</div>
	
</div>
