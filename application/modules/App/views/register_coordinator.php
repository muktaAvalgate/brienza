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
							<h2>Coordinator Registration</h2>
							
						</div>
						<div class="col-md-7 col-sm-12 blocks block-2">
							<input type="hidden" value="<?php echo $msg;?>" id="msg">
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

							<?php //print "<pre>"; print_r($teacher); print "</pre>";?>
							
							<div id="teacher_info">
								<?php 
									$attributes = array('class' => 'form-horizontal', 'id' => 'frm_teacher_info', 'role' => 'form', 'data-toggle' => 'validator');
									echo form_open('', $attributes);
								?>
								<div class="form-group">
									<label class="col-sm-4 control-label">First Name</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo $coordinator->first_name;?></p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label">Last Name</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo $coordinator->last_name;?></p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label">Rate Type</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo $coordinator->meta['rate_type'];?></p>
									</div>
								</div>								

								<div class="form-group">
									<label class="col-sm-4 control-label">Rate</label>
									<div class="col-sm-2">
										<p class="form-control-static"><?php echo $coordinator->meta['rate'];?></p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label">Email</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo $coordinator->email;?></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Phone</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php if(isset($coordinator->meta['phone'])) {echo $coordinator->meta['phone'];}?></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Member Since</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo date_display($coordinator->created_on);?></p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
										Do you want to accept the above?<br><br>
										<button type="button" class="btn btn-success" id="btn-yes">YES</button>
										<button type="button" class="btn btn-danger" id="btn-no">NO</button>
									</div>
								</div>
								<?php echo form_close();?>
							</div>
							
							<!-- Register Form -->
							<div id="teacher_register" style="display:none">
								<?php 
									$attributes = array('class' => 'form-horizontal', 'id' => 'frm_teacher_register', 'role' => 'form', 'data-toggle' => 'validator');
									echo form_open('', $attributes);
								?>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputPassword">Password*</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter password " value="" required >
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputConfPassword">Confirm Password*</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" id="inputConfPassword" name="conf_password" placeholder="Enter confirm password" data-match="#inputPassword" value="" required >
										<div class="help-block with-errors"></div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputQuestion1">Security Question*</label>
									<div class="col-sm-8">
										<select name="question1" class="form-control" id="inputQuestion1" required>
											<option value="" selected>Select Question</option>
											<?php foreach ($question1 as $item) {?>
											<option value="<?php echo $item->id;?>"><?php echo $item->name;?></option>
											<?php }?>
										</select>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputAnswer1">Answer*</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="inputAnswer1" name="answer1" placeholder="Enter answer " value="" required>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputQuestion2">Security Question*</label>
									<div class="col-sm-8">
										<select name="question2" class="form-control" id="inputQuestion2" required>
											<option value="" selected>Select Question</option>
											<?php foreach ($question2 as $item) {?>
											<option value="<?php echo $item->id;?>"><?php echo $item->name;?></option>
											<?php }?>
										</select>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputAnswer2">Answer*</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="inputAnswer2" name="answer2" placeholder="Enter answer " value="" required>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label"></label>
									<label class="col-sm-8 control-label" style="color:#b6b0b0; text-align: left;">* Mandatory fields.</label>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
										<button type="submit" class="btn btn-success">Save</button>
										<button type="button" class="btn btn-danger" id="btn-cancel-register">Cancel</button>
									</div>
								</div>
								<input type="hidden" name="action" value="register">
								<input type="hidden" name="user_id" value="<?php echo $coordinator->id;?>">
								<?php echo form_close();?>
							</div>
							
							<!-- Edit Form -->
							<div id="teacher_edit" style="display:none">
								<?php 
									$attributes = array('class' => 'form-horizontal', 'id' => 'frm_teacher_edit', 'role' => 'form', 'data-toggle' => 'validator');
									echo form_open('', $attributes);
								?>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputName">First Name*</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="inputName" name="first_name" placeholder="Enter name " value="<?php echo $coordinator->first_name;?>" required >
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputName">Last Name*</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="inputName" name="last_name" placeholder="Enter name " value="<?php echo $coordinator->last_name;?>" required >
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputPhone">Phone*</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="inputPhone" name="meta[phone]" placeholder="Enter phone " value="<?php echo $coordinator->meta['phone'];?>" required>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputName">Rate Type </label>
									<div class="col-sm-8">
										<!--<select name="meta[rate_type]" class="form-control" required >
											<option value="">Choose rate type</option>	
											<option value="percentage" <?php if(!empty($coordinator->meta['rate_type']) && strtolower($coordinator->meta['rate_type']) == 'percentage') echo 'selected'; ?>>Percentage</option>
											<option value="fixed" <?php if(!empty($coordinator->meta['rate_type']) && strtolower($coordinator->meta['rate_type']) == 'fixed') echo 'selected'; ?>>Fixed</option>
										</select>-->
										<input type="hidden" class="form-control" name="meta[rate_type]" value="<?php echo $coordinator->meta['rate_type'];?>">
										<p class="form-control-static"><?php echo $coordinator->meta['rate_type']?></p>
										<div class="help-block with-errors"></div>
									</div>
								</div>								

								<div class="form-group">
									<label class="col-sm-4 control-label">Rate</label>
									<div class="col-sm-8">
										<input type="hidden" class="form-control" id="inputPhone" name="meta[rate]" placeholder="Enter rate " value="<?php echo $coordinator->meta['rate'];?>">
										<p class="form-control-static"><?php echo $coordinator->meta['rate']?></p>
										<div class="help-block with-errors"></div>										
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-4 control-label" for="inputEmail">Email</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo $coordinator->email;?></p>
									</div>
								</div>

								
								<div class="form-group">
									<label class="col-sm-4 control-label">Member Since</label>
									<div class="col-sm-8">
										<p class="form-control-static"><?php echo date_display($coordinator->created_on);?></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label"></label>
									<label class="col-sm-8 control-label" style="color:#b6b0b0; text-align: left;">* Mandatory fields.</label>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-8">
										<button type="submit" class="btn btn-success">Save</button>
										<button type="button" class="btn btn-danger" id="btn-cancel-edit">Cancel</button>
									</div>
								</div>
								<input type="hidden" name="action" value="edit">
								<input type="hidden" name="user_id" value="<?php echo $coordinator->id;?>">
								<input type="hidden" name="created_by" value="<?php echo $coordinator->created_by;?>">
								<input type="hidden" name="email" value="<?php echo $coordinator->email;?>">
								<?php echo form_close();?>
							</div>
							
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
			var msg = $('#msg').val();
			if(msg == 2){
				var url = '<?php echo BASE_URL?>';
				setTimeout(function(){ window.location = url; }, 3000);
			}
			$(".user-table a.tclose").click(function(){
				$('tbody').slideToggle("slow");
				$('.user-table').css('padding','0px');
				$('.table').css('margin','0px');
			});

			$(".search-user a.tclose").click(function(){
				$('form').slideToggle("slow");
				$('.search-user h2').toggleClass('radius');
			});
			
			$("#btn-no").click(function() {
				$("#teacher_info").css("display", "none");
				$("#teacher_edit").css("display", "block");
				
				$("#frm_teacher_edit").validator('update');
			});
			
			$("#btn-yes").click(function() {
				$("#teacher_info").css("display", "none");
				$("#teacher_register").css("display", "block");
				
				$("#frm_teacher_register").validator('update');
			});
			
			$("#btn-cancel-register").click(function() {
				$("#teacher_info").css("display", "block");
				$("#teacher_register").css("display", "none");
			});
			
			$("#btn-cancel-edit").click(function() {
				$("#teacher_info").css("display", "block");
				$("#teacher_edit").css("display", "none");
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