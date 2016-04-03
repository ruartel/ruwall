<?php

require_once '../meekrodb.2.3.class.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

DB::update('Emails', array(
    'email_content' => $obj->p->subsMail,
    'email_subject' => $obj->p->subsMail_subject
), "id=%i", 1);

DB::update('Emails', array(
    'email_content' => $obj->p->authMail,
    'email_subject' => $obj->p->authMail_subject
), "id=%i", 2);

DB::update('Emails', array(
    'email_content' => $obj->p->yahMail,
    'email_subject' => $obj->p->yahMail_subject
), "id=%i", 3);