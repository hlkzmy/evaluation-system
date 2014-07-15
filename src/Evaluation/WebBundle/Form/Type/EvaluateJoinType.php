<?php
namespace Evaluation\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

//加载使用到的子表单
use Evaluation\WebBundle\Form\Type\EvaluatedPersonResultType;

class EvaluateJoinType extends AbstractType
{
	public function __construct($doctrine){
		$this->doctrine = $doctrine;
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		
// 		//第二步:查询该民主评价的相关的参与人员列表
// 		$entityManager = $this->doctrine->getManager();
// 		$evaluationId = $options['attr']['evaluation_id'];
// 		$evaluationRespository = $entityManager->getRepository('EvaluationCommonBundle:Evaluation');
		
// 		$evaluation = $evaluationRespository->find($evaluationId);
// 		$evaluatedPerson = $evaluation->getEvaluatedPerson();
// 		$evaluatedPersonIdList = unserialize($evaluatedPerson);
		
		
		$builder->add('evaluatedPersonList','collection',array('type'=>new EvaluatedPersonResultType()));
		
		
// 		$builder->add('name[1]','text',array('attr'=>array ('name'=>'name[1]') ));
// // 		$builder->add('name[2]','text');
// // 		$builder->add('name[3]','text');
		
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'evaluate_join_form';
	}
	
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Evaluation\CommonBundle\Entity\Evaluation',
		));
	}
	
	
	
	
	

}