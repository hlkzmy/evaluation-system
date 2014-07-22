<?php
namespace Evaluation\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvaluationType extends AbstractType
{
	
	public function __construct($doctrine){
		$this->doctrine = $doctrine;
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		
		//第二步:对于choice模块这种需要装载选项的元素,通过依赖注入的方法填充数据
		$entityManager = $this->doctrine->getManager();
		
		//1.得到学校的所有选项
		$evaluateSchoolRespository = $entityManager->getRepository('EvaluationCommonBundle:EvaluateSchool');
		$evaluateSchoolList = $evaluateSchoolRespository->findAll();
		
		$schoolChoiceOptions = array();
		foreach($evaluateSchoolList as $school){
			$schoolChoiceOptions[$school->getId()] = $school->getName();
		}
		
		//2.得到测评对象所有选项
		$evaluatedPersonRespository = $entityManager->getRepository('EvaluationCommonBundle:EvaluatedPerson');
		$evaluatedPersonList = $evaluatedPersonRespository->getPersonList();
		
		$personChoiceOptions = array();
		foreach($evaluatedPersonList as $person){
			$personChoiceOptions[$person['id']] = sprintf('%s-%s',$person['schoolName'],$person['realname']);
		}
		
		//第三步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->add('name','text',array(
												'attr'=>array(
																'placeholder'=>'请民主评价的名称，长度不要超过20个字',
																'class'=>'form-control'
												 ),//attr end
												
										)//name option end
					 );
		
		$builder->add('school_id','choice',array(
												'attr'=>array(
														'placeholder'=>'请民主评价的名称，长度不要超过20个字',
														'class'=>'form-control select2me'
												),//attr end
												'choices'   => $schoolChoiceOptions,
		
					 						)//name option end
		);
		
		$builder->add('evaluated_person','choice',array(
														'attr'=>array(
																'placeholder'=>'请选择该测评单位的测评对象',
																'class'=>'form-control select2me',
																'multiple'=>'multiple'
														),//attr end
														'multiple'=>true,
														'choices'   => $personChoiceOptions,
											  )//evaluated_person option end
		);
		
		$builder->add('start_time','text',array(
													'attr'=>array(
															'placeholder'=>'请选择民主评价的开始时间',
															'class'=>'form-control',
															'readonly'=>'readonly'
													),//attr end
										)//start_time option end
		);
		
		$builder->add('end_time','text',array(
													'attr'=>array(
															'placeholder'=>'请选择民主评价的结束时间',
															'class'=>'form-control',
															'readonly'=>'readonly'
													),//attr end
										)//end_time option end
		);
		
		$builder->add('evaluate_user_count','text',array(
													'attr'=>array(
															'placeholder'=>'请填写民主评价的参与人数,数值为正整数',
															'class'=>'form-control'
													),//attr end
					 				    )//evaluate_user_count option end
		);
		
		
		$builder->add('description','textarea',array(
													'attr'=>array(
															'placeholder'=>'请民主评价的相关描述，长度不要超过100个字',
															'class'=>'form-control'
													),//attr end
										       )//description option end
					 );
	
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'evaluation_form';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Evaluation\CommonBundle\Entity\Evaluation',
		));
	}
	
	
	
	
	

}