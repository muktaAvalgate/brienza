// App.js
jQuery(document).ready(function() {

	jQuery("input[name='type']").click(function() {
		previewUsers();
	});

	jQuery(".clickable-row").click(function() {

		var notification_id = jQuery(this).data("id");
		var folder = jQuery(this).data("folder");
		var role = jQuery(this).data("role");
		
		jQuery("#notification_list").hide();
		jQuery("#notification_details").show();
		jQuery("#notification_details").html('<span class="glyphicon glyphicon-refresh"></span> Loading please wait..');
		
		jQuery.ajax({
	        type: "POST",
	        url: base_url+"app/notifications/get_notification_details/"+notification_id,
	        async: true,
	        success: function(response){
				$table = '<table class="table table-responsive" width="100%">';
				$table += '<tbody>';

				$table += '<tr>';

				if(response.subject){
				$table += '<td colspan="3"><h4>'+response.subject+'</h4>';
				}else{
					$table += '<td colspan="3"><h4>'+"Message"+'</h4>';
				}
				
				if(role=='administrator' && folder=='inbox' && !response.reply){
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
				// $table += '<td colspan="3">'+response.description+'</br> <span>Teacher Name - </span>'+response.teacher_name+'</br> <span>Grade - </span>'+response.grade+'</td>';
				$table += '<td colspan="3">'+response.description+'</td>';
				$table += '</tr>';

				$table += '</tbody>';
				$table += '</table>';

				jQuery("#notification_details").html($table);
				jQuery("#notificationId").attr('value', notification_id);
				jQuery("#sender_id").attr('value', response.created_by);
	        	console.log(response);
	        }
	    });
		
	});
	
	previewUsers();
});

function previewUsers() {
	
	jQuery("#usersPreview").html('<span class="glyphicon glyphicon-refresh"></span> Loading users..');
	$data = jQuery('#send-notify-form').serialize();

	jQuery.ajax({
	        type: "POST",
	        url: base_url+"app/notifications/get_users/",
	        data: $data,
	        async: true,
	        success: function(response){

				$table = '<table class="table table-striped table-responsive" width="100%">';
				$table += '<tbody>';

				$i = 0;
				$.each(response.users, function( index, item ) {
					$table += '<tr>';
					$table += '<td><input type="checkbox" name="users[]" class="checkbox-item" value="'+item.id+'"></td>';
					$table += '<td>'+item.first_name+' '+item.last_name+' ('+item.email+')</td>';
					$table += '</tr>';
					$i++;
				});
				$table += '</tbody>';
				$table += '</table>';

				jQuery("#usersPreview").html($table);
	        	//console.log(response);
	    }
	});
}
function viewRecipients(id, type) {

	if (id == "") {
		return;
	}

	jQuery("#notificationUsersModal tbody").html('<span class="glyphicon glyphicon-refresh"></span> Loading..');

	jQuery.ajax({
		type: "POST",
		url: base_url+"app/notifications/get_notification_users/"+id,
		data: '&type='+type,
		async: true,
		success: function(response){

			$table = '';
			$.each(response.users, function( index, item ) {
				$table += '<tr>';
				$table += '<td>'+item.name+'</td>';
				$table += '<td>'+item.email+'</td>';
				$table += '<td>';
				if (item.status == 'unread') {
					$table += 'Unread';
				} else {
					$table += 'Read';
				}
				$table += '</td>';
				$table += '</tr>';
			});
			jQuery("#notificationUsersModal tbody").html($table);
			console.log(response);
		}
	});
}
