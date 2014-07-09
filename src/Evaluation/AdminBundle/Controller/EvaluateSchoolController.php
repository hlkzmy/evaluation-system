<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EvaluateSchoolController extends Controller
{
    
	public function readAction(){
		 
		//第二部分:查询数据形成列表
		$defaultEntityManager = $this->getDoctrine()->getManager ('default');
		$evaluateSchoolRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:EvaluateSchool');
		$evaluateSchool = $evaluateSchoolRepository->findAll();
			
			
			
		return $this->render('EvaluationAdminBundle:EvaluateSchool:Read.html.twig',array('evaluateSchool'=>$evaluateSchool));
		
	}
	
	public function createAction(){
	
	
	
	
		return $this->render('EvaluationAdminBundle:EvaluateSchool:Create.html.twig');
	}
    
    
   
    
    
    
    
    
    
    
    
}
