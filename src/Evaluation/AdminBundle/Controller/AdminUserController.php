<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminUserController extends Controller
{
	
	
    public function readAction(){
		 
		 
    	//第二部分:查询数据形成列表
    	$defaultEntityManager = $this->getDoctrine()->getManager ('default');
    	$adminUserRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:AdminUser');
    	$adminUser = $adminUserRepository->findAll();
    	
		 
		 
		return $this->render('EvaluationAdminBundle:AdminUser:Read.html.twig',array('adminUser'=>$adminUser));
	}
	
	
	public function createAction(){
	
		//第二部分:创建表单
		$formOptions = array(
				'attr'=>array('class'=>'post-data-form'),
				'action' => $this->generateUrl('evaluation_admin_user_check_create'),
		);
		
		$form = $this->createForm('admin_user_form',null,$formOptions);
		$formView = $form->createView();
		
		return $this->render('EvaluationAdminBundle:AdminUser:Create.html.twig',array('formView'=>$formView));
	}
	
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
		$form = $this->createForm('admin_user_form');
		$form->handleRequest($this->getRequest());
		
		if(!$form->isValid()){
			foreach($form as $formElement){
				foreach($formElement->getErrors() as $error){
					return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
				}
			}
		}
			
		//1.根据表单回收的实体对象的基础上再根据逻辑添加其他数据项的取值
		$adminUser = $form->getData();
		$adminUser->setInsertTime(new \DateTime());
		
		
		//2.对于密码做混淆处理
		$factory = $this->get('security.encoder_factory');
		
		$encoder = $factory->getEncoder($adminUser);
		$password = $encoder->encodePassword('ryanpass', $adminUser->getSalt());
		$adminUser->setPassword($password);
		
		
		//2.得到数据库对象，然后插入数据
		$doctrine = $this->getDoctrine();
		$em = $doctrine->getManager();
		
		//3.单张数据表的操作不需要事务操作
		try{
			$em->persist($adminUser);
			$em->flush();
		}
		catch (\Exception $e){
			return new JsonResponse(array('statusCode'=>300,'message'=>$e->getMessage()));
		}
			
		return new JsonResponse(array('statusCode'=>200,'message'=>'添加系统管理员成功'));
		
	}
	
	
    
    
   
    
    
    
    
    
    
    
    
}
