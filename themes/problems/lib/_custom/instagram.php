<?php

//==============
//! Grab Instagram Feed
//==============
		
	// 1. Grab API
		// Check if transient is active
		// ability to turn off transient check
		// Grab API response
	

//==============================================================================
//! * Instagram Feed.
//==============================================================================

	function get_instagram() {
		    
	    $instagram_url = 'https://www.instagram.com/XXXXX/media/';
		
	    // Let's create a cache
		$cache = WP_CONTENT_DIR.'/uploads/social-feeds/'.sha1($instagram_url).'.json';

	    if(file_exists($cache) && filemtime($cache) > time() - 60){
	        // If a cache file newer than 18000 seconds (5hrs) exists, use it!
	        $jsonData = json_decode(file_get_contents($cache));
	    } else {
	        $jsonData = json_decode((file_get_contents($instagram_url)));
	        file_put_contents($cache,json_encode($jsonData));
	    }
	
		// Return the data if it's an array
	    if(is_array($jsonData->items)){
		    return $jsonData->items;
	    	        
	    } else {

	        // It wasn't an array so do something else			
			return NULL;		    

	    }
	    	    
	}
	
