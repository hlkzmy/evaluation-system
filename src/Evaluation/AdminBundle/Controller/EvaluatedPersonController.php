<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EvaluatedPersonController extends Controller
{
    
	public function readAction(){
		 
		 
		 
		 
		return $this->render('EvaluationAdminBundle:EvaluatedPerson:Read.html.twig');
	}
	
	public function createAction(){
	
	
	
	
		return $this->render('EvaluationAdminBundle:EvaluatedPerson:Create.html.twig');
	}
    
    
   
    
    
    
    
    
    
    
    
}
