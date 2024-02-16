<style>
.log_template{
   position:absolute;
  top:190px;
  right:50px;
}
.align{
   position: absolute;
   top: 287px;
}
.width{
   width: 100%;
}
.flash_message{
   position:absolute;
   top: 230px;
   width: 100%;
}
  
</style>
 
<div class="subnav">
   <div class="container-fluid">
       <h1><span class="fa fa-user-plus"></span> Manage Log</h1>
 
   </div>
</div>
 
<div class="container-fluid main">
   <ol class="breadcrumb">
       <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
       <li><a href="<?php echo base_url('app/presenters');?>">Presenter Management</a></li>
       <li class="active">Log Management</li>
   </ol>
 
   <div>
       <button class="btn btn-primary log_template" onclick="window.location='<?php echo base_url('app/presenters/add_log_template');?>'">Add Log Templates</buttton>
   </div>
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
 
 
   <div class="table-responsive align">
       <!-- Table -->
       <table class="table table-striped table-responsive width">
           <thead>
               <tr>
                   <!-- <th><input type="checkbox" id="checkall"></th> -->
                   <th>Template Name</th>
                   <th>Message</th>
                   <th>Actions</th>
                 
               </tr>
           </thead>
           <tbody>
               <?php if (count($tem_list) == 0) { ?>
               <tr>
                   <td colspan="100%">Sorry!! No Records found.</td>
               </tr>
               <?php } ?>
 
               <?php foreach($tem_list as $list) { ?>
               <tr>
                   <!-- <td><input type="checkbox" name="item_id[<?php echo $list->id;?>]" class="checkbox-item" value="Y"></td> -->
                   <td><?php echo $list->tmp_name;?></td>
                   <td><?php echo $list->message;?></td>
                  
                  
                   <td class="text-nowrap">
                    <a href="<?php echo site_url('app/presenters/edit_log_template/'.$list->id);?>" title="Edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>

                    <a href="<?php echo site_url('app/presenters/delete_log_template/'.$list->id);?>" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this?')"> <span class="glyphicon glyphicon-trash"> </span> Delete </a>
                       <!-- <?php echo render_action(array('edit', 'delete'), $list->id);?> -->
                   </td>
               </tr>
               <?php } ?>
 
           </tbody>
 
 
       </table>
 
   </div>
 
 
 
 
</div>