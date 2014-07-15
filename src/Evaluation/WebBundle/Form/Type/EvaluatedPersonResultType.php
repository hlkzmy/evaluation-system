<?php
namespace Evaluation\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EvaluatedPersonResultType extends AbstractType
{
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('score','text');
		
		$builder->add('evaluated_person_realname','text');
		
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