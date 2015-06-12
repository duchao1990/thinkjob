<?php
namespace Admin\Controlle;

use Admin\Controller\AdminController;
Vendor('Swift.swift_required');

class SwiftController extends AdminController {
     public  function sends($to_emails, $subject, $content,$annex) {
            $where['setname']='mail';
            $info=M('set')->where($where)->find();
            $mail=json_decode($info['setvalue'],true);
            try{
                $smtp = new \Swift_SmtpTransport($mail['EMAILHOST'], $mail['EMAILPORT']);
                $smtp->setUsername($mail('EMAILUSER'));
                $smtp->setPassword($mail('EMAILPWD'));
                $mailer = new \Swift_Mailer($smtp);
                $swiftmsg= new \Swift_Message();
                $message = $swiftmsg->newInstance($subject, $content,"text/html","utf-8");
                $message->setFrom(array($mail('EMAILUSER') => $mail('EMAILNAME')));
                $message->setTo($to_emails);
                if($annex) {
                    $message->attach(Swift_Attachment::fromPath($annex['name'], $annex['type'])->setFilename($annex['to_name'])); //这里是附件
                }
                $mailer->send($message);
                $ms = "success";
            }catch(Exception $e){
                echo $e;
                $ms = "fail";
            }
            return $ms;
    }
}