<!-- page title -->
<div class="container clearfix">
    <div class="main-content">
		
        <div class="row page-heading">
            <!-- <div class="col-sm-9 col-md-9 page-name">
              	<h3><i class="fa fa-home" aria-hidden="true"></i> <?php echo $this->lang->line('auth_dashboard_page_heading')?></h3>
            </div> -->

		<?php if ($this->session->userdata('role') == "administrator") { ?>
			<div class="col-sm-10 col-md-10 page-name">
              	<h3><i class="fa fa-home" aria-hidden="true"></i> <?php echo $this->lang->line('auth_dashboard_page_heading')?></h3>
            </div>
			<!-- session -->
			<div id="sub-menu" class="col-sm-2 col-md-2 pull-right">
				<!-- <div class="form-group" style="margin-top: 10px;">
					<select name="session" class="form-control" onchange="getDetails()"; id="session">
						<?php foreach ($s_array as $key => $value) {?>
							<option value="<?php echo $key;?>" <?php echo $curr_session_id == $key?'selected':''; ?>><?php echo $value;?></option>
						<?php }?>
					</select>
				</div> -->
				<!-- <div class="form-group" style="margin-top: 10px;">
					<span style="font-weight:900">Total hours assigned : </span><span style="font-weight:900" id="assignHours"></span>
				</div>
				<div class="form-group" style="margin-top: -10px;">
					<span style="font-weight:900">Total hours scheduled : </span><span style="font-weight:900" id="scheduleHours"></span>
				</div> -->
			</div>
		<?php }else if($this->session->userdata('role') == "teacher"){ ?>
			<div class="col-sm-10 col-md-10 page-name">
              	<h3><i class="fa fa-home" aria-hidden="true"></i> <?php echo $this->lang->line('auth_dashboard_page_heading')?></h3>
            </div>
			<!-- session -->
			<div id="sub-menu" class="col-sm-2 col-md-2 pull-right">
				<div class="form-group" style="margin-top: 10px;">
					<select name="session" class="form-control" onchange="getDetailsPresenter()"; id="sessionPre">
						<?php foreach ($session_array as $key => $value) {?>
							<option value="<?php echo $key;?>" <?php echo $curr_session_id == $key?'selected':''; ?>><?php echo $value;?></option>
						<?php }?>
					</select>
				</div>
				<div class="form-group" style="margin-top: 10px;">
					<span style="font-weight:900">Total hours assigned : </span><span style="font-weight:900" id="assignHoursPre"></span>
				</div>
				<div class="form-group" style="margin-top: -10px;">
					<span style="font-weight:900">Total hours scheduled : </span><span style="font-weight:900" id="scheduleHoursPre"></span>
				</div>
			</div>
		<?php }else{ ?>
			<div class="col-sm-10 col-md-10 page-name">
              	<h3><i class="fa fa-home" aria-hidden="true"></i> <?php echo $this->lang->line('auth_dashboard_page_heading')?></h3>
            </div>
		<?php } ?>

        </div>
		<div class="row">
			<div class="col-md-12">
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
			</div>
		</div>
	
		<div class="row">
            <div class="headline">
				<?php //if ($this->session->userdata('last_login')){ ?>
					<!-- <h2><?php //echo $this->lang->line('auth_dashboard_page_lastlogin_text')?> <?php //echo datetime_display($this->session->userdata('last_login'));?> </h2> -->
				<?php //} else { ?>
					<h2>Welcome <?php echo $this->session->userdata('name'); ?></h2>
				<?php //}?>
			</div>
		</div>

		<?php if ($this->session->userdata('role') == "administrator") { ?>
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-building fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_school'];?></div>
								<div>Total Schools</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url("app/schools");?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>

			<!-- Implementation on 18-07-2019 by Soumya -->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-user fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_coordinator'];?></div>
								<div>Total Coordinators</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url("app/coordinator");?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>			
			<!-- Implementation on 18-07-2019 by Soumya -->			
			
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-user-plus fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_presenter'];?></div>
								<div>Total Presenters</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url("app/presenters");?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-tags fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_title'];?></div>
								<div>Total Funding Source</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url("app/titles");?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			
			<!-- Implementation on 18-07-2019 by Soumya -->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-file fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['remaining_price'];?></div>
								<div>Total Remaining (<i class="fa fa-usd"></i>)</div>
							</div>
						</div>
					</div>
					
					<div class="panel-footer">
						<span class="pull-left">&nbsp;</span>
						<span class="pull-right">
							<!-- <i class="glyphicon glyphicon-circle-arrow-right"></i> -->
							&nbsp;
						</span>
						<div class="clearfix"></div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-usd fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['billed_amount'];?></div>
								<div>Total Billed</div>
							</div>
						</div>
					</div>
					
					<div class="panel-footer">
						<span class="pull-left"><a href="<?php echo base_url('totalbilled'); ?>">View Details</a></span>
						<span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
						<div class="clearfix"></div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-lock fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_secured'];?></div>
								<div>Total Secured</div>
							</div>
						</div>
					</div>
					
					<div class="panel-footer">
						<span class="pull-left">&nbsp;</span>
						<span class="pull-right">
							<!-- <i class="glyphicon glyphicon-circle-arrow-right"></i> -->
							&nbsp;
						</span>
						<div class="clearfix"></div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- Implementation on 18-07-2019 by Soumya -->			
			
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-shopping-cart fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_order'];?></div>
								<div>Total Orders</div>
							</div>
						</div>
					</div>
					
					<div class="panel-footer">
						 <a href="<?php echo base_url("app/orders");?>">
							<span class="pull-left">View Details</span>
							 <a href="<?php echo base_url("app/orders/add");?>">
							<span class="pull-right">Create Order</span>
						</a> 
							<!-- <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span> -->
							<div class="clearfix"></div>
						    <div class="clearfix"></div>
						 </a>					
					</div>
					
				</div>
			</div>
			
			<!-- Implementation on 18-07-2019 by Soumya -->
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-bell fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_agenda_hours'];?></div>
								<div>Agenda Hours Scheduled</div>
							</div>
						</div>
					</div>
					
					<div class="panel-footer">
						<a href="<?php echo base_url("agenda_schedule");?>">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
						</a>
						<div class="clearfix"></div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- Implementation on 18-07-2019 by Soumya -->	
			
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success sorting_1">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-envelope-o fa-5x"></i>
                                <?php if($dashboard['new_msg']>0){ ;?><div class="new">New <?php echo $dashboard['new_msg'];?></div><?php } ?>
                            </div>

							<?php if($log_details!=false){ ?>
								<div class="col-xs-4 text-right" style="margin-left:1rem;">
									<img src="<?php echo base_url('assets/images/hazard_oval.png');?>"  width="45" height="43" class="bgimg"style="margin-top:1.5rem;margin-left: 2.4rem ">
									<div style="margin-top: -2.6rem; font-weight: bold; text-align: center; margin-right: -2.9rem; font-size: 15px;"><?php echo $log_details;?></div><br>
									<?php //if($log_details!=false){ ?>
										<!-- <div class="huge-heading" style="margin-right: 0.5rem; margin-top: -23px;">Logs</div>  -->
									<?php //}else{ ?>
										<!-- <div class="huge-heading" style="margin-right: 0.7rem; margin-top: 1px;">Logs</div>  -->
									<?php //} ?>
								</div>
							<?php }else{ ?>
								<div class="col-xs-4 text-right" style="margin-left:1rem;">
                                </div>
							<?php }?>




                            <div class="col-xs-4 text-right">
                                <div class="huge"><?php echo $dashboard['total_inbox'];?></div>
                                <div class="huge-heading">Inbox</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/notifications');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-gg-circle fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_goal'];?></div>
								<div>Total Goal</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url('app/goals');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-archive fa-5x"></i> 
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_reports_storage'];?></div>
								<div>Total Report Storage</div>
							</div>
						</div>
					</div>
					<a href="<?php echo base_url('app/reports_storage');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-shopping-cart fa-5x"></i> 
							</div>
							<div class="col-xs-9">
								<div class="huge">Billing</div>
								<div>Admin Billing & Processing Center</div>
								<?php
								if($new_billing > 0){
								?>
								<div class="bnew">New</div>
							<?php } ?>
							</div>
							
						</div>
					</div>
					
					<div class="panel-footer">
						 <a href="<?php echo base_url("app/orders/billings");?>">
							<span class="pull-left">View Details</span>
							<div class="clearfix"></div>
						    <div class="clearfix"></div>
						 </a>					
					</div>
					
				</div>
			</div>
		</div>
		<?php }?>
		
		<?php if ($this->session->userdata('role') == "teacher") { ?>
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
								<?php if($dashboard['new_order'] > 0){
								?>
								<div class="dnew"><?php echo $dashboard['new_order'];?> New</div>
								<?php
								}
								?>
                                <div class="huge"><?php echo $dashboard['tot_order'];?></div>
                                <div class="huge-heading">Orders</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/presenters/order');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-copy fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                            	
							    <?php if($new_tag_ready_to_invoice[0] > 0){
                            	?>
                            	<div class="dnew"><?php echo $new_tag_ready_to_invoice[0];?> New</div>
                            	<?php
                            	}
                            	?>
                            	
                                <div class="huge"><?php echo round($new_tag_ready_to_invoice[0]);?></div>
                                <div class="huge-heading">Ready to invoice</div>

                            </div>
                        </div>
                    </div>
					<!-- <a href="<?php echo base_url('app/presenters/billing');?>"> -->
					<?php if($new_tag_ready_to_invoice[0] > 0){
                    ?>
					<a href="<?php echo base_url('app/presenters/billing/2');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					<?php }else{ ?>
						<a href="#" onclick="alert('You have no remaining hours to confirm!');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					<?php } ?>
					
					
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-check fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                            	<?php if($dashboard['new_count'] > 0){
                            	?>
                            	<div class="dnew"><?php echo $dashboard['new_count'];?> New</div>
                            	<?php
                            	}
                            	?>
                            	
                                <div class="huge"><?php echo round($dashboard['total_hours']);?></div>
                                <div class="huge-heading">Hours to confirm</div>
                            </div>
                        </div>
                    </div>
					<?php if($last_hrs_to_cnf_ord_id > 0){
					?>
					<a href="<?php echo base_url('app/orders/billing/?order_id='.$last_hrs_to_cnf_ord_id);?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					<?php
					}else{
					?>
					<a href="#" onclick="alert('You have no remaining hours to confirm!');">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					<?php
					}
					?>
					
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success sorting_1">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-envelope-o fa-5x"></i>
                                <?php if($dashboard['new_msg']>0){ ;?><div class="new">New <?php echo $dashboard['new_msg'];?></div><?php } ?>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $dashboard['total_notification'];?></div>
                                <div class="huge-heading">Inbox</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/notifications');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>
        </div>
		<?php }?>

		<?php if ($this->session->userdata('role') == "school_admin") { ?>
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $dashboard['total_coordinator'];?></div>
                                <div class="huge-heading">Coordinators</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/coordinator/list_coordinators');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $dashboard['total_order'];?></div>
                                <div class="huge-heading">Orders</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/orders');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tags fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $dashboard['total_title'];?></div>
                                <div class="huge-heading">Title</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/teachers');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-clock-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo ($dashboard['total_hours'] != '') ? $dashboard['total_hours'] : '0';?></div>
                                <div class="huge-heading">Total Hours</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/orders');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-clock-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo ($dashboard['total_approved_hours'] != '') ? $dashboard['total_approved_hours'] : '0';?></div>
                                <div class="huge-heading">Approved Hours</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/orders');?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-pencil-square-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $dashboard['total_signlog']->total_signlog;?></div>
                                <div class="huge-heading">No. Of Sign Log</div>
                            </div>
                        </div>
                    </div>
					<a href="<?php echo base_url('app/orders/billing/?order_id='.$dashboard['total_signlog']->orderId);?>">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
					
				</div>
			</div>

			
        </div>
		<?php }?>

        <!--<div class="row">
            <div class="headline">
              	<h2>New Order <span><a href="javascript:void(0);" class="tclose"><i class="fa fa-check-circle" aria-hidden="true"></i></a></span></h2>
              	<div class="col-sm-6 col-md-6 box-container">
					<div class="heading">
						<h2>1. Order Number - 133698FH458m</h2>
					</div>
					<div class="box-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras elementum porta purus id porta. Vestibulum sit amet pretium sem. Nulla sed tortor placerat, euismod risus quis, bibendum erat.</p>
						<p>Cras sed arcu ex. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla facilisi.</p>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 box-container">
					<div class="heading">
						<h2>1. Order Number - 133698FH458m</h2>
					</div>
					<div class="box-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras elementum porta purus id porta. Vestibulum sit amet pretium sem. Nulla sed tortor placerat, euismod risus quis, bibendum erat.</p>
						<p>Cras sed arcu ex. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla facilisi.</p>
					</div>
				</div>
            </div>
        </div>-->
    </div>
</div>
<!-- /page title --> 


<!-- New schedule hour Modal -->
<div class="modal fade" id="newScheduleHourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Total new schedule hour</h4>
			</div>
			<div class="modal-body">
				<?php $scheduleHr = ($total_new_schedule_hour !='' && $total_new_schedule_hour > 0) ? $total_new_schedule_hour : 0; ?>
				Total new schedule hour is <?php echo $scheduleHr; ?> h
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!--New Billing Modal-->
<div id="billModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" style="text-align: center;">New Billing has been received !</h4>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var role = '<?php echo $this->session->userdata('role'); ?>';
		var counter = '<?php echo $this->session->userdata('hour_counter'); ?>';
		var schr = '<?php echo $scheduleHr; ?>';
		var newbillinb ='<?php echo $new_billing; ?>';

		if(role == 'administrator' && schr > 0 && counter == 0){
			jQuery('#newScheduleHourModal').modal('show');
		}
		if(role == 'administrator' && newbillinb > 0){
			jQuery('#billModal').modal('show');
		}

		if(role == 'administrator'){
			getDetails();
		}
		if(role == 'teacher'){
			getDetailsPresenter();
		}
	});

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
				var totHoursAssgnd = response.totHoursAssgnd;
				var totHoursSchedule = response.totHoursSchedule;
				$('#scheduleHours').html(totHoursSchedule);
				$('#assignHours').html(totHoursAssgnd);
			}
		});
	}

	function getDetailsPresenter(){
		var session = $('#sessionPre').val();
		jQuery.ajax({
			url: base_url+'auth/session_details_presenter',
			data: { session:session },
			type: 'post',
			async: false,
			dataType: 'JSON',
			success: function (response) {
				// selecting values from response Object
				var totHoursAssgnd = response.totHoursAssgnd;
				var totHoursSchedule = response.totHoursSchedule;
				$('#scheduleHoursPre').html(totHoursSchedule);
				$('#assignHoursPre').html(totHoursAssgnd);
			}
		});
	}
</script>

<?php $this->session->set_userdata('hour_counter', 1);?>