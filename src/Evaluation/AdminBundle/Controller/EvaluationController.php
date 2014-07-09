<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EvaluationController extends Controller
{
    
    public function readAction(){
    	
    	
    	//第二部分:查询数据形成列表
    	$defaultEntityManager = $this->getDoctrine()->getManager ('default');
    	$evaluationRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:Evaluation');
    	$evaluation = $evaluationRepository->findAll();
    		
    		
    		
    	return $this->render('EvaluationAdminBundle:Evaluation:Read.html.twig',array('evaluation'=>$evaluation));
    	
    }
    
    public function createAction(){
    	 
    	 
    	
    	
    	 
    	 
    	return $this->render('EvaluationAdminBundle:Evaluation:Create.html.twig');
    }
   
    
    
    
    
    
    
    
    
}
