<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUserController extends Controller
{
	
	
	
	
	
    public function readAction(){
		 
		 
		 
		 
		return $this->render('EvaluationAdminBundle:AdminUser:Read.html.twig');
	}
	
	public function createAction(){
	
	
	
	
		return $this->render('EvaluationAdminBundle:AdminUser:Create.html.twig');
	}
    
    
   
    
    
    
    
    
    
    
    
}
