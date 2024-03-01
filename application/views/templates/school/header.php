<style>
	.nav_menu {
    background: #fff;
    margin-left: 0px;
}

.session {
	margin-top: 8px;
	font-weight: bold;
}
.form-control-session {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    margin-left: 10px;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;

}

</style>
<div class="top_nav hidden-print">
	<div class="row nav_menu">
		<div class="col-md-3">
			<div class="navbar nav_title" style="border: 0;"> <a href="javascript:void(0);" class="site_title"><img src="<?php echo HTTP_IMAGES_PATH;?>logo.png"></a></div>
		</div>

		<div class="col-md-3" style="margin-top: 30px; display:flex;">
			<span class="session">Session:</span><select name="session" class="form-control form-control-session" onchange="getDetails()"; id="session">
					<?php foreach ($this->session->userdata('s_array') as $key => $value) {?>
						<option value="<?php echo $key;?>" <?php echo $this->session->userdata('curr_session_id') == $key?'selected':''; ?>><?php echo $value;?></option>
					<?php }?>
				</select>
		</div>
		
		<div class="col-md-2" style="margin-top: 27px;">
					<span style="font-weight:900" >Total hours assigned : </span><span style="font-weight:900" id="assignHours"><?php echo $this->session->userdata('totHoursAssgnd') ?></span>
				
					<span style="font-weight:900">Total hours scheduled : </span><span style="font-weight:900" id="scheduleHours"><?php echo $this->session->userdata('totHoursSchedule')  ?></span>
				</div>
			
		<div class="col-md-4">
			<nav>
				<ul class="nav navbar-nav navbar-right">
					<li class="logout"><a href="<?php echo base_url('Auth/logout');?>">Logout</a></li>			  
					<li class="">
							<a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<?php if ($this->session->userdata('profile_pic') != "") {?>
									<img src="<?php echo base_url(DIR_PROFILE_PICTURE_THUMB.$this->session->userdata('profile_pic'));?>" alt=""><span class=" fa fa-angle-down"></span> 
								<?php } else {?>
									<img src="<?php echo base_url(DIR_PROFILE_PICTURE_THUMB."no_image_profile.jpg");?>" alt=""><span class=" fa fa-angle-down"></span> 
								<?php }?>
							</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
								<li><a href="<?php echo base_url('profile');?>"> Profile</a></li>
					<!-- <li> <a href="javascript:void(0);"> <span class="badge bg-red pull-right">50%</span> <span>Settings</span> </a> </li> -->
					<?php if($this->session->userdata('role') == 'administrator') { ?>
						<li> <a href="javascript:void(0);"> <span>Settings</span> </a> </li>
									<li><a href="<?php echo base_url('app/notifications');?>">Notifications</a></li>
					<?php } ?>

								<li><a href="<?php echo base_url('Auth/logout');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
					</li>
					
					<li class="username">Hello <span><?php echo $this->session->userdata('name');?></span></li>
				</ul>
			</nav>
		</div>
	</div>
</div>

<script type="text/javascript">


function getDetails(){
		var session = $('#session').val();
		jQuery.ajax({
			url: base_url+'auth/session_details',
			data: { session:session },
			type: 'post',
			async: false,
			dataType: 'JSON',
			success: function (response) {
				// selecting values from response Object
				console.log(response);
				// var totHoursAssgnd = response.totHoursAssgnd;
				// var totHoursSchedule = response.totHoursSchedule;
				// $('#scheduleHours').html(totHoursSchedule);
				// $('#assignHours').html(totHoursAssgnd);
				window.location.reload();
			}
		});

		
	}
</script>