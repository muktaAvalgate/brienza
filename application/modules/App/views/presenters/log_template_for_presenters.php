<style>
.table_width {
  max-width: 250px;
}

.table_width2{
    max-width: 500px;
}
  
</style>
 
<div class="subnav">
   <div class="container-fluid">
       <h1><span class="fa fa-user-plus"></span> Manage log templates</h1>
 
   </div>
</div>
 
    <div class="container-fluid main">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('app/presenters');?>">Presenter Management</a></li>
            <li class="active">Manage Log Templates</li>
        </ol>
        
        <div style="float: right;">
            <button class="btn btn-primary" style="text-align: right; margin-right: -14px;"  onclick="window.location='<?php echo base_url('app/presenters/add_log_template');?>'">Add Log Template</buttton>
        </div>
    </div>
        <div>
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
 
 
        <div class="table-responsive">
            <!-- Table -->
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <!-- <th><input type="checkbox" id="checkall"></th> -->
                        <th>Template Name</th>
                        <th>Template</th>
                        <th>Actions</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tem_list == false) { ?>
                    <tr>
                        <td colspan="100%">Sorry!! No Records found.</td>
                    </tr>
                    <?php }else{ foreach($tem_list as $list) { ?>
        
                    
                    <tr>

                        <td class="table_width"> <?php echo (strlen($list->tmp_name)>70) ? substr($list->tmp_name,0,70).'....': $list->tmp_name; ?> </td>

                        <td class="table_width2"><?php echo (strlen($list->message)>145) ? substr($list->message,0,145).'....': $list->message ; ?> </td>
                        
                        <td class="text-nowrap">
                            <a href="<?php echo site_url('app/presenters/edit_log_template/'.$list->id);?>" title="Edit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>

                            <a href="<?php echo site_url('app/presenters/delete_log_template/'.$list->id);?>" title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this?')"> <span class="glyphicon glyphicon-trash"> </span> Delete </a>
                        </td>
                    </tr>
                    <?php } } ?>
        
                </tbody>
        
        
            </table>
        
        </div>
 
 
 
 
    </div>