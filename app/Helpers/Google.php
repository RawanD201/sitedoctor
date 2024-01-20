<?php 


    function google_page_speed_insight_desktop($domain="",$strategy="desktop")
    {

        $key=config("settings.google_api_key");
        if($domain=="" || $key=="") return false;
        
        // $url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=".$domain."&fields=lighthouseResult%2Fcategories%2F*%2Fscore&prettyPrint=false&strategy=".$strategy."&category=performance&category=pwa&category=best-practices&category=accessibility&category=seo&key={$key}";
        
        $url="https://www.googleapis.com/pagespeedonline/v5/runPagespeed?key=".$key."&url=".$domain."&strategy=".$strategy."&category=performance";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
     
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($ch); // run the whole process

        $content= json_decode($content,TRUE);

        curl_close($ch);

        return $content;

    }

    function google_page_speed_insight_mobile($domain="",$strategy="mobile")
    {

        $key=config("settings.google_api_key");
        if($domain=="" || $key=="") return false;

        $url="https://www.googleapis.com/pagespeedonline/v5/runPagespeed?key=".$key."&url=".$domain."&strategy=".$strategy."&category=performance";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
     
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($ch); // run the whole process

        $content= json_decode($content,TRUE);

        curl_close($ch);

        return $content;

    }


	function mobile_ready($domain="")
	{		
		$key=config("settings.google_api_key");
		
		if($domain=="" || $key=="") exit();
		$domain=$this->clean_domain_name($domain);
		$domain=addHttp($domain);
		$url="https://www.googleapis.com/pagespeedonline/v3beta1/mobileReady?key=".$key."&url=".$domain."&strategy=mobile";
		$respose=$this->get_general_content($url);
		// $respose_array=json_decode($respose,true);
		// if(!$respose_array || !isset($respose_array["ruleGroups"]["USABILITY"]["pass"]))
		// $respose=$this->get_general_content($url);
		// else 
		return $respose;
	}


	function syncMailchimp($data='') 
 	{
        $apikey = config("settings.mailchimp_api_key"); // They key is generated at mailchimps controlpanel under settings.
        $apikey_explode = explode('-',$apikey); // The API ID is the last part of your api key, after the hyphen (-), 
        if(is_array($apikey_explode) && isset($apikey_explode[1])) $api_id=$apikey_explode[1];
        else $api_id="";
        $listId = config("settings.mailchimp_list_id"); //  example: us2 or us10 etc.

        if($apikey=="" || $api_id=="" || $listId=="" || $data=="") return false;
      
        $auth = base64_encode( 'user:'.$apikey );
		
        $insert_data=array
        (
			'email_address'  => $data['email'],
			'status'         => 'subscribed', // "subscribed","unsubscribed","cleaned","pending"
			'merge_fields'  => array('FNAME'=>$data['firstname'],'LNAME'=>'','CITY'=>'','MMERGE5'=>"Subscriber")	
	    );
			
		$insert_data=json_encode($insert_data);
 	
		$url="https://".$api_id.".api.mailchimp.com/3.0/lists/".$listId."/members/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $insert_data);                                                                                                           
        $result = curl_exec($ch);
    }