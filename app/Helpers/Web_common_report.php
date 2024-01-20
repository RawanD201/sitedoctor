<?php  


if ( ! function_exists('ip_info')) {
	function ip_info($ip)
	{
		$url="ipinfo.io/{$ip}/json";
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");  
		curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 20); // times out after 20s
		$st=curl_exec($ch);  
		$result=json_decode($st,TRUE);
		$get_info=curl_getinfo($ch) ;
		$httpcode=$get_info['http_code'];

		$response=array();

		if($httpcode=='200' && isset($result['country'])){
		$response['status']="success";
		
		
		$response['city']= isset($result['city'])?$result['city']:"";
		
		$country_code =isset($result['country'])?strtoupper($result['country']):"";
		if($country_code)
			$response['country']=get_country_iso_phone_currency_list()[$country_code];
		else
			$response['country']="";
		
		$response['postal']=isset($result['postal'])?$result['postal']:"";
		$response['org']=isset($result['org'])?$result['org']:"";
		$response['hostname']=$result['hostname'];
		$response['region']=isset($result['region'])?$result['region']:"";

		$location=isset($result['loc'])?$result['loc']:"";
		$location=explode(",",$location);
		$response['latitude']=isset($location[0]) ? $location[0]:"";
		$response['longitude']=isset($location[1]) ? $location[1]:"";

		}	

		else{
			$response['status']="error";
		} 

		return $response; 
	}
}

if ( ! function_exists('free_geo_ip')) {
	function free_geo_ip($ip)
	{
		$url="freegeoip.net/json/{$ip}";
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");  
		curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 20); // times out after 20s
		$st=curl_exec($ch);  
		$result=json_decode($st,TRUE);

		$get_info=curl_getinfo($ch) ;
		$httpcode=$get_info['http_code'];

		$response=array();

		if($httpcode=='200' && isset($result['country_code']))
		{
			$response['status']="success";
			$response['city']=$result['city'];
			$county_code = strtoupper($result['country_code']);
			$response['country']=get_country_iso_phone_currency_list()[$country_code];;
			$response['postal']=$result['zip_code'];
			$response['latitude']=$result['latitude'];
			$response['longitude']=$result['longitude'];

		} else{
			$response['status']="error";
		} 

		return $response; 

	}
}


if ( ! function_exists('ip_information')) {
	function ip_information($ip)
	{
		$ip_information=free_geo_ip($ip);

		if($ip_information['status']=='error'){
			$ip_information=ip_info($ip);
		}

		return $ip_information;	
	}
}

/** Get Alexa Ranking, Traffic Rank, Reach Rank, Country Rank ****/
if ( ! function_exists('get_alexa_rank')) {
	function get_alexa_rank($domain)
	{

		try 
		{
			$doc = new DOMDocument; 
			$url="http://data.alexa.com/data?cli=10&url={$domain}";
			$doc->load($url);
			$thedocument = $doc->documentElement;
			$rankingInfo=$thedocument->getElementsByTagName('SD');

			$country="";
			$country_rank="";

			foreach($rankingInfo as $info){
				/****Get Reach Rank*****/
				$ranks=$info->getElementsByTagName('REACH');

				foreach($ranks as $rank){
					$reach_rank=$rank->getAttribute('RANK');
				}

				/****Get country Rank***/
				$countr_rank_info=$info->getElementsByTagName('COUNTRY');

				foreach($countr_rank_info as $c_info){
					$country=$c_info->getAttribute('NAME');
					$country_rank=$c_info->getAttribute('RANK');
				}

				/***** Get Traffic Rank *****/
				$ranks=$info->getElementsByTagName('POPULARITY');

				foreach($ranks as $rank){
					$traffic_rank=$rank->getAttribute('TEXT');
				}


			}

			$response['reach_rank']=isset($reach_rank)?$reach_rank:"no data";
			$response['country']=isset($country)?$country:"no data";
			$response['country_rank']=isset($country_rank)?$country_rank:"no data";
			$response['traffic_rank']=isset($traffic_rank)?$traffic_rank:"no data";

			return $response;
		} 

		catch (Exception $e) 
		{
			$url="http://getbddoctor.com/secure/alexa/index.php?domain={$domain}";
			$ch = curl_init(); // initialize curl handle
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
			curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_REFERER, 'http://'.$url);
			curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
			curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
			curl_setopt($ch, CURLOPT_POST, 0); // set POST method
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
			curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
			$content = curl_exec($ch); // run the whole process
			$curl_info= curl_getinfo($ch);
			curl_close($ch);
			return json_decode($content,true);
		}
	}
}


if ( ! function_exists('get_ip_country_old')) {
	function get_ip_country_old($domain,$proxy='')
	{
		$domain=str_replace("www.","",$domain);
		$domain=str_replace("http://","",$domain);
		$domain=str_replace("https://","",$domain);
		$domain=str_replace("/","",$domain);
		$domain=strtolower($domain);

		$ip_link = "http://www.iplocationfinder.com/{$domain}";
		$ch = curl_init(); // initialize curl handle
		curl_setopt($ch, CURLOPT_URL,$ip_link); // set url to post to
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );

		/**** Using proxy of public and private proxy both ****/
		// if($this->proxy_ip!='')
		// 	curl_setopt($ch, CURLOPT_PROXY, $this->proxy_ip);
		
		// if($this->proxy_auth_pass!='')	
		// 	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth_pass);
			
		
		$content = curl_exec($ch); // run the whole process
		curl_close($ch);

		$response=array();		

		preg_match('#<th>ISP:</th><td>(.*?)</td>#', $content, $matches);
		$response['isp']=isset($matches[1])?$matches[1] : '';

		preg_match('#<th>IP:</th><td>(.*?)</td>#', $content, $matches);
		$response['ip']=isset($matches[1])?$matches[1] : '';

		preg_match('#<th>Organization:</th><td>(.*?)</td>#', $content, $matches);
		$response['organization']=isset($matches[1])?$matches[1] : '';		

		preg_match('#<th>City:</th><td>(.*?)</td>#', $content, $matches);
		$response['city']=isset($matches[1])?$matches[1] : '';

		preg_match('#<th>Region:</th><td>(.*?)</td>#', $content, $matches);
		$response['region']=isset($matches[1])?$matches[1] : '';

		preg_match('#<th>Country:</th><td>(.*?)</td>#', $content, $matches);
		$country=isset($matches[1])?$matches[1] : '';
		$response['country'] = preg_replace("#<img.*?>#", "", $country); 

		preg_match('#<th>Timezone:</th><td>(.*?)</td>#', $content, $matches);
		$response['time_zone']=isset($matches[1])?$matches[1] : '';

		preg_match('#<th>Longitude:</th><td>(.*?)</td>#', $content, $matches);
		$response['longitude']=isset($matches[1])?$matches[1] : '';

		preg_match('#<th>Latitude:</th><td>(.*?)</td>#', $content, $matches);
		$response['latitude']=isset($matches[1])?$matches[1] : '';

		return $response;
	}
}


// heatmap helper functions
if ( ! function_exists('get_ip_country')){
    function get_ip_country($ip)
    {
        $function_list=array("get_ip_info_from_geo_plugin","get_ip_from_ipinfo");
        // $function_list=array("get_ip_from_ipinfo");
        shuffle($function_list);
        $ip_info=$function_list[0]($ip);
        return $ip_info;
    }
}


//http://www.geoplugin.net/json.gp
function get_ip_info_from_geo_plugin($ip)
{
    $link="http://www.geoplugin.net/php.gp?ip={$ip}";
    $ip_info_json=file_get_contents($link);
    $ip_info_array=unserialize($ip_info_json);
    $ip_info=array();
    if(!empty($ip_info_array)){
        $ip_info['ip']=$ip; 
        $ip_info['city']=$ip_info_array['geoplugin_city'] ?? ""; 
        $ip_info['country']=$ip_info_array['geoplugin_countryCode'] ?? ""; 
        $ip_info['latitude']=$ip_info_array['geoplugin_latitude'] ?? ""; 
        $ip_info['longitude']=$ip_info_array['geoplugin_longitude'] ?? ""; 
        $ip_info['time_zone']=$ip_info_array['geoplugin_timezone'] ?? ""; 
    }
    return $ip_info;
}



