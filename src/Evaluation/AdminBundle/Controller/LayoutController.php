<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    
    public function consoleAction(){
    	
    	
    	
    	
    	return $this->render('EvaluationAdminBundle:Layout:Console.html.twig');
    }
    
    
    
    public function loginAction(){
    
    	
    
    
    
    
    
    	return $this->render('EvaluationAdminBundle:Layout:Login.html.twig');
    }
   
    
    
    
    
    
    
    
    
}
