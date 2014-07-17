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
		$evaluatedPersonRepository = $em->getRepository('EvaluationCommonBundle:EvaluatedPerson');
		
		
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
		$evaluatedPerson 	  = $evaluation->getEvaluatedPerson();//得到序列化字段
		$evaluatedPersonIdList = unserialize($evaluatedPerson);//得到序列化字段
		
		$evaluationEntity = new Evaluation();
		$evaluationEntity->setName($evaluation->getName());
		
		foreach($evaluatedPersonIdList as $personId){
			
			//通过personId得到person的信息
			$person = $evaluatedPersonRepository->find($personId);
			
			//然后得到的真实姓名和职位设置给personResult对象
			$personResult = new EvaluatedPersonResult();
			$personResult->setRealname($person->getRealname());
			$personResult->setPosition($person->getPosition());
			
			$evaluationEntity->getPersonResult()->set($personId,$personResult);
		}
		
		//4.通过已经附加了相关参数的evaluationEntity对象得到表单
		$formOptions = array('attr'=>array('class'=>'post-data-form form-bordered form-horizontal'));
		
		$form = $this->createForm('evaluate_join_form',$evaluationEntity,$formOptions);
		
		return $form;
	}
	
	
	public function submitAction(){
		
		//第一步:得到数据库相关的句柄
		$em = $this->getDoctrine()->getManager();
		
		
		//第二步：验证表单的相关数据
		$form = $this->getEvalutionForm($em);
		$form->handleRequest($this->getRequest());
		
		//1.验证表单的数据
		if(!$form->isValid()){
			foreach($form as $formElement){
				foreach($formElement->getErrors() as $error){
					return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
				}
			}
		}
		
		//2.验证schoolResult的fieldType的数据
		$schoolResultForm = $form->get('schoolResult');
		foreach($schoolResultForm as $column){//循环collection，每一个元素就是一个表单
			foreach($column->getErrors() as $error){
				return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
			}
		}//form foreach end
		
		
		
		//3.验证personResult的collection的数据
		$personResultCollection = $form->get('personResult');//得到collection集合
		if(!$personResultCollection->isValid()){
			foreach($personResultCollection as $form){//循环collection，每一个元素就是一个表单
				foreach($form as $column){
					foreach($column->getErrors() as $error){
						return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
					}
				}//column foreach end
			}//form foreach end
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
