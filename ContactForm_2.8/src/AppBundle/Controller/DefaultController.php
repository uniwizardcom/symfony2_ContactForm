<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ContactType;
use AppBundle\Entity\Messages;

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
				$messages = new Messages();
				$messages->setEmail($form->get('email')->getData());
				$messages->setIp($request->getClientIp());
				$messages->setSubject($form->get('subject')->getData());
				$messages->setMessage($form->get('message')->getData());
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($messages);
				$em->flush();
				
				$message = \Swift_Message::newInstance()
				->setSubject($form->get('subject')->getData())
				->setFrom($form->get('email')->getData())
				//->setTo('Piotr.Gradzinski@vml.com')
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
				
				
				return $this->redirect($this->generateUrl('thankyou'));
				//return $this->redirect($this->generateUrl('contact'));
			}
		}
		
		return $this->render(
				"AppBundle:Default:form.html.twig",
				['form' => $form->createView()]
			);
	}
	
	/**
	 * @Route("/thankyou", _name="thankyou")
	 */
	public function thankyouAction(Request $request) {
		return $this->render("AppBundle:Default:thankyou.html.twig");
	}
}
