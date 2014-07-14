<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

//加载相关的实体
use Evaluation\CommonBundle\Entity\Evaluation;
use Evaluation\CommonBundle\Entity\EvaluateUser;

class EvaluationController extends Controller
{
    
    public function readAction(){
    	
    	
    	//第二部分:查询数据形成列表
    	$defaultEntityManager = $this->getDoctrine()->getManager ('default');
    	$evaluationRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:Evaluation');
    	$evaluation = $evaluationRepository->findAll();
    		
    		
    		
    	return $this->render('EvaluationAdminBundle:Evaluation:Read.html.twig',array('evaluation'=>$evaluation));
    	
    }
    
    /**
     * 删除数据对象
     * @param int $id
     */
    public function deleteAction(Evaluation $evaluation){
    
    	//第一步:对于民主评价是否已经删除进行判断
    	if (!$evaluation) {
    		return new JsonResponse(array('message'=>'该对象已经被删除，请刷新页面','statusCode'=>300));
    	}
    	
    	//第二步:民主评价处于进行中和已结束两个状态都不允许删除
    	$startTimestamp =  $evaluation->getStartTime()->getTimestamp();
    	$endTimestamp   =  $evaluation->getEndTime()->getTimestamp();
    	
    	//1.进行之中的判断
    	if($startTimestamp<= time() && $endTimestamp >= time()){
    		return new JsonResponse(array('message'=>'处于进行之中的民主评价无法被删除,否则会引起错误','statusCode'=>300));
    	}
    	
    	//2.已经结束的判断
    	if($endTimestamp< time()){
    		return new JsonResponse(array('message'=>'处于已结束状态的民主评价无法删除,请在后台中查看相关结果','statusCode'=>300));
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->remove($evaluation);
    	$em->flush();
    
    	return new JsonResponse(array('message'=>'删除民主评价成功','statusCode'=>200));
    		
    }//function deleteAction() end
    
    
    public function createAction(){
    	 
    	//第二部分:创建表单
    	$formOptions = array(
    			'attr'=>array('class'=>'post-data-form'),
    			'action' => $this->generateUrl('evaluation_evaluate_check_create'),
    	);
    	
    	
    	$form = $this->createForm('evaluation_form',null,$formOptions);
    	$formView = $form->createView();
    	
    	return $this->render('EvaluationAdminBundle:Evaluation:Create.html.twig',array('formView'=>$formView));
    
    }
   
    
    /**
     * 检测并验证数据对象添加的方法，由表单提交
     */
    public function checkCreateAction(){
    
    	//第一步:得到相关请求
    	$form = $this->createForm('evaluation_form');
    	$form->handleRequest($this->getRequest());
    	
    	
    	//第二步:根据validation.yml里面的内容验证表单元素的内容
    	if(!$form->isValid()){
    		foreach($form as $formElement){
    			foreach($formElement->getErrors() as $error){
    				return new JsonResponse(array('statusCode'=>300,'message'=>$error->getMessage()));
    			}
    		}
    	}

    	//第三步:对于从表单回收的数据进行处理，以便可以存储进数据库
    	$evaluation = $form->getData();
    	
    	//1.根据表单回收的实体对象的基础上再根据逻辑添加其他数据项的取值
    	$evaluation->setCreateAdminUser( method_exists($this->getUser(),'getRealname')? $this->getUser()->getRealname() : $this->getUser()->getUsername()  );
    	
    	//2.序列化参与的人员列表,因为是一个评价中包含若干个评价人
    	$evaluation->setEvaluatedPerson( serialize($evaluation->getEvaluatedPerson()));
    	
    	//3.因为从表单收取的数据是字符串，但是插入的时间格式要求是datetime,所以要进行转换
    	$evaluation->setInsertTime(new \DateTime());
    	$evaluation->setStartTime( new \DateTime( $evaluation->getStartTime())  );
    	$evaluation->setEndTime( new \DateTime( $evaluation->getEndTime())  );
    	
    	
    	
    	//第四步:将经过处理和验证的数据插入数据库
    	//1.得到数据库对象
    	$doctrine = $this->getDoctrine();
    	$em = $doctrine->getManager();
    	
    	//2.因为涉及多张数据表，所以需要开启数据库事务操作
    	$em->getConnection()->beginTransaction();
    	try{
    		
    		//插入民主评价的数据表
    		$em->persist($evaluation);
    		$em->flush();
    		
    		
    		//插入前台用户的数据表
    		$evaluateUserCount = intval( $evaluation->getEvaluateUserCount());
    		$evaluationId = $evaluation->getId();
    		
    		//生成账号规则的评价编号部分,取3位数字，最做为999
    		$evaluationIdPart = '000000'.$evaluationId;
    		$evaluationIdPart = substr($evaluationIdPart,strlen($evaluationIdPart)-3);
    		
    		//生成账号规则的学校部分,取3位数字，最做为999
    		$schoolId 	  = '000000'.$evaluation->getSchoolId();
    		$schoolIdPart = substr($schoolId,strlen($schoolId)-3);
    		
    		for($i=0;$i<$evaluateUserCount;$i++){
    			$user = new EvaluateUser();
    			$user->setEvaluationId($evaluationId);
    			
    			//生成账号规则的用户Id部分,取3位数字，最做为999
    			$userId 	= '000000'.$i;
    			$userIdPart = substr($userId,strlen($userId)-3);
    			
    			//设置账号
    			$username = sprintf('%s%s%s',$schoolIdPart,$evaluationIdPart,$userIdPart);
    			$user->setUsername($username);
    			
    			//设置密码
    			$password = md5( sha1($schoolIdPart).md5($evaluationIdPart).sha1($userIdPart) );
    			$passwordLength = strlen($password);//得到长度
    			$rand = rand(0,$passwordLength-7);//得到开始范围
    			$password = substr($password,$rand,6);//随机从中取出6位数字
    			$user->setPassword($password);
    			$em->persist($user);
    		}
    		
    		$em->flush();
    	
    	}
    	catch (\Exception $e){
    		$em->getConnection()->rollback();
    		$em->getConnection()->close();
    		return new JsonResponse(array('statusCode'=>300,'message'=>$e->getMessage()));
    	}
    	
    	$em->getConnection()->commit();
    	$em->getConnection()->close();
    	
    	return new JsonResponse(array('statusCode'=>200,'message'=>'创建民主评价成功'));
    
    }//function checkCreateAction() end
    
    
    
    
    
    
}
