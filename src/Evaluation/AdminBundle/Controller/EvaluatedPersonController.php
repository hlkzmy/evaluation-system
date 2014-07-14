<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

//加载相应的实体
use Evaluation\CommonBundle\Entity\EvaluatedPerson;



class EvaluatedPersonController extends Controller
{
    
	public function readAction(){
		 

		//第二部分:查询数据形成列表
		$defaultEntityManager = $this->getDoctrine()->getManager ('default');
		$evaluatedPersonRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:EvaluatedPerson');
		$evaluatedPerson = $evaluatedPersonRepository->findAll();
		 
			
			
		return $this->render('EvaluationAdminBundle:EvaluatedPerson:Read.html.twig',array('evaluatedPerson'=>$evaluatedPerson));
		
	}
	
	public function createAction(){
	
		//第二部分:创建表单
		$formOptions = array(
							 'attr'=>array('class'=>'post-data-form'),
							 'action' => $this->generateUrl('evaluation_evaluated_person_check_create'),
						);
		
		
		$form = $this->createForm('evaluated_person_form',null,$formOptions);
		$formView = $form->createView();
		
		return $this->render('EvaluationAdminBundle:EvaluatedPerson:Create.html.twig',array('formView'=>$formView));
	}
	
	/**
	 * 删除数据对象
	 * @param int $id
	 */
	public function deleteAction(EvaluatedPerson $person){
	
		if (!$person) {
			return new JsonResponse(array('message'=>'该对象已经被删除，请刷新页面','statusCode'=>300));
		}
	
		$em = $this->getDoctrine()->getManager();
		$em->remove($person);
		$em->flush();
	
		return new JsonResponse(array('message'=>'删除评价对象成功','statusCode'=>200));
		 
	}//function deleteAction() end
	
	
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
		$form = $this->createForm('evaluated_person_form');
		$form->handleRequest($this->getRequest());
		
		if(!$form->isValid()){
			foreach($form as $formElement){
				foreach($formElement->getErrors() as $error){
					return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
				}
			}
		}
			
		//1.根据表单回收的实体对象的基础上再根据逻辑添加其他数据项的取值
		$evaluatePerson = $form->getData();
		$evaluatePerson->setInsertTime(new \DateTime());
		$evaluatePerson->setCreateAdminUser( method_exists($this->getUser(),'getRealname')? $this->getUser()->getRealname() : $this->getUser()->getUsername() );
		
		//2.得到数据库对象，然后插入数据
		$doctrine = $this->getDoctrine();
		$em = $doctrine->getManager();
		
		//3.单张数据表的操作不需要事务操作
		try{
			$em->persist($evaluatePerson);
			$em->flush();
		}
		catch (\Exception $e){
			return new JsonResponse(array('statusCode'=>300,'message'=>$e->getMessage()));
		}
			
		return new JsonResponse(array('statusCode'=>200,'message'=>'添加测评对象成功'));
		
	}//function checkCreateAction() end
    
    
   
    
    
}
