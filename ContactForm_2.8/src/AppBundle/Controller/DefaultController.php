<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ContactType;

class DefaultController extends Controller {
	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction(Request $request) {
		return $this->render('default/index.html.twig', [
				'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}
	
	/**
	 * @Route("/contact", _name="contact")
	 */
	public function contactAction(Request $request) {
		$form = $this->createForm(new ContactType());
	
		if($request->isMethod('POST')) {
			$form->bind($request);
	
			if($form->isValid()) {
				$message = \Swift_Message::newInstance()
				->setSubject($form->get('subject')->getData())
				->setFrom($form->get('email')->getData())
				->setTo('niewiadomski.wojciech@gmail.com')
				->setBody(
						$this->renderView(
								'AppBundle:Mail:contact.html.twig', [
										'ip' => $request->getClientIp(),
										'name' => $form->get('name')->getData(),
										'message' => $form->get('message')->getData()
								]
							)
						);
	
				$this->get('mailer')->send($message);
				$request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');
	
				return $this->redirect($this->generateUrl('contact'));
			}
		}
		
		return $this->render(
				"AppBundle:Default:form.html.twig",
				['form' => $form->createView()]
			);
	}
}
