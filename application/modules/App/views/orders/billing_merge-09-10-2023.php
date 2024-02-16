
<style>
.loader_img {
 position: fixed;
 left: 0px;
 top: 0px;
 width: 100%;
 height: 100%;
 z-index: 9999;
 background: url(<?php echo base_url('assets/images/loader.gif'); ?>) center no-repeat transparent;
 opacity: .7;
}
</style>
<div class="container clearfix">
    <div class="main-content">
		<div class="row page-heading">
                <div class="col-sm-9 col-md-9 page-name">
                    <h3>Merge Billing</h3>
                </div>

                <div id="sub-menu" class="pull-right">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="<?php echo base_url('app/orders/billings');?>" title="Schools"><span class="fa fa-building"></span> Billings</a></li>
                    </ul>
                </div>
              <!DOCTYPE html>
                <html>
                    <body>
                    
                    <?php $lastOrderId=null; ?>
                    <?php foreach ($pdfmerge_data as $row) { ?> 
                         <div class="row">
                         
                            <table class="table table-bordered" id="datatable-order" style="width: 100%;" width="100%">
                            
                                <thead>
                                <?php
                                    if(!empty($row->invoice_id)  && $lastOrderId != $row->invoice_id){ 
                                        $lastAttachmentName = ''; ?>
                                    <tr role="row">
                                        <th> <span style="font-weight:normal"> Presenter Name </span></th>  
                                        <th> <span style="font-weight:normal"> Presenter INV# </span></th>  
                                        <th> <span style="font-weight:normal"> Attachment Name </span></th>
                                        <th><?php if($row->is_merged==null){ 
                                                if($attachmentCount[$row->invoice_id] == 0){
                                            ?>
                                             <button type="button" id="mergeBtn.<?php echo $row->invoice_id; ?>" class="btn subbtn" data-toggle="modal" data-target="#signModal" onclick="mergePdf('<?php echo $row->invoice_id; ?>','<?php echo $row->billing_id; ?>')" >Merge</button>
                                             <?php } else{?>
                                                <button type="button" id="mergeBtn.<?php echo $row->invoice_id; ?>" class="btn subbtn" data-toggle="modal" data-target="#signModal" onclick="mergePdf('<?php echo $row->invoice_id; ?>','<?php echo $row->billing_id; ?>')" disabled>Merge</button>
                                            <?php } ?>
                                            </th>
                                    </tr>
                                    <?php
                                        }
                                    } ?>
                                    
                                    
                                </thead>
                                
                                <tbody>
                                
                                        <?php
                                            if($lastAttachmentName != $row->attachment){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->presenter_name; ?></td>
                                            <td><?php echo $row->invoice_id; ?></td>
                                            <td><?php echo $row->attachment; ?><input type="hidden" value="<?php echo $row->id; ?>">
                                            </td>
                                        <?php if($row->is_merged==null){ ?>
                                              <?php  if($row->pdf_merge_status == 1){
                                            ?>
                                            <td><button type="button" id="compressBtn.<?php echo $row->id; ?>"  class="btn subbtn " data-toggle="modal" data-target="#signModal" onclick="compressPdf('<?php echo $row->id; ?>','<?php echo $row->attachment; ?>','<?php echo $row->invoice_id; ?>','<?php echo $attachmentCount[$row->invoice_id]; ?>')" disabled>Ready To Merge</button></td>
                                            <?php } else { ?>
                                                <td><button type="button" id="compressBtn.<?php echo $row->id; ?>"  class="btn subbtn " data-toggle="modal" data-target="#signModal" onclick="compressPdf('<?php echo $row->id; ?>','<?php echo $row->attachment; ?>','<?php echo $row->invoice_id; ?>','<?php echo $attachmentCount[$row->invoice_id]; ?>')">Convert To Merge</button></td>
                                            <?php } ?>
                                        </tr>
                                    <?php 
                                        }
                                     $lastAttachmentName= $row->attachment;
                                     $lastOrderId= $row->invoice_id;
                                
                                     
                                }} ?>
                                </tbody>
                            </table>
                        </div> 
                    </body>
             </html>
         </div>
    </div>
</div>
<div class="loader_img" style="display:none;">

<script src="jquery-3.6.4.min.js"></script>
<script type="text/javascript">
var countDoc=0;
function compressPdf(id,filename,order_id,attachmentCount){
    // alert(filename);
    // jQuery('.loader_img').show();
    var compressBtnId='compressBtn'+id;
    // alert(compressBtnId);
    var escapedId = id.replace(/\./g, "\\.");
    var mergeEscapedId = order_id.replace(/\./g, "\\.");
    console.log(mergeEscapedId);
    // var mergeBtnId='mergeBtn'+id;
    // var noOfDoc=$('#noOfAttachment').val();
    // alert(attachmentCount);
    $.ajax({
				url:base_url+'app/orders/compressPdf',
				// url:base_url+'app/orders/compressPdfMethodTwo',
				method:'POST',
				data:{fileName:filename,fileId:id},
				// contentType:false,
				// cache:false,
				// processData:false,
				beforeSend:function(){
					// $('#msg').html('Loading......');
                    jQuery('.loader_img').show();
				},
				success:function(data,textStatus, xhr){
                    if(xhr.status === 200){
                        // countDoc++;
                        // console.log(countDoc);
                        // $('#compressBtn'+id).prop('disabled',true);
                        // $("#compressBtn\\." + escapedId).prop("disabled", true);
                        // alert(countDoc);
                    //     if(countDoc==attachmentCount){
                    //     console.log(countDoc);
                    //     $('#mergeBtn\\.'+mergeEscapedId).removeAttr('disabled');
                    //     // location.reload();
                    // }
                    alert('Well done . Converted Successfully');
                    // jQuery('.loader_img').hide();
                    location.reload();
                    }else{
                        alert('Oh ! Snap . Conversion Unsuccessful');
                    }
                    
                    // if(data == true){
                        // window.location.reload();
                        // $('#mergeBtn').removeAttr('disabled');
                        // $('#compressBtn').prop('disabled',true);

                    // }
					console.log(response);
					// window.location.href=base_url+'app/orders/billing/?order_id='+order_id
				},
                error: function (xhr, textStatus, errorThrown) {
                    alert('Error occurred: ' + textStatus);
                }
			});
}

function mergePdf(order_id,billing_id){
    // alert(order_id+' '+billing_id);
    jQuery('.loader_img').show();
    var afterCompress=true;
    
    $.ajax({
				url:base_url+'app/orders/billingProcess',
				// url:base_url+'app/orders/compressPdfMethodTwo',
				method:'POST',
				data:{order_id:order_id,billing_id:billing_id,afterCompress:afterCompress},
				// contentType:false,
				// cache:false,
				// processData:false,
				// beforeSend:function(){
				// 	// $('#msg').html('Loading......');
                //     jQuery('.loader_img').show();
				// },
				success:function(data,textStatus, xhr){
                    if(xhr.status===200){
                        
                        alert('Merged successfully');
                        location.reload();
                    }else{
                        alert('Merge unsuccessful');
                    }
					console.log(response);
					// window.location.href=base_url+'app/orders/billing/?order_id='+order_id
				},
                error: function (xhr, textStatus, errorThrown) {
                    alert('Error occurred: ' + textStatus);
                }
			});
}

</script>