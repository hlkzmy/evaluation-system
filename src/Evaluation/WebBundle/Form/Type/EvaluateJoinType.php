<?php
namespace Evaluation\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

//加载所使用的学校结果的实体，使用fieldType
use Evaluation\WebBundle\Form\Type\EvaluatedSchoolResultType;

//加载所使用的评价人的实体,使用colllection
use Evaluation\WebBundle\Form\Type\EvaluatedPersonResultType;


/**
 * 这个是民主评价的参与表单,提交的结果对应两张数据表
 * 第一张数据表是evaluated_school_result,一次民主评价对应一行记录
 * 所以用evaluated_school_result做表单的主体类
 * 
 * 第二张数据表是evaluated_person_result,一次民主评价对应多行记录
 * 在evaluated_school_result下添加一个ArrayCollection,
 * 不要用add方法添加元素,使用set方法添加元素,set指定的元素就是person的id
 * 
 * 
 */

class EvaluateJoinType extends AbstractType
{
	public function __construct($doctrine,$router){
		$this->doctrine = $doctrine;
		$this->router = $router;
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		$builder->setAction($this->router->generate('evaluation_evaluate_submit') );
		
		
		//第二步：设置表单的字段
		$builder->add('person','collection',array(
													'type'=>new EvaluatedPersonResultType(),
												    'by_reference'=>'false',
													'cascade_validation'=>true
												)
					);
		
		
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