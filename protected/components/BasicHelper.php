<?php

trait BasicHelper
{
	function rearrangeFiles($file_arr) {
		$new_file_arr = [];

	    foreach($file_arr as $file_prop_name => $prop_val_arr) {
	        foreach($prop_val_arr as $i => $val) {
	            $new_file_arr[$i][$file_prop_name] = $val;    
	        }  
	    }

	    foreach($new_file_arr as $key => $file_prop) {
	    	if($file_prop['error'] != 0) {
	    		unset($new_file_arr[$key]);
	    	}
	    }
	    
	    return $new_file_arr;
	}

	function validateFileInput($input_name, array $file_list)
	{
		return (isset($file_list[$input_name]) && $file_list[$input_name]['error'] == 0);
	}
}