function get_ip_from_ipinfo($ip)
{
    $link="http://ipinfo.io/{$ip}/json";
    $ip_info_json=file_get_contents($link);
    $ip_info_array=json_decode($ip_info_json,true);
    $ip_info=array();

    if(!empty($ip_info_array)){
    	$lat_long = $ip_info_array['loc'] ?? '';
    	$lat_long = explode(',',$lat_long);
    	$ip_info['latitude'] = $lat_long[0] ?? '';
    	$ip_info['longitude'] = $lat_long[1] ?? '';
    	$ip_info['ip']=$ip;
        $ip_info['city']=$ip_info_array['city'] ?? ""; 
        $ip_info['country']=$ip_info_array['country'] ?? ""; 
        $ip_info['time_zone']=$ip_info_array['timezone'] ?? ""; 
    }
    
    return $ip_info;
}



if ( ! function_exists('get_country_iso_phone_currency_list')) {
    function get_country_iso_phone_currency_list($return = 'country') // country,currency_name,currecny_icon,phonecode
    {
        $countries = array(
            array('name' => 'Afghanistan', 'iso_alpha2' => 'AF', 'iso_alpha3' => 'AFG', 'iso_numeric' => '4', 'calling_code' => '93', 'currency_code' => 'AFN', 'currency_name' => 'Afghani', 'currency_symbol' => '؋'),
            array('name' => 'Albania', 'iso_alpha2' => 'AL', 'iso_alpha3' => 'ALB', 'iso_numeric' => '8', 'calling_code' => '355', 'currency_code' => 'ALL', 'currency_name' => 'Lek', 'currency_symbol' => 'Lek'),
            array('name' => 'Algeria', 'iso_alpha2' => 'DZ', 'iso_alpha3' => 'DZA', 'iso_numeric' => '12', 'calling_code' => '213', 'currency_code' => 'DZD', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'American Samoa', 'iso_alpha2' => 'AS', 'iso_alpha3' => 'ASM', 'iso_numeric' => '16', 'calling_code' => '1684', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Andorra', 'iso_alpha2' => 'AD', 'iso_alpha3' => 'AND', 'iso_numeric' => '20', 'calling_code' => '376', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Angola', 'iso_alpha2' => 'AO', 'iso_alpha3' => 'AGO', 'iso_numeric' => '24', 'calling_code' => '244', 'currency_code' => 'AOA', 'currency_name' => 'Kwanza', 'currency_symbol' => 'Kz'),
            array('name' => 'Anguilla', 'iso_alpha2' => 'AI', 'iso_alpha3' => 'AIA', 'iso_numeric' => '660', 'calling_code' => '1264', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Antarctica', 'iso_alpha2' => 'AQ', 'iso_alpha3' => 'ATA', 'iso_numeric' => '10', 'calling_code' => '672', 'currency_code' => '', 'currency_name' => '', 'currency_symbol' => ''),
            array('name' => 'Antigua and Barbuda', 'iso_alpha2' => 'AG', 'iso_alpha3' => 'ATG', 'iso_numeric' => '28', 'calling_code' => '1268', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Argentina', 'iso_alpha2' => 'AR', 'iso_alpha3' => 'ARG', 'iso_numeric' => '32', 'calling_code' => '54', 'currency_code' => 'ARS', 'currency_name' => 'Peso', 'currency_symbol' => '$'),
            array('name' => 'Armenia', 'iso_alpha2' => 'AM', 'iso_alpha3' => 'ARM', 'iso_numeric' => '51', 'calling_code' => '374', 'currency_code' => 'AMD', 'currency_name' => 'Dram', 'currency_symbol' => ''),
            array('name' => 'Aruba', 'iso_alpha2' => 'AW', 'iso_alpha3' => 'ABW', 'iso_numeric' => '533', 'calling_code' => '297', 'currency_code' => 'AWG', 'currency_name' => 'Guilder', 'currency_symbol' => 'ƒ'),
            array('name' => 'Australia', 'iso_alpha2' => 'AU', 'iso_alpha3' => 'AUS', 'iso_numeric' => '36', 'calling_code' => '61', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Austria', 'iso_alpha2' => 'AT', 'iso_alpha3' => 'AUT', 'iso_numeric' => '40', 'calling_code' => '43', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Azerbaijan', 'iso_alpha2' => 'AZ', 'iso_alpha3' => 'AZE', 'iso_numeric' => '31', 'calling_code' => '994', 'currency_code' => 'AZN', 'currency_name' => 'Manat', 'currency_symbol' => 'ман'),
            array('name' => 'Bahamas', 'iso_alpha2' => 'BS', 'iso_alpha3' => 'BHS', 'iso_numeric' => '44', 'calling_code' => '1242', 'currency_code' => 'BSD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Bahrain', 'iso_alpha2' => 'BH', 'iso_alpha3' => 'BHR', 'iso_numeric' => '48', 'calling_code' => '973', 'currency_code' => 'BHD', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'Bangladesh', 'iso_alpha2' => 'BD', 'iso_alpha3' => 'BGD', 'iso_numeric' => '50', 'calling_code' => '880', 'currency_code' => 'BDT', 'currency_name' => 'Taka', 'currency_symbol' => ''),
            array('name' => 'Barbados', 'iso_alpha2' => 'BB', 'iso_alpha3' => 'BRB', 'iso_numeric' => '52', 'calling_code' => '1246', 'currency_code' => 'BBD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Belarus', 'iso_alpha2' => 'BY', 'iso_alpha3' => 'BLR', 'iso_numeric' => '112', 'calling_code' => '375', 'currency_code' => 'BYR', 'currency_name' => 'Ruble', 'currency_symbol' => 'p.'),
            array('name' => 'Belgium', 'iso_alpha2' => 'BE', 'iso_alpha3' => 'BEL', 'iso_numeric' => '56', 'calling_code' => '32', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Belize', 'iso_alpha2' => 'BZ', 'iso_alpha3' => 'BLZ', 'iso_numeric' => '84', 'calling_code' => '501', 'currency_code' => 'BZD', 'currency_name' => 'Dollar', 'currency_symbol' => 'BZ$'),
            array('name' => 'Benin', 'iso_alpha2' => 'BJ', 'iso_alpha3' => 'BEN', 'iso_numeric' => '204', 'calling_code' => '229', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Bermuda', 'iso_alpha2' => 'BM', 'iso_alpha3' => 'BMU', 'iso_numeric' => '60', 'calling_code' => '1441', 'currency_code' => 'BMD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Bhutan', 'iso_alpha2' => 'BT', 'iso_alpha3' => 'BTN', 'iso_numeric' => '64', 'calling_code' => '975', 'currency_code' => 'BTN', 'currency_name' => 'Ngultrum', 'currency_symbol' => ''),
            array('name' => 'Bolivia', 'iso_alpha2' => 'BO', 'iso_alpha3' => 'BOL', 'iso_numeric' => '68', 'calling_code' => '591', 'currency_code' => 'BOB', 'currency_name' => 'Boliviano', 'currency_symbol' => '$b'),
            array('name' => 'Bosnia and Herzegovina', 'iso_alpha2' => 'BA', 'iso_alpha3' => 'BIH', 'iso_numeric' => '70', 'calling_code' => '387', 'currency_code' => 'BAM', 'currency_name' => 'Marka', 'currency_symbol' => 'KM'),
            array('name' => 'Botswana', 'iso_alpha2' => 'BW', 'iso_alpha3' => 'BWA', 'iso_numeric' => '72', 'calling_code' => '267', 'currency_code' => 'BWP', 'currency_name' => 'Pula', 'currency_symbol' => 'P'),
            array('name' => 'Bouvet Island', 'iso_alpha2' => 'BV', 'iso_alpha3' => 'BVT', 'iso_numeric' => '74', 'calling_code' => '', 'currency_code' => 'NOK', 'currency_name' => 'Krone', 'currency_symbol' => 'kr'),
            array('name' => 'Brazil', 'iso_alpha2' => 'BR', 'iso_alpha3' => 'BRA', 'iso_numeric' => '76', 'calling_code' => '55', 'currency_code' => 'BRL', 'currency_name' => 'Real', 'currency_symbol' => 'R$'),
            array('name' => 'British Indian Ocean Territory', 'iso_alpha2' => 'IO', 'iso_alpha3' => 'IOT', 'iso_numeric' => '86', 'calling_code' => '', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'British Virgin Islands', 'iso_alpha2' => 'VG', 'iso_alpha3' => 'VGB', 'iso_numeric' => '92', 'calling_code' => '1284', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Brunei', 'iso_alpha2' => 'BN', 'iso_alpha3' => 'BRN', 'iso_numeric' => '96', 'calling_code' => '673', 'currency_code' => 'BND', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Bulgaria', 'iso_alpha2' => 'BG', 'iso_alpha3' => 'BGR', 'iso_numeric' => '100', 'calling_code' => '359', 'currency_code' => 'BGN', 'currency_name' => 'Lev', 'currency_symbol' => 'лв'),
            array('name' => 'Burkina Faso', 'iso_alpha2' => 'BF', 'iso_alpha3' => 'BFA', 'iso_numeric' => '854', 'calling_code' => '226', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Burundi', 'iso_alpha2' => 'BI', 'iso_alpha3' => 'BDI', 'iso_numeric' => '108', 'calling_code' => '257', 'currency_code' => 'BIF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Cambodia', 'iso_alpha2' => 'KH', 'iso_alpha3' => 'KHM', 'iso_numeric' => '116', 'calling_code' => '855', 'currency_code' => 'KHR', 'currency_name' => 'Riels', 'currency_symbol' => '៛'),
            array('name' => 'Cameroon', 'iso_alpha2' => 'CM', 'iso_alpha3' => 'CMR', 'iso_numeric' => '120', 'calling_code' => '237', 'currency_code' => 'XAF', 'currency_name' => 'Franc', 'currency_symbol' => 'FCF'),
            array('name' => 'Canada', 'iso_alpha2' => 'CA', 'iso_alpha3' => 'CAN', 'iso_numeric' => '124', 'calling_code' => '1', 'currency_code' => 'CAD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Cape Verde', 'iso_alpha2' => 'CV', 'iso_alpha3' => 'CPV', 'iso_numeric' => '132', 'calling_code' => '238', 'currency_code' => 'CVE', 'currency_name' => 'Escudo', 'currency_symbol' => ''),
            array('name' => 'Cayman Islands', 'iso_alpha2' => 'KY', 'iso_alpha3' => 'CYM', 'iso_numeric' => '136', 'calling_code' => '1345', 'currency_code' => 'KYD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Central African Republic', 'iso_alpha2' => 'CF', 'iso_alpha3' => 'CAF', 'iso_numeric' => '140', 'calling_code' => '236', 'currency_code' => 'XAF', 'currency_name' => 'Franc', 'currency_symbol' => 'FCF'),
            array('name' => 'Chad', 'iso_alpha2' => 'TD', 'iso_alpha3' => 'TCD', 'iso_numeric' => '148', 'calling_code' => '235', 'currency_code' => 'XAF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Chile', 'iso_alpha2' => 'CL', 'iso_alpha3' => 'CHL', 'iso_numeric' => '152', 'calling_code' => '56', 'currency_code' => 'CLP', 'currency_name' => 'Peso', 'currency_symbol' => ''),
            array('name' => 'China', 'iso_alpha2' => 'CN', 'iso_alpha3' => 'CHN', 'iso_numeric' => '156', 'calling_code' => '86', 'currency_code' => 'CNY', 'currency_name' => 'YuanRenminbi', 'currency_symbol' => '¥'),
            array('name' => 'Christmas Island', 'iso_alpha2' => 'CX', 'iso_alpha3' => 'CXR', 'iso_numeric' => '162', 'calling_code' => '61', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Cocos Islands', 'iso_alpha2' => 'CC', 'iso_alpha3' => 'CCK', 'iso_numeric' => '166', 'calling_code' => '61', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Colombia', 'iso_alpha2' => 'CO', 'iso_alpha3' => 'COL', 'iso_numeric' => '170', 'calling_code' => '57', 'currency_code' => 'COP', 'currency_name' => 'Peso', 'currency_symbol' => '$'),
            array('name' => 'Comoros', 'iso_alpha2' => 'KM', 'iso_alpha3' => 'COM', 'iso_numeric' => '174', 'calling_code' => '269', 'currency_code' => 'KMF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Cook Islands', 'iso_alpha2' => 'CK', 'iso_alpha3' => 'COK', 'iso_numeric' => '184', 'calling_code' => '682', 'currency_code' => 'NZD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Costa Rica', 'iso_alpha2' => 'CR', 'iso_alpha3' => 'CRI', 'iso_numeric' => '188', 'calling_code' => '506', 'currency_code' => 'CRC', 'currency_name' => 'Colon', 'currency_symbol' => '₡'),
            array('name' => 'Croatia', 'iso_alpha2' => 'HR', 'iso_alpha3' => 'HRV', 'iso_numeric' => '191', 'calling_code' => '385', 'currency_code' => 'HRK', 'currency_name' => 'Kuna', 'currency_symbol' => 'kn'),
            array('name' => 'Cuba', 'iso_alpha2' => 'CU', 'iso_alpha3' => 'CUB', 'iso_numeric' => '192', 'calling_code' => '53', 'currency_code' => 'CUP', 'currency_name' => 'Peso', 'currency_symbol' => '₱'),
            array('name' => 'Cyprus', 'iso_alpha2' => 'CY', 'iso_alpha3' => 'CYP', 'iso_numeric' => '196', 'calling_code' => '357', 'currency_code' => 'CYP', 'currency_name' => 'Pound', 'currency_symbol' => ''),
            array('name' => 'Czech Republic', 'iso_alpha2' => 'CZ', 'iso_alpha3' => 'CZE', 'iso_numeric' => '203', 'calling_code' => '420', 'currency_code' => 'CZK', 'currency_name' => 'Koruna', 'currency_symbol' => 'Kč'),
            array('name' => 'Democratic Republic of the Congo', 'iso_alpha2' => 'CD', 'iso_alpha3' => 'COD', 'iso_numeric' => '180', 'calling_code' => '243', 'currency_code' => 'CDF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Denmark', 'iso_alpha2' => 'DK', 'iso_alpha3' => 'DNK', 'iso_numeric' => '208', 'calling_code' => '45', 'currency_code' => 'DKK', 'currency_name' => 'Krone', 'currency_symbol' => 'kr'),
            array('name' => 'Djibouti', 'iso_alpha2' => 'DJ', 'iso_alpha3' => 'DJI', 'iso_numeric' => '262', 'calling_code' => '253', 'currency_code' => 'DJF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Dominica', 'iso_alpha2' => 'DM', 'iso_alpha3' => 'DMA', 'iso_numeric' => '212', 'calling_code' => '1767', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Dominican Republic', 'iso_alpha2' => 'DO', 'iso_alpha3' => 'DOM', 'iso_numeric' => '214', 'calling_code' => '1809', 'currency_code' => 'DOP', 'currency_name' => 'Peso', 'currency_symbol' => 'RD$'),
            array('name' => 'East Timor', 'iso_alpha2' => 'TL', 'iso_alpha3' => 'TLS', 'iso_numeric' => '626', 'calling_code' => '670', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Ecuador', 'iso_alpha2' => 'EC', 'iso_alpha3' => 'ECU', 'iso_numeric' => '218', 'calling_code' => '593', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Egypt', 'iso_alpha2' => 'EG', 'iso_alpha3' => 'EGY', 'iso_numeric' => '818', 'calling_code' => '20', 'currency_code' => 'EGP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'El Salvador', 'iso_alpha2' => 'SV', 'iso_alpha3' => 'SLV', 'iso_numeric' => '222', 'calling_code' => '503', 'currency_code' => 'SVC', 'currency_name' => 'Colone', 'currency_symbol' => '$'),
            array('name' => 'Equatorial Guinea', 'iso_alpha2' => 'GQ', 'iso_alpha3' => 'GNQ', 'iso_numeric' => '226', 'calling_code' => '240', 'currency_code' => 'XAF', 'currency_name' => 'Franc', 'currency_symbol' => 'FCF'),
            array('name' => 'Eritrea', 'iso_alpha2' => 'ER', 'iso_alpha3' => 'ERI', 'iso_numeric' => '232', 'calling_code' => '291', 'currency_code' => 'ERN', 'currency_name' => 'Nakfa', 'currency_symbol' => 'Nfk'),
            array('name' => 'Estonia', 'iso_alpha2' => 'EE', 'iso_alpha3' => 'EST', 'iso_numeric' => '233', 'calling_code' => '372', 'currency_code' => 'EEK', 'currency_name' => 'Kroon', 'currency_symbol' => 'kr'),
            array('name' => 'Ethiopia', 'iso_alpha2' => 'ET', 'iso_alpha3' => 'ETH', 'iso_numeric' => '231', 'calling_code' => '251', 'currency_code' => 'ETB', 'currency_name' => 'Birr', 'currency_symbol' => ''),
            array('name' => 'Falkland Islands', 'iso_alpha2' => 'FK', 'iso_alpha3' => 'FLK', 'iso_numeric' => '238', 'calling_code' => '500', 'currency_code' => 'FKP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'Faroe Islands', 'iso_alpha2' => 'FO', 'iso_alpha3' => 'FRO', 'iso_numeric' => '234', 'calling_code' => '298', 'currency_code' => 'DKK', 'currency_name' => 'Krone', 'currency_symbol' => 'kr'),
            array('name' => 'Fiji', 'iso_alpha2' => 'FJ', 'iso_alpha3' => 'FJI', 'iso_numeric' => '242', 'calling_code' => '679', 'currency_code' => 'FJD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Finland', 'iso_alpha2' => 'FI', 'iso_alpha3' => 'FIN', 'iso_numeric' => '246', 'calling_code' => '358', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'France', 'iso_alpha2' => 'FR', 'iso_alpha3' => 'FRA', 'iso_numeric' => '250', 'calling_code' => '33', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'French Guiana', 'iso_alpha2' => 'GF', 'iso_alpha3' => 'GUF', 'iso_numeric' => '254', 'calling_code' => '', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'French Polynesia', 'iso_alpha2' => 'PF', 'iso_alpha3' => 'PYF', 'iso_numeric' => '258', 'calling_code' => '689', 'currency_code' => 'XPF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'French Southern Territories', 'iso_alpha2' => 'TF', 'iso_alpha3' => 'ATF', 'iso_numeric' => '260', 'calling_code' => '', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Gabon', 'iso_alpha2' => 'GA', 'iso_alpha3' => 'GAB', 'iso_numeric' => '266', 'calling_code' => '241', 'currency_code' => 'XAF', 'currency_name' => 'Franc', 'currency_symbol' => 'FCF'),
            array('name' => 'Gambia', 'iso_alpha2' => 'GM', 'iso_alpha3' => 'GMB', 'iso_numeric' => '270', 'calling_code' => '220', 'currency_code' => 'GMD', 'currency_name' => 'Dalasi', 'currency_symbol' => 'D'),
            array('name' => 'Georgia', 'iso_alpha2' => 'GE', 'iso_alpha3' => 'GEO', 'iso_numeric' => '268', 'calling_code' => '995', 'currency_code' => 'GEL', 'currency_name' => 'Lari', 'currency_symbol' => ''),
            array('name' => 'Germany', 'iso_alpha2' => 'DE', 'iso_alpha3' => 'DEU', 'iso_numeric' => '276', 'calling_code' => '49', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Ghana', 'iso_alpha2' => 'GH', 'iso_alpha3' => 'GHA', 'iso_numeric' => '288', 'calling_code' => '233', 'currency_code' => 'GHC', 'currency_name' => 'Cedi', 'currency_symbol' => '¢'),
            array('name' => 'Gibraltar', 'iso_alpha2' => 'GI', 'iso_alpha3' => 'GIB', 'iso_numeric' => '292', 'calling_code' => '350', 'currency_code' => 'GIP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'Greece', 'iso_alpha2' => 'GR', 'iso_alpha3' => 'GRC', 'iso_numeric' => '300', 'calling_code' => '30', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Greenland', 'iso_alpha2' => 'GL', 'iso_alpha3' => 'GRL', 'iso_numeric' => '304', 'calling_code' => '299', 'currency_code' => 'DKK', 'currency_name' => 'Krone', 'currency_symbol' => 'kr'),
            array('name' => 'Grenada', 'iso_alpha2' => 'GD', 'iso_alpha3' => 'GRD', 'iso_numeric' => '308', 'calling_code' => '1473', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Guadeloupe', 'iso_alpha2' => 'GP', 'iso_alpha3' => 'GLP', 'iso_numeric' => '312', 'calling_code' => '', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Guam', 'iso_alpha2' => 'GU', 'iso_alpha3' => 'GUM', 'iso_numeric' => '316', 'calling_code' => '1671', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Guatemala', 'iso_alpha2' => 'GT', 'iso_alpha3' => 'GTM', 'iso_numeric' => '320', 'calling_code' => '502', 'currency_code' => 'GTQ', 'currency_name' => 'Quetzal', 'currency_symbol' => 'Q'),
            array('name' => 'Guinea', 'iso_alpha2' => 'GN', 'iso_alpha3' => 'GIN', 'iso_numeric' => '324', 'calling_code' => '224', 'currency_code' => 'GNF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Guinea-Bissau', 'iso_alpha2' => 'GW', 'iso_alpha3' => 'GNB', 'iso_numeric' => '624', 'calling_code' => '245', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Guyana', 'iso_alpha2' => 'GY', 'iso_alpha3' => 'GUY', 'iso_numeric' => '328', 'calling_code' => '592', 'currency_code' => 'GYD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Haiti', 'iso_alpha2' => 'HT', 'iso_alpha3' => 'HTI', 'iso_numeric' => '332', 'calling_code' => '509', 'currency_code' => 'HTG', 'currency_name' => 'Gourde', 'currency_symbol' => 'G'),
            array('name' => 'Heard Island and McDonald Islands', 'iso_alpha2' => 'HM', 'iso_alpha3' => 'HMD', 'iso_numeric' => '334', 'calling_code' => '', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Honduras', 'iso_alpha2' => 'HN', 'iso_alpha3' => 'HND', 'iso_numeric' => '340', 'calling_code' => '504', 'currency_code' => 'HNL', 'currency_name' => 'Lempira', 'currency_symbol' => 'L'),
            array('name' => 'Hong Kong', 'iso_alpha2' => 'HK', 'iso_alpha3' => 'HKG', 'iso_numeric' => '344', 'calling_code' => '852', 'currency_code' => 'HKD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Hungary', 'iso_alpha2' => 'HU', 'iso_alpha3' => 'HUN', 'iso_numeric' => '348', 'calling_code' => '36', 'currency_code' => 'HUF', 'currency_name' => 'Forint', 'currency_symbol' => 'Ft'),
            array('name' => 'Iceland', 'iso_alpha2' => 'IS', 'iso_alpha3' => 'ISL', 'iso_numeric' => '352', 'calling_code' => '354', 'currency_code' => 'ISK', 'currency_name' => 'Krona', 'currency_symbol' => 'kr'),
            array('name' => 'India', 'iso_alpha2' => 'IN', 'iso_alpha3' => 'IND', 'iso_numeric' => '356', 'calling_code' => '91', 'currency_code' => 'INR', 'currency_name' => 'Rupee', 'currency_symbol' => '₹'),
            array('name' => 'Indonesia', 'iso_alpha2' => 'ID', 'iso_alpha3' => 'IDN', 'iso_numeric' => '360', 'calling_code' => '62', 'currency_code' => 'IDR', 'currency_name' => 'Rupiah', 'currency_symbol' => 'Rp'),
            array('name' => 'Iran', 'iso_alpha2' => 'IR', 'iso_alpha3' => 'IRN', 'iso_numeric' => '364', 'calling_code' => '98', 'currency_code' => 'IRR', 'currency_name' => 'Rial', 'currency_symbol' => '﷼'),
            array('name' => 'Iraq', 'iso_alpha2' => 'IQ', 'iso_alpha3' => 'IRQ', 'iso_numeric' => '368', 'calling_code' => '964', 'currency_code' => 'IQD', 'currency_name' => 'Dinar', 'currency_symbol' => 'د.ع'),
            array('name' => 'Ireland', 'iso_alpha2' => 'IE', 'iso_alpha3' => 'IRL', 'iso_numeric' => '372', 'calling_code' => '353', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Israel', 'iso_alpha2' => 'IL', 'iso_alpha3' => 'ISR', 'iso_numeric' => '376', 'calling_code' => '972', 'currency_code' => 'ILS', 'currency_name' => 'Shekel', 'currency_symbol' => '₪'),
            array('name' => 'Italy', 'iso_alpha2' => 'IT', 'iso_alpha3' => 'ITA', 'iso_numeric' => '380', 'calling_code' => '39', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Ivory Coast', 'iso_alpha2' => 'CI', 'iso_alpha3' => 'CIV', 'iso_numeric' => '384', 'calling_code' => '225', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Jamaica', 'iso_alpha2' => 'JM', 'iso_alpha3' => 'JAM', 'iso_numeric' => '388', 'calling_code' => '1876', 'currency_code' => 'JMD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Japan', 'iso_alpha2' => 'JP', 'iso_alpha3' => 'JPN', 'iso_numeric' => '392', 'calling_code' => '81', 'currency_code' => 'JPY', 'currency_name' => 'Yen', 'currency_symbol' => '¥'),
            array('name' => 'Jordan', 'iso_alpha2' => 'JO', 'iso_alpha3' => 'JOR', 'iso_numeric' => '400', 'calling_code' => '962', 'currency_code' => 'JOD', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'Kazakhstan', 'iso_alpha2' => 'KZ', 'iso_alpha3' => 'KAZ', 'iso_numeric' => '398', 'calling_code' => '7', 'currency_code' => 'KZT', 'currency_name' => 'Tenge', 'currency_symbol' => 'лв'),
            array('name' => 'Kenya', 'iso_alpha2' => 'KE', 'iso_alpha3' => 'KEN', 'iso_numeric' => '404', 'calling_code' => '254', 'currency_code' => 'KES', 'currency_name' => 'Shilling', 'currency_symbol' => ''),
            array('name' => 'Kiribati', 'iso_alpha2' => 'KI', 'iso_alpha3' => 'KIR', 'iso_numeric' => '296', 'calling_code' => '686', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Kuwait', 'iso_alpha2' => 'KW', 'iso_alpha3' => 'KWT', 'iso_numeric' => '414', 'calling_code' => '965', 'currency_code' => 'KWD', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'Kyrgyzstan', 'iso_alpha2' => 'KG', 'iso_alpha3' => 'KGZ', 'iso_numeric' => '417', 'calling_code' => '996', 'currency_code' => 'KGS', 'currency_name' => 'Som', 'currency_symbol' => 'лв'),
            array('name' => 'Laos', 'iso_alpha2' => 'LA', 'iso_alpha3' => 'LAO', 'iso_numeric' => '418', 'calling_code' => '856', 'currency_code' => 'LAK', 'currency_name' => 'Kip', 'currency_symbol' => '₭'),
            array('name' => 'Latvia', 'iso_alpha2' => 'LV', 'iso_alpha3' => 'LVA', 'iso_numeric' => '428', 'calling_code' => '371', 'currency_code' => 'LVL', 'currency_name' => 'Lat', 'currency_symbol' => 'Ls'),
            array('name' => 'Lebanon', 'iso_alpha2' => 'LB', 'iso_alpha3' => 'LBN', 'iso_numeric' => '422', 'calling_code' => '961', 'currency_code' => 'LBP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'Lesotho', 'iso_alpha2' => 'LS', 'iso_alpha3' => 'LSO', 'iso_numeric' => '426', 'calling_code' => '266', 'currency_code' => 'LSL', 'currency_name' => 'Loti', 'currency_symbol' => 'L'),
            array('name' => 'Liberia', 'iso_alpha2' => 'LR', 'iso_alpha3' => 'LBR', 'iso_numeric' => '430', 'calling_code' => '231', 'currency_code' => 'LRD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Libya', 'iso_alpha2' => 'LY', 'iso_alpha3' => 'LBY', 'iso_numeric' => '434', 'calling_code' => '218', 'currency_code' => 'LYD', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'Liechtenstein', 'iso_alpha2' => 'LI', 'iso_alpha3' => 'LIE', 'iso_numeric' => '438', 'calling_code' => '423', 'currency_code' => 'CHF', 'currency_name' => 'Franc', 'currency_symbol' => 'CHF'),
            array('name' => 'Lithuania', 'iso_alpha2' => 'LT', 'iso_alpha3' => 'LTU', 'iso_numeric' => '440', 'calling_code' => '370', 'currency_code' => 'LTL', 'currency_name' => 'Litas', 'currency_symbol' => 'Lt'),
            array('name' => 'Luxembourg', 'iso_alpha2' => 'LU', 'iso_alpha3' => 'LUX', 'iso_numeric' => '442', 'calling_code' => '352', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Macao', 'iso_alpha2' => 'MO', 'iso_alpha3' => 'MAC', 'iso_numeric' => '446', 'calling_code' => '853', 'currency_code' => 'MOP', 'currency_name' => 'Pataca', 'currency_symbol' => 'MOP'),
            array('name' => 'Macedonia', 'iso_alpha2' => 'MK', 'iso_alpha3' => 'MKD', 'iso_numeric' => '807', 'calling_code' => '389', 'currency_code' => 'MKD', 'currency_name' => 'Denar', 'currency_symbol' => 'ден'),
            array('name' => 'Madagascar', 'iso_alpha2' => 'MG', 'iso_alpha3' => 'MDG', 'iso_numeric' => '450', 'calling_code' => '261', 'currency_code' => 'MGA', 'currency_name' => 'Ariary', 'currency_symbol' => ''),
            array('name' => 'Malawi', 'iso_alpha2' => 'MW', 'iso_alpha3' => 'MWI', 'iso_numeric' => '454', 'calling_code' => '265', 'currency_code' => 'MWK', 'currency_name' => 'Kwacha', 'currency_symbol' => 'MK'),
            array('name' => 'Malaysia', 'iso_alpha2' => 'MY', 'iso_alpha3' => 'MYS', 'iso_numeric' => '458', 'calling_code' => '60', 'currency_code' => 'MYR', 'currency_name' => 'Ringgit', 'currency_symbol' => 'RM'),
            array('name' => 'Maldives', 'iso_alpha2' => 'MV', 'iso_alpha3' => 'MDV', 'iso_numeric' => '462', 'calling_code' => '960', 'currency_code' => 'MVR', 'currency_name' => 'Rufiyaa', 'currency_symbol' => 'Rf'),
            array('name' => 'Mali', 'iso_alpha2' => 'ML', 'iso_alpha3' => 'MLI', 'iso_numeric' => '466', 'calling_code' => '223', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Malta', 'iso_alpha2' => 'MT', 'iso_alpha3' => 'MLT', 'iso_numeric' => '470', 'calling_code' => '356', 'currency_code' => 'MTL', 'currency_name' => 'Lira', 'currency_symbol' => ''),
            array('name' => 'Marshall Islands', 'iso_alpha2' => 'MH', 'iso_alpha3' => 'MHL', 'iso_numeric' => '584', 'calling_code' => '692', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Martinique', 'iso_alpha2' => 'MQ', 'iso_alpha3' => 'MTQ', 'iso_numeric' => '474', 'calling_code' => '', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Mauritania', 'iso_alpha2' => 'MR', 'iso_alpha3' => 'MRT', 'iso_numeric' => '478', 'calling_code' => '222', 'currency_code' => 'MRO', 'currency_name' => 'Ouguiya', 'currency_symbol' => 'UM'),
            array('name' => 'Mauritius', 'iso_alpha2' => 'MU', 'iso_alpha3' => 'MUS', 'iso_numeric' => '480', 'calling_code' => '230', 'currency_code' => 'MUR', 'currency_name' => 'Rupee', 'currency_symbol' => '₨'),
            array('name' => 'Mayotte', 'iso_alpha2' => 'YT', 'iso_alpha3' => 'MYT', 'iso_numeric' => '175', 'calling_code' => '262', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Mexico', 'iso_alpha2' => 'MX', 'iso_alpha3' => 'MEX', 'iso_numeric' => '484', 'calling_code' => '52', 'currency_code' => 'MXN', 'currency_name' => 'Peso', 'currency_symbol' => '$'),
            array('name' => 'Micronesia', 'iso_alpha2' => 'FM', 'iso_alpha3' => 'FSM', 'iso_numeric' => '583', 'calling_code' => '691', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Moldova', 'iso_alpha2' => 'MD', 'iso_alpha3' => 'MDA', 'iso_numeric' => '498', 'calling_code' => '373', 'currency_code' => 'MDL', 'currency_name' => 'Leu', 'currency_symbol' => ''),
            array('name' => 'Monaco', 'iso_alpha2' => 'MC', 'iso_alpha3' => 'MCO', 'iso_numeric' => '492', 'calling_code' => '377', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Mongolia', 'iso_alpha2' => 'MN', 'iso_alpha3' => 'MNG', 'iso_numeric' => '496', 'calling_code' => '976', 'currency_code' => 'MNT', 'currency_name' => 'Tugrik', 'currency_symbol' => '₮'),
            array('name' => 'Montserrat', 'iso_alpha2' => 'MS', 'iso_alpha3' => 'MSR', 'iso_numeric' => '500', 'calling_code' => '1664', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Morocco', 'iso_alpha2' => 'MA', 'iso_alpha3' => 'MAR', 'iso_numeric' => '504', 'calling_code' => '212', 'currency_code' => 'MAD', 'currency_name' => 'Dirham', 'currency_symbol' => ''),
            array('name' => 'Mozambique', 'iso_alpha2' => 'MZ', 'iso_alpha3' => 'MOZ', 'iso_numeric' => '508', 'calling_code' => '258', 'currency_code' => 'MZN', 'currency_name' => 'Meticail', 'currency_symbol' => 'MT'),
            array('name' => 'Myanmar', 'iso_alpha2' => 'MM', 'iso_alpha3' => 'MMR', 'iso_numeric' => '104', 'calling_code' => '95', 'currency_code' => 'MMK', 'currency_name' => 'Kyat', 'currency_symbol' => 'K'),
            array('name' => 'Namibia', 'iso_alpha2' => 'NA', 'iso_alpha3' => 'NAM', 'iso_numeric' => '516', 'calling_code' => '264', 'currency_code' => 'NAD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Nauru', 'iso_alpha2' => 'NR', 'iso_alpha3' => 'NRU', 'iso_numeric' => '520', 'calling_code' => '674', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Nepal', 'iso_alpha2' => 'NP', 'iso_alpha3' => 'NPL', 'iso_numeric' => '524', 'calling_code' => '977', 'currency_code' => 'NPR', 'currency_name' => 'Rupee', 'currency_symbol' => '₨'),
            array('name' => 'Netherlands', 'iso_alpha2' => 'NL', 'iso_alpha3' => 'NLD', 'iso_numeric' => '528', 'calling_code' => '31', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Netherlands Antilles', 'iso_alpha2' => 'AN', 'iso_alpha3' => 'ANT', 'iso_numeric' => '530', 'calling_code' => '599', 'currency_code' => 'ANG', 'currency_name' => 'Guilder', 'currency_symbol' => 'ƒ'),
            array('name' => 'New Caledonia', 'iso_alpha2' => 'NC', 'iso_alpha3' => 'NCL', 'iso_numeric' => '540', 'calling_code' => '687', 'currency_code' => 'XPF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'New Zealand', 'iso_alpha2' => 'NZ', 'iso_alpha3' => 'NZL', 'iso_numeric' => '554', 'calling_code' => '64', 'currency_code' => 'NZD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Nicaragua', 'iso_alpha2' => 'NI', 'iso_alpha3' => 'NIC', 'iso_numeric' => '558', 'calling_code' => '505', 'currency_code' => 'NIO', 'currency_name' => 'Cordoba', 'currency_symbol' => 'C$'),
            array('name' => 'Niger', 'iso_alpha2' => 'NE', 'iso_alpha3' => 'NER', 'iso_numeric' => '562', 'calling_code' => '227', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Nigeria', 'iso_alpha2' => 'NG', 'iso_alpha3' => 'NGA', 'iso_numeric' => '566', 'calling_code' => '234', 'currency_code' => 'NGN', 'currency_name' => 'Naira', 'currency_symbol' => '₦'),
            array('name' => 'Niue', 'iso_alpha2' => 'NU', 'iso_alpha3' => 'NIU', 'iso_numeric' => '570', 'calling_code' => '683', 'currency_code' => 'NZD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Norfolk Island', 'iso_alpha2' => 'NF', 'iso_alpha3' => 'NFK', 'iso_numeric' => '574', 'calling_code' => '', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'North Korea', 'iso_alpha2' => 'KP', 'iso_alpha3' => 'PRK', 'iso_numeric' => '408', 'calling_code' => '850', 'currency_code' => 'KPW', 'currency_name' => 'Won', 'currency_symbol' => '₩'),
            array('name' => 'Northern Mariana Islands', 'iso_alpha2' => 'MP', 'iso_alpha3' => 'MNP', 'iso_numeric' => '580', 'calling_code' => '1670', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Norway', 'iso_alpha2' => 'NO', 'iso_alpha3' => 'NOR', 'iso_numeric' => '578', 'calling_code' => '47', 'currency_code' => 'NOK', 'currency_name' => 'Krone', 'currency_symbol' => 'kr'),
            array('name' => 'Oman', 'iso_alpha2' => 'OM', 'iso_alpha3' => 'OMN', 'iso_numeric' => '512', 'calling_code' => '968', 'currency_code' => 'OMR', 'currency_name' => 'Rial', 'currency_symbol' => '﷼'),
            array('name' => 'Pakistan', 'iso_alpha2' => 'PK', 'iso_alpha3' => 'PAK', 'iso_numeric' => '586', 'calling_code' => '92', 'currency_code' => 'PKR', 'currency_name' => 'Rupee', 'currency_symbol' => '₨'),
            array('name' => 'Palau', 'iso_alpha2' => 'PW', 'iso_alpha3' => 'PLW', 'iso_numeric' => '585', 'calling_code' => '680', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Palestinian Territory', 'iso_alpha2' => 'PS', 'iso_alpha3' => 'PSE', 'iso_numeric' => '275', 'calling_code' => '', 'currency_code' => 'ILS', 'currency_name' => 'Shekel', 'currency_symbol' => '₪'),
            array('name' => 'Panama', 'iso_alpha2' => 'PA', 'iso_alpha3' => 'PAN', 'iso_numeric' => '591', 'calling_code' => '507', 'currency_code' => 'PAB', 'currency_name' => 'Balboa', 'currency_symbol' => 'B/.'),
            array('name' => 'Papua New Guinea', 'iso_alpha2' => 'PG', 'iso_alpha3' => 'PNG', 'iso_numeric' => '598', 'calling_code' => '675', 'currency_code' => 'PGK', 'currency_name' => 'Kina', 'currency_symbol' => ''),
            array('name' => 'Paraguay', 'iso_alpha2' => 'PY', 'iso_alpha3' => 'PRY', 'iso_numeric' => '600', 'calling_code' => '595', 'currency_code' => 'PYG', 'currency_name' => 'Guarani', 'currency_symbol' => 'Gs'),
            array('name' => 'Peru', 'iso_alpha2' => 'PE', 'iso_alpha3' => 'PER', 'iso_numeric' => '604', 'calling_code' => '51', 'currency_code' => 'PEN', 'currency_name' => 'Sol', 'currency_symbol' => 'S/.'),
            array('name' => 'Philippines', 'iso_alpha2' => 'PH', 'iso_alpha3' => 'PHL', 'iso_numeric' => '608', 'calling_code' => '63', 'currency_code' => 'PHP', 'currency_name' => 'Peso', 'currency_symbol' => 'Php'),
            array('name' => 'Pitcairn', 'iso_alpha2' => 'PN', 'iso_alpha3' => 'PCN', 'iso_numeric' => '612', 'calling_code' => '870', 'currency_code' => 'NZD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Poland', 'iso_alpha2' => 'PL', 'iso_alpha3' => 'POL', 'iso_numeric' => '616', 'calling_code' => '48', 'currency_code' => 'PLN', 'currency_name' => 'Zloty', 'currency_symbol' => 'zł'),
            array('name' => 'Portugal', 'iso_alpha2' => 'PT', 'iso_alpha3' => 'PRT', 'iso_numeric' => '620', 'calling_code' => '351', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Puerto Rico', 'iso_alpha2' => 'PR', 'iso_alpha3' => 'PRI', 'iso_numeric' => '630', 'calling_code' => '1', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Qatar', 'iso_alpha2' => 'QA', 'iso_alpha3' => 'QAT', 'iso_numeric' => '634', 'calling_code' => '974', 'currency_code' => 'QAR', 'currency_name' => 'Rial', 'currency_symbol' => '﷼'),
            array('name' => 'Republic of the Congo', 'iso_alpha2' => 'CG', 'iso_alpha3' => 'COG', 'iso_numeric' => '178', 'calling_code' => '242', 'currency_code' => 'XAF', 'currency_name' => 'Franc', 'currency_symbol' => 'FCF'),
            array('name' => 'Reunion', 'iso_alpha2' => 'RE', 'iso_alpha3' => 'REU', 'iso_numeric' => '638', 'calling_code' => '', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Romania', 'iso_alpha2' => 'RO', 'iso_alpha3' => 'ROU', 'iso_numeric' => '642', 'calling_code' => '40', 'currency_code' => 'RON', 'currency_name' => 'Leu', 'currency_symbol' => 'lei'),
            array('name' => 'Russia', 'iso_alpha2' => 'RU', 'iso_alpha3' => 'RUS', 'iso_numeric' => '643', 'calling_code' => '7', 'currency_code' => 'RUB', 'currency_name' => 'Ruble', 'currency_symbol' => 'руб'),
            array('name' => 'Rwanda', 'iso_alpha2' => 'RW', 'iso_alpha3' => 'RWA', 'iso_numeric' => '646', 'calling_code' => '250', 'currency_code' => 'RWF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Saint Helena', 'iso_alpha2' => 'SH', 'iso_alpha3' => 'SHN', 'iso_numeric' => '654', 'calling_code' => '290', 'currency_code' => 'SHP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'Saint Kitts and Nevis', 'iso_alpha2' => 'KN', 'iso_alpha3' => 'KNA', 'iso_numeric' => '659', 'calling_code' => '1869', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Saint Lucia', 'iso_alpha2' => 'LC', 'iso_alpha3' => 'LCA', 'iso_numeric' => '662', 'calling_code' => '1758', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Saint Pierre and Miquelon', 'iso_alpha2' => 'PM', 'iso_alpha3' => 'SPM', 'iso_numeric' => '666', 'calling_code' => '508', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Saint Vincent and the Grenadines', 'iso_alpha2' => 'VC', 'iso_alpha3' => 'VCT', 'iso_numeric' => '670', 'calling_code' => '1784', 'currency_code' => 'XCD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Samoa', 'iso_alpha2' => 'WS', 'iso_alpha3' => 'WSM', 'iso_numeric' => '882', 'calling_code' => '685', 'currency_code' => 'WST', 'currency_name' => 'Tala', 'currency_symbol' => 'WS$'),
            array('name' => 'San Marino', 'iso_alpha2' => 'SM', 'iso_alpha3' => 'SMR', 'iso_numeric' => '674', 'calling_code' => '378', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Sao Tome and Principe', 'iso_alpha2' => 'ST', 'iso_alpha3' => 'STP', 'iso_numeric' => '678', 'calling_code' => '239', 'currency_code' => 'STD', 'currency_name' => 'Dobra', 'currency_symbol' => 'Db'),
            array('name' => 'Saudi Arabia', 'iso_alpha2' => 'SA', 'iso_alpha3' => 'SAU', 'iso_numeric' => '682', 'calling_code' => '966', 'currency_code' => 'SAR', 'currency_name' => 'Rial', 'currency_symbol' => '﷼'),
            array('name' => 'Senegal', 'iso_alpha2' => 'SN', 'iso_alpha3' => 'SEN', 'iso_numeric' => '686', 'calling_code' => '221', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Serbia and Montenegro', 'iso_alpha2' => 'CS', 'iso_alpha3' => 'SCG', 'iso_numeric' => '891', 'calling_code' => '', 'currency_code' => 'RSD', 'currency_name' => 'Dinar', 'currency_symbol' => 'Дин'),
            array('name' => 'Seychelles', 'iso_alpha2' => 'SC', 'iso_alpha3' => 'SYC', 'iso_numeric' => '690', 'calling_code' => '248', 'currency_code' => 'SCR', 'currency_name' => 'Rupee', 'currency_symbol' => '₨'),
            array('name' => 'Sierra Leone', 'iso_alpha2' => 'SL', 'iso_alpha3' => 'SLE', 'iso_numeric' => '694', 'calling_code' => '232', 'currency_code' => 'SLL', 'currency_name' => 'Leone', 'currency_symbol' => 'Le'),
            array('name' => 'Singapore', 'iso_alpha2' => 'SG', 'iso_alpha3' => 'SGP', 'iso_numeric' => '702', 'calling_code' => '65', 'currency_code' => 'SGD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Slovakia', 'iso_alpha2' => 'SK', 'iso_alpha3' => 'SVK', 'iso_numeric' => '703', 'calling_code' => '421', 'currency_code' => 'SKK', 'currency_name' => 'Koruna', 'currency_symbol' => 'Sk'),
            array('name' => 'Slovenia', 'iso_alpha2' => 'SI', 'iso_alpha3' => 'SVN', 'iso_numeric' => '705', 'calling_code' => '386', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Solomon Islands', 'iso_alpha2' => 'SB', 'iso_alpha3' => 'SLB', 'iso_numeric' => '90', 'calling_code' => '677', 'currency_code' => 'SBD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Somalia', 'iso_alpha2' => 'SO', 'iso_alpha3' => 'SOM', 'iso_numeric' => '706', 'calling_code' => '252', 'currency_code' => 'SOS', 'currency_name' => 'Shilling', 'currency_symbol' => 'S'),
            array('name' => 'South Africa', 'iso_alpha2' => 'ZA', 'iso_alpha3' => 'ZAF', 'iso_numeric' => '710', 'calling_code' => '27', 'currency_code' => 'ZAR', 'currency_name' => 'Rand', 'currency_symbol' => 'R'),
            array('name' => 'South Georgia and the South Sandwich Islands', 'iso_alpha2' => 'GS', 'iso_alpha3' => 'SGS', 'iso_numeric' => '239', 'calling_code' => '', 'currency_code' => 'GBP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'South Korea', 'iso_alpha2' => 'KR', 'iso_alpha3' => 'KOR', 'iso_numeric' => '410', 'calling_code' => '82', 'currency_code' => 'KRW', 'currency_name' => 'Won', 'currency_symbol' => '₩'),
            array('name' => 'Spain', 'iso_alpha2' => 'ES', 'iso_alpha3' => 'ESP', 'iso_numeric' => '724', 'calling_code' => '34', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Sri Lanka', 'iso_alpha2' => 'LK', 'iso_alpha3' => 'LKA', 'iso_numeric' => '144', 'calling_code' => '94', 'currency_code' => 'LKR', 'currency_name' => 'Rupee', 'currency_symbol' => '₨'),
            array('name' => 'Sudan', 'iso_alpha2' => 'SD', 'iso_alpha3' => 'SDN', 'iso_numeric' => '736', 'calling_code' => '249', 'currency_code' => 'SDD', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'Suriname', 'iso_alpha2' => 'SR', 'iso_alpha3' => 'SUR', 'iso_numeric' => '740', 'calling_code' => '597', 'currency_code' => 'SRD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Svalbard and Jan Mayen', 'iso_alpha2' => 'SJ', 'iso_alpha3' => 'SJM', 'iso_numeric' => '744', 'calling_code' => '', 'currency_code' => 'NOK', 'currency_name' => 'Krone', 'currency_symbol' => 'kr'),
            array('name' => 'Swaziland', 'iso_alpha2' => 'SZ', 'iso_alpha3' => 'SWZ', 'iso_numeric' => '748', 'calling_code' => '268', 'currency_code' => 'SZL', 'currency_name' => 'Lilangeni', 'currency_symbol' => ''),
            array('name' => 'Sweden', 'iso_alpha2' => 'SE', 'iso_alpha3' => 'SWE', 'iso_numeric' => '752', 'calling_code' => '46', 'currency_code' => 'SEK', 'currency_name' => 'Krona', 'currency_symbol' => 'kr'),
            array('name' => 'Switzerland', 'iso_alpha2' => 'CH', 'iso_alpha3' => 'CHE', 'iso_numeric' => '756', 'calling_code' => '41', 'currency_code' => 'CHF', 'currency_name' => 'Franc', 'currency_symbol' => 'CHF'),
            array('name' => 'Syria', 'iso_alpha2' => 'SY', 'iso_alpha3' => 'SYR', 'iso_numeric' => '760', 'calling_code' => '963', 'currency_code' => 'SYP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'Taiwan', 'iso_alpha2' => 'TW', 'iso_alpha3' => 'TWN', 'iso_numeric' => '158', 'calling_code' => '886', 'currency_code' => 'TWD', 'currency_name' => 'Dollar', 'currency_symbol' => 'NT$'),
            array('name' => 'Tajikistan', 'iso_alpha2' => 'TJ', 'iso_alpha3' => 'TJK', 'iso_numeric' => '762', 'calling_code' => '992', 'currency_code' => 'TJS', 'currency_name' => 'Somoni', 'currency_symbol' => ''),
            array('name' => 'Tanzania', 'iso_alpha2' => 'TZ', 'iso_alpha3' => 'TZA', 'iso_numeric' => '834', 'calling_code' => '255', 'currency_code' => 'TZS', 'currency_name' => 'Shilling', 'currency_symbol' => ''),
            array('name' => 'Thailand', 'iso_alpha2' => 'TH', 'iso_alpha3' => 'THA', 'iso_numeric' => '764', 'calling_code' => '66', 'currency_code' => 'THB', 'currency_name' => 'Baht', 'currency_symbol' => '฿'),
            array('name' => 'Togo', 'iso_alpha2' => 'TG', 'iso_alpha3' => 'TGO', 'iso_numeric' => '768', 'calling_code' => '228', 'currency_code' => 'XOF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Tokelau', 'iso_alpha2' => 'TK', 'iso_alpha3' => 'TKL', 'iso_numeric' => '772', 'calling_code' => '690', 'currency_code' => 'NZD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Tonga', 'iso_alpha2' => 'TO', 'iso_alpha3' => 'TON', 'iso_numeric' => '776', 'calling_code' => '676', 'currency_code' => 'TOP', 'currency_name' => 'Paanga', 'currency_symbol' => 'T$'),
            array('name' => 'Trinidad and Tobago', 'iso_alpha2' => 'TT', 'iso_alpha3' => 'TTO', 'iso_numeric' => '780', 'calling_code' => '1868', 'currency_code' => 'TTD', 'currency_name' => 'Dollar', 'currency_symbol' => 'TT$'),
            array('name' => 'Tunisia', 'iso_alpha2' => 'TN', 'iso_alpha3' => 'TUN', 'iso_numeric' => '788', 'calling_code' => '216', 'currency_code' => 'TND', 'currency_name' => 'Dinar', 'currency_symbol' => ''),
            array('name' => 'Turkey', 'iso_alpha2' => 'TR', 'iso_alpha3' => 'TUR', 'iso_numeric' => '792', 'calling_code' => '90', 'currency_code' => 'TRY', 'currency_name' => 'Lira', 'currency_symbol' => 'YTL'),
            array('name' => 'Turkmenistan', 'iso_alpha2' => 'TM', 'iso_alpha3' => 'TKM', 'iso_numeric' => '795', 'calling_code' => '993', 'currency_code' => 'TMM', 'currency_name' => 'Manat', 'currency_symbol' => 'm'),
            array('name' => 'Turks and Caicos Islands', 'iso_alpha2' => 'TC', 'iso_alpha3' => 'TCA', 'iso_numeric' => '796', 'calling_code' => '1649', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Tuvalu', 'iso_alpha2' => 'TV', 'iso_alpha3' => 'TUV', 'iso_numeric' => '798', 'calling_code' => '688', 'currency_code' => 'AUD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'U.S. Virgin Islands', 'iso_alpha2' => 'VI', 'iso_alpha3' => 'VIR', 'iso_numeric' => '850', 'calling_code' => '1340', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Uganda', 'iso_alpha2' => 'UG', 'iso_alpha3' => 'UGA', 'iso_numeric' => '800', 'calling_code' => '256', 'currency_code' => 'UGX', 'currency_name' => 'Shilling', 'currency_symbol' => ''),
            array('name' => 'Ukraine', 'iso_alpha2' => 'UA', 'iso_alpha3' => 'UKR', 'iso_numeric' => '804', 'calling_code' => '380', 'currency_code' => 'UAH', 'currency_name' => 'Hryvnia', 'currency_symbol' => '₴'),
            array('name' => 'United Arab Emirates', 'iso_alpha2' => 'AE', 'iso_alpha3' => 'ARE', 'iso_numeric' => '784', 'calling_code' => '971', 'currency_code' => 'AED', 'currency_name' => 'Dirham', 'currency_symbol' => ''),
            array('name' => 'United Kingdom', 'iso_alpha2' => 'GB', 'iso_alpha3' => 'GBR', 'iso_numeric' => '826', 'calling_code' => '44', 'currency_code' => 'GBP', 'currency_name' => 'Pound', 'currency_symbol' => '£'),
            array('name' => 'United States', 'iso_alpha2' => 'US', 'iso_alpha3' => 'USA', 'iso_numeric' => '840', 'calling_code' => '1', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'United States Minor Outlying Islands', 'iso_alpha2' => 'UM', 'iso_alpha3' => 'UMI', 'iso_numeric' => '581', 'calling_code' => '', 'currency_code' => 'USD', 'currency_name' => 'Dollar', 'currency_symbol' => '$'),
            array('name' => 'Uruguay', 'iso_alpha2' => 'UY', 'iso_alpha3' => 'URY', 'iso_numeric' => '858', 'calling_code' => '598', 'currency_code' => 'UYU', 'currency_name' => 'Peso', 'currency_symbol' => '$U'),
            array('name' => 'Uzbekistan', 'iso_alpha2' => 'UZ', 'iso_alpha3' => 'UZB', 'iso_numeric' => '860', 'calling_code' => '998', 'currency_code' => 'UZS', 'currency_name' => 'Som', 'currency_symbol' => 'лв'),
            array('name' => 'Vanuatu', 'iso_alpha2' => 'VU', 'iso_alpha3' => 'VUT', 'iso_numeric' => '548', 'calling_code' => '678', 'currency_code' => 'VUV', 'currency_name' => 'Vatu', 'currency_symbol' => 'Vt'),
            array('name' => 'Vatican', 'iso_alpha2' => 'VA', 'iso_alpha3' => 'VAT', 'iso_numeric' => '336', 'calling_code' => '39', 'currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€'),
            array('name' => 'Venezuela', 'iso_alpha2' => 'VE', 'iso_alpha3' => 'VEN', 'iso_numeric' => '862', 'calling_code' => '58', 'currency_code' => 'VEF', 'currency_name' => 'Bolivar', 'currency_symbol' => 'Bs'),
            array('name' => 'Vietnam', 'iso_alpha2' => 'VN', 'iso_alpha3' => 'VNM', 'iso_numeric' => '704', 'calling_code' => '84', 'currency_code' => 'VND', 'currency_name' => 'Dong', 'currency_symbol' => '₫'),
            array('name' => 'Wallis and Futuna', 'iso_alpha2' => 'WF', 'iso_alpha3' => 'WLF', 'iso_numeric' => '876', 'calling_code' => '681', 'currency_code' => 'XPF', 'currency_name' => 'Franc', 'currency_symbol' => ''),
            array('name' => 'Western Sahara', 'iso_alpha2' => 'EH', 'iso_alpha3' => 'ESH', 'iso_numeric' => '732', 'calling_code' => '', 'currency_code' => 'MAD', 'currency_name' => 'Dirham', 'currency_symbol' => ''),
            array('name' => 'Yemen', 'iso_alpha2' => 'YE', 'iso_alpha3' => 'YEM', 'iso_numeric' => '887', 'calling_code' => '967', 'currency_code' => 'YER', 'currency_name' => 'Rial', 'currency_symbol' => '﷼'),
            array('name' => 'Zambia', 'iso_alpha2' => 'ZM', 'iso_alpha3' => 'ZMB', 'iso_numeric' => '894', 'calling_code' => '260', 'currency_code' => 'ZMK', 'currency_name' => 'Kwacha', 'currency_symbol' => 'ZK'),
            array('name' => 'Zimbabwe', 'iso_alpha2' => 'ZW', 'iso_alpha3' => 'ZWE', 'iso_numeric' => '716', 'calling_code' => '263', 'currency_code' => 'ZWD', 'currency_name' => 'Dollar', 'currency_symbol' => 'Z$')
        );

        $output = array();
        foreach ($countries as $key => $value) {
            if ($return == 'country') $output[$value['iso_alpha2']] = $value['name'];
            else if ($return == 'currency_name') $output[$value['currency_code']] = $value['currency_code'] . " (" . $value['currency_name'] . ")";
            else if ($return == 'currency_icon') $output[$value['currency_code']] = !empty($value['currency_symbol']) ? $value['currency_symbol'] : $value['currency_code'];
            else $output[$value['iso_alpha2']] = $value['calling_code'];
        }
        if (isset($output[''])) unset($output['']);

        asort($output);
        return $output;
    }
}
