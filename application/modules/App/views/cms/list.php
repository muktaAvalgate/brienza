<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-edit"></span> Manage Content</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
        		<li class="active"><a href="<?php echo base_url('/app/cms');?>"><span class="glyphicon glyphicon-edit"></span> Contents</a></li>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Manage Content</li>
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

	<div class="table-responsive">
		<!-- Table -->
	    <table class="table table-striped table-responsive table-hover" width="100%">
	    	<thead>
	    		<tr>
					<th><input type="checkbox" id="checkall"></th>
					<th>Page Name</th>
	          		<th>Title</th>
					<th>Last Updated</th>
					<th>Action</th>
	          	</tr>
	        </thead>
	        <tbody>
	            <?php if (count($cms) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($cms as $item) { ?>
	            <tr>
					<td><input type="checkbox" name="item_id[<?php echo $item->id;?>]" class="checkbox-item" value="Y"></td>
					<td><?php echo anchor_popup('page/'.$item->page_type.'/?nocache=1', $item->name, array('title' => 'Preview Page'));?></td>
					<td><?php echo $item->title;?></td>
					<td><?php echo datetime_display($item->updated_on);?> by <?php echo $item->updated_by_name;?></td>
	            	<td class="text-nowrap">
						<?php
							echo render_action(array('edit'), $item->id);
						?>
	            	</td>
	            </tr>
	            <?php } ?>
	        </tbody>
	    </table>
	</div>

</div>


<script>
	<?php if (isset($filter) && $filter['field'] <> "") {?>
		updateSearchFields('<?php echo $filter['field'];?>', '<?php echo $filter['ope'];?>', '<?php echo $filter['q'];?>');
	<?php }?>

	/*$(".table").colResizable({
		liveDrag:true,
		//gripInnerHtml:"<div class='grip'></div>",
		//draggingClass:"dragging",
		resizeMode:'overflow',
	   	postbackSafe:true,
	   	partialRefresh:true
	});*/
</script>
