<?php
namespace Evaluation\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvaluatedPersonType extends AbstractType
{
	
	public function __construct($doctrine){
		$this->doctrine = $doctrine;
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		
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
														'class'=>'form-control select2me'
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
		
		$builder->add('position','text',array(
											'attr'=>array(
													'placeholder'=>'请填写测评对象的职位，长度不要超过10个字',
													'class'=>'form-control'
											),//attr end
										)//position option end
					 );
	
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'evaluated_person_form';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Evaluation\CommonBundle\Entity\EvaluatedPerson',
		));
	}
	

}