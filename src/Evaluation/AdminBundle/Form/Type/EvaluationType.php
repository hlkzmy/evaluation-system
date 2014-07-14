<?php
namespace Evaluation\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvaluateSchoolType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		
		
		$builder->add('name','text',array(
												'attr'=>array(
																'placeholder'=>'请单位测评的名称，长度不要超过20个字',
																'class'=>'form-control'
												 ),//attr end
												
										)//realname option end
					 );
		
		$builder->add('description','textarea',array(
											'attr'=>array(
													'placeholder'=>'请单位测评的相关描述，长度不要超过100个字',
													'class'=>'form-control'
											),//attr end
										)//position option end
					 );
	
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'evaluate_school_form';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Evaluation\CommonBundle\Entity\EvaluateSchool',
		));
	}
	
	
	
	
	

}