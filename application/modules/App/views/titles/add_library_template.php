<style>
        #disabledTopic {
        font-weight: normal;
        display: block;
        white-space: nowrap;
        min-height: 1.2em;
        font-size: 14px;
        line-height: 1.42857143;
        font-family: inherit;
    }
</style>
<div class="subnav">
   <div class="container-fluid">
       <h1><span class="glyphicon glyphicon-envelope"></span> Add Library Template</h1>
   </div>
</div>
 
<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <li><a href="<?php echo base_url('app/titles');?>">Titles</a></li>
       <li><a href="<?php echo base_url('app/titles/add_log_templates/'.$title_id);?>">Library Templates</a></li>
       <li class="active">Add Library Template</li>
   </ol>
 
   <?php
       //form validation
       // echo validation_errors();
 
       // $attributes = array('class' => 'form-horizontal', 'id' => 'send-notify-form', 'role' => 'form', 'data-toggle' => 'validator');
       echo form_open(base_url('app/titles/add_library_template/'.$title_id));
   ?>
 
   <div class="col-sm-12"> 
       <fieldset>
           <!-- <legend>Compose Log</legend> -->

          
           <div class="form-group">
               <label for="inputTopic" class="col-sm-2 control-label">Topic *</label>
               <div class="col-sm-10">
              <!-- <?php// echo'<pre>'; print_r($template_topic_id) ?> -->
                    <select name="topic" class="form-control" id="topic" style="margin-left: -70px! important; width: 104rem;" required>
                            <option value="">Select</option>
                         
                            <?php foreach ($topic_list as $item) {?>
                        
                                <?php 
                                        // $dataSubjectsValue = array_column($template_topic_id, 'topic');
                                        $dataSubjectsValue = array_map(function($e) {
                                            return is_object($e) ? $e->topic_id : $e['topic_id'];
                                        }, $template_topic_id);

                                        if(in_array( $item->id, $dataSubjectsValue)){ 
                                    ?>
                                        <option value="<?php echo $item->id;?>" class="tooltip" title="There is already a library template for this topic." id="disabledTopic" disabled> <?php echo $item->topic;?></option>
                                        <!-- <span class="tooltiptext">Tooltip text</span> -->
                                    <?php }else{ ?>
                                        <option value="<?php echo $item->id;?>"> <?php echo $item->topic;?></option>
                                    <?php } ?>
                                            
                                        <?php } ?>
                        </select>
                        <div class="help-block with-errors"></div>
               </div>
           </div>
         
           <!-- <div class="form-group">
               <label for="inputSubject" class="col-sm-2 control-label">Template Name *</label>
               <div class="col-sm-10">
                   <input type="text" name="tmp_name" class="form-control" id="tmp_name" placeholder="Enter the template name..." value="" style="margin-left: -70px! important; width: 104rem;" required>
                   <div class="help-block with-errors"></div>
               </div>
           </div> -->
 
           <div class="form-group">
               <label for="inputDesc" class="col-sm-2 control-label">Template *</label>
               <div class="col-sm-10">
                   <textarea class="form-control" name="message" id="message_template" placeholder="Enter the message text..." rows="15" style="margin-left: -70px! important; width: 104rem;" required ></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
       </fieldset>
 
       <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
               <button type="submit" class="btn btn-primary" id="save_button"  style="margin-left: -70px! important;"><span class="glyphicon glyphicon-ok-sign"></span> Save</button> or <a href="<?php echo base_url('app/titles/add_log_templates/'.$title_id);?>">Cancel</a>
           </div>
           <div class="help-block with-errors"></div>
       </div>
  </div>
  
 
   <?php echo form_close();?>
</div>
 
<script>
    $(document).ready(function(){
        $("#save_button").prop("disabled", true);
        $("#message_template").keyup(function(){
            var presenter_msg = jQuery("#message_template").val();
            var presenter_msg_result = presenter_msg.trim();
            if(presenter_msg_result!=''){
                $("#save_button").prop("disabled", false);
            }else{
                $("#save_button").prop("disabled", true);
            }
        });

    
    });

</script>