<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-education"></span> Titles</h1>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Titles</li>
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
		echo form_open(base_url('app/presenters/search_titles'), $attributes);
	?>


<fieldset>
		<legend><span class="glyphicon glyphicon-filter"></span> Filters</legend>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" id="" name="order_no" placeholder="Order number" value="<?php if (isset($filter['order_no'])) {echo $filter['order_no'];}?>" size="25" >
				</div>

				<div class="form-group">
					<select name="school" class="form-control" >
						<option value="" selected>Select a school</option>
						<?php foreach ($schools as $item) {?>
						<option value="<?php echo $item->school_id;?>" <?php if ($filter['school'] == $item->school_id) {echo "selected";}?>><?php echo $item->school_name;?></option>
						<?php }?>
					</select>
				</div>
				
				<div class="form-group">
                	<button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url('app/presenters/titles');?>'"><span class="glyphicon glyphicon-refresh"></span> Reset</button>

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
	    <table class="table table-striped table-responsive" style="width:60%">
	    	<thead>
	    		<tr>
					<th>Name</th>
					<th style="text-align:center">Action</th>
	          	</tr>
	        </thead>
	        <tbody>
				<?php //print "<pre>"; print_r($list); print "</pre>";	?>
	            <?php if (count($list) == 0) { ?>
	            <tr>
	            	<td colspan="100%">Sorry!! No Records found.</td>
	            </tr>
	            <?php } ?>
	            <?php foreach($list as $item) { ?>
	            <tr>
					<td><?php echo $item->name;?></td>
	            	<td style="text-align:center">
                        <!-- add new -->
                        <!-- <button type="button" class="btn topicviw" data-toggle="modal" data-target="#titleDetails" data-title_id="<?php echo $item->id;?>"  data-startdate="" data-enddate="" data-schedule_id=""   style="margin-top: 4px;">View Topic Codes</button> -->
						<button type="button" class="btn topicviw" data-toggle="modal" data-target="#titleDetails" data-title_id="<?php echo $item->id;?>"   data-order_no="<?php if($this->uri->segment(4) == 'order_no' && $this->uri->segment(5) != '~'){
							echo $this->uri->segment(5);
						}else{
							echo 'false';
						} ?>" data-enddate="" data-schedule_id=""   style="margin-top: 4px;">View Topic Codes</button>
	            	</td>
	            </tr>
	            <?php } ?>
	        </tbody>
			<tfoot>
				
			</tfoot>
	    </table>
	</div>
	<?php echo form_close();?>

	<?php echo $this->pagination->create_links(); ?>
</div>

	<!-- Modal -->

<div class="modal fade" id="titleDetails" tabindex="-1" role="dialog" aria-labelledby="titleDetailsLabel">
  <div class="modal-dialog" style="width: 50%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="historyLabel">View Topic Codes</h4>
      </div>
      <div class="modal-body" style="padding: 18px;">
	  	<table class="table table-striped table-responsive resultappend" width="100%">
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

$('#titleDetails').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var title_id = button.data('title_id') // Extract info from data-* attributes
	var order_no = button.data('order_no') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    // var startdate = button.data('startdate') 
    // var enddate = button.data('enddate') 
    // var schedule_id = button.data('schedule_id')
    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    // modal.find('.modal-body input').val(recipient)
    $.ajax({
        url: base_url+'app/presenters/viewTitleDetails_ajax',
        data: { title_id:title_id,  order_no:order_no },
        type: 'post',
        success: function (response) {
            // console.log(response);
            modal.find('.modal-body .resultappend').html(response);
            
        },
        error:function(response){
            console.log(response);
        }
    });
})

</script>