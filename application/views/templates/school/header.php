<div class="top_nav hidden-print">
    <div class="nav_menu">
        <div class="navbar nav_title" style="border: 0;"> <a href="javascript:void(0);" class="site_title"><img src="<?php echo HTTP_IMAGES_PATH;?>logo.png"></a> </div>
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
