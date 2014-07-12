<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
	
	
	
	
		return $this->render('EvaluationAdminBundle:EvaluatedPerson:Create.html.twig');
	}
	
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
	
	
	
		return new JsonResponse();
	}
    
    
   
    
    
    
    
    
    
    
    
}
