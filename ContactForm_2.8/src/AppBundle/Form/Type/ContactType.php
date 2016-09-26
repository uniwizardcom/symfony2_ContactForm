<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name', 'text', [
					'attr' => [
							'placeholder' => 'What\'s your name?',
							'pattern'	 => '.{2,}' //minlength
					]
			])
			->add('email', 'email', [
					'attr' => [
							'placeholder' => 'So I can get back to you.'
					]
			])
			->add('subject', 'text', [
					'attr' => [
							'placeholder' => 'The subject of your message.',
							'pattern'	 => '.{3,}' //minlength
					]
			])
			->add('message', 'textarea', [
					'attr' => [
							'cols' => 90,
							'rows' => 10,
							'placeholder' => 'And your message to me...'
					]
			]);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$collectionConstraint = new Collection([
				'name' => [
						new NotBlank(['message' => 'Name should not be blank.']),
						new Length(['min' => 2])
				],
				'email' => [
						new NotBlank(['message' => 'Email should not be blank.']),
						new Email(['message' => 'Invalid email address.'])
				],
				'subject' => [
						new NotBlank(['message' => 'Subject should not be blank.']),
						new Length(['min' => 3])
				],
				'message' => [
						new NotBlank(['message' => 'Message should not be blank.']),
						new Length(['min' => 5])
				]
		]);

		$resolver->setDefaults(array(
			'constraints' => $collectionConstraint
		));
	}

	public function getName() {
		return 'contact';
	}
}
