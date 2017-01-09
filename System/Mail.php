<?php
namespace System;

class Mail
{
    private $from;
    private $subject;
    private $message;
        
    public $charset = 'UTF-8';
    public $encoding = '8bit';
    public $type = 'text/html';
    public $mime = '1.0';
    
    private static function implode($list)
    {
        return is_array($list) ? implode(', ', $list) : $list;
    }
    
    public function __construct($subject, $message, $from)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->from = $from;
    }
    
    public function send($to, $cc = null, $bcc = null)
    {
        $header  = 'MIME-Version: ' . $this->mime . '' . "\r\n";
        $header .= 'Content-type: ' . $this->type . '; charset=' . $this->charset . "\r\n";
        
        $header .= 'From: ' . $this->from . "\r\n";
        
        if($cc != null)
            $header .= 'Cc: ' . self::implode($cc) . "\r\n";
        
        if($bcc != null)
            $header .= 'Bcc: ' . self::implode($bcc) . "\r\n";
                
        return mail(
            self::implode($to),
            $this->subject,
            $this->message,
            $header
        );
    }    
    
}
