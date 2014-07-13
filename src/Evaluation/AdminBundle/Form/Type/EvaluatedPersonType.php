<?php
namespace Evaluation\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EvaluatedPersonType extends AbstractType
{
	
	public function __construct($doctrine){
		$this->doctrine = $doctrine;
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		//第一步:对于choice模块这种需要装载选项的元素,通过依赖注入的方法填充数据
		$entityManager = $this->doctrine->getEntityManager();
		
		$evaluateSchoolRespository = $entityManager->getRepository('EvaluationCommonBundle:EvaluateSchool');
		$evaluateSchoolList = $evaluateSchoolRespository->findAll();
		
		$schoolChoiceOptions = array();
		foreach($evaluateSchoolList as $school){
			$schoolChoiceOptions[$school->getId()] = $school->getName();
		}
		
		
		//第二步：使用build的add方法向表单中添加元素
		$builder->add('school_id','choice',array(
												  'attr'=>array(
														'class'=>'form-control'		
												   ),//attr end
												  'choices'   => $schoolChoiceOptions,
					));
		
		$builder->add('realname','text',array(
												'attr'=>array(
																'placeholder'=>'请填写测评对象的姓名，长度不要超过10个汉字',
																'class'=>'form-control'
												 ),//attr end
												
											 )//realname option end
					 );
		
		$builder->add('position');
	
	}
	
	
	public function getName()
	{
		return 'evaluated_person_form';
	}
	

}