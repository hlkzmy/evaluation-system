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
	
		$evaluatedPerson = new EvaluatedPerson();
		$evaluatedPerson->setPosition('教导主任');
		
		
		
		
		
		//第二部分:创建表单
		$formOptions = array(
							'action' => $this->generateUrl('evaluation_evaluated_person_check_create'),
						);
		
		$form = $this->createForm('evaluated_person_form',$evaluatedPerson,$formOptions);
		
		$formView = $form->createView();
		

		return $this->render('EvaluationAdminBundle:EvaluatedPerson:Create.html.twig',array('formView'=>$formView));
	}
	
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
		
		
		
	
		return new JsonResponse();
	}
    
    
   
    
    
    
    
    
    
    
    
}
