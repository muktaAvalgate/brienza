<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="shortcut icon" href="assets/favicon.ico">
	    <title><?php echo $page_title;?></title>
		
		<!--<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH."";?>" type="text/css" />-->
		<style>
            .button_template{
                float: right;
                background-color: rgb(117, 48, 153);
                color: white;
                font-size: 12px;
                padding: 12px 11px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border-radius: 8px;

            }

        </style>
  	</head>
<body>
			<select class="button_template" name="topic" class="form-control" id="topic_template" >
                <option value="">View Brienza Templates</option>
                
                <?php foreach ($tem_list as $item) {?>
            
                    
                            <option value="<?php echo $item->id;?>" > <?php echo $item->tmp_name;?></option>
                            
                        <?php }?>
            </select>
        
            <button type="button" class="button_template" data-toggle="tooltip" data-placement="bottom" title="This will display the favorite template added by presenter in the log writing room" onclick="use_favorite_template()">Use Favorite Template</button>

            <button type="button" class="button_template" data-toggle="tooltip" data-placement="bottom" title="This will display the template added by presenter in the log writing room under this topic" onclick="use_custom_template(<?php if(isset($schedule->topic_id)){ echo $schedule->topic_id;} ?>)">Use Custom Template</button>

            <button type="button" class=" button_template" data-toggle="tooltip" data-placement="bottom" title="This will display the topic description saved in the library under this topic" onclick="use_library_topic(<?php if(isset($schedule->topic_id)){ echo $schedule->topic_id;} ?>)">Use Library Topic</button>
<?php
	$attributes = array('class' => '', 'id' => '', 'role' => 'form');
	echo form_open(base_url('app/orders/presenter_billing/?order_id='.$order->id), $attributes);
?>
	<table width="50%" cellpadding="5" cellspacing="0" border="0" style="border:solid 1px; font-family:'Ubuntu', sans-serif;">
		<tr>
			<td><img src="<?php echo base_url('assets/images/logo.png');?>"</td>
			<td align="right" style="color:#813D97;">8696 18th Ave, Brooklyn, NY 11214<br>+718-232-0114 800-581-0887<br>brienzas.com</td>
		</tr>
		<tr>
			<th colspan="2" style="height:40px;"><?php echo $schedule->worktype_name;?> Sign- In Log</th>
		</tr>
		<tr>
			<td align="center" colspan="2" style="height:40px;"><strong>Presenter's Name:</strong> <?php echo $schedule->first_name." ".$schedule->last_name;?></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="height:40px;"><strong>Date:</strong> <?php echo date_display($schedule->start_date, "l, F j, Y");?></td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="height:40px;"><strong>Start Time:</strong> <?php echo time_display($schedule->start_date, true);?> <strong>End Time:</strong> <?php echo time_display($schedule->end_date, true);?> <strong>Total Hours:</strong> <?php echo $schedule->total_hours;?></td>
		</tr>
		<tr>
			<td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>School:</strong> <?php echo $order->school_name;?> <strong>Title:</strong> <?php echo $order->title_name;?> <strong>PO#:</strong> <?php echo $order->order_no;?></td>
		</tr>
		<tr>
			<td align="left" colspan="2" style="height:50px; border-top:solid 1px;"><strong>Topic:</strong> <?php echo $schedule->topic_name;?></td>
		</tr>
		<tr>
			<td align="left" colspan="2" style="border-top:solid 1px;">
				<textarea cols="110" rows="15" name="content" required></textarea>
			</td>
		</tr>

		<tr>
			<?php if(isset($principal_name)){ ?>
				<td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal : </strong> 
					<input type="text" name="principal_nameForLog" class="form-control" id="inputName"  placeholder="Enter name" value="<?php if(isset($principal_name)) {echo $principal_name->meta_value;}?>" required>
				</td>
			<?php }else{ ?>
				<td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal : </strong> 
					<input type="text" name="principal_nameForLog" class="form-control" id="inputName"  placeholder="Enter name" value="<?php echo 'N/A' ?>" required>
				</td>
			<?php } ?>
			
			<td align="left" style="height:50px; border-top:solid 1px;"></td>
		</tr>

		<tr>
			<td align="left" style="height:50px; border-top:solid 1px;"><strong>Principal’s Signature:</strong></td>
			<td align="right" style="height:50px; border-top:solid 1px;"><strong>Total Hours:</strong> <?php echo $schedule->total_hours;?></td>
		</tr>
		<tr>
			<td align="right" colspan="2" style="height:50px; border-top:solid 1px;">
				<button type="submit" class="btn btn-primary">Send to Principal for Signature</button>
				<input type="hidden" name="status[<?php echo $schedule->id?>]" value="Log sent - awaiting principal signature" />	
				<input type="hidden" name="old_status[<?php echo $schedule->id?>]" value="Create log" />	
			</td>
		</tr>
	</table>
	<?php echo form_close();?>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


    <script>
        $(document).ready(function(){
            $('#topic_template').change(function(){
                let brienza_template_id = jQuery('#topic_template').val();
                // alert(brienza_template_id);
                let description_val = jQuery('#template_descp').val();
                if (description_val != '')
                {
                    if (confirm("By selecting this template, all data previously entered in the log text box will be deleted")) {

                        if(brienza_template_id != ''){
                            jQuery.ajax({
                                url: '<?php echo base_url('app/presenters/brienza_template/');?>',
                                
                                data: {brienza_template_id:brienza_template_id},
                                type: 'post',
                                // ajaxCall:true,
                                async: false,
                                success: function (response) {
                                    // alert(response);
                                    if(response == false){
                                        alert('No template saved for this topic. ');
                                    }else{
                                    $('.view_message').val(response);
                                    }
                                }
                            });
                        }
                    }
                }else{
                    if(brienza_template_id != ''){
                        jQuery.ajax({
                            url: '<?php echo base_url('app/presenters/brienza_template/');?>',
                            
                            data: {brienza_template_id:brienza_template_id},
                            type: 'post',
                            // ajaxCall:true,
                            async: false,
                            success: function (response) {
                                // alert(response);
                                if(response == false){
                                    alert('No template saved for this topic. ');
                                }else{
                                $('.view_message').val(response);
                                }
                            }
                        });
                    }
                }
            })
        });

		function use_custom_template(topic_id){
            // alert(topic_id);
            let description_val = jQuery('#template_descp').val();
            if (description_val != '')
            {
                if (confirm("By selecting this template, all data previously entered in the log text box will be deleted")) {
            
                    jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_custom_template/');?>',
                        
                        data: {topic_id:topic_id},
                        type: 'post',
                        // ajaxCall:true,
                        async: false,
                        success: function (response) {
                            // alert(response);
                            if(response == false){
                                alert('No template saved for this topic. ');
                            }else{
                            $('.view_message').val(response);
                            }
                        }
                    });
                }
            }else{
                    jQuery.ajax({
                            url: '<?php echo base_url('app/presenters/use_custom_template/');?>',
                            
                            data: {topic_id:topic_id},
                            type: 'post',
                            // ajaxCall:true,
                            async: false,
                            success: function (response) {
                                // alert(response);
                                // $('.view_message').val(response);
                                if(response == false){
                                alert('No template saved for this topic. ');
                            }else{
                            $('.view_message').val(response);
                            }
                                
                            }
                        });
            }
        }

        function use_favorite_template(){
            // alert('hii');
            // $('#template_descp').val('');
            let description_val = jQuery('#template_descp').val();
            if (description_val != '')
            {
                if (confirm("By selecting this template, all data previously entered in the log text box will be deleted")) {
            
                    jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_favorite_template/');?>',
                        
                        data: {},
                        type: 'post',
                        // ajaxCall:true,
                        // async: false,
                        success: function (response) {
                            // alert(response);
                            if(response == false){
                                alert('No favorite template saved in library ');
                            }else{
                                $('.view_message').val(response);
                            
                            }
                        }
                    });
                }
            }else{

                    jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_favorite_template/');?>',
                        
                        data: {},
                        type: 'post',
                        // ajaxCall:true,
                        // async: false,
                        success: function (response) {
                            // alert(response);
                            if (response == ''){
                                alert('No favorite template saved in library');
                            }else{
                            $('.view_message').val(response);
                            }
                            
                        }
                    });
                }
            
        }

		function use_library_topic(topic_id){
            // alert('hii');
            // $('#template_descp').val('');
            let description_val = jQuery('#template_descp').val();
            if (description_val != '')
            {
                if (confirm("By selecting this template, all data previously entered in the log text box will be deleted")) {
            
                    jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_library_topic/');?>',
                        
                        data: {topic_id:topic_id},
                        type: 'post',
                        // ajaxCall:true,
                        async: false,
                        success: function (response) {
                            // alert(response);
                            $('.view_message').val(response);
                            
                        }
                    });
                }
            }else{
                jQuery.ajax({
                        url: '<?php echo base_url('app/presenters/use_library_topic/');?>',
                        
                        data: {topic_id:topic_id},
                        type: 'post',
                        // ajaxCall:true,
                        async: false,
                        success: function (response) {
                            // alert(response);
                            $('.view_message').val(response);
                            
                        }
                    });
            }
        }

        function save_custom_template(topic_id,message){
            // alert(message);die;
            let description_val = jQuery('#template_descp').val();
            if(message != ''){
                if (confirm("You already have a template saved for this topic, would you like to replace it ?")) {
                    jQuery.ajax({
                                url: '<?php echo base_url('app/presenters/save_custom_template/');?>',
                                
                                data: {topic_id:topic_id,description_val:description_val},
                                type: 'post',
                                // ajaxCall:true,
                                async: false,
                                success: function (response) {
                                    // alert(response);
                                    $('.view_message').val(response);
                                    
                                }
                            });
                }

            }else{
                jQuery.ajax({
                                url: '<?php echo base_url('app/presenters/save_custom_template/');?>',
                                
                                data: {topic_id:topic_id,description_val:description_val},
                                type: 'post',
                                // ajaxCall:true,
                                async: false,
                                success: function (response) {
                                    // alert(response);
                                    $('.view_message').val(response);
                                    
                                }
                            });
            }
        }
    </script>

</html>