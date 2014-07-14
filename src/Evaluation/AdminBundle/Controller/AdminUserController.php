<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

//加载相关的实体
use Evaluation\CommonBundle\Entity\AdminUser;

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
	 * 删除数据对象
	 * @param int $id
	 */
	public function deleteAction(AdminUser $user){
	
		//第一步:只允许username为admin的账号进行操作
		$sessionUsername = $this->getUser()->getUsername();
		
		if($sessionUsername!='admin'){
			return new JsonResponse(array('statusCode'=>300,'message'=>'只允许账号为admin的超级管理员进行操作'));
		}
		
		//第二步:判断数据对象是否合法
		if (!$user) {
			return new JsonResponse(array('message'=>'该对象已经被删除，请刷新页面','statusCode'=>300));
		}
	
		//第三步:操作数据库
		$em = $this->getDoctrine()->getManager();
		$em->remove($user);
		$em->flush();
	
		return new JsonResponse(array('message'=>'删除系统管理员成功','statusCode'=>200));
		 
	}//function deleteAction() end
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
		//第一步:只允许username为admin的账号进行操作
 		$sessionUsername = $this->getUser()->getUsername();
		
		if($sessionUsername!='admin'){
			return new JsonResponse(array('statusCode'=>300,'message'=>'只允许账号为admin的超级管理员进行操作'));
		}
		
		
		//第二步:验证数据是否正确
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
		$password = $encoder->encodePassword($adminUser->getPassword(), $adminUser->getSalt());
		$adminUser->setPassword($password);
		
		
		//第三步:插入数据库
		//1.得到数据库对象，然后插入数据
		$doctrine = $this->getDoctrine();
		$em = $doctrine->getManager();
		
		//2.单张数据表的操作不需要事务操作
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
