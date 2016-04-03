<?php
require_once 'meekrodb.2.3.class.php';
require_once 'Controller/User.php';
require_once 'Controller/Lead.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'Controller/YizkorMail.php';

# Sandbox
$host = 'https://api.paypal.com';
$clientId = 'AWVtj7ddkw2LwCjHWG_NzbxPMSfN0kc7CUlQYoij6wk4kkpZNObMtcSDV9oPJZtqoin8QlvWAAOBEbGg';
$clientSecret = 'EBCAJVolVPxe9Mo-OX-ecFjzNousBadEc8CnxkVeGPwyg7Ot_uKerquO0xwI-0k4qaOjiMd3Z0Qf9Grx';

// Set sandbox (test mode) to true/false.
$sandbox = FALSE;
 
// Set PayPal API version and credentials.
$api_version = '85.0';
$api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
$api_username = $sandbox ? 'SANDBOX_USERNAME_GOES_HERE' : 'mzalmanov_api1.gmail.com';
$api_password = $sandbox ? 'SANDBOX_PASSWORD_GOES_HERE' : 'Z8PD5TN6SCD35S2K';
$api_signature = $sandbox ? 'SANDBOX_SIGNATURE_GOES_HERE' : 'AFcWxV21C7fd0v3bYYYRCpSSRl31AX-nYgFFJDuSKJToJF7vGQZang.j';

$json = file_get_contents('php://input');
$obj = json_decode($json);

$token = '';
// function to read stdin
function read_stdin() {
        $fr=fopen("php://stdin","r");   // open our file pointer to read from stdin
        $input = fgets($fr,128);        // read a maximum of 128 characters
        $input = rtrim($input);         // trim any trailing spaces.
        fclose ($fr);                   // close the file handle
        return $input;                  // return the text entered
}
function get_access_token($url, $postdata) {
	global $clientId, $clientSecret;
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
	curl_setopt($curl, CURLOPT_HEADER, false); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
#	curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
//		echo "Time took: " . $info['total_time']*1000 . "ms\n";
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}
	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode( $response );
	return $jsonResponse->access_token;
}
function make_post_call($url, $postdata) {
	global $token;
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer '.$token,
				'Accept: application/json',
				'Content-Type: application/json'
				));
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
	#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
//		echo "Time took: " . $info['total_time']*1000 . "ms\n";
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}
	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode($response, TRUE);
	return $jsonResponse;
}
function make_get_call($url) {
	global $token;
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer '.$token,
				'Accept: application/json',
				'Content-Type: application/json'
				));
	
	#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
//		echo "Time took: " . $info['total_time']*1000 . "ms\n";
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}
	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode($response, TRUE);
	return $jsonResponse;
}

