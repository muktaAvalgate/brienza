<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('datetime_display')){
    function datetime_display($date, $default = '')
    {
    	if ($date == "" || $date == "0000-00-00 00:00:00") {
            if ($default == '') {
                return;
            } else {
                return $default;
            }

    	}

    	return date("m/d/Y h:i a", strtotime($date));
    }
}

if(!function_exists('date_display')){
	function date_display($date, $format = '')
    {
    	if ($date == "" || $date == "0000-00-00") {
    		return;
    	}
		
		if ($format == "")
			return date("m/d/Y", strtotime($date));
		else 
			return date($format, strtotime($date));
    }
}


if(!function_exists('time_display')){
	function time_display($time, $meridiem = false, $blank = false)
    {
    	if ($time == "") {
    		return;
    	}
    	if ($meridiem)
			$format = "h:i a";
		else
			$format = "H:i";
    	$time = date($format, strtotime($time));

		if ($time == "00:00" && !$blank) {
			$time = "";
		}
		return $time;
    }
}

if(!function_exists('phone_display')){
	function phone_display($phone)
    {
        $output = "";
        if ($phone <> "") {
            $output = '<a href="callto:'.$phone.'">'.$phone.'</a>';
        }
        return $output;
    }
}

if(!function_exists('email_display')){
	function email_display($email)
    {
        $output = "";
        if ($email <> "") {
            $output = '<a href="mailto:'.$email.'">'.$email.'</a>';
        }
        return $output;
    }
}

if(!function_exists('name_display')){
	function name_display($firstname, $middlename, $lastname)
    {
        $output = "";
        if ($firstname <> "") {
            $output .= $firstname." ";
        }
        if ($middlename <> "") {
            $output .= $middlename." ";
        }
        if ($lastname <> "") {
            $output .= $lastname;
        }
        return $output;
    }
}

if(!function_exists('get_age')){
	function get_age($dob)
    {
        if ($dob == '') {
            return '';
        }
        $from = new DateTime($dob);
        $to   = new DateTime('today');
        return $from->diff($to)->y;
    }
}

if(!function_exists('status_display')){
	function status_display($status)
    {
        if ($status == "active") {
            return '<span class="label label-success">Active</span>';
        } else {
            return '<span class="label label-warning">In-active</span>';
        }
    }
}

if(!function_exists('order_status_display')){
	function order_status_display($status)
    {
		if ($status == "pending") {
			return '<span class="label label-info"><span class="glyphicon glyphicon-question-sign"></span> Pending</span>';
        } else if ($status == "approved") {
			return '<span class="label label-success"><span class="glyphicon glyphicon-ok-circle"></span> Approved</span>';
        } else {
			return '<span class="label label-danger"><span class="glyphicon glyphicon-ban-circle"></span> Cancelled</span>';
        }
    }
}

if(!function_exists('price_display')){
	function price_display($price)
    {
        if ($price <> "") {
            return CURRENCY_SYMBOL.number_format($price,2);
        } else {
            return CURRENCY_SYMBOL."0";
        }
    }
}

