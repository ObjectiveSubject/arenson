<?php 
 $to = "kirk.pettinga@gmail.com"; 
 $subject = "Inquiry from aof.com"; 
 $email = $_REQUEST['email'] ;
 $phone = $_REQUEST['phone'] ; 
 $message = $_REQUEST['message'] ; 
 $headers = "From: $email"; 
 $sent = mail($to, $subject, $phone, $message, $headers) ; 
 if($sent) 
 {print "Your mail was sent successfully"; }
 else 
 {print "We encountered an error sending your mail"; }
 ?> 