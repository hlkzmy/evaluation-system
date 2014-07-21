<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

//加载相关的实体
use Evaluation\CommonBundle\Entity\Evaluation;
use Evaluation\CommonBundle\Entity\EvaluateUser;
use Symfony\Component\HttpFoundation\Response;

//加载所使用的到phpexcel的工具类


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
    			$user->setActive(0);
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
    
    
    /**
     * 导出参与民主评价的网站前台用户的相关信息
     */
    
    public function userExportAction($id){
    	
    	//第一步:得到相关的数据库对象
    	$doctrine = $this->getDoctrine();
    	$em = $doctrine->getManager();
    	
    	
    	//第二步:查询跟本次教学评价相关的网站前台用户的信息
    	$evaluateUserRepository = $em->getRepository('EvaluationCommonBundle:EvaluateUser');
    	$evaluateUserList = $evaluateUserRepository->findBy(array('evaluationId'=>$id));
    	
    	$evaluateUserArray = array();
    	array_push($evaluateUserArray,array('用户账号','用户密码'));	
    			
    	foreach($evaluateUserList as $element){
    		
    		$user = array();
    		$user['username'] = ' '.$element->getUsername();
    		$user['password'] = ' '.$element->getPassword();
    		array_push($evaluateUserArray,$user);
    	}
    	
    	//第三步: 利用phpexcel输出到excel中
    	$phpExcel= new \PHPExcel();
    	
    	$phpExcel->getActiveSheet()->fromArray($evaluateUserArray,null,'A1',true);
    	
    	$phpExcelWriter = new \PHPExcel_Writer_Excel5($phpExcel);
    	
    	//查询相关的信息，组成文件名
    	$evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
    	$evaluationRecord = $evaluationRepository->find($id);
    	
    	$filename = sprintf('%s-%s.xls',$evaluationRecord->getName(),'用户列表');
    	$filename = urlencode($filename);
    	
    	header("Content-Type: application/force-download");
    	header("Content-Type: application/octet-stream");
    	header("Content-Type: application/download");
    	header('Content-Disposition:inline;filename="'.$filename.'"');
    	header("Content-Transfer-Encoding: binary");
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    	header("Pragma: no-cache");
    	$phpExcelWriter->save('php://output');
    	
    	exit();
    	
    }//function userExport() end
    
    
    /**
     * 得到学校评价的相关数据
     */
    
    private function getSchoolResultData($id){
    	
    	//第一步:查询相关的数据信息，然后向模版数组中填入数据
    	$em = $this->getDoctrine()->getManager();
    	$evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
    	$evaluationRecord = $evaluationRepository->find($id);
    	
    	//1.查询单位名称
    	$schoolRepository = $em->getRepository('EvaluationCommonBundle:EvaluateSchool');
    	$schoolRecord = $schoolRepository->find($evaluationRecord->getSchoolId());
    	$schoolName = $schoolRecord->getName();
    	
    	//2.查询应到和实到人数
    	$evaluateUserRepository = $em->getRepository('EvaluationCommonBundle:EvaluateUser');
    	$shouldUserCount = $evaluationRecord->getEvaluateUserCount();
    	$actualUserCount = count($evaluateUserRepository->findBy(array('evaluationId'=>$id,'active'=>1)));
    	
    	//3.查询好中差的个数
    	$evaluatedSchoolResultRepository = $em->getRepository('EvaluationCommonBundle:EvaluatedSchoolResult');
    	$goodCount   = count($evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id,'score'=>1)));
    	$middleCount = count($evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id,'score'=>2)));
    	$badCount    = count($evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id,'score'=>3)));
    	
    	//4.查询相关的意见
    	$schoolResultRecord = $evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id));
    	
    	//第二步:利用之前输出的结果数组形成数据模版
    	$result = array (
    			array (
    					0 => '学校干部民主测评（领导班子）汇总表',
    					1 => NULL,
    					2 => NULL,
    					3 => NULL,
    					4 => NULL,
    			),
    	
    			array (
    					0 => '单位名称',
    					1 => $schoolName,
    					2 => '测评等次',
    					3 => NULL,
    					4 => NULL,
    			),
    	
    			array (
    					0 => '应参加人数',
    					1 => '实参加人数',
    					2 => '好',
    					3 => '中',
    					4 => '差',
    			),
    	
    			array (
    					0 => $shouldUserCount,
    					1 => $actualUserCount,
    					2 => $goodCount,
    					3 => $middleCount,
    					4 => $badCount,
    			),
    			array (
    					0 => '意见及意见',
    					1 => NULL,
    					2 => NULL,
    					3 => NULL,
    					4 => NULL,
    			)
    	);
    	
    	foreach($schoolResultRecord as $element){
    		$data = array (
    					0 => $element->getComment(),
    					1 => NULL,
    					2 => NULL,
    					3 => NULL,
    					4 => NULL,
    			);
    		array_push($result,$data);
    	}
    	
    	return $result;
    	
    }//function getSchoolResultData() end
    
    
    public function setPersonSheet(\PHPExcel $phpExcel,$id){
    	
    	
    	//第一步:查询相关的数据信息，然后向模版数组中填入数据
    	$em = $this->getDoctrine()->getManager();
    	$evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
    	$schoolRepository = $em->getRepository('EvaluationCommonBundle:EvaluateSchool');
    	$evaluateUserRepository = $em->getRepository('EvaluationCommonBundle:EvaluateUser');
    	$evaluatedPersonRepository = $em->getRepository('EvaluationCommonBundle:EvaluatedPerson');
    	
    	//1.查询单位名称
		$evaluationRecord = $evaluationRepository->find($id);
    	$schoolRecord = $schoolRepository->find($evaluationRecord->getSchoolId());
    	$schoolName = $schoolRecord->getName();
    	 
    	//2.查询应到和实到人数
    	$shouldUserCount = $evaluationRecord->getEvaluateUserCount();
    	$actualUserCount = count($evaluateUserRepository->findBy(array('evaluationId'=>$id,'active'=>1)));
    	 
    	//第二步:查询每个测评对象的对应的数据结果
    	$personSheet = $phpExcel->getSheet(0);
    	
    	//1.B2是所参加的学校名称
    	$personSheet->getCell('B2')->setValue($schoolName);
    	 
    	//2.C3的位置是测评对象的应到人数
    	$personSheet->getCell('C3')->setValue($shouldUserCount);
    	 
    	//3.E3是测评对象的实到人数
    	$personSheet->getCell('E3')->setValue($actualUserCount);
    	 
    	//第三步:查询每个测评对象的所得到的各种分数
    	//1.查询结果
    	$schoolId = $evaluationRecord->getSchoolId();
    	$evaluatedPersonIdList  = unserialize( $evaluationRecord->getEvaluatedPerson() );
    	 
    	//2.建立标准容器
    	$standardArrayContainer = array();
    	 
    	foreach($evaluatedPersonIdList as $personId){
    	
    		$evaluatedPersonRecord = $evaluatedPersonRepository->findOneBy(array('id'=>$personId,'schoolId'=>$schoolId));
    	
    		$array = array();
    		$array['realname'] = $evaluatedPersonRecord->getRealname();
    		$array['position'] = $evaluatedPersonRecord->getPosition();
    		//分别对应四个等级
    		$array['score1']   = 0;
    		$array['score2']   = 0;
    		$array['score3']   = 0;
    		$array['score4']   = 0;
    	
    		$hash = md5($array['realname'].$array['position']);
    	
    	
    		$standardArrayContainer[$hash] = $array;
    	
    	}//foreach end
    	 
    	  
    	/**
    	 因为现在还不知道doctrine里面怎么样实现group by
    	 所以还是使用repository里面定义一个custom method，然后用DQL查询数据的方法
    	 */
    	$evaluatedPersonResultRepository = $em->getRepository('EvaluationCommonBundle:EvaluatedPersonResult');
    	$evaluatedPersonResult = $evaluatedPersonResultRepository->getEvaluatedPersonResult($id);
    	 
    	//print_r($evaluatedPersonResult);
    	 
    	//4.拼接数组
    	foreach($evaluatedPersonResult as $value){
    		$hash = $value['hash'];
    		$scoreKey = 'score'.$value['score'];
    		$standardArrayContainer[$hash][$scoreKey] = $value['total'];
    	}
    	 
    	$standardArrayContainer = array_values($standardArrayContainer);
    	 
    	//5.写入phpexcel对象
    	for($i=0;$i<sizeof($standardArrayContainer);$i++){
    		$row = $i+6;
    		$personSheet->getCell( 'A'.$row )->setValue($standardArrayContainer[$i]['realname']);
    		$personSheet->getCell( 'B'.$row )->setValue($standardArrayContainer[$i]['position']);
    		$personSheet->getCell( 'C'.$row )->setValue($standardArrayContainer[$i]['score1']);
    		$personSheet->getCell( 'D'.$row )->setValue($standardArrayContainer[$i]['score2']);
    		$personSheet->getCell( 'E'.$row )->setValue($standardArrayContainer[$i]['score3']);
    		$personSheet->getCell( 'F'.$row )->setValue($standardArrayContainer[$i]['score4']);
    	}
    	 
	}//function getPersonResultData() end
    
    
    
    public function resultExportAction($id){
    	
    	
    	//第一步:得到相关的数据库对象
    	$doctrine = $this->getDoctrine();
    	$em = $doctrine->getManager();
    	
    	//第二步: 利用phpexcel输出到excel中
    	/**
			因为之前才用fromArray读取excel数据表，得到的合并单元格的内容为null
			但是还原的时候使用toArray却不能争取的还原
			所以从excel中读取单元格的格式作为模版，然后再填充数值，
			但是保存的时候不save到文件中，而是save到php://output里面
			
    	 */
    	
    	$phpExcelReader = new \PHPExcel_Reader_Excel5();
    	$phpExcel = $phpExcelReader->load('excel-template/person.xls');
    	$this->setPersonSheet($phpExcel, $id);//设置测评对象的sheet
    	
    	
    	
    	$phpExcelWriter = new \PHPExcel_Writer_Excel5($phpExcel);
    	
    	
    	//1.查询相关的信息，组成文件名
    	$evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
    	$evaluationRecord =  $evaluationRepository->find($id);
    	$filename = sprintf('%s-%s.xls',$evaluationRecord->getName(),'评价结果');
    	$filename = urlencode($filename);
    	 
    	//2.设置header信息
    	header("Content-Type: application/force-download");
    	header("Content-Type: application/octet-stream");
    	header("Content-Type: application/download");
    	header('Content-Disposition:inline;filename="'.$filename.'"');
    	header("Content-Transfer-Encoding: binary");
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    	header("Pragma: no-cache");
    	$phpExcelWriter->save('php://output');
    	 
    	exit();
    	
    }
    
    
    
    
    
    
    
}
