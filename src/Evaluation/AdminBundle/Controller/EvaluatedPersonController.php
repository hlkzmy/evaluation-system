<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    
    
   
    
    
    
    
    
    
    
    
}
