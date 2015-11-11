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
	
	if (!function_exists('http_parse_headers')) { 
		function http_parse_headers($raw_headers) {
	        $headers = array();
	        $key = ''; 
	
	        foreach(explode("\n", $raw_headers) as $i => $h)
	        {
	            $h = explode(':', $h, 2);
	
	            if (isset($h[1]))
	            {
	                if (!isset($headers[$h[0]]))
	                    $headers[$h[0]] = trim($h[1]);
	                elseif (is_array($headers[$h[0]]))
	                {
	                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
	                }
	                else
	                {
	                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
	                }
	
	                $key = $h[0];
	            }
	            else
	            {
	                if (substr($h[0], 0, 1) == "\t")
	                    $headers[$key] .= "\r\n\t".trim($h[0]);
	                elseif (!$key)
	                    $headers[0] = trim($h[0]);trim($h[0]);
	            }
	        }
	
	        return $headers;
	    }
   	} 
