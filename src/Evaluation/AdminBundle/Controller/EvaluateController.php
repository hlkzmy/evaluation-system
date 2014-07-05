<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EvaluateController extends Controller
{
    
    public function readAction(){
    	
    	$phpExcelReader = new \PHPExcel_Reader_Excel5();
    	
    	
    	
    	return $this->render('EvaluationAdminBundle:Evaluate:Read.html.twig');
    }
    
    public function createAction(){
    	 
    	 
    	 
    	 
    	return $this->render('EvaluationAdminBundle:Evaluate:Create.html.twig');
    }
   
    
    
    
    
    
    
    
    
}
