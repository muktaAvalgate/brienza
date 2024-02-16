<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Dynamically add Javascript files to header page
if(!function_exists('add_js')){
    function add_js($file='')
    {
        $str = '';
        $ci = &get_instance();
        $header_js  = $ci->config->item('header_js');

        if(empty($file)){
            return;
        }

        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){
                $header_js[] = $item;
            }
            $ci->config->set_item('header_js',$header_js);
        }else{
            $str = $file;
            $header_js[] = $str;
            $ci->config->set_item('header_js',$header_js);
        }
    }
}

//Dynamically add CSS files to header page
if(!function_exists('add_css')){
    function add_css($file='')
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('header_css');

        if(empty($file)){
            return;
        }

        if(is_array($file)){
            if(!is_array($file) && count($file) <= 0){
                return;
            }
            foreach($file AS $item){
                $header_css[] = $item;
            }
            $ci->config->set_item('header_css',$header_css);
        }else{
            $str = $file;
            $header_css[] = $str;
            $ci->config->set_item('header_css',$header_css);
        }
    }
}

if(!function_exists('put_headers')){
    function put_headers()
    {
        $str = '';
        $ci = &get_instance();
        $header_css = $ci->config->item('header_css');
        $header_js  = $ci->config->item('header_js');

        foreach($header_css AS $item){

        	$file = "";
        	if (file_exists(DIR_CSS.$item)) {
        		$file = HTTP_CSS_PATH.$item;
        	}
        	if (file_exists(DIR_THEME.$item)) {
        		$file = HTTP_THEME_PATH.$item;
        	}
        	if (file_exists($item)) {
        		$file = BASE_URL.$item;
        	}

        	if ($file <> "") {
	            $str .= '<link rel="stylesheet" href="'.$file.'" type="text/css" />'."\n";
        	}
        }

        foreach($header_js AS $item){

        	$file = "";
        	if (file_exists(DIR_JS.$item)) {
        		$file = HTTP_JS_PATH.$item;
        	}
        	if (file_exists($item)) {
        		$file = BASE_URL.$item;
        	}

        	if ($file <> "") {
	            $str .= '<script type="text/javascript" src="'.$file.'"></script>'."\n";
        	}
        }

        return $str;
    }
}

if(!function_exists('render_field')){
    function render_field($data = array(), $value = '', $extra = '')
    {
    	if (empty($data)) {
    		return;
    	}

    	if ($value <> "") {
	    	$data['attributes']['value'] = $value;
    	}

    	$output = '<div class="form-group '.($data['hide_on_load']?'hide':'').'">
		  	<label for="'.$data['attributes']['id'].'" class="col-sm-3 control-label">'.$data['label'].'</label>
		  	<div class="col-sm-7">';
		if ($data['type'] == "file") {
			$output .= form_upload($data['attributes']);
		}elseif ($data['type'] == "number") {
            $output .= form_input($data['attributes']);
        } else {
			$output .= form_input($data['attributes']);
		}
		$output .= '<div class="help-block with-errors">'.$data['help_text'].'</div>
			</div>
		</div>';
    	return $output;
    }
}