if(!function_exists('billing_status_update')){
	function billing_status_update($data, $display_cell=false)
    {
		$modarators_role = array('administrator');
		
		$ci = &get_instance();
		$role = $ci->session->userdata('role');
	
		$output = "";
		
		if ($display_cell) {
			$output .= '<td style="border:2px solid #763199;background-color: #51c03de3; min-width:170px; max-width: 170px; font-size: 12px;" class="';
		
			// For TD Class
			if ($data->status == "Hours scheduled") {
				$output .= 'hrs';
			} else if ($data->status == "Draft attached") {
				$output .= 'draft';
			} else if ($data->status == "Approved") {
				$output .= 'approval';
			} else if ($data->status == "Confirm hours") {
				$output .= 'confirm';
			} else if ($data->status == "Create log") {
				$output .= 'createlog';
			} else if ($data->status == "Log sent - awaiting principal signature") {
				$output .= 'waiting';
			} else if ($data->status == "Awaiting Review") {
				$output .= '';
			} else if ($data->status == "Create invoice") {
				$output .= 'createinv';
			} else if ($data->status == "Payment sent") {
				$output .= 'approved';
			} else if ($data->status == "Completed") {
				$output .= 'Confirm';
			} 
			
			$output .= '">';
		}
		
		$display_only = true;
		$options = "";
		
		// 
		if (in_array($role, $modarators_role) && $data->status == "Hours scheduled") {
			$options .= '<option value="Hours scheduled" data-id="hours_scheduled" ';
			if ($data->status == "Hours scheduled") {
				$options .= 'selected';
			}
			$options .= '>Hours scheduled</option>';
			
			$options .= '<option value="Draft attached" data-id="draft_attached" ';
			if ($data->status == "Draft attached") {
				$options .= 'selected';
			}
			$options .= '>Draft attached</option>';
			
			$display_only = false;
		}
		
		if (in_array($role, $modarators_role) && $data->status == "Draft attached") {
			$options .= '<option value="Draft attached" data-id="draft_attached" ';
			if ($data->status == "Draft attached") {
				$options .= 'selected';
			}
			$options .= '>Draft attached</option>';
				
			$options .= '<option value="Approved" data-id="approved" ';
			if ($data->status == "Approved") {
				$options .= 'selected';
			}
			$options .= '>Approved</option>';
			
			$display_only = false;
		}
		
		if (in_array($role, array('teacher')) && $data->status == "Approved") {
			$options .= '<option value="Approved" data-id="approved" ';
			if ($data->status == "Approved") {
				$options .= 'selected';
			}
			$options .= '>Approved</option>';
				
			// Show the "Approve" option is available as soon as the scheduled hours passed,
			if (date('Y-m-d H:i:s') > $data->end_date) {
				$options .= '<option value="Confirm hours" data-id="confirm_hours" ';
				if ($data->status == "Confirm hours") {
					$options .= 'selected';
				}
				$options .= '>Confirm hours</option>';
			}
			
			$display_only = false;
		}
		
		if (in_array($role, array('teacher')) && $data->status == "Confirm hours") {
			$options .= '<option value="Confirm hours" data-id="confirm_hours" ';
			if ($data->status == "Confirm hours") {
				$options .= 'selected';
			}
			$options .= '>Confirm hours</option>';
				
			// Show the "Approve" option is available as soon as the scheduled hours passed,
			//if (date('Y-m-d H:i:s') > $data->end_date) {
				$options .= '<option value="Create log" data-id="create_log" ';
				if ($data->status == "Create log") {
					$options .= 'selected';
				}
				$options .= '>Create log</option>';
			//}
			
			$display_only = false;
		}
		
		
		if (in_array($role, array('administrator')) && $data->status == "Payment sent") {
			$options .= '<option value="Payment sent" data-id="payment_sent" ';
			if ($data->status == "Payment sent") {
				$options .= 'selected';
			}
			$options .= '>Payment sent</option>';
			
			if (date('Y-m-d H:i:s') > $data->updated_on) {
				$options .= '<option value="Completed" data-id="completed" ';
				if ($data->status == "Completed") {
						$options .= 'selected';
				}
				$options .= '>Confirmed</option>';
			}
			
			$display_only = false;
		}
		
		if ($display_only) {
			if(($data->status == "Awaiting Review" || $data->status == "Create invoice" || $data->status == "Invoice created" || $data->status == "Payment sent") && $role == 'school_admin') {

				$output .= '<span style="background-color: #fff; padding: 7px 12px; font-size: 12px; color: #000000; display: flex; justify-content: center;">Completed</span>';
			}else{
				if($data->status == "Awaiting Review"){
					$output .= ($data->status != "Completed") ? '<span style="background-color: #fff; padding: 7px 3px;font-size: 12px;color: #000000;display: flex; justify-content: center;">'.$data->status.'</span>' : '<span style="background-color: #fff; padding: 7px 12px; font-size: 12px;color: #000000;display: flex; justify-content: center;">Confirmed</span>';
				}else{
					$output .= ($data->status != "Completed") ? '<span style="background-color: #fff; padding: 7px 5px;font-size: 12px;color: #000000;display: flex; justify-content: center;">'.$data->status.'</span>' : '<span style="background-color: #fff; padding: 7px 12px; font-size: 12px;color: #000000;display: flex; justify-content: center;">Confirmed</span>';
				}
				// $output .= ($data->status != "Completed") ? '<span style="background-color: #fff; padding: 7px 5px;">'.$data->status.'</span>' : '<span style="background-color: #fff; padding: 7px 12px;">Confirmed</span>';
			}
			
			if ($data->attachment <> "") {
				//if ($display_cell) {
					//$output .= '</td><td><a href="'.base_url(DIR_TEACHER_FILES.$data->attachment).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
				//} else {
					////$output .= ' <a href="'.base_url(DIR_TEACHER_FILES.$data->attachment).'"><img src="'.base_url('assets/dist/images/attachment-icon.png').'" border="0" alt="" title="Click here to download attachment"></a>';
				//}
			}
			
		} else {
			$output .= '<select class="form-control" style="font-size: 12px;color:#000000;" name="status['.$data->id.']" onchange="updateBillingStatus(this, '.$data->id.')">';
			$output .= $options;
			$output .= '</select>';
		}
		
		/*if ($display_only) {
			
		} else {
			
			$output .= '<option value="Create log" ';
			if ($status == "Create log") {
				$output .= 'selected';
			}
			$output .= '>Create log</option>';
			
			$output .= '<option value="Log sent - awaiting principal signature" ';
			if ($status == "Log sent - awaiting principal signature") {
				$output .= 'selected';
			}
			$output .= '>Log sent - awaiting principal signature</option>';
			
			$output .= '<option value="Awaiting Review" ';
			if ($status == "Awaiting Review") {
				$output .= 'selected';
			}
			$output .= '>Awaiting Review</option>';
			
			$output .= '<option value="Create invoice" ';
			if ($status == "Create invoice") {
				$output .= 'selected';
			}
			$output .= '>Create invoice</option>';
			
			$output .= '<option value="Payment sent" ';
			if ($status == "Payment sent") {
				$output .= 'selected';
			}
			$output .= '>Payment sent</option>';
			
			$output .= '<option value="Completed" ';
			if ($status == "Completed") {
				$output .= 'selected';
			}
			$output .= '>Confirmed</option>';
			
			
			//$output .= $status;
		}*/
		
		if ($display_cell)
			$output .= '</td>';
		
		echo $output;
    }
}

