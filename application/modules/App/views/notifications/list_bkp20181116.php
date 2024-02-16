<div class="subnav">
	<div class="container-fluid">
    	<h1><span class="glyphicon glyphicon-envelope"></span> Inbox</h1>

        <div id="sub-menu" class="pull-right">
        	<ul class="nav nav-pills">
        		<li class="active"><a href="<?php echo base_url('app/notifications');?>"><span class="glyphicon glyphicon-envelope"></span> Inbox</a></li>
    			<li><a href="<?php echo base_url('app/notifications/add/');?>"><span class="glyphicon glyphicon-pencil"></span> Compose</a></li>
				
				<?php if ($this->session->userdata('role') == 'administrator') {?>
				<li><a href="<?php echo base_url('app/notifications/add/?folder=announcement');?>"><span class="glyphicon glyphicon-bullhorn"></span> Announce</a></li>
				<?php }?>
    		</ul>
        </div>
    </div>
</div>

<div class="container-fluid main">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
		<li class="active">Inbox</li>
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
	
	<div class="row">
		<div class="col-md-3"> 
			<div class="list-group">
			  <a href="<?php echo base_url('app/notifications');?>" class="list-group-item <?php if($folder=="inbox") {echo "active";}?>">Inbox <?php if($unread_inbox>0){?><span class="badge"><?php echo $unread_inbox;?></span><?php }?></a>
			  <a href="<?php echo base_url('app/notifications/?folder=sent');?>" class="list-group-item <?php if($folder=="sent") {echo "active";}?>">Sent</a>
			  <a href="<?php echo base_url('app/notifications/?folder=announcement');?>" class="list-group-item <?php if($folder=="announcement") {echo "active";}?>">Announcements <?php if($unread_announcement>0){?><span class="badge"><?php echo $unread_announcement;?></span><?php }?></a>
			</div>
		</div>
		<div class="col-md-9">
		
			<div class="notification-list <?php echo $folder;?>" id="notification_list">
				<!-- Table -->
				<table class="table table-responsive" width="100%">
					<tbody>
						<?php if (count($notifications) == 0) { ?>
						<tr>
							<td colspan="100%">Your list is empty.</td>
						</tr>
						<?php } ?>
						
						<?php foreach($notifications as $item) { //print_r($item); ?>
						<?php $summery = "<span>".$item->subject."</span> - ".strip_tags($item->description); $summery = character_limiter($summery, 85);?>
						<tr class="clickable-row <?php echo $item->status;?>" data-folder="<?php echo $folder;?>" data-id="<?php echo $item->id;?>">
							<?php if($folder<>"announcement") {?>
							<td width="20%"><span><?php echo $item->created_by_name;?></span></td>
							<?php }?>
							<td><?php echo $summery;?></td>
							<td width="200"><?php echo datetime_display($item->created_on);?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			
			<div class="notification-details" id="notification_details">
				
			</div>
		</div>
	</div>
	<?php echo $this->pagination->create_links(); ?>
</div>

<!-- Notification Users Modal -->
<div class="modal fade bs-example-modal-sm" id="notificationUsersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Recipients</h4>
		    </div>
		    <div class="modal-body">
				<table class="table table-striped table-responsive" width="100%">
			    	<thead>
			    		<tr>
			          		<th>Name</th>
			          		<th>Email</th>
							<th>Read / Unread</th>
			          	</tr>
			        </thead>
					<tbody></tbody>
			   </table>
			</div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		</div>
	</div>
</div>
