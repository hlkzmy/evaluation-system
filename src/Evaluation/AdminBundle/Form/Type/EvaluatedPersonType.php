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
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		$builder->setAttribute('class', 'post-data-form');
		
		//对于怎么根据路由设置action的方法现在还不知道，不知道依赖注入要哪个服务才能调用generateUrl这个方法
		
		
		//第二步:对于choice模块这种需要装载选项的元素,通过依赖注入的方法填充数据
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