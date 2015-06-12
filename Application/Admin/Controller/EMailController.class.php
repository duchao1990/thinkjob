<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;

class EMailCotroller extends AdminController {
    Public function index() {
        $this->index() ;
    }
    public function sendMail() {
            $send=array();
            $send['to']=I('post.mailto','','email');
            $send['subject']=I('post.subject');
            $send['content']=I('post.content');
            $rs=R('Swift/send',$send);
            if ($rs=='success') {
                $this->success('发送成功');
            }else{
                $this->error('发送成功');
            }
        }
}