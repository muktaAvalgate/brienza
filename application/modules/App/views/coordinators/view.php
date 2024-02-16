<style>
.page-title .title_left {
    width: 100%;
    float: left;
    display: block;
}
</style>

<div class="">

	<!-- <div class="page-title">
	 

	</div> -->
	
	<div class="clearfix"></div>
	
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">

		  <div class="x_content">

				<div class="col-sm-12">
						<div class="col-sm-6">
							<fieldset>
								<legend>Basic Info</legend>			

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label"> Email : </label>
									<div class="col-sm-7">
										<?php echo $presenter_details->email; ?></label>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Name :</label>
									<div class="col-sm-7">
										<?php echo $presenter_details->first_name.' '.$presenter_details->last_name; ?></label>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Info :</label>
									<div class="col-sm-7">
										<?php echo (isset($presenter_details->meta['info']) && $presenter_details->meta['info'] != '') ? $presenter_details->meta['info'] : '--'; ?>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Hourly Rate:</label>
									<div class="col-sm-7">
										<?php echo isset($presenter_details->meta['rate']) ? '$'.number_format($presenter_details->meta['rate'], 2) : '--'; ?>
										<div class="help-block with-errors"></div>
									</div>
								</div>
							</fieldset>
						</div>

						<div class="col-sm-6">
							<fieldset>
								<legend>Others Info</legend>
								
								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Phone  :</label>
									<div class="col-sm-7">
										<?php echo isset($presenter_details->meta['phone']) ? $presenter_details->meta['phone'] : '--'; ?>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Company Name  :</label>
									<div class="col-sm-7">
										<?php echo isset($presenter_details->meta['company_name']) ? $presenter_details->meta['company_name'] : '--'; ?>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Address  :</label>
									<div class="col-sm-7">
										<?php echo isset($presenter_details->meta['address']) ? $presenter_details->meta['address'] : '--'; ?>	
										<div class="help-block with-errors"></div>									
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-sm-5 control-label">Hourly Rate PDF  :</label>
									<div class="col-sm-7">
										<p><?php if(isset($presenter_details->meta['rate_file']) && $presenter_details->meta['rate_file'] != '') {echo anchor(base_url(DIR_TEACHER_FILES.$presenter_details->meta['rate_file']),"Show PDF", array("target"=>"_blank"));}?></p>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>