/**
Followig helper functions 
are being created for giving
option for invoice generation 
Created by: Soumya
Created on: 01-07-2019
**/
if(!function_exists('can_generate_invoice'))
{
	function can_generate_invoice($order_id)
	{
		$CI =& get_instance();

		$CI->db->select('SUM(total_hours) AS total_scheduled_hours');
		$CI->db->from('order_schedules');
		$CI->db->where('order_id', $order_id);
		$CI->db->where('status', 'Completed');

		$get_scheduled_hours_que = $CI->db->get();
		$get_scheduled_hours_arr = $get_scheduled_hours_que->row_array();

		$get_scheduled_hours = $get_scheduled_hours_arr['total_scheduled_hours'];

		$CI->db->select('hours');
		$CI->db->from('orders');
		$CI->db->where('id', $order_id);

		$get_alloted_hours_que = $CI->db->get();
		$get_alloted_hours_arr = $get_alloted_hours_que->row_array();

		$get_alloted_hours 	   = $get_alloted_hours_arr['hours'];

		$hours_left = ($get_alloted_hours - $get_scheduled_hours);

		return 	$hours_left;		
	}

}

if(!function_exists('disable_invoice_button'))
{
	function disable_invoice_button($order_id)
	{
		$CI =& get_instance();

		$CI->db->select('COUNT(id) AS total_rows');
		$CI->db->from('coordinator_billing_master');
		$CI->db->where('order_id', $order_id);

		$get_que = $CI->db->get();
		$get_arr = $get_que->row_array();

		$get_number_row = $get_arr['total_rows'];
		
		return 	$get_number_row;		
	}

}

## ------------ End of the code ------------- ##

/**
 * Following function can be used
 * to check the probable invoice generation 
 * date for a session 
 * Created on:25-08-2019
 * Created by: Soumya
 */
