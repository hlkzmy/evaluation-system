<?php

namespace Evaluation\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

//加载用到的实体
use Evaluation\CommonBundle\Entity\Evaluation;
use Evaluation\CommonBundle\Entity\EvaluatedPersonResult;
use Evaluation\CommonBundle\Entity\EvaluatedPerson;
use Symfony\Component\HttpFoundation\JsonResponse;

class EvaluateController extends Controller
{
	
	public function submitAction(){
		
		$form = $this->createForm('evaluate_join_form');
		
		$request = $this->getRequest();
		
		$form->handleRequest($request);
		
		if(!$form->isValid()){
			foreach($form as $formElement){
				foreach($formElement->getErrors() as $error){
					return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
				}
			}
			
			//echo $form->getErrorsAsString();
		}
		
		$person = $form->get('person');
		
		foreach($person as $element){
			
			var_dump('dsfsdfsdfds'.$element->isValid());
			
		}
		
		//print_r($form->getData());
		
		
		return new JsonResponse(array('statusCode'=>200,'message'=>'提交民主评价成功'));
	}//function submitAction() end
	
	
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
    	 $evaluatedPersonRepository  = $em->getRepository('EvaluationCommonBundle:EvaluatedPerson');
    	 $evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
    	 
    	 $evaluateUser = $evaluateUserRepository->findOneByUsername($username);
    	 
    	 if(!$evaluateUser){
    	 	return new Response('没有查询到关于您的账号所关联的民主评价');
    	 }
    	 
    	 //2.查询得到民主评价的相关信息
    	 $evaluationId = $evaluateUser->getEvaluationId();
    	 $evaluationRecord = $evaluationRepository->find($evaluationId);
    	 
    	 if(!$evaluationRecord){
    	 	return new Response('没有查询到关于您的账号所关联的民主评价的详细信息');
    	 }
    	 
    	 
    	 //3.根据民主评价的信息得到测评对象的信息
    	 $evaluatePersonColumn = $evaluationRecord->getEvaluatedPerson();//得到序列化字段
    	 $evaluatePersonIdList = unserialize($evaluatePersonColumn);//得到序列化字段
    	 
    	 
    	 $evaluationEntity = new Evaluation();
    	 foreach($evaluatePersonIdList as $personId){
    	 	
    	 	//根据id查询到相关的测评对象的真实信息
    	 	$person = $evaluatedPersonRepository->find($personId);
    	 	
    	 	if(!$person)continue;
    	 	
    	 	$personResult = new EvaluatedPersonResult();
    	 	$evaluationEntity->getPerson()->set($personId,$personResult);
    	 }
    	 
    	 //2.通过createForm的第三个参数传递options选项，动态的添加表单元素
    	 $form = $this->createForm('evaluate_join_form',$evaluationEntity,array('attr'=>array(
    	 																				'class'=>'post-data-form'
    	 																				)
    	 																		)
    	 						  );
    	 
    	 $formView = $form->createView();
    	
    	 return $this->render('EvaluationWebBundle:Evaluate:join.html.twig',array('formView'=>$formView));
    }
}
