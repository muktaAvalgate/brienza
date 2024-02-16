<!DOCTYPE html>
<html lang="en">
  <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/favicon.ico">
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

    <!-- Bootstrap core CSS -->
    <link href="<?php echo HTTP_CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/font-awesome.min.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/custom.min.css" rel="stylesheet">
	<!-- Heade footer CSS -->
	<link href="<?php echo BASE_URL;?>assets/dist/css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -
    <link href="<?php echo HTTP_THEME_PATH; ?>auth.css" rel="stylesheet">-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo HTTP_JS_PATH; ?>html5shiv.js"></script>
      <script src="<?php echo HTTP_JS_PATH; ?>respond.min.js"></script>
    <![endif]-->
	
	
    
  </head>

  <body>
	<div  id="login-page">
		<div class="container body">
			<div class="main_container">
				<div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo HTTP_IMAGES_PATH; ?>logo.png"></a></div>
				<div class="login-container">
					<div class="container clearfix">
					<div class="row">
						<div class="col-md-5 col-sm-12 blocks block-1">
							<h2>Welcome to the BAA : Solutions Portal</h2>
							<!-- <h2><?php //echo $this->lang->line('auth_login_box_heading')?></h2> -->
							<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a odio aliquam, blandit tellus ac, vehicula sem. Donec tristique id dolor vel feugiat. Praesent eget orci vel quam ultricies euismod. Mauris porttitor, enim ac dapibus placerat, sem eros efficitur est, non euismod enim turpis nec tortor.</p> -->
						</div>
						<div class="col-md-7 col-sm-12 blocks block-2">
							<h2>Please login</h2>
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
							<?php if(isset($error)):?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?php echo $error;?>
							</div>
							<?php endif;?>

							<form id="loginform" class="form-horizontal" role="form" data-toggle="validator" method="post" action="<?php echo base_url('do_login'); ?>">
								<div style="margin-bottom: 15px" class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" class="form-control" name="email" placeholder="Enter email address" required > 
								</div>
								<div style="margin-bottom: 15px" class="input-group"> <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" class="form-control" name="password" placeholder="Enter password" required>
								</div>
								<div class="input-group checkbx col-md-12">
									<div class="col-md-6 col-sm-12 "> 
										<div class="checkbox">
											<label>
												<input id="login-remember" type="checkbox" name="remember" value="1">
												Remember me </label>
										</div>
									</div>
									<div class="col-md-6 col-sm-12 text-right">
										Forgot password?
										<a href="<?php echo base_url('forgot_password'); ?>">
											Reset Here
										</a>
									</div>
								</div>
								<div class="form-group">
									<input type="submit" class="login-button">
								</div>
							</form>
						</div>
					</div>
				</div>
					
			</div>
			<div class="shadow"></div>
			<!-- footer content -->
			<div class="footer clearfix">
				<p>© <?php echo date("Y");?> Brienza's Academic Advantage. All rights reserved.</p>
			</div>
			<!-- /footer content -->
			</div>
		</div>
	</div>
  	

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>plugins/validator.min.js"></script>

	<!-- Custom Theme Scripts --> 
	<script src="<?php echo BASE_URL;?>assets/dist/js/plugin.js"></script> 
	<script src="<?php echo BASE_URL;?>assets/dist/js/custom.min.js"></script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$(".user-table a.tclose").click(function(){
			$('tbody').slideToggle("slow");
			$('.user-table').css('padding','0px');
			$('.table').css('margin','0px');
			});

			$(".search-user a.tclose").click(function(){
			$('form').slideToggle("slow");
			$('.search-user h2').toggleClass('radius');
			});
		});
		
		// equal height
		
		equalheight = function(container){

		var currentTallest = 0,
			currentRowStart = 0,
			rowDivs = new Array(),
			$el,
			topPosition = 0;
		$(container).each(function() {

		$el = $(this);
		$($el).height('auto')
		topPostion = $el.position().top;

		if (currentRowStart != topPostion) {
			for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
			}
			rowDivs.length = 0; // empty the array
			currentRowStart = topPostion;
			currentTallest = $el.height();
			rowDivs.push($el);
		} else {
			rowDivs.push($el);
			currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		}
		for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}
		});
		}

		$(window).load(function() {
			equalheight('.blocks');
		});


		$(window).resize(function(){
			equalheight('.blocks');
		});

    </script>
  </body>
</html>