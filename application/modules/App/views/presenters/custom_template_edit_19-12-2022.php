<div class="subnav">
   <div class="container-fluid">
       <h1><span class="glyphicon glyphicon-envelope"></span> Edit Custom Template</h1>
   </div>
</div>
 
<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <!-- <li><a href="<?php //echo base_url('app/presenters');?>">Presenter Management</a></li> -->
       <li><a href="<?php echo base_url('app/presenters/logs');?>">Logs</a></li>
       <li class="active">Edit Log</li>
   </ol>
 
   <?php
       //form validation
       // echo validation_errors();
 
       // $attributes = array('class' => 'form-horizontal', 'id' => 'send-notify-form', 'role' => 'form', 'data-toggle' => 'validator');
       echo form_open(base_url('app/presenters/custom_template_edit/'.$log_content->id));
   ?>
 
   <div class="col-sm-12">   
       <fieldset>
            <div class="form-group">
               <label for="inputTopic" class="col-sm-2 control-label">Topic *</label>
               <div class="col-sm-10">
              
                        <select name="topic" class="form-control" id="topic"  required>
                                <!-- <option value="<?php echo $topic_name->id;?>"><?php echo $topic_name->topic;?></option> -->
                            
                                <?php foreach ($topic as $item) {?>
                            
                                    <?php 
                                            // $dataSubjectsValue = array_column($template_topic_id, 'topic');
                                            $dataSubjectsValue = array_map(function($e) {
                                                return is_object($e) ? $e->topic : $e['topic'];
                                            }, $template_topic_id);
                                            if(in_array( $item->topic_id, $dataSubjectsValue)){ 
                                                if($item->topic_id == $log_content->topic){
                                        ?>
                                            <option value="<?php echo $item->topic_id;?>" class="tooltip" title="There is already a custom template for this topic." selected > <?php echo $item->topic;?></option>
                                            <!-- <span class="tooltiptext">Tooltip text</span> -->
                                            <?php }else{ ?>
                                                <option value="<?php echo $item->topic_id;?>" class="tooltip" title="There is already a custom template for this topic." disabled> <?php echo $item->topic;?></option>
                                        <?php } }else{ ?>
                                            <option value="<?php echo $item->topic_id;?>"> <?php echo $item->topic;?></option>
                                        <?php } ?>
                                                
                                            <?php } ?>
                            </select>
                        <div class="help-block with-errors"></div>
               </div>
            </div>
 
           <div class="form-group">
               <label for="edit_essage" class="col-sm-2 control-label">Template *</label>
               <div class="col-sm-10">
                   <textarea class="form-control" name="message" id="edit_essage" placeholder="Enter the message text..." rows="15" required ><?php echo $log_content->message; ?></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
       </fieldset>
 
       <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
               <button onclick="save_tmp()" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Save</button> or <a href="<?php echo base_url('app/presenters/logs');?>">Cancel</a>
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
    //    if(presenter_msg == '' || tmp_name == ''){
    //    alert("Template Name and Message field is required.");
    //    }
    }
</script>