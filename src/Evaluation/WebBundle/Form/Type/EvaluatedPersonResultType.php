<?php
namespace Evaluation\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EvaluatedPersonResultType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
// 		$choiceOptions = array('1'=>'优秀','2'=>'称职','3'=>'基本称职','4'=>'不称职');
		
// 		$builder->add('score','choice',array(
// 												'attr'=>array(
// 														'class'=>'form-control select2me'
// 												 ),//attr end
												 
// 											'choices'   => $choiceOptions,
// 											'empty_value' => '请选择您的评价',
// 											'empty_data'  => null
// 					));
		
		
		$builder->add('score','text');
		
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'evaluated_person_result_form';
	}
	
		public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Evaluation\CommonBundle\Entity\EvaluatedPersonResult',
		));
	}
	
}