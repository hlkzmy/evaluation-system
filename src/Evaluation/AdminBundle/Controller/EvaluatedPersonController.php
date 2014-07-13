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
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
		$form = $this->createForm('evaluated_person_form');
		$form->handleRequest($this->getRequest());
		
		if(!$form->isValid()){
			echo $form->getErrorsAsString();
		}
			
		//1.根据表单回收的实体对象的基础上再根据逻辑添加其他数据项的取值
		$evaluatePerson = $form->getData();
		$evaluatePerson->setInsertTime(new \DateTime());
		$evaluatePerson->setCreateAdminUser($this->getUser()->getUsername());
		
		//2.得到数据库对象，然后插入数据
		$doctrine = $this->getDoctrine();
		$em = $doctrine->getEntityManager();
		
		//3.单张数据表的操作不需要事务操作
		try{
			$em->persist($evaluatePerson);
			$em->flush();
		}
		catch (\Exception $e){
			echo $e->getMessage();
		}
			
		return new JsonResponse();
		
	}//function checkCreateAction() end
    
    
   
    
    
    
    
    
    
    
    
}
