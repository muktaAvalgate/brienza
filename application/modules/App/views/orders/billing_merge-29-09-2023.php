
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
                    <?php $loop=1;$lastOrderId = null;?>
                    <?php foreach ($pdfmerge_data as $row) { 
                        
                        ?> 
                         <div class="row">
                            <table class="table table-bordered" id="datatable-order" style="width: 100%;" width="100%">
                            
                                <thead>
                                    <?php if($lastOrderId != $row->order_id){ 
                                        $loop++;
                                        ?>
                                    <tr role="row">
                                        <th> <span style="font-weight:normal"> Presenter Name </span></th>  
                                        <th> <span style="font-weight:normal"> Order Number </span></th>  
                                        <th> <span style="font-weight:normal"> Attachment Name </span></th>
                                        <th> <button type="button" id="mergeBtn.<?php echo $row->order_id; ?>" class="btn subbtn" data-toggle="modal" data-target="#signModal" onclick="mergePdf('<?php echo $row->order_id; ?>','<?php echo $row->billing_id; ?>')" disabled>Merge</button></th>
                                    </tr>
                                    <?php }else{
                                    $loop=1;
                                } ?>
                                </thead>
                                
                                <tbody>
                                
                                        
                                        <tr>
                                            <td><?php echo $row->presenter_name; ?></td>
                                            <td><?php echo $row->order_no; ?></td>
                                            <td><?php echo $row->attachment; ?><input type="text" value="<?php echo $row->id; ?>">
                                            <input type="text" id="noOfAttachment" value="<?php echo $loop;?>">
                                        </td>
                                           
                                            <td><button type="button" id="compressBtn.<?php echo $row->id; ?>"  class="btn subbtn " data-toggle="modal" data-target="#signModal" onclick="compressPdf('<?php echo $row->id; ?>','<?php echo $row->attachment; ?>','<?php echo $row->order_id; ?>')">Compress</button></td>
                                        </tr>
                                    <?php $lastOrderId= $row->order_id;
                                
                                } ?>
                                </tbody>
                            </table>
                        </div> 
                    </body>
             </html>
         </div>
    </div>
</div>

<script src="jquery-3.6.4.min.js"></script>
<script type="text/javascript">
var countDoc=0;
function compressPdf(id,filename,order_id){
    // alert(filename);
    var compressBtnId='compressBtn'+id;
    alert(compressBtnId);
    var escapedId = id.replace(/\./g, "\\.");
    var mergeEscapedId = order_id.replace(/\./g, "\\.");
    var mergeBtnId='mergeBtn'+id;
    var noOfDoc=$('#noOfAttachment').val();
    alert(noOfDoc);
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
				// 	$('#msg').html('Loading......');
				// },
				success:function(data){
                    
                    // alert('merged successfully');
                    // if(data == true){
                        // window.location.reload();
                        // 

                    // }
					console.log(response);
					// window.location.href=base_url+'app/orders/billing/?order_id='+order_id
				}
			});
}

</script>