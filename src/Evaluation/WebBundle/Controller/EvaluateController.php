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
	
	private function checkEvaluationCondition($em){
		
		
		
	}
	
	private function getEvalutionForm($em){
		
		$evaluateUserRepository = $em->getRepository('EvaluationCommonBundle:EvaluateUser');
		$evaluationRepository   = $em->getRepository('EvaluationCommonBundle:Evaluation');
		
		
		//1.根据用户名查询所属的教学评价的ID
		$username     = $this->getUser()->getUsername();//得到用户信息账号
		$evaluateUser = $evaluateUserRepository->findOneByUsername($username);
		
		if(!$evaluateUser){
			throw new  \Exception('没有查询到关于您的账号所关联的民主评价');
		}
		
		//2.查询得到民主评价的相关信息
		$evaluationId = $evaluateUser->getEvaluationId();
		$evaluation = $evaluationRepository->find($evaluationId);
		
		if(!$evaluation){
			return new \Exception('没有查询到关于您的账号所关联的民主评价的详细信息');
		}
		
		//3.根据民主评价的信息得到测评对象的信息
		$evaluatePerson 	  = $evaluation->getEvaluatedPerson();//得到序列化字段
		$evaluatePersonIdList = unserialize($evaluatePerson);//得到序列化字段
		
		$evaluationEntity = new Evaluation();
		
		foreach($evaluatePersonIdList as $personId){
			$personResult = new EvaluatedPersonResult();
			$evaluationEntity->getPersonResult()->set($personId,$personResult);
		}
		
		//4.通过已经附加了相关参数的evaluationEntity对象得到表单
		$formOptions = array('attr'=>array('class'=>'post-data-form'));
		
		$form = $this->createForm('evaluate_join_form',$evaluationEntity,$formOptions);
		
		return $form;
	}
	
	
	public function submitAction(){
		
		//第一步:得到数据库相关的句柄
		$em = $this->getDoctrine()->getManager();
		
		
		//第二步：验证表单的相关数据
		$evaluationForm = $this->getEvalutionForm($em);
		$evaluationForm->handleRequest($this->getRequest());
		
		
		
		if($evaluationForm->isValid()){
			echo 'true';
		}
		else{
			
			echo 'false';
			echo $evaluationForm->getErrorsAsString();
		}
		
		
		
		
		//$personResult = $evaluationForm->getData()->getPersonResult();
		
		$personResult = $evaluationForm->get('personResult');
		
		
		foreach($personResult as $person){
			
// 			echo $person->getErrorsAsString();
			
// 			var_dump($person->isValid());
			
		}
		
		
		
		return new JsonResponse(array('statusCode'=>200,'message'=>'提交民主评价成功，感谢您的参与'));
	}
	
	
	public function joinAction()
	{
		
		//第一步:得到数据库相关的句柄
		$em = $this->getDoctrine()->getManager();
		
		//第二步：形成相关的表单
		$evaluationForm = $this->getEvalutionForm($em);
		$formView = $evaluationForm->createView();
		 
		return $this->render('EvaluationWebBundle:Evaluate:join.html.twig',array('formView'=>$formView));
	}
	
	
	
	
	
}
