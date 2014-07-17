<?php
namespace Evaluation\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EvaluatedSchoolResultType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
		$choiceOptions = array('1'=>'好','2'=>'中','3'=>'查');
		
		$builder->add('score','choice',array(
												'attr'=>array(
														'class'=>'form-control select2me'
												 ),//attr end
												 
											'choices'   => $choiceOptions,
											'empty_value' => '请选择您对学校的评价',
											'empty_data'  => null
					));
		
		$builder->add('comment','textarea',array(
												'attr'=>array(
															'class'=>'form-control',
															'rows'=> 8
													),//attr end
											)
					 );
		
		
		
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'evaluated_school_result_form';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Evaluation\CommonBundle\Entity\EvaluatedSchoolResult',
		));
	}
	
}