function cardType($number)
{
    $number=preg_replace('/[^\d]/','',$number);
    if (preg_match('/^3[47][0-9]{13}$/',$number))
    {
        return 'amex';
    }
    elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
    {
        return 'Diners Club';
    }
    elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
    {
        return 'discover';
    }
    elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
    {
        return 'JCB';
    }
    elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
    {
        return 'mastercard';
    }
    elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
    {
        return 'visa';
    }
    else
    {
        return 'Unknown';
    }
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function saveLead($obj){
    global $dbDonationSug, $dbDonationType;
    
    $c_ip = get_client_ip();

    $cdate = date("Y-m-d H:i:s");
    $lead = $obj->p->lead;
    //$lead->donation_type = $obj->p->donationsType;
//    $lead->donation_type = $dbDonationType[$obj->p->donationsTo];
    $lead->suggested_donation = $lead->amount;
    //$lead->donationTo = $obj->p->donationsTo;
    $lead->ip = $c_ip;
    $lead->cdate = $cdate;
    $lead->c_date = $cdate;

    //var_dump($duserArr);
    #### sanitize values!!!!
    $lead_fname=filter_var($lead->fname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lead_lname=filter_var($lead->lname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lead_email=filter_var($lead->email, FILTER_SANITIZE_EMAIL);
	
    $cc = $obj->p->cck;	
    #### save to db ####
    $row_lead = (array)$lead;
    $row_lead['address1'] = $cc->address1;
    $row_lead['address2'] = $cc->address2;
    $row_lead['city'] = $cc->city;
    $row_lead['state'] = $cc->state;
    $row_lead['country'] = $cc->country;
    $row_lead['zip'] = $cc->zip;
    
    $result1 = DB::insert('donor',$row_lead);
    $donor_id = DB::insertId();
    
    return $donor_id;
}

if($lead->amount > 0){#### go to paypal payment
    if($obj->p->donationsType == 1){
        ## pay with paypal - redirect to paypal page
        $donor_id = saveLead($obj);
        echo 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&item_name=Donation for FJC&amount='.$lead->amount.'&currency_code=USD&business=ruartel-facilitator@gmail.com&return=https://fjc.ru/ruwall/ppReturn.php?ids=' . $donor_id . '&cancel_return=https://fjc.ru/ruwall/ppCancel.php?ids=' . $donor_id;
    }else if($obj->p->donationsType == 2){
        ## pay with cc - start payment
        $cc = $obj->p->cck;
//        var_dump($cc);
        $cc_number=filter_var($cc->number, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cc_month=filter_var($cc->month, FILTER_SANITIZE_NUMBER_INT);
        $cc_year=filter_var($cc->year, FILTER_SANITIZE_NUMBER_INT);
        $cc_code=filter_var($cc->code, FILTER_SANITIZE_NUMBER_INT);
        $cc_name=filter_var($cc->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cc_type=cardType($cc_number);
//        var_dump($cc_type);
        $uNameArr = explode(' ', $cc_name);
        $firstName = $uNameArr[0];
        $lastName = '';
        $len = count($uNameArr);
        for ($i=1; $i < $len; $i++){
            if($lastName == ''){
                $lastName = $uNameArr[$i];
            }else{
                $lastName = ' ' . $uNameArr[$i];
            }
        }
        
        // Store request params in an array
        $request_params = array
                    (
                    'METHOD' => 'DoDirectPayment', 
                    'USER' => $api_username, 
                    'PWD' => $api_password, 
                    'SIGNATURE' => $api_signature, 
                    'VERSION' => $api_version, 
                    'PAYMENTACTION' => 'Sale',                   
                    'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CREDITCARDTYPE' => $cc_type, 
                    'ACCT' => $cc_number,                        
                    'EXPDATE' => $cc_month . $cc_year,           
                    'CVV2' => $cc_code, 
                    'FIRSTNAME' => $cc_name, 
                    'LASTNAME' => $lastName, 
                    'STREET' => $cc->address1 . ' ' . $cc->address2, 
                    'CITY' => $cc->city, 
                    'STATE' => $cc->state,                     
                    'COUNTRYCODE' => $cc->country, 
                    'ZIP' => $cc->zip, 
                    'AMT' => $valueToPay, 
                    'CURRENCYCODE' => 'USD', 
                    'DESC' => 'Testing Payments Pro'
                    );
//        var_dump($request_params);
        // Loop through $request_params array to generate the NVP string.
        $nvp_string = '';
        foreach($request_params as $var=>$val)
        {
            $nvp_string .= '&'.$var.'='.urlencode($val);    
        }     
//        var_dump($nvp_string);
        // Send NVP string to PayPal and store response
        $curl = curl_init();
                curl_setopt($curl, CURLOPT_VERBOSE, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_URL, $api_endpoint);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

        $ppresult = curl_exec($curl);     
        curl_close($curl);
//        var_dump($ppresult);
        // Parse the API response
        $nvp_response_array = explode('&', $ppresult);

//        $url = $host.'/v1/oauth2/token'; 
//        $postArgs = 'grant_type=client_credentials';
//        $token = get_access_token($url,$postArgs);
//
//        $url = $host.'/v1/payments/payment';
//        $payment = array(
//                        'intent' => 'sale',
//                        'payer' => array(
//                                'payment_method' => 'credit_card',
//                                'funding_instruments' => array ( array(
//                                                'credit_card' => array (
//                                                        'number' => $cc_number,
//                                                        'type'   => $cc_type,
//                                                        'expire_month' => $cc_month,
//                                                        'expire_year' => $cc_year,
//                                                        'cvv2' => $cc_code,
//                                                        'first_name' => $cc_name,
//                                                        'last_name' => $lastName
//                                                        )
//                                                ))
//                                ),
//                        'transactions' => array (array(
//                                        'amount' => array(
//                                                'total' => $lead->amount,
//                                                'currency' => 'USD'
//                                                ),
//                                        'description' => 'payment by a credit card using a test script'
//                                        ))
//                        );
//        $json = json_encode($payment);
//        $json_resp = make_post_call($url, $json);
//        foreach ($json_resp['links'] as $link) {
//                if($link['rel'] == 'self'){
//                        $payment_detail_url = $link['href'];
//    //                    $payment_detail_method = $link['method'];
//                }
//        }
//        $related_resource_count = 0;
//        $related_resources = "";
//        foreach ($json_resp['transactions'] as $transaction) {
//                if($transaction['related_resources']) {
//                        $related_resource_count = count($transaction['related_resources']);
//                        foreach ($transaction['related_resources'] as $related_resource) {
//                                if($related_resource['sale']){
//                                        $related_resources = $related_resources."sale ";
//                                        $sale = $related_resource['sale'];
//                                        $transactionID = $sale['id'];
//                                        $amountTotal = $sale['amount']['total'];
//                                        foreach ($sale['links'] as $link) {
//                                                if($link['rel'] == 'self'){
//                                                        $sale_detail_url = $link['href'];
//    //                                                    $sale_detail_method = $link['method'];
//                                                }else if($link['rel'] == 'refund'){
//                                                        $refund_url = $link['href'];
//    //                                                    $refund_method = $link['method'];
//                                                }
//                                        }
//                                } else if($related_resource['refund']){
//                                        $related_resources = $related_resources."refund";
//                                }	
//                        }
//                }
//        }
//        var_dump($payment_detail_url);
//        var_dump($transactionID);
//        var_dump($amountTotal);
//        var_dump($refund_url);
        if($nvp_response_array[2] == 'ACK=Failure'){
            echo FALSE;
        }else{
            $donor_id = saveLead($obj);
            $user_id = saveUser($obj, $donor_id);
            
            $transArr = explode('=', $nvp_response_array[9]);
            $transactionID = $transArr[1];
            
            $ammsArr = explode('=', $nvp_response_array[2]);
            $amountTotal = urldecode($ammsArr[1]);//AMT=1%2e00
            
            #### update transsaction id and echo true
            DB::update('donor', array(
                'transaction_id' => $transactionID,
                'payment_amount' => $amountTotal,
                'payment_status' => 'Completed',
                'payment_method' => 'Credit Card',
                'payment_detail_url' => '',
                'refund_url' => ''
            ), "id=%i", $donor_id);
            
            echo $user_id;
            $yMail = new YizkorMail($donor_id);
            $yMail->mailMeLoved(TRUE);
            
            require_once 'mailchimp/src/Mailchimp.php';

            $clead = $obj->p->lead;

            $api_key = '3cf78da98880b865ab6f13c1453b93b7-us5';
            $list_id = 'c4e6938325';
            $email  = $clead->email;

            $Mailchimp = new Mailchimp( $api_key );
            $Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
            $subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($email) ) );

            if ( ! empty( $subscriber['leid'] ) ) {
            //   echo "success";
            }
        }
    }
}