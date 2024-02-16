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
			  <a href="<?php echo base_url('app/notifications');?>" class="list-group-item <?php if($folder=="inbox") {echo "active";}?>">Inbox <?php if($unread_inbox>0){?><span class="badge" style="color: #fff; background-color: #d9534f;"><?php echo $unread_inbox;?></span><?php }?></a>
			  <a href="<?php echo base_url('app/notifications/?folder=sent');?>" class="list-group-item <?php if($folder=="sent") {echo "active";}?>">Sent</a>
			  <a href="<?php echo base_url('app/notifications/?folder=announcement');?>" class="list-group-item <?php if($folder=="announcement") {echo "active";}?>">Announcements <?php if($unread_announcement>0){?><span class="badge" style="color: #fff; background-color: #d9534f;"><?php echo $unread_announcement;?></span><?php }?></a>
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

						<?php if($item->teacher_name != NULL && $item->grade != NULL) {?>
                        <?php $summery .="</br>"; ?>
                        <?php $summery .="Teacher-".$item->teacher_name.", Grade-".$item->grade; ?>
                        <?php } ?>

						<tr class="clickable-row <?php echo $item->status;?>" data-folder="<?php echo $folder;?>" data-id="<?php echo $item->id;?>" data-role="<?php echo $this->session->userdata('role');?>">
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



<!-- Notification Users Modal -->
<div class="modal fade bs-example-modal-sm" id="notificationReplyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Reply</h4>
		    </div>
		    <div class="modal-body">
				<div class="">
				<form action="<?php echo base_url('app/notifications/reply') ?>" class ="form-horizontal" id = "send-reply-form" role = "form" data-toggle = "validator">
					<fieldset>
					  	<div class="form-group">
							<label for="inputReply" class="col-sm-2 control-label">Sender</label>
							<div class="col-sm-10">
					  			<input class="form-control" type="text" value="" id="notify_sender" readonly="readonly" disabled="disabled">
							</div>
					  	</div>
					  	<div class="form-group">
							<label for="notify_ques" class="col-sm-2 control-label">Question</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="notify_ques" rows="3" readonly="readonly" disabled="disabled"></textarea>
								<div class="help-block with-errors"></div>
					  		</div>
					  	</div>
					  	<div class="form-group">
							<label for="inputReply" class="col-sm-2 control-label">Message</label>
							<div class="col-sm-10">
					  			<textarea class="form-control" name="description" id="inputReply" placeholder="Compose your message .." rows="8" required ></textarea>
								<div class="help-block with-errors"></div>
							</div>
					  	</div>

					</fieldset>

					<input type="hidden" name="notification_id" id="notificationId">
					<input type="hidden" name="sender_id" id="sender_id">
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-9">
							<button type="button" class="btn btn-primary" id="btnReply"><span class="glyphicon glyphicon-ok-sign"></span> Send</button>
						</div>
					</div>
				</form>
				</div>
				
			</div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		    </div>
		</div>
	</div>
</div>

<script>
	
	jQuery(document).ready(function(){
		jQuery("#btnReply").click(function(){
			var reply = jQuery('#inputReply').val();
			var notification_id = jQuery('#notificationId').val();
			var sender_id = jQuery('#sender_id').val();
			var folder = jQuery(this).data("folder");

			jQuery.ajax({
		        type: "POST",
		        url: base_url+"app/notifications/reply_notification/",
		        data: jQuery('form#send-reply-form').serialize(),
		        async: true,
		        success: function(response){
		        	
					$table = '<table class="table table-responsive" width="100%">';
					$table += '<tbody>';

					$table += '<tr>';
					$table += '<td colspan="3"><h4>'+response.subject+'</h4>';
					if(!response.reply){
						$table += '<a class="btn btn-default btn-xs pull-right" href="javascript:;" data-target="#notificationReplyModal" data-toggle="modal" title="Reply"><span class="fa fa-share"></span> Reply</a>';
					}
					$table += '</td>';
					$table += '</tr>';
					if(response.reply){
						$table += '<tr class="no-bdr">';
						$table += '<td>';
						$table += '<strong><i class="fa fa-user fa-3" aria-hidden="true"></i> '+response.reply.created_by_name+'</strong> ';
						if (folder == "sent") {
							$table += '<a class="btn btn-default btn-xs" href="javascript:;" data-target="#notificationUsersModal" data-toggle="modal" onclick="viewRecipients('+response.id+', \''+response.type+'\')" title="Recipients"><span class="fa fa-share"></span> Recipients</a>';
						}
						$table += '</td>';
						$table += '<td class="text-right">'+response.reply.created+'</td>';
						$table += '</tr>';
						
						$table += '<tr>';
						$table += '<td colspan="3">'+response.reply.reply+'</td>';
						$table += '</tr>';
					}

					$table += '<tr class="no-bdr">';
					//$table += '<td width="20"><h1></h1></td>';
					$table += '<td>';
					$table += '<strong><i class="fa fa-user fa-3" aria-hidden="true"></i> '+response.created_by_name+'</strong> ';
					if (folder == "sent") {
						$table += '<a class="btn btn-default btn-xs" href="javascript:;" data-target="#notificationUsersModal" data-toggle="modal" onclick="viewRecipients('+response.id+', \''+response.type+'\')" title="Recipients"><span class="fa fa-share"></span> Recipients</a>';
					}
					$table += '</td>';
					$table += '<td class="text-right">'+response.created_on+'</td>';
					$table += '</tr>';
					
					$table += '<tr>';
					$table += '<td colspan="3">'+response.description+'</td>';
					$table += '</tr>';

					$table += '</tbody>';
					$table += '</table>';

					jQuery("#notification_details").html($table);
		        	jQuery('#notificationReplyModal').modal('hide');
		        }
		    });
	    });


		jQuery(".clickable-row").click(function(){
			jQuery('.pagination').css('display', 'none');
	    });
	});
</script>