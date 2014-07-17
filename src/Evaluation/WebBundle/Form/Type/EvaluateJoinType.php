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
	public function __construct($router){
		$this->router = $router;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		$builder->setAction($this->router->generate('evaluation_evaluate_submit') );
		
		
		//第二步：添加表单的相关元素
		//1.添加民主评价的名称
		$builder->add('name','text');
		
		//2.添加类型为fieldType的表单元素，是学校评价结果的嵌套表单
		$builder->add('schoolResult',new EvaluatedSchoolResultType() );
		
		//3.添加类型为collection的表单元素，是测评人对测评对象的嵌套表单
		$builder->add('personResult','collection',array(
												 'type'=>new EvaluatedPersonResultType(),
												 'by_reference'=>true,
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
			'cascade_validation'=>true
		));
	}
	
	
	
	
	

}