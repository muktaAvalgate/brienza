<!-- page title -->
<div class="container clearfix">
    <div class="main-content">
		
        <div class="row page-heading">
            <div class="col-sm-9 col-md-9 page-name">
              	<h3><i class="fa fa-home" aria-hidden="true"></i> <?php echo $this->lang->line('auth_dashboard_page_heading')?></h3>
            </div>
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
                            <div class="col-xs-9 text-right">
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
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $dashboard['total_order'];?></div>
								<div>Admin Billing & Processing Center</div>
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
                                <div class="huge"><?php echo $dashboard['total_order'];?></div>
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
                            	
                            	<?php if($dashboard['new_invoice'] == 1){
                            	?>
                            	<div class="dnew">New</div>
                            	<?php
                            	}
                            	?>
                            	
                                <div class="huge"><?php echo $dashboard['total_invoice'];?></div>
                                <div class="huge-heading">Ready to invoice</div>

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
                                <i class="fa fa-check fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                            	<?php if($dashboard['new_hours'] == 1){
                            	?>
                            	<div class="dnew">New</div>
                            	<?php
                            	}
                            	?>
                            	
                                <div class="huge"><?php echo $dashboard['total_hours'];?></div>
                                <div class="huge-heading">Hours to confirm</div>
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

<script type="text/javascript">
	jQuery(document).ready(function(){
		var role = '<?php echo $this->session->userdata('role'); ?>';
		var counter = '<?php echo $this->session->userdata('hour_counter'); ?>';
		var schr = '<?php echo $scheduleHr; ?>';

		if(role == 'administrator' && schr > 0 && counter == 0){
			jQuery('#newScheduleHourModal').modal('show');
		}
	});
</script>

<?php $this->session->set_userdata('hour_counter', 1);?>