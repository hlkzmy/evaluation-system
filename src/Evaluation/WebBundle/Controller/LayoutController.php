<?php

namespace Evaluation\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContextInterface;

class LayoutController extends Controller
{
	
	
	
	public function loginAction()
    {
    	$request = $this->getRequest();
    	$session = $request->getSession();
    	 
    	//第一步：判断用户是否被授权了，如果已经被授权了相关的角色的权限，直接跳转到登陆后的目标页面
    	/**
    	 * 这部分的逻辑，是因为安全层委托程序员来实现的，所以程序员可以添加自己想要的逻辑，
    	 * 而不必严格按照手册中的内容进行编写
    	*/
    	if($this->get('Security.Context')->isGranted('ROLE_WEB_USER')){
    		return $this->redirect($this->generateUrl('evaluation_web_console'));
    	}
    	 
     	//第二步：从安全上下文或者session中取得相关报错信息并返回给登陆页
    	if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
    		$error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
    	}
    	else {
    		$error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
    		$session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
    	}
    	 
    	
    	return $this->render('EvaluationWebBundle:Layout:Login.html.twig',
    			array(
    					'last_username' => $session->get(SecurityContextInterface::LAST_USERNAME),
    					'error' => $error,
    			));
    
     }//function loginAction() end
    
    
    public function consoleAction(){
    	
    	
    	
    	return $this->render('EvaluationWebBundle:Layout:Console.html.twig');
    			
    }//function consoleAction() end
    
    
    
    
    /**
     * 认证的方法，可以委托给框架来处理，里面什么内容都不用写
     */
    public function authenticAction(){
    	 
    	//don't do anything
    }
     
    /**
     * 退出认证的方法，可以委托给框架来处理，里面什么内容都不用写
     */
    public function logoutAction(){
    
    	//don't do anything
    }
    
}
