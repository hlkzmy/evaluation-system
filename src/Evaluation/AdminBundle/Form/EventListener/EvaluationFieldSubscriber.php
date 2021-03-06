<?php


namespace Evaluation\AdminBundle\Form\EventListener;
//namespace Acme\DemoBundle\Form\EventListener;


//加载表单事件相关的类
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EvaluationFieldSubscriber implements EventSubscriberInterface {
	
	private $schoolChoiceOptions = null;
	
	private $personChoiceOptions = null;
	
	public function setSchoolChoiceOptions($options){
		$this->schoolChoiceOptions = $options;
	}
	
	public function setPersonChoiceOptions($options){
		$this->personChoiceOptions = $options;
	}
	
	public static function getSubscribedEvents() {
		
		return array (
				
				//1.【形成编辑页面视图】  和【形成新增页面视图】 的时候触发的函数
				FormEvents::PRE_SET_DATA => 'preSetData',
				//PRE_SET_DATA绑定的回调函数是preSetData
				
				//2.【检测编辑页面数据】  和【 检测新增页面数据】的时候触发的函数
				FormEvents::PRE_SUBMIT   => 'preSubmit'
				//PRE_SUBMIT绑定的回调函数是preSubmit
		);
	}
	
	public function preSubmit(FormEvent $event){
		
		$form       = $event->getForm();
		$evaluation = $form->getData();
		
		if ( $evaluation && !is_null( $evaluation->getId ()) ) {
			$form->remove('school_id');
			$form->remove('name');
			$form->remove('evaluate_user_count');
		}
		
	}
	
	
	public function preSetData(FormEvent $event) {
		
		$form       = $event->getForm();
		$evaluation = $event->getData();
		
		//第一部分：建立表单元素中公共部分的options
		$nameOptions = array(
								'attr'=>array(
												'placeholder'=>'请民主评价的名称，长度不要超过20个字',
												'class'=>'form-control'
								 ),//attr end
							);//name option end
		
		$schoolIdOptions = array(
								'attr'=>array(
										'placeholder'=>'请民主评价的名称，长度不要超过20个字',
										'class'=>'form-control select2me'
								),//attr end
								'choices'   => $this->schoolChoiceOptions
							);
		
		$evaluateUserCountOptions = array(
										'attr'=>array(
												'placeholder'=>'请填写民主评价的参与人数,数值为正整数',
												'class'=>'form-control'
										),//attr end
					 		);//evaluate_user_count option end
		
		
		if ( $evaluation && !is_null( $evaluation->getId ()) ) {
		//编辑教学评价的时候
		
 			$nameOptions['attr']['disabled'] = 'disabled';
 			$schoolIdOptions['attr']['disabled'] = 'disabled';
			$evaluateUserCountOptions['attr']['disabled'] = 'disabled';

		}//if end
		else{//创建教学评价的时候
			
			$evaluatedPersonOptions = array(
													'attr'=>array(
																	'placeholder'=>'请选择该测评单位的测评对象',
																	'class'=>'form-control select2me',
																	'multiple'=>'multiple'
													),//attr end
													'multiple'=>true,
													'choices'   => $this->personChoiceOptions,
										  );//evaluated_person option end
			
			$form->add('evaluated_person','choice',$evaluatedPersonOptions);
			
		}//else end
		
		$form->add('name','text',$nameOptions);
		$form->add('school_id','choice',$schoolIdOptions);
		$form->add('evaluate_user_count','text',$evaluateUserCountOptions);
		
	}
	
	
}