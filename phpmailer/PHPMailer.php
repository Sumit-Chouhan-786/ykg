<?php
/**
 * PHPMailer master class.
 * Direct include version for shared hosting (no Composer needed)
 */

namespace PHPMailer\PHPMailer;

class PHPMailer
{
    public $Mailer = 'smtp';
    public $Host;
    public $Port = 587;
    public $SMTPAuth = true;
    public $Username;
    public $Password;
    public $SMTPSecure = 'tls';

    public $From;
    public $FromName;
    public $Subject;
    public $Body;
    public $AltBody;
    public $CharSet = 'UTF-8';

    protected $to = [];
    protected $replyTo = [];
    protected $attachments = [];

    public function __construct($exceptions = false) {}

    public function isSMTP()
    {
        $this->Mailer = 'smtp';
    }

    public function setFrom($address, $name = '')
    {
        $this->From = $address;
        $this->FromName = $name;
    }

    public function addAddress($address, $name = '')
    {
        $this->to[] = [$address, $name];
    }

    public function addReplyTo($address, $name = '')
    {
        $this->replyTo = [$address, $name];
    }

    public function addAttachment($path, $name = '')
    {
        $this->attachments[] = [$path, $name];
    }

    public function send()
    {
        return SMTP::sendSMTPMail($this);
    }
}