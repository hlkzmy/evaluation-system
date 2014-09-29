<?php

namespace Evaluation\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

//加载相关的实体
use Evaluation\CommonBundle\Entity\Evaluation;
use Evaluation\CommonBundle\Entity\EvaluateUser;
use Symfony\Component\HttpFoundation\Response;



class DataController extends Controller
{
	
	/**
	 * 按照现在的excel数据表格式,数据导出的时候的起始行数
	 * 每导出一个学校，起始行数就会因为学校领导的个数发生累加过程
	 */
	private $startRowNumber = 6;
	
	/**
	 * 现在正在循环的学校领导个数，就是学校领导班子所需要merge的单元格的行数
	 */
	private $currentEvaluationSchoolLeaderCount = 0;
	
	
	
	/**
	 * 设置学校领导班子的评价结果
	 */
	
	private function setSchoolSheet(\PHPExcel $phpExcel,$id){
		 
		//第一步:查询相关的数据信息，然后向模版数组中填入数据
		$em = $this->getDoctrine()->getManager();
		$evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
		$evaluationRecord = $evaluationRepository->find($id);
		 
		//1.查询单位名称
		$schoolRepository = $em->getRepository('EvaluationCommonBundle:EvaluateSchool');
		$schoolRecord = $schoolRepository->find($evaluationRecord->getSchoolId());
		$schoolName = $schoolRecord->getName();
		 
		//2.查询应到 实到 缺席人数
		$evaluateUserRepository = $em->getRepository('EvaluationCommonBundle:EvaluateUser');
		$shouldUserCount = $evaluationRecord->getEvaluateUserCount();
		$actualUserCount = count($evaluateUserRepository->findBy(array('evaluationId'=>$id,'active'=>1)));
		$absentUserCount = intval($shouldUserCount)-intval($actualUserCount);
		
		
		//3.查询好中差的个数
		$evaluatedSchoolResultRepository = $em->getRepository('EvaluationCommonBundle:EvaluatedSchoolResult');
		$goodCount   = count($evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id,'score'=>1)));
		$middleCount = count($evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id,'score'=>2)));
		$badCount    = count($evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id,'score'=>3)));
		 
		//4.查询相关的意见
		$schoolResultRecord = $evaluatedSchoolResultRepository->findBy(array('evaluationId'=>$id));
		 
		 
		//5.合并单元格
		$schoolSheet = $phpExcel->getActiveSheet();

		for($i=66;$i<=77;$i++){
			
			$alpha = chr($i);
			$mergeStartCell = $alpha.$this->startRowNumber;
			$mergeEndCell   = $alpha.($this->startRowNumber + $this->currentEvaluationSchoolLeaderCount -1);
			
			$schoolSheet->mergeCells($mergeStartCell.':'.$mergeEndCell);
			
			if($alpha=='B'){
				$schoolSheet->getCell($mergeStartCell)->setValue($schoolName);
			}
			else if($alpha=='C'){
				$schoolSheet->getCell($mergeStartCell)->setValue($shouldUserCount);
			}
			else if($alpha=='D'){
				$schoolSheet->getCell($mergeStartCell)->setValue($actualUserCount);
			}
			else if($alpha=='E'){
				$schoolSheet->getCell($mergeStartCell)->setValue($goodCount);
			}
			else if($alpha=='F'){
				$rate = round( $goodCount/$shouldUserCount,4)*100;
				$schoolSheet->getCell($mergeStartCell)->setValue($rate);
			}
			else if($alpha=='G'){
				$schoolSheet->getCell($mergeStartCell)->setValue($middleCount);
			}
			else if($alpha=='H'){
				$rate = round( $middleCount/$shouldUserCount,4)*100;
				$schoolSheet->getCell($mergeStartCell)->setValue($middleCount);
			}
			else if($alpha=='I'){
				$schoolSheet->getCell($mergeStartCell)->setValue($badCount);
			}
			else if($alpha=='J'){
				$rate = round( $badCount/$shouldUserCount,4)*100;
				$schoolSheet->getCell($mergeStartCell)->setValue($badCount);
			}
			else if($alpha=='K'){
				$schoolSheet->getCell($mergeStartCell)->setValue($absentUserCount);
			}
			else if($alpha=='L'){
				$rate = round( $absentUserCount/$shouldUserCount,4)*100;
				$schoolSheet->getCell($mergeStartCell)->setValue($rate);
			}
			
		}
		
		//6.对中间变量进行处理
		$this->startRowNumber = $this->startRowNumber + $this->currentEvaluationSchoolLeaderCount;
		
		 
	}//function getSchoolResultData() end
	
	
	/**
	 * 
	 * @param \PHPExcel $phpExcel 当前操作的excel对象
	 * @param int $id 当前的教学评价的id
	 */
	private function setPersonSheet(\PHPExcel $phpExcel,$id){
		 
		 
		//第一步:查询相关的数据信息，然后向模版数组中填入数据
		$em = $this->getDoctrine()->getManager();
		$evaluationRepository 		= $em->getRepository('EvaluationCommonBundle:Evaluation');
		$schoolRepository 			= $em->getRepository('EvaluationCommonBundle:EvaluateSchool');
		$evaluateUserRepository 	= $em->getRepository('EvaluationCommonBundle:EvaluateUser');
		$evaluatedPersonRepository 	= $em->getRepository('EvaluationCommonBundle:EvaluatedPerson');
		 
		//1.查询单位名称
		$evaluationRecord 	= $evaluationRepository->find($id);
		
		//2.查询应到人数，应到人数和 缺席人数
		//should代表应该
		$shouldUserCount = $evaluationRecord->getEvaluateUserCount();
		
		//actual代表实际
		$actualUserCount = count($evaluateUserRepository->findBy(array('evaluationId'=>$id,'active'=>1)));
	
		//absent
		$absentUserCount = intval($shouldUserCount) - intval( $actualUserCount );
		
		
		//第二步:查询每个测评对象的对应的数据结果
		$personSheet = $phpExcel->getActiveSheet();
		 
		
	
		//第三步:查询每个测评对象的所得到的各种分数
		//1.查询结果
		$schoolId = $evaluationRecord->getSchoolId();
		$evaluatedPersonIdList  = unserialize( $evaluationRecord->getEvaluatedPerson() );
	
		//2.建立标准容器
		$standardArrayContainer = array();
	
		foreach($evaluatedPersonIdList as $personId){
			 
			$evaluatedPersonRecord = $evaluatedPersonRepository->findOneBy(array('id'=>$personId,'schoolId'=>$schoolId));
			 
			if(is_null($evaluatedPersonRecord)){
				continue;
			}
	
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
	
		 
		//4.拼接数组
		foreach($evaluatedPersonResult as $value){
			$hash = $value['hash'];
			$scoreKey = 'score'.$value['score'];
			$standardArrayContainer[$hash][$scoreKey] = $value['total'];
		}
	
		$standardArrayContainer = array_values($standardArrayContainer);
	
		//5.写入phpexcel对象
		for($i=0;$i<sizeof($standardArrayContainer);$i++){
			
			$row = $i + $this->startRowNumber;
			
			//设置真实姓名和职位
			$personSheet->getCell( 'N'.$row )->setValue($standardArrayContainer[$i]['realname']);
			$personSheet->getCell( 'O'.$row )->setValue($standardArrayContainer[$i]['position']);
			
			//优秀和优秀率 P Q
			$personSheet->getCell( 'P'.$row )->setValue($standardArrayContainer[$i]['score1']);
			$rate = round($standardArrayContainer[$i]['score1']/$shouldUserCount,4)*100;
			$personSheet->getCell( 'Q'.$row )->setValue($rate);
			
			//称职和称职率R S
			$personSheet->getCell( 'R'.$row )->setValue($standardArrayContainer[$i]['score2']);
			$rate = round($standardArrayContainer[$i]['score2']/$shouldUserCount,4)*100;
			$personSheet->getCell( 'S'.$row )->setValue($rate);
			
			//基本称职和基本称职率 TU
			$personSheet->getCell( 'T'.$row )->setValue($standardArrayContainer[$i]['score3']);
			$rate = round($standardArrayContainer[$i]['score3']/$shouldUserCount,4)*100;
			$personSheet->getCell( 'U'.$row )->setValue($rate);
			
			//不称职和不称职率 VW
			$personSheet->getCell( 'V'.$row )->setValue($standardArrayContainer[$i]['score4']);
			$rate = round($standardArrayContainer[$i]['score4']/$shouldUserCount,4)*100;
			$personSheet->getCell( 'W'.$row )->setValue($rate);
			
			//缺席和缺席率 XY
			$personSheet->getCell( 'X'.$row )->setValue($absentUserCount);
			$rate = round($absentUserCount/$shouldUserCount,4)*100;
			$personSheet->getCell( 'Y'.$row )->setValue($rate);
			
		}
	
		//6.为本次的设置前面的学校领导评价结果返回要merge的函数
		$this->currentEvaluationSchoolLeaderCount = sizeof($standardArrayContainer);
		
	}//function getPersonResultData() end
	
	
	public function summaryResultExportAction(){
    	
    	
    	//第一步：根据上传的id[]得到数据列表
    	$request  = $this->getRequest();
    	$postData = $request->request;
    	$evaluationIdList = $postData->get('id');
    	
    	
    	//第二步：通过respository中的自定义方法查询相关信息
    	$doctrine = $this->getDoctrine();
    	$em 	  = $doctrine->getManager();
    	$evaluationRepository = $em->getRepository('EvaluationCommonBundle:Evaluation');
    	$evaluationList 	  = $evaluationRepository->findEvaluationById($evaluationIdList);
    	
    	
    	 
    	//第三步: 利用phpexcel输出到excel中
    	/**
    	 因为之前才用fromArray读取excel数据表，得到的合并单元格的内容为null
    	 但是还原的时候使用toArray却不能争取的还原
    	 所以从excel中读取单元格的格式作为模版，然后再填充数值，
    	 但是保存的时候不save到文件中，而是save到php://output里面
    	 	
    	 */
    	 
    	$phpExcelReader = new \PHPExcel_Reader_Excel5();
    	$phpExcel = $phpExcelReader->load('excel-template/summary.xls');
    	
    	foreach($evaluationList as $element){
    		
    		$id = $element['id'];
    		
    		//对excel数据表中的学校领导每个的数据进行设置
    		$this->setPersonSheet($phpExcel, $id);
    		
    		//对excel数据表中的学校情况进行设置
    		$this->setSchoolSheet($phpExcel, $id);
    		
    	}//foreach end
    	
    	
    	
    	 
    	$phpExcelWriter = new \PHPExcel_Writer_Excel5($phpExcel);
    	 
    	//1.查询相关的信息，组成文件名
    	$filename = urlencode('民主评价结果汇总.xls');
    	
    	//2.设置header信息
    	header("Content-Type: application/force-download");
    	header("Content-Type: application/octet-stream");
    	header("Content-Type: application/download");
    	header('Content-Disposition:inline;filename="'.$filename.'"');
    	header("Content-Transfer-Encoding: binary");
    	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    	header("Cache-Control: must-revalidate, post-check=0, s-check=0");
    	header("Pragma: no-cache");
    	 
    	//3.phpExcel将对象保存到缓存之中
    	$phpExcelWriter->save('php://output');
    	
    	exit();
    }
    
    
    
    
    
    
    
}
