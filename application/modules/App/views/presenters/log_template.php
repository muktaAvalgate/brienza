<style>
    .right_col {
        min-height: 670px ! important;
    }
</style>

<div class="subnav">
   <div class="container-fluid">
       <h1><span class="glyphicon glyphicon-envelope"></span> Add new log template</h1>
   </div>
</div>
 
<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <li><a href="<?php echo base_url('app/presenters');?>">Presenter Management</a></li>
       <li><a href="<?php echo base_url('app/presenters/log_template_for_presenters');?>">Manage Log Templates</a></li>
       <li class="active">Add Log Template</li>
   </ol>
 
   <?php
       //form validation
       // echo validation_errors();
 
       // $attributes = array('class' => 'form-horizontal', 'id' => 'send-notify-form', 'role' => 'form', 'data-toggle' => 'validator');
       echo form_open(base_url('app/presenters/add_log_template'));
   ?>
 
   <div class="col-sm-15">
      
      
       <fieldset>
           <!-- <legend>Compose Log</legend> -->
 
           <div class="form-group">
               <label for="inputSubject" class="col-sm-2 control-label">Template Name *</label>
               <div class="col-sm-10">
                   <input type="text" name="tmp_name" class="form-control" id="tmp_name" placeholder="Enter the template name..." value="" style="margin-left: -70px! important; width: 104rem;" required>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
 
           <div class="form-group">
               <label for="inputDesc" class="col-sm-2 control-label">Template *</label>
               <div class="col-sm-10">
                   <textarea class="form-control" name="message" id="message_template" placeholder="Enter the template text..." rows="15" style="margin-left: -70px! important; width: 104rem;" required ></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
 
       </fieldset>
 
       <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
               <button type="submit" class="btn btn-primary" id="save_button"  style="margin-left: -70px! important;"><span class="glyphicon glyphicon-ok-sign"></span> Save</button> or <a href="<?php echo base_url('app/presenters/log_template_for_presenters');?>">Cancel</a>
           </div>
       </div>
 
   </div>
  
 
   <?php echo form_close();?>
</div>
 
<script>
    $(document).ready(function(){
        // let constant = 1;
        $("#save_button").prop("disabled", true);
        // if(constant==)
        $("#tmp_name").keyup(function(){
            //   alert('jhbh');
            var tmp_name = jQuery("#tmp_name").val();
            var tmp_name_result = tmp_name.trim();
            var presenter_msg = jQuery("#message_template").val();
            var presenter_msg_result = presenter_msg.trim();
            if(tmp_name_result!='' && presenter_msg_result!=''){
                $("#save_button").prop("disabled", false);
            }else{
                $("#save_button").prop("disabled", true);
            }
        });

        $("#message_template").keyup(function(){
            var presenter_msg = jQuery("#message_template").val();
            var presenter_msg_result = presenter_msg.trim();
            var tmp_name = jQuery("#tmp_name").val();
            var tmp_name_result = tmp_name.trim();
            if(tmp_name_result!='' && presenter_msg_result!=''){
                $("#save_button").prop("disabled", false);
            }else{
                $("#save_button").prop("disabled", true);
            }
        });

    
    });


</script>