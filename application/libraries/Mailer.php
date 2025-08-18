<?php
use PHPMailer\PHPMailer\PHPMailer;

class Mailer {
    
    private $CI;
    private $mail;
    
    public function __construct() {
        $this->CI =& get_instance();
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'your-email@gmail.com';
        $this->mail->Password = 'your-password';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
    }
    
    public function send_leave_notification($to, $subject, $message) {
        try {
            $this->mail->setFrom('noreply@company.com', 'Leave System');
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'Mail Error: ' . $this->mail->ErrorInfo);
            return false;
        }
    }
}