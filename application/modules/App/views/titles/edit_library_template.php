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
       <h1><span class="glyphicon glyphicon-envelope"></span> Edit Library Template</h1>
   </div>
</div>
 
<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <li><a href="<?php echo base_url('app/titles');?>">Titles</a></li>
       <li><a href="<?php echo base_url('app/titles/add_log_templates/'.$title_id);?>">Library Templates</a></li>
       <li class="active">Edit Library Template</li>
   </ol>
 
   <?php
    //  echo'<pre>'; print_r($log_content);
       echo form_open(base_url('app/titles/library_template_edit/'.$log_content->id.'/'.$log_content->title_id));
   ?>
 
   <div class="col-sm-12">   
       <fieldset>

           <div class="form-group">
                    <label for="inputTopic" class="col-sm-2 control-label">Topic *</label>
                <div class="col-sm-10">
                <?php //echo'<pre>'; print_r($template_topic_id); ?>
                            <select name="topic" class="form-control" id="topic" style="margin-left: -70px! important; width: 104rem;"   required>
                            
                            <?php foreach ($topic_list as $item) { ?>
                        
                        <?php //echo'<pre>'; print_r($item);
                                // $dataSubjectsValue = array_column($template_topic_id, 'topic');
                                $dataSubjectsValue = array_map(function($e) {
                                    return is_object($e) ? $e->topic_id : $e['topic_id'];
                                }, $template_topic_id);

                                if(in_array( $item->id, $dataSubjectsValue)){ 
                                    if($item->id == $log_content->topic_id){
                            ?>
                                 <option value="<?php echo $item->id;?>" class="tooltip" title="There is already a library template for this topic." id="disabledTopic" selected > <?php echo $item->topic;?></option>

                                 <?php }else{ ?>

                                <option value="<?php echo $item->id;?>" class="tooltip" title="There is already a library template for this topic." id="disabledTopic" disabled> <?php echo $item->topic;?></option>
                                <!-- <span class="tooltiptext">Tooltip text</span> -->
                            <?php } }else{ ?>
                                <option value="<?php echo $item->id;?>"> <?php echo $item->topic;?></option>
                            <?php } ?>
                                    
                                <?php } ?>
                            </select>
                            <div class="help-block with-errors"></div>
                </div>
           </div>
 <?php //echo'<pre>'; print_r($log_content); die; ?>
           <div class="form-group">
               <label for="edit_essage" class="col-sm-2 control-label">Template *</label>
               <div class="col-sm-10">
                   <textarea class="form-control" name="message" id="message_template" placeholder="Enter the message text..." rows="15" style="margin-left: -70px! important; width: 104rem;"   required ><?php echo $log_content->description;?></textarea>
                   <div class="help-block with-errors"></div>
               </div>
           </div>
       </fieldset>
 
       <div class="form-group">
           <div class="col-sm-offset-2 col-sm-9">
               <button  type="submit" class="btn btn-primary" id="save_button" style="margin-left: -70px! important;"><span class="glyphicon glyphicon-ok-sign"></span> Save</button> or <a href="<?php echo base_url('app/titles/add_log_templates/'.$title_id);?>">Cancel</a>
           </div>
       </div>
   </div>
  
 
   <?php echo form_close();?>
</div>
 
<script>
//    jQuery('#edit_essage').wysihtml5();
 
$(document).ready(function(){
        // $("#save_button").prop("disabled", true);
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