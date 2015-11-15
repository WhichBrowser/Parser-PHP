<?php

	if (!function_exists('getallheaders')) { 
		function getallheaders() { 
		    foreach($_SERVER as $key => $value) { 
		        if (substr($key,0,5) == "HTTP_") { 
		            $key = str_replace(" ", "-",ucwords(strtolower(str_replace("_", " ", substr($key,5))))); 
		            $out[$key] = $value; 
		        } else { 
		            $out[$key] = $value; 
				} 
		    } 
		    return $out; 
		}
	} 
	