<?php defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> 'Your module description',
	'name'		    => 'Admin',
     /*
      * Replace the 'name' entry above with this entry and create the entry in
      * the application_lang file for localization/translation support in the
      * menu
      */
	'version'		=> '0.0.1',
	'author'		=> 'debarshi',
	'users'			=> array(
		'meta' 	=> array(
    		'phone' => array(
    			'name'			=> 'phone',
    			'type' 			=> 'text',
    			'label' 		=> 'Phone',
    			'attributes' 	=> array(
					'name'          => 'meta[phone]',
					'id'            => 'inputPhone',
					'value'         => '',
					'maxlength'     => 10,
    				'data-minlength' => 10,
					//'size'          => '',
					//'style'         => '',
    				'placeholder' 	=> "Enter phone number",
    				'required' 		=> true,
    				'class'			=> 'form-control',
				),
    			'help_text' 	=> '10 digit phone number',  
    			'hide_on_load'	=> false,			
    		),
    		'location' => array(
    			'name'			=> 'location',
    			'type' 			=> 'text',
    			'label' 		=> 'Location',
    			'attributes' 	=> array(
					'name'          => 'meta[location]',
					'id'            => 'inputLocation',
					//'value'         => '',
					//'maxlength'     => '',
    				//'data-minlength' => '',
					//'size'          => '',
					//'style'         => '',
    				'placeholder' 	=> "Enter location",
    				//'required' 		=> '',
    				'class'			=> 'form-control',
				),
    			'help_text' 	=> '',  
				'hide_on_load'	=> true,
    		),
    		'location' => array(
    			'name'			=> 'profile_pic',
    			'type' 			=> 'file',
    			'label' 		=> 'Profile Picture',
    			'attributes' 	=> array(
					'name'          => 'profile_pic',
					'id'            => 'inputPicture',
					//'value'         => '',
					//'maxlength'     => '',
    				//'data-minlength' => '',
					//'size'          => '',
					//'style'         => '',
    				'placeholder' 	=> "Select image",
    				//'required' 		=> '',
    				'class'			=> 'form-control',
				),
    			'help_text' 	=> 'Select a JPG or PNG file.',  
				'hide_on_load'	=> false,
    		)
			
    	)
    )
);
