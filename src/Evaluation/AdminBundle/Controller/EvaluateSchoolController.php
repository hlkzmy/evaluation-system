<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EvaluateSchoolController extends Controller
{
    
	public function readAction(){
		 
		 
		 
		 
		return $this->render('EvaluationAdminBundle:EvaluateSchool:Read.html.twig');
	}
	
	public function createAction(){
	
	
	
	
		return $this->render('EvaluationAdminBundle:EvaluateSchool:Create.html.twig');
	}
    
    
   
    
    
    
    
    
    
    
    
}
