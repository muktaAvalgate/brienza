
<?php  foreach($order_schedules as $scheduled){ 
  
  //   echo "<pre>";
  //   print_r($scheduled);
                      foreach($scheduled->order_log as $order_log){
                          if($scheduled->id == $schedule_id){
                              // if($order_log->order_schedule_id == $schedule_id){
              ?>
                    
                     <tr>
                     <?php if($order_log->new_status != 'Create invoice'){ ?>
                          <td><p><?php echo date_display($scheduled->start_date, "l, F j, Y");?> @ <?php echo $scheduled->teacher;?> <?php echo time_display($scheduled->start_date, true);?>-<?php echo time_display($scheduled->end_date, true);?></p>
                          
                          </td>
                          
                          <td style="padding-left: 10px; text-align: center;">
                          <?php
                          if($order_log->new_status == 'Invoice created'){
                              echo "Invoice created";
                          }elseif ($order_log->new_status == 'Awaiting Review') {
                              echo "Awaiting Review";
                          }elseif($order_log->new_status == 'Log sent - awaiting principal signature'){
                              echo "Log sent - awaiting principal signature";
                          }elseif($order_log->new_status == 'Confirm hours'){
                              echo "Hours Confirmed";
                          }elseif($order_log->new_status == 'Approved'){
                              echo "Approved";
                          }elseif($order_log->new_status == 'Draft attached'){
                              echo "Draft attached";
                          }
                          ?>
                          </td>
                          
                          <td style="padding-left: 10px;">
                       
                              <?php
                              if($order_log->new_status != 'Confirm hours'){
                                  if($order_log->attachment && $order_log->attachment != NULL){
                                      if($order_log->new_status == 'Invoice created'){
                                          echo ' <a href="'.base_url('app/orders/download/'.$order_log->id.'/'.$order_log->new_status).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download invoice"  style="height:3rem"></a>';
                                      }else{
                                          echo ' <div id="file_attach_'. $order_log->id.'"><a href="'.base_url('app/orders/download/'.$order_log->id.'/'.$order_log->new_status).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"  style="height:3rem"></a>';
                                      }
                                  }if($order_log->content){
                                      echo ' <a href="'.base_url('app/orders/display_log/'.$scheduled->id).'" target="_blank"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"  style="height:3rem"></a>';
                                  }
                              }else{
                                  echo "";
                              }
                              ?>
                          </td>
  
                          <td style="padding-left: 10px;">
                       
                              <?php
                              if($order_log->new_status != 'Confirm hours'){
                                if ($scheduled->status == 'Log sent - awaiting principal signature' && $order_log->new_status == 'Log sent - awaiting principal signature') { ?>
                                    <div class="fileUpload btn btn-sm btn-primary" style=" width: 122px; height: 39px;">
                                    <span> Replace document</span>
                                    <input id="photo<?php echo $order_log->id;?>" type="file" class="upload" onchange="reUpload_document_for_presenter('<?php echo $order_log->id;?>','<?php echo $scheduled->id;?>');"/>
                                </div>
                            <?php	}else if ($scheduled->status == 'Awaiting Review' && $order_log->new_status == 'Awaiting Review'){ ?>
                                <div class="fileUpload btn btn-sm btn-primary" style=" width: 122px; height: 39px;">
                                    <span> Replace document</span>
                                    <input id="photo<?php echo $order_log->id;?>" type="file" class="upload" onchange="reUpload_document_for_presenter('<?php echo $order_log->id;?>','<?php echo $scheduled->id;?>');"/>
                                </div>
                            <?php	}else if ($scheduled->status == 'Create invoice' && $order_log->new_status == 'Awaiting Review'){ ?>
        
                                <div class="fileUpload btn btn-sm btn-primary" style=" width: 122px; height: 39px;">
                                    <span> Replace document</span>
                                    <input id="photo<?php echo $order_log->id;?>" type="file" class="upload" onchange="reUpload_document_for_presenter('<?php echo $order_log->id;?>','<?php echo $scheduled->id;?>');"/>
                                </div>
                                <?php }} ?>
                          </td>
  
                          <?php } ?>
                      </tr>
                      <?php 
                                      // }
                                  }
                              }
                          } 
                      ?>