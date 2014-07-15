<?php
namespace Evaluation\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvaluateJoinType extends AbstractType
{
	public function __construct($doctrine){
		$this->doctrine = $doctrine;
	}
	
	
	
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		
		//第二步:查询该民主评价的相关的参与人员列表
		$entityManager = $this->doctrine->getManager();
		$evaluationId = $options['attr']['evaluation_id'];
		$evaluationRespository = $entityManager->getRepository('EvaluationCommonBundle:Evaluation');
		
		$evaluation = $evaluationRespository->find($evaluationId);
		$evaluatedPerson = $evaluation->getEvaluatedPerson();
		$evaluatedPersonIdList = unserialize($evaluatedPerson);
		
		print_r($evaluatedPersonIdList);
		
		//第二步：使用build的add方法向表单中添加元素
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
		return 'evaluate_join_form';
	}
	
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Evaluation\CommonBundle\Entity\EvaluatedPerson',
		));
	}
	
	
	
	
	

}