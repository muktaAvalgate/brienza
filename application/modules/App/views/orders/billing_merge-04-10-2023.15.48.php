
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
                    <?php $loop=0;$lastOrderId=null;$lastAttachmentName = '';?>
                    <?php foreach ($pdfmerge_data as $row) { 
                        
                        ?> 
                         <div class="row">
                            <table class="table table-bordered" id="datatable-order" style="width: 100%;" width="100%">
                            
                                <thead>
                                    <?php if(!empty($row->order_id)  && $lastOrderId != $row->order_id &&($lastAttachmentName != $row->attachment)){ 
                                        $loop++;
                                        ?>
                                    <tr role="row">
                                        <th> <span style="font-weight:normal"> Presenter Name </span></th>  
                                        <th> <span style="font-weight:normal"> Order Number </span></th>  
                                        <th> <span style="font-weight:normal"> Attachment Name </span></th>
                                        <th><?php if($row->is_merged==null){ ?>
                                             <button type="button" id="mergeBtn.<?php echo $row->order_id; ?>" class="btn subbtn" data-toggle="modal" data-target="#signModal" onclick="mergePdf('<?php echo $row->order_id; ?>','<?php echo $row->billing_id; ?>')" disabled>Merge</button>
                                             <?php } ?>
                                            </th>
                                    </tr>
                                    <?php }else{
                                    $loop=0;
                                } ?>
                                </thead>
                                
                                <tbody>
                                
                                        
                                        <tr>
                                            <td><?php echo $row->presenter_name; ?></td>
                                            <td><?php echo $row->order_no; ?></td>
                                            <td><?php echo $row->attachment; ?><input type="hidden" value="<?php echo $row->id; ?>">
                                            <input type="hidden" id="noOfAttachment" value="<?php echo $loop;?>">
                                        </td>
                                        <?php if($row->is_merged==null){ ?>
                                            <td><button type="button" id="compressBtn.<?php echo $row->id; ?>"  class="btn subbtn " data-toggle="modal" data-target="#signModal" onclick="compressPdf('<?php echo $row->id; ?>','<?php echo $row->attachment; ?>','<?php echo $row->order_id; ?>')">Compress</button></td>
                                            <?php } ?>
                                        </tr>
                                    <?php 
                                     $lastAttachmentName= $row->attachment;
                                     $lastOrderId= $row->order_id;
                                } ?>
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
function compressPdf(id,filename,order_id){
    // alert(filename);
    var compressBtnId='compressBtn'+id;
    // alert(compressBtnId);
    var escapedId = id.replace(/\./g, "\\.");
    var mergeEscapedId = order_id.replace(/\./g, "\\.");
    var mergeBtnId='mergeBtn'+id;
    var noOfDoc=$('#noOfAttachment').val();
    // alert(noOfDoc);
    $.ajax({
				url:base_url+'app/orders/compressPdf',
				// url:base_url+'app/orders/compressPdfMethodTwo',
				method:'POST',
				data:{fileName:filename,fileId:id},
				// contentType:false,
				// cache:false,
				// processData:false,
				// beforeSend:function(){
				// 	$('#msg').html('Loading......');
				// },
				success:function(data,textStatus, xhr){
                    if(xhr.status===200){
                        countDoc++;
                        console.log(countDoc);
                        // $('#compressBtn'+id).prop('disabled',true);
                        $("#compressBtn\\." + escapedId).prop("disabled", true);
                        alert('compressed successfully');
                        
                        if(countDoc==noOfDoc){
                        console.log(countDoc);
                        $('#mergeBtn\\.'+mergeEscapedId).removeAttr('disabled');
                        
                    }
                    }else{
                        alert('compressed unsuccess');
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