if(!function_exists('render_action')){
    function render_action($action = array(), $value = '')
    {
        $ci = &get_instance();
        $page_data = $ci->session->userdata('page_data');

        $url = $page_data['url'];
        $permissions = $page_data['permissions'];
        // echo '<pre>';print_r($url);echo '</pre>';die;
        $output = '';

    	if (empty($action)) {
    		return $output;
    	}

        if (in_array('reset_pass', $action) && checkActionPermission($permissions['reset_pass'])) {
            $output .= anchor($url.'/reset_pass/'.$value, '<span class="glyphicon glyphicon-lock"></span> Reset Password', array('title' => 'Reset Password', 'class' => 'btn btn-info btn-xs'));
        }

        $output .= " ";
        if (in_array('edit', $action) && checkActionPermission($permissions['edit'])) {
            $output .= anchor($url.'/edit/'.$value, '<span class="glyphicon glyphicon-edit"></span> Edit', array('title' => 'Edit', 'class' => 'btn btn-primary btn-xs'));
        }

        $output .= " ";
        if (in_array('delete', $action) && checkActionPermission($permissions['delete'])) {
            $output .= anchor($url.'/delete/'.$value, '<span class="glyphicon glyphicon-trash"></span> Delete', array('title' => 'Delete', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm(\'Are you sure you want to delete this?\')'));
        }

        // Modified to delete temp orders .. created on: 20-06-2019 
        $output .= " ";
        if (in_array('delete_temp_order', $action) && checkActionPermission($permissions['delete_temp_order'])) {
            $output .= anchor($url.'/delete_temp_order/'.$value, '<span class="glyphicon glyphicon-ban-circle"></span> Cancel', array('title' => 'Delete', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'return confirm(\'Are you sure you want to cancel this?\')'));
        }       

        $output .= " ";
        if (in_array('set_rebate', $action) && checkActionPermission($permissions['set_rebate'])) {
            $output .= anchor($url.'/set_rebate/'.$value, '<span class="glyphicon glyphicon-usd"></span> Rebate Rule', array('title' => 'Set Rebate Rule', 'class' => 'btn btn-info btn-xs'));
        }

    	return $output;
    }
}

if(!function_exists('render_link')){
    function render_link($action = '', $label = '')
    {
        $ci = &get_instance();
        $page_data = $ci->session->userdata('page_data');
        $url = $page_data['url'];
        $permissions = $page_data['permissions'];
        
        $valid_actions = array('add','delete','update_status','reset_pass','index','order','order_add');

        $output = '';

        if (empty($action)) {
    		return $output;
    	}

        if (!in_array($action, $valid_actions)) {
            return $output;
        }

        if (('add' == $action) && checkActionPermission($permissions[$action])) {
            $output .= anchor($url.'/add', $label, array('title' => strip_tags($label), 'class' => ''));
            // echo '<pre>';print_r($url.'/add');echo '</pre>';die;
        }
        
        
        ## Added following on 11-06-2019 for give delete order facility from coordinator side ..
        if (('order' == $action) && checkActionPermission($permissions[$action])) {
            $output .= anchor($url.'/order', $label, array('title' => strip_tags($label), 'class' => ''));
        }
        
        if (('order_add' == $action) && checkActionPermission($permissions[$action])) {
            $output .= anchor($url.'/order_add', $label, array('title' => strip_tags($label), 'class' => ''));
        }        
        ## ---------- End of the segment -------------- ##      

        if (('index' == $action) && checkActionPermission($permissions[$action])) {
            $output .= anchor($url, $label, array('title' => strip_tags($label), 'class' => ''));
        }
        
    	return $output;
    }
}


if(!function_exists('render_buttons')){
    function render_buttons($action = array())
    {
        $ci = &get_instance();
        $page_data = $ci->session->userdata('page_data');

        $url = $page_data['url'];
        // echo $url;die;
        $permissions = $page_data['permissions'];

        $has_output = false;
        $output = '';

    	if (empty($action)) {
    		return $output;
    	}

        if (in_array('update_status', $action) && checkActionPermission($permissions['update_status'])) {
            $output .= form_button(array(
                    'name' => 'operation',
                    'id' => 'btn_status_active',
                    'value' => 'active',
                    'type' => 'submit',
                    'content' => '<span class="glyphicon glyphicon-ok-circle"></span> Activate',
                    'class' => 'btn btn-sm btn-success'
                )
            );
            $output .= " ";
            $output .= form_button(array(
                    'name' => 'operation',
                    'id' => 'btn_status_deactive',
                    'value' => 'inactive',
                    'type' => 'submit',
                    'content' => '<span class="glyphicon glyphicon-ban-circle"></span> Deactivate',
                    'class' => 'btn btn-sm btn-warning'
                )
            );

            $has_output = true;
        }

        $output .= " ";
        if (in_array('delete', $action) && checkActionPermission($permissions['delete'])) {
            
            $output .= form_button(array(
                    'name' => 'operation',
                    'id' => 'btn_status_delete',
                    'value' => 'delete',
                    'type' => 'submit',
                    'content' => '<span class="glyphicon glyphicon-trash"></span> Delete',
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm(\'Are you sure you want to delete the selected item(s)?\')'
                )
            );
            $has_output = true;
        }

        ## Added following on 11-06-2019 for give delete order facility from coordinator side ..
        $output .= " ";
        if (in_array('delete_temp_order', $action) && checkActionPermission($permissions['delete_temp_order'])) {
            $output .= form_button(array(
                    'name' => 'operation',
                    'id' => 'btn_status_delete',
                    'value' => 'delete',
                    'type' => 'submit',
                    'content' => '<span class="glyphicon glyphicon-ban-circle"></span> Cancel',
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete the selected item(s)?")'
                )
            );
            $has_output = true;
        }       

        $output .= " ";
        if (in_array('set_payment', $action) && checkActionPermission($permissions['set_payment'])) {
            $output .= form_button(array(
                    'name' => 'operation',
                    'id' => 'btn_set_payment',
                    'value' => 'set_payment',
                    'type' => 'submit',
                    'content' => '<span class="glyphicon glyphicon-cog"></span> Set Payment',
                    'class' => 'btn btn-sm btn-deafult'
                )
            );
            $has_output = true;
        }

        if ($has_output) {
            $output = "With selected ".$output;
        }
    	return $output;
    }
}

function checkActionPermission($method) {
    $ci = &get_instance();
    $permissions = $ci->session->userdata('permissions');

    if (!in_array($method, $permissions)) {
        return false;
    } else {
        return true;
    }
}
