<?php

class YizkorMail{
    var $replace_values = array(
        '$[dfname]$',
        '$[dfullname]$',
        '$[lfname]$',
        '$[lfullname]$',
        '$[ldate]$',
        '$[lhdate]$',
        '$[lurl]$'
    );
    var $donor_id;
    var $type;
    var $user_id;
//    var $host='gator4078.hostgator.com';
    var $host='mail.yizkorwall.org';
//    var $from='ruartel@gmail.com';
    var $from='info@yizkorwall.org';
    var $pass='ru110202';
//    var $port = 465;
    var $port = 25;

    function __construct($donor_id=null,$type=null,$user_id = null) {
        $this->donor_id=$donor_id;
        $this->type=$type;
        $this->user_id=$user_id;
    }
    
    public function authMailToUsers($ids) {
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->from;                 // SMTP username
        $mail->Password = $this->pass;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $this->port;                                    // TCP port to connect to

        $mail->From = $this->from;
        $mail->FromName = 'Yizkor Wall';
        $mail->isHTML(true);
        #### get subject and body #####
//        $mResult = DB::query('select * from Emails where id=2');
        $this->type = 2;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $userResults = DB::query('select id,donor_id from dpeople where id in (' . $ids . ')');
        foreach ($userResults as $v=>$user){
            $dResults = DB::query('select email from donor where id=' . $user['donor_id']);
//            $mail->addAddress('ruartel@gmail.com');
            $mail->addAddress($dResults[0]['email']);
            
            $this->donor_id = $user['donor_id'];
            $this->user_id  = $user['id'];
            
            $mTxt = $this->getMailDetails();
            $mail->Subject = $mTxt[0];
            $mail->Body    = $mTxt[1];
            
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
    }
    
    public function mailMe($obj){
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->from;                 // SMTP username
        $mail->Password = $this->pass;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $this->port;                                    // TCP port to connect to

        $mail->From = $this->from;
        $mail->FromName = 'Yizkor Wall';
        $mail->addAddress('danielgordon770@gmail.com');
        $mail->addAddress('ruartel@gmail.com');
        $mail->isHTML(true);
//        var_dump($obj);
        $body = '<div>Name: ' . $obj->p->lead->fname . ' ' . $obj->p->lead->lname . '</div>';
        $body .= '<div>Email: ' . $obj->p->lead->email . '</div>';
        $body .= '<div>Message: ' . $obj->p->lead->message . '</div>';
        $mail->Subject = 'Contact from Yizkor Wall';
        $mail->Body    = $body;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if(!$mail->send()) {
            return TRUE;
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return FALSE;
//            echo 'Message has been sent';
        }
        $mail->clearAddresses();
        $mail->clearAttachments();
    }
    
    public function mailMeLoved($isDonation = false){
        $donorResp = DB::query('select * from donor where id=%i', $this->donor_id);
        
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->from;                 // SMTP username
        $mail->Password = $this->pass;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $this->port;                                    // TCP port to connect to

        $mail->From = $this->from;
        $mail->FromName = 'Yizkor Wall';
        $mail->addAddress('danielgordon770@gmail.com');
        
        if($donorResp[0]['payment_status'] == 'Completed' || $donorResp[0]['payment_status'] == 'approved'){
            $mail->addAddress('fjc.office.us@gmail.com');
            $mail->addAddress('oravnerdavid@gmail.com');
            $mail->addAddress('oravnerchaim@gmail.com');
        }
        
        $mail->addAddress('ruartel@gmail.com');
        $mail->isHTML(true);
//        var_dump($obj);
        if($isDonation){
            $body = '<div>New Donation on Yizkor Wall</div>';
            $mail->Subject = 'New Donation on Yizkor Wall';
        }else{
            $body = '<div>New Loved One added</div>';
            $mail->Subject = 'New Loved One added';
        }
        
        $body .= '<div>Name: ' . $donorResp[0]['fname'] .' ' . $donorResp[0]['lname'] . '</div>';
        $body .= '<div>Emai: ' . $donorResp[0]['email'] . '</div>';
        $body .= '<div>Donation: ' . $donorResp[0]['suggested_donation'] . '</div>';
        $body .= '<div>Donate to: ' . $donorResp[0]['donation_type'] . '</div>';
        $body .= '<div></br></div>';
        
        $body .= '<div>Go to the <a href="https://yizkorwall.org/admin/">admin page</a></div>';
        
        $mail->Body    = $body;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if(!$mail->send()) {
            return TRUE;
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return FALSE;
//            echo 'Message has been sent';
        }
        $mail->clearAddresses();
        $mail->clearAttachments();
    }

    public function sendMail() {
        $mTxt = $this->getMailDetails();

        $dResp = DB::query('select email from donor where id=%i', $this->donor_id);
        $email = $dResp[0]['email'];
        
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $this->from;                 // SMTP username
        $mail->Password = $this->pass;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $this->port;                                    // TCP port to connect to

        $mail->From = $this->from;
        $mail->FromName = 'Yizkor Wall';
        $mail->addAddress($email);     // Add a recipient
//        $mail->addBCC('bcc@example.com');
        $mail->isHTML(true); 
        $mail->Subject = $mTxt[0];
        $mail->Body    = $mTxt[1];

//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
//            echo 'Message has been sent';
        }
        $mail->clearAddresses();
        $mail->clearAttachments();
    }
    
    public function getMailDetails(){
        $results = DB::query('select * from Emails where id=%i', $this->type);
//        var_dump($results);
        $eContent = $results[0]['email_content'];
        $eSubject = $results[0]['email_subject'];
        
        $donorResp = DB::query('select fname,lname from donor where id=%i', $this->donor_id);
        $dFullName = $donorResp[0]['fname'] . ' ' . $donorResp[0]['lname'];
        
        if($this->user_id){
            $lResp = DB::query('select first_name,last_name,greg_date,hebrew_date from dpeople where id=%i', $this->user_id);
            $lFullName = $lResp[0]['first_name'] . ' ' . $lResp[0]['last_name'];
            $lURL='<a href="https://yizkorwall.org/d/d.php?id=' . $this->user_id . '">https://yizkorwall.org/d/d.php?id=' . $this->user_id . '</a>';
        
            $newVals = array($donorResp[0]['fname'], $dFullName, $lResp[0]['first_name'], $lFullName, $lResp[0]['greg_date'], $lResp[0]['hebrew_date'], $lURL);
        }else{
            $newVals = array($donorResp[0]['fname'], $dFullName,$lResp[0]['first_name']);
        }
        
        $final_mail = str_replace($this->replace_values, $newVals, $eContent);
        
        $mailresp = array($eSubject,$final_mail);
        return $mailresp;
    }
}