if(!function_exists('get_session_invoice_date'))
{
	function get_session_invoice_date($order_id, $session_id)
	{
		$CI =& get_instance();
		
		$CI->db->select('DATE(start_date) AS service_date');
		$CI->db->from('order_schedules');
		$CI->db->where('order_id', $order_id);
		$CI->db->where('id', $session_id);

		$get_que 			= $CI->db->get();
		$get_arr 			= $get_que->row_array();		
		$get_assigned_hours = $get_arr['service_date'];
		$date_array 		= explode('-', $get_assigned_hours);
		$month 				= $date_array[1];
		$year 				= $date_array[0];
		
		$CI->db->select('billing_date, session_from, session_to, payment_date');
		$CI->db->from('payment_schedule');

		$CI->db->where('month', $month);
		$CI->db->where('year', 	$year);
		$where = " ('".$get_assigned_hours."' BETWEEN session_from AND session_to) ";
		$CI->db->where($where);
		$CI->db->where('is_deleted', 0);	

		$get_que2			= $CI->db->get();
		$get_arr2 			= $get_que2->row_array();
		$billing_date		= $get_arr2;

		return 	$billing_date;		
	}
} 

/**
 * Following function can be used
 * to check the if the order is ready 
 * for invoice generation
 * Created on: 25-08-2019
 * Created by: Soumya
 */
if(!function_exists('is_order_readyto_invoice'))
{
	function is_order_readyto_invoice($order_id, $session_id)
	{
		$CI =& get_instance();
		
		$CI->db->select('id');
		$CI->db->from('order_schedules');
		$CI->db->where('order_id', $order_id);

		$get_que3 = $CI->db->get();
		$get_arr3 = $get_que3->result_array();

		//echo "<pre>";print_r($get_arr3);exit;

		if(!empty($get_arr3[0]))
		{
			$session_id_arr = array();
			
			foreach($get_arr3 as $session_inners)
			{
				$session_id_arr[] = $session_inners['id'];
			}		

			$CI->db->select('COUNT(id) AS total_log_ids');
			$CI->db->from('order_schedule_status_log');
			$CI->db->where_in('order_schedule_id', $session_id_arr);
			$CI->db->where('new_status', 'Create invoice');

			$get_que = $CI->db->get();	
			$get_arr = $get_que->row_array();
			$log_counter = $get_arr['total_log_ids'];
		}
		else
		{
			$log_counter = 0;
		}

		
		$CI->db->select('DATE(id) AS total_session_ids');
		$CI->db->from('order_schedules');
		$CI->db->where('order_id', $order_id);

		$get_que2 = $CI->db->get();
		$get_arr2 = $get_que2->row_array();		

		$session_counter = $get_arr2['total_session_ids'];
		
		if($session_counter == $log_counter)
			$ready_to_invoice = 1;
		else
			$ready_to_invoice = 0;	
		
		return 	$ready_to_invoice;		
	}

} 


if(!function_exists('revoke_nofify_data'))
{
	function revoke_nofify_data($role_type, $id)
	{
		$CI =& get_instance();

		$CI->db->select('coordinator_permission.*, CONCAT_WS(" ", co.first_name, co.last_name) AS co_name, school.meta_value AS school_name');
		$CI->db->from('coordinator_permission');
		$CI->db->join('users as co', 'co.id=coordinator_permission.coordinator_id', 'left');
        $CI->db->join('user_meta AS school', 'school.user_id = coordinator_permission.school_id AND school.meta_key = \'school_name\'', 'left');
		$CI->db->where('coordinator_permission.notify_status', 'yes');
		if($role_type == 'coordinator'){
			$CI->db->where('coordinator_permission.coordinator_id', $id);
		}

		return $CI->db->get()->result_array();
				
	}

}

if(!function_exists('update_notify_status'))
{
	function update_notify_status($id)
	{
		$CI =& get_instance();

        $CI->db->where('id', $id);
        $CI->db->update('coordinator_permission', array('notify_status'=>'no'));
        
        return true;
				
	}

}

## ------------ End of the code ------------- ##
