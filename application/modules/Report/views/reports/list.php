 <div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-list-alt"></span> Reports</h1>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb hidden-print">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Reports</li>
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

		$attributes = array('class' => 'form-horizontal hidden-print', 'id' => 'report-form');
		echo form_open(base_url('report/reports/search_submit'), $attributes);
	?>
		<fieldset>
			<legend>Report Filters</legend>
			<div class="row">
				<div class="col-md-6">

					<div class="form-group">
				  		<label for="inputType" class="col-sm-3 control-label">Log Type </label>
				  		<div class="col-sm-7">
					  		<select name="type" id="inputType" class="form-control" >
				  				<option value="" selected>Select a Type</option>
				  				<option value="info" <?php if (isset($filter['type']) && $filter['type'] == 'info') {echo 'selected';}?>>Info</option>
								<option value="debug" <?php if (isset($filter['type']) && $filter['type'] == 'debug') {echo 'selected';}?>>Debug</option>
								<option value="error" <?php if (isset($filter['type']) && $filter['type'] == 'error') {echo 'selected';}?>>Error</option>
							</select>
					  		<div class="help-block with-errors"></div>
					  	</div>
				  	</div>
  				</div>
  				<div class="col-md-6">
  					<?php $title = ""; if (isset($filter['title']) && $filter['title']) {$title = $filter['title'];}?>
					<div class="form-group">
					    <label for="inputTitle" class="col-sm-2 control-label">Contents</label>
						<div class="col-sm-7">
					    	<input type="text" class="form-control" id="inputTitle" name="title" placeholder="Search Content" value="<?php echo $title;?>">
					    </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">

					<div class="form-group">
    					<div class="col-sm-offset-3 col-sm-9">
				      		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>&nbsp;
				      		<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('report/reports/index');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
				   	 	</div>
				  	</div>

				</div>
  				<div class="col-md-6">

					<div class="form-group">
					    <div class="col-sm-12 text-right">

					   		<div class="btn-group" role="group" aria-label="...">
								<a class="btn btn-default" href="<?php echo base_url($this->uri->uri_string()."/action/print");?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Print</a>

							  	<div class="btn-group" role="group">
							    	<button type="button" class="btn btn-info"><span class="glyphicon glyphicon-download-alt"></span> Export To</button>
  									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							      		<span class="caret"></span>
							      		<span class="sr-only">Toggle Dropdown</span>
							    	</button>
							    	<ul class="dropdown-menu dropdown-menu-right">
							      		<li><a href="<?php echo base_url($this->uri->uri_string()."/action/csv");?>">CSV</a></li>
							   	 	</ul>
							  	</div>
							</div>

					    </div>
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
		<table class="table table-striped table-responsive" width="100%">
		    <thead>
				<tr>
		        	<th>Sl. No.</th>
		          	<th>Type</th>
		          	<th>Action</th>
		          	<th>Title</th>
	          		<th>Created</th>
		        </tr>
		   	</thead>
		    <tbody>
		    	<?php if (count($rows) == 0) { ?>
		            <tr>
		            	<td colspan="100%">Sorry!! No Records found.</td>
		            </tr>
		       	<?php } ?>
		       	<?php $count = (($page_no-1)*RECORD_PER_PAGE)+1;?>

				<?php foreach($rows as $item) { ?>
					<?php //print "<pre>"; print_r($item);print "</pre>";?>
		            <tr>
		            	<td><?php echo $count;?></td>
		            	<td><?php echo ucfirst($item->type);?></td>
		            	<td><?php echo ucfirst($item->subtype);?></td>
		            	<td><?php echo $item->title;?></td>
		            	<td>
		            		On <small><?php echo datetime_display($item->created_on);?></small><br />
			    			by <small><?php echo $item->created_by_name;?></small>
			    		</td>
		            </tr>
		            <?php $count++;?>
		        <?php } ?>
		    </tbody>
		   	<tfoot>
				<tr>
					<td colspan="4" class="hidden-print">
						<?php
							if (isset($filter['limit']) && $filter['limit'] > 0) {
								echo $this->pagination->create_links();
							} else {
								echo "<script>window.print();</script>";
							}
						?>
					</td>
	               	<td colspan="100%" class="text-right" style="vertical-align: middle;">
						Total <?php echo $total_rows;?> records found.
					</td>
				</tr>
			</tfoot>
		</table>
	</div>



</div>
