<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $page_title;?></title>

	<!-- Favicon-->
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASE_URL;?>assets/dist/images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo BASE_URL;?>assets/dist/images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL;?>assets/dist/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo BASE_URL;?>assets/dist/images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL;?>assets/dist/images/favicon-16x16.png">
	<link rel="manifest" href="<?php echo BASE_URL;?>assets/dist/images/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo BASE_URL;?>assets/dist/images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">

	<!-- Bootstrap -->
	<link href="<?php echo BASE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/font-awesome.min.css" rel="stylesheet">

	<!-- jQuery custom content scroller -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/mCustomScrollbar.min.css" rel="stylesheet"/>

	<!-- Custom Theme Style -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/custom.min.css" rel="stylesheet">
	<!-- Heade footer CSS -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/style.css" rel="stylesheet">
	
	<!-- -->
	<?php echo put_headers();?>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>html5shiv.js"></script>
	<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		var base_url = '<?php echo base_url();?>';
	</script>
</head>



<body class="nav-sm">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col menu_fixed">
				<div class="left_col scroll-view hidden-print">
					<div class="nav_menu">
						<nav>
							<div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-align-left"></i></a> </div>
						</nav>
					</div>
					<div class="clearfix"></div>
			
					<!-- sidebar menu -->
					<?php $this->load->view('templates/'.THEME.'/sidebar'); ?>
					<!-- /sidebar menu --> 
				</div>
			</div>
			<div class="col-md-15">
				<!-- top navigation -->
				<?php $this->load->view('templates/'.THEME.'/header'); ?>
				<!-- /top navigation --> 
		
				<!-- page content -->
				<div class="right_col " role="main"> 
					<?php $this->load->view($main_content); ?>
				</div>
				<!-- /page content --> 
				
		
				<!-- footer content -->
				<?php $this->load->view('templates/'.THEME.'/footer'); ?>
				<!-- /footer content --> 
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade bs-example-modal-sm" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Confirm !!</h4>
				</div>
				<div class="modal-body">Are you sure you want to delete ?</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Yes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Notification Details Modal -->
	<div class="modal fade" id="notificationDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Notification</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Admin Message Modal -->
	<div class="modal fade" id="adminMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<?php
				$attributes = array('class' => '', 'name' => 'notification_submit_form', 'id' => 'notification-submit-form', 'role' => 'form', 'data-toggle' => 'validator');
				echo form_open(base_url('app/notifications/add'), $attributes);
			?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">To: Admin</h4>
				</div>
				<div class="modal-body">
					<textarea name="description" class="form-control" rows="5" required >I'm having issues.</textarea>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="type" value="admin" />
					<input type="hidden" name="subject" value="Issue reported from portal" />
					<button type="submit" class="btn btn-primary">Send</button>
				</div>
			</div>
			<?php echo form_close();?>
		</div>
	</div>

	<!-- Admin Message Modal For add teachers Blink -->
	<div class="modal fade" id="adminMessageModalBlink" tabindex="-1" role="dialog" 	  aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <?php
                $attributes = array('class' => '', 'name' => 'notification_submit_form', 'id' => 'notification-submit-form', 'role' => 'form', 'data-toggle' => 'validator');
                echo form_open(base_url('app/notifications/request_new_teacher'), $attributes);
                // echo '<pre>'; print_r($attributes);die;
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">To: Admin</h4>
                </div>
                <div class="modal-body">
                    <!-- <textarea name="description" class="form-control" rows="5" required >Sudip.</textarea> -->
                    <label for="teacher_name">Teacher Name:</label>
                    <input type="text" class="form-control" name = "teacher_name" placeholder="Enter Teacher Name">
                    <label for="grade">Grade:</label>
                    <select name="grade" class="form-control grades">
                                    <option value="">Select</option>
                                    <?php foreach ($teacher_grades as $item) {?>
                                        <option value="<?php echo $item->grade_name;?>" data-slug="<?php echo $item->school_id; ?>" data-orderId="<?php echo $order_id; ?>"><?php echo $item->grade_name;?></option>
                                    <?php } ?>
                                </select>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="type" value="admin" />
                    <input type="hidden" name="subject" value="Issue reported from portal" />
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
	
	
	<!-- jQuery --
	<script src="<?php echo BASE_URL;?>assets/dist/js/jquery.min.js"></script> -->
	<!-- Bootstrap --
	<script src="<?php echo BASE_URL;?>assets/bootstrap/js/bootstrap.min.js"></script> -->
	<script src="<?php echo BASE_URL;?>assets/dist/js/jquery.mCustomScrollbar.min.js"></script> 
	<!-- Custom Theme Scripts --> 
	<script src="<?php echo BASE_URL;?>assets/dist/js/plugin.js"></script> 
	<script src="<?php echo BASE_URL;?>assets/dist/js/custom.min.js"></script> 
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".user-table a.tclose").click(function(){
				jQuery('tbody').slideToggle("slow");
				jQuery('.user-table').css('padding','0px');
				jQuery('.table').css('margin','0px');
			});

			jQuery(".search-user a.tclose").click(function(){
				jQuery('form').slideToggle("slow");
				jQuery('.search-user h2').toggleClass('radius');
			});
			
			<!-- For the First Login -->
			<?php /*if (!$this->session->userdata('last_login')){ ?>
				jQuery('#schoolTitleModal').modal({
				  keyboard: false,
				  backdrop: 'static'
				});
			<?php }*/?>
		});
    </script>
</body>
</html>
