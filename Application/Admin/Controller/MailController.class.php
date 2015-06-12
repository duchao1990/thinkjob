<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;
Vendor('Swift.swift_required');
class MailController extends AdminController {
     function index() {
         $setM=M('set');
        if (IS_POST) {

            $data=array();
            $data['emailhost']=I('post.EMAILHOST');
            $data['emailport']=I('post.EMAILPORT');
            $data['emailuser']=I('post.EMAILUSER');
            $data['emailname']='超级工作';
            $data['emailpwd']=I('post.EMAILPWD');
            $data['toemail']=I('post.TOEMAIL');
            $inset=json_encode($data);
            $map['setname']=I('post.setname');
            $map['setvalue']=$inset;
            if (intval(I('post.sid'))==0) {
                $rs=$setM->add($map);
                $this->sendMail($data['toemail']);
            }else {
                $where['sid']=intval(I('post.sid'));
                $rs=$setM->where($where)->save($map);
                $this->sendMail($data['toemail']);
            }
        }else{
            $where['setname']='mail';
            $info=$setM->where($where)->find();
            $mail=json_decode($info['setvalue'],true);
            $mail['sid']=$info['sid'];
            $mail['setname']=$info['setname'];
            $this->assign('mail',$mail);
            $this->display() ;
        }
    }
    public function sendMail($toemail) {
            $send=array();
            $send['to_emails']=$toemail;
            $send['subject']='测试标题';
            $send['content']="测试内容,来自超级工作服务端的测试内容";

            $rs=$this->sends($toemail, $send['subject'], $send['content']);
            if ($rs=='success') {
                $this->success('发送成功');
            }else{
                $this->error('发送失败');
            }
        }

        public  function sends($to_emails, $subject, $content,$annex) {
            $where['setname']='mail';
            $info=M('set')->where($where)->find();
            $mail=json_decode($info['setvalue'],true);
            try{
                $smtp = new \Swift_SmtpTransport($mail['emailhost'], $mail['emailport']);
                $smtp->setUsername($mail['emailuser']);
                $smtp->setPassword($mail['emailpwd']);
                $mailer = new \Swift_Mailer($smtp);
                $swiftmsg= new \Swift_Message();
                $message = $swiftmsg->newInstance($subject, $content,"text/html","utf-8");
                $message->setFrom(array($mail['emailuser'] => $mail['emailname']));
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