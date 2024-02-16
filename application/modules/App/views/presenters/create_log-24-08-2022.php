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
  	</head>
<body>
<?php
	$attributes = array('class' => '', 'id' => '', 'role' => 'form');
	echo form_open(base_url('app/orders/billing/?order_id='.$order->id), $attributes);
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
				<button type="submit" class="btn btn-primary">Send to Principal <?php echo ucwords($order->principle_name);?> for Signature</button>
				<input type="hidden" name="status[<?php echo $schedule->id?>]" value="Log sent - awaiting principal signature" />	
				<input type="hidden" name="old_status[<?php echo $schedule->id?>]" value="Create log" />	
			</td>
		</tr>
	</table>
	<?php echo form_close();?>
</body>
</html>