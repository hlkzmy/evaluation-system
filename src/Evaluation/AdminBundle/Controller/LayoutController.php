<?php

namespace Evaluation\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Evaluation\AdminBundle\Controller\BaseController;

class LayoutController extends Controller
{
    
    public function consoleAction(){
    	
    	//第一部分：通过判断session来决定是否调用登录页面
    	$request = $this->getRequest();
    	$session = $request->getSession();
    	if(!$session->has('admin_info')){//如果之前没有登陆过，就跳转到登陆页面
    		//return $this->redirect($this->generateUrl('evaluation_admin_console'),302);
    	}
    	
    	
    	
    	
    	
    	return $this->render('EvaluationAdminBundle:Layout:Console.html.twig');
    }
    
    
    
    public function loginAction(){
    
    	//第一部分：通过判断session来决定是否调用登录页面
    	$request = $this->getRequest();
    	$session = $request->getSession();
    	
    	if($session->has('admin_info')){//如果之前登陆过，就直接跳转到后台控制台页面
    		return $this->redirect($this->generateUrl('evaluation_admin_console'),302);
    	}
    	

    	
    
    
    
    
    
    	return $this->render('EvaluationAdminBundle:Layout:Login.html.twig');
    }
   
    
    
    
    
    
    
    
    
}
