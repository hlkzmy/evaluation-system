<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
	
	
	
	
	
    public function readAction(){
		 
		 
		 
		 
		return $this->render('EvaluationAdminBundle:User:Read.html.twig');
	}
	
	public function createAction(){
	
	
	
	
		return $this->render('EvaluationAdminBundle:User:Create.html.twig');
	}
    
    
   
    
    
    
    
    
    
    
    
}
