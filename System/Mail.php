<?php
namespace System;

class Mail
{
	private $to;
	private $from;
	private $subject;
	private $header;
	private $message;
	private $boundary;
	
    public function __construct(string $to, string $subject)
    {
	    $this->to = $to;
	    $this->subject = $subject;
	    
	    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $this->to))
		    $break = "\r\n";
		else
		    $break = "\n";
	    
	    $this->boundary = "-----=".md5(rand());
	    
	    $this->header = "From: \"GreenHand\"<green@hand.fr>".$break
	    	."Reply-to: \"GreenHand\" <green@hand.fr>".$break
			."MIME-Version: 1.0".$break;
			."Content-Type: text/html;".$break
			."boundary=\"$this->boundary\"".$break;
			
		$this->message = $break."--".$this->boundary.$break;
			."Content-Type: text/html; charset=\"ISO-8859-1\"".$break;
			."Content-Transfer-Encoding: 8bit".$break;
			.$break.$message_html.$break;
			.$break."--".$this->boundary."--".$break;
			.$break."--".$this->boundary."--".$break;		
    }
    
    public function send()
    {
	    mail($this->to, $this->subject, $this->message, $this->header);
    }
}
