<?php
namespace Evaluation\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AdminUserType extends AbstractType
{
	
	public function __construct(){
		
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//第一步：设置表单的基本属性,从控制器中中设置变成在这里设置
		$builder->setMethod('post');
		
		$builder->add('username','text',array(
												'attr'=>array(
														'placeholder'=>'只能由英文字母和阿拉伯数字组成，长度不超过10个字符',
														'class'=>'form-control'
												),//attr end
										)//position option end
		);
		
		$builder->add('password','text',array(
												'attr'=>array(
													  'placeholder'=>'只能由英文字母和阿拉伯数字组成，长度不超过20个字符',
													  'class'=>'form-control'
												 ),//attr end
												
											 )//realname option end
					 );
		
		
		$builder->add('realname','text',array(
											'attr'=>array(
													'placeholder'=>'请填写管理员的真实姓名',
													'class'=>'form-control'
											),//attr end
										)//position option end
					 );
	
	}//function buildForm() end
	
	
	public function getName()
	{
		return 'admin_user_form';
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'Evaluation\CommonBundle\Entity\AdminUser',
				
		));
	}
	
	
	
	
	

}