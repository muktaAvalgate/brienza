<div class="subnav">
   <div class="container-fluid">
       <h1><span class="glyphicon glyphicon-envelope"></span>Edit Log</h1>
   </div>
</div>
 
<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <li><a href="<?php echo base_url('app/presenters');?>">Presenter Management</a></li>
       <li><a href="<?php echo base_url('app/presenters/log_template_for_presenters');?>">Log Management</a></li>
       <li class="active">Edit Log</li>
   </ol>
 
   <?php
       //form validation
       // echo validation_errors();
 
       // $attributes = array('class' => 'form-horizontal', 'id' => 'send-notify-form', 'role' => 'form', 'data-toggle' => 'validator');
       echo form_open(base_url('app/presenters/edit_log_template/'.$log_content->id));
   ?>
 
   <div class="col-sm-8">
      
      
       <fieldset>
           <legend>Compose Log</legend>
 
           <div class="form-group">
               <label for="inputSubject" class="col-sm-2 control-label">Template Name</label>
               <div class="col-sm-10">
                   <input type="text" name="tmp_name" class="form-control" id="tmp_name" placeholder="Template Name" value="<?php echo $log_content->tmp_name; ?>" required>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
 
           <div class="form-group">
               <label for="edit_essage" class="col-sm-2 control-label">Message</label>
               <div class="col-sm-10">
                   <textarea class="form-control" name="message" id="edit_essage" placeholder="Compose your message .." rows="15" required ><?php echo $log_content->message; ?></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
 
       </fieldset>
 
       <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
               <button onclick="save_tmp()" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save</button> or <a href="<?php echo base_url('app/presenters/log_template_for_presenters');?>">Cancel</a>
           </div>
       </div>
 
   </div>
  
 
   <?php echo form_close();?>
</div>
 
<script>
   jQuery('#edit_essage').wysihtml5();
 
   function save_tmp() {
       var tmp_name = jQuery("#tmp_name").val();
       var presenter_msg = jQuery("#edit_essage").val();
       if(presenter_msg == '' || tmp_name == ''){
       alert("Template Name and Message field is required.");
       }
    }
</script>