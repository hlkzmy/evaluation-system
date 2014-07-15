<?php

namespace Evaluation\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class EvaluateController extends Controller
{
	
	public function joinAction()
    {
    	//第一步：验证当前用户是否具有权限
    	
    	
		$doctine = $this->getDoctrine();
		$em = $doctine->getManager();
    	//第二步：验证当前评价是否处于进行中，如果是未开始或者已结束的状态就显示相应的提示
    	
    	
    	
    	//第三步：验证当前用户是否已经提交过数据，如果已经提交过数据，就显示相应的提示
    	
    	
    	
    	//第四步：根据当前用户的信息查询民主评价的相关信息，然后形成相关的表单
    	 //1.根据用户名查询所属的教学评价的ID
		 $username = $this->getUser()->getUsername();//得到用户信息账号
    	 $evaluateUserRepository = $em->getRepository('EvaluationCommonBundle:EvaluateUser');
    	 $record = $evaluateUserRepository->findOneByUsername($username);
    	 
    	 if(!$record){
    	 	return new Response('没有查询到关于您的任何民主评价的信息');
    	 }
    	 
    	 $evaluationId = $record->getEvaluationId();
    	 //2.通过createForm的第三个参数传递options选项，动态的添加表单元素
    	 $form = $this->createForm('evaluate_join_form',null,array('attr'=>array('evaluation_id'=>$evaluationId) ) );
    	 $formView = $form->createView();
    	
    	
    	
         return $this->render('EvaluationWebBundle:Evaluate:join.html.twig',array('formView'=>$formView));
    }
}
