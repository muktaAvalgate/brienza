<style>
    .delete_button
    {
        /* position: absolute; */
        /* position: left;
        left: 44rem;
        margin-top: 342px; */
    }
</style>

<div class="subnav">
   <div class="container-fluid">
       <h1><span class="glyphicon glyphicon-envelope"></span> Favorite Template</h1>
   </div>
</div>

<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <li><a href="<?php echo base_url('app/presenters/logs');?>">Logs</a></li>
       <!-- <li><a href="<?php //echo base_url('app/presenters/log_writting_room');?>">Template Management</a></li> -->
       <li class="active">Favorite Template</li>
   </ol>

   <div class="flash_message">
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

   <?php
       //form validation
       // echo validation_errors();
 
       // $attributes = array('class' => 'form-horizontal', 'id' => 'send-notify-form', 'role' => 'form', 'data-toggle' => 'validator');
       echo form_open(base_url('app/presenters/favorite_template'));
   ?>

        <div class="col-sm-12">
      
      
            <fieldset>
                <!-- <legend>Compose Favorite Template</legend> -->
                <div class="form-group">
                    <label for="inputDesc" class="col-sm-2 control-label">Template *</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="message" id="message" placeholder="Enter the template text..." rows="15" style="margin-left: -70px! important; width: 104rem;"  required ><?php if(isset($favorite_template->message)){ echo $favorite_template->message ;} ?></textarea>

                        <input type="hidden" name="" id="edit_id" value = "<?php if(isset($favorite_template->id)){ echo $favorite_template->id ;} ?>">

                        <div class="help-block with-errors"></div>
                    </div>
                </div>
        
            </fieldset>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9" style="">
                    <?php if (isset($favorite_template->message)){ ?>
                     <a  class="btn btn-primary" style="margin-left: -70px! important;" onclick="edit()"><span class="glyphicon glyphicon-ok-sign"></span> Update</a>
                    <?php } else {?>
                    <button class="btn btn-primary" style="margin-left: -70px! important;">Save</button>
                    <div style="margin-top:-2.5rem;"> or <a href="<?php echo base_url('app/presenters/logs');?>">Cancel</a></div>
                    <?php }?> 
                    
                    <?php if(isset($favorite_template->id)){ ?> 
                    <div style="margin-left:3.5rem; margin-top:-3.9rem;">
                        <a class="btn btn-danger" href="<?php echo base_url('app/presenters/favorite_template_delete/'.$favorite_template->id);?>" onclick="return confirm('Are you sure you want to delete this?')"> <span class=" glyphicon glyphicon-trash"> </span> Delete </a>
                    </div>
                    <div style="margin-left:13rem; margin-top:-2.5rem;"> or <a href="<?php echo base_url('app/presenters/logs');?>">Cancel</a></div>
                     <?php } ?>
                     <div class="help-block with-errors"></div>
                </div>
                
            </div>

        </div>
       
       <!-- <?php if(isset($favorite_template->id)){ ?> 
            <div class="delete_button">
                <a class="btn btn-danger" href="<?php echo base_url('app/presenters/favorite_template_delete/'.$favorite_template->id);?>"> <span class=" glyphicon glyphicon-trash"> </span> Delete </a>
             </div> <?php } ?>
            <div class="help-block with-errors"></div> -->
            <?php echo form_close();?>
</div>

<script>
	function edit(){
        var message = jQuery('#message').val();
        var edit_id = jQuery('#edit_id').val();
		// alert(edit_id);
		jQuery.ajax({
				url: base_url+'app/presenters/favorite_template_edit/'+edit_id,
				data: { message:message},
				type: 'post',
                // ajaxCall:true,
				// async: false,
				success: function (response) {
                    window.location.href = base_url+"/app/presenters/favorite_template";
                    
				}
			});
	}

</script>