<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

//加载使用到的实体
use Evaluation\CommonBundle\Entity\EvaluateSchool;

class EvaluateSchoolController extends Controller
{
    
	public function readAction(){
		 
		//第二部分:查询数据形成列表
		$defaultEntityManager = $this->getDoctrine()->getEntityManager();
		$evaluateSchoolRepository = $defaultEntityManager->getRepository('EvaluationCommonBundle:EvaluateSchool');
		$evaluateSchool = $evaluateSchoolRepository->findAll();
			
			
			
		return $this->render('EvaluationAdminBundle:EvaluateSchool:Read.html.twig',array('evaluateSchool'=>$evaluateSchool));
		
	}
	
	public function createAction(){
	
		return $this->render('EvaluationAdminBundle:EvaluateSchool:Create.html.twig');
	}
	
	/**
	 * 删除数据对象
	 * @param int $id
	 */
	public function deleteAction(EvaluateSchool $school){
		
		if (!$school) {
			return new JsonResponse(array('message'=>'该对象已经被删除，请刷新页面','statusCode'=>300));
		}

    	$em = $this->getDoctrine()->getEntityManager();
    	$em->remove($school);
    	$em->flush();
		
    	return new JsonResponse(array('message'=>'删除成功','statusCode'=>200));
    	
	}//function deleteAction() end
	
    
	
	/**
	 * 检测并验证数据对象添加的方法，由表单提交
	 */
	public function checkCreateAction(){
		
		//第一步:处理request对象传递上来的数据，并调用表单对象进行验证
		$request = $this->getRequest();
		if(!$request->isXmlHttpRequest()){
			return new Response('Forbidden',403);
		}
		
		$post = $request->request;
		
		$name 		= $post->get('name');//得到测评对象的名称 
		$description= $post->get('description');//得到测频对象的描述
		
		//第二步：通过提交的数据验证,包括[数据库重复，输入的数据不符合规定]等内容
		
		
		
		
		
		//第三步:向数据库中插入数据
		$doctrine = $this->getDoctrine();
		$em = $doctrine->getEntityManager();
		$evaluateSchoolRespository = $em->getRepository('EvaluationCommonBundle:EvaluateSchool');
		
		$em->getConnection()->beginTransaction();
		try {
    		$evaluateSchool = new EvaluateSchool();
			$evaluateSchool->setName($name);
			$evaluateSchool->setDescription($description);
			$evaluateSchool->setCreateAdminUser($this->getUser()->getUsername());
			$evaluateSchool->setInsertTime(new \DateTime());
			$em->persist($evaluateSchool);
			$em->flush();
		    
		} catch (\Exception $e) {
    		$em->getConnection()->rollback();
    		return new JsonResponse(array('statusCode'=>200,'message'=>$e->getMessage()));
    	}
		
		$em->getConnection()->commit();
		
		return new JsonResponse(array('statusCode'=>200,'message'=>'添加测评单位成功'));
		
	}//function checkCreateAction() end
	
    
   
    
    
    
    
    
    
    
    
}
