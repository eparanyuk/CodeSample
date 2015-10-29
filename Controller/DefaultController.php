<?php

namespace CeBundle\Controller;

use CeBundle\Entity\Email;
use CeBundle\Event\EmailEvent;
use CeBundle\CeEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('ce_email_collector');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $value = $form->get('email')->getData();
            $email = $this->getDoctrine()->getRepository('CeBundle:Email')->findOneBy(['email' => $value,]);

            if (! $email) {
                $email = new Email();
                $email->setEmail($value);
                $em = $this->getDoctrine()->getManager();
                $em->persist($email);
                $em->flush();

                $this->get('event_dispatcher')->dispatch(
                    CeEvents::EMAIL_ADDED, new EmailEvent($email)
                );
            }

            if ($email->getIsConfirm()) {
                $request->getSession()->getFlashBag()->add('error', 'collector_already_confirmed');
            } else {
                $request->getSession()->getFlashBag()->add('success', 'collector_send_confirmation');
            }
        }

        return $this->render('CeBundle::index.html.twig', array(
            'subscribe_form' => $form->createView(),
        ));
    }

    /**
     * @Route("/confirm/", name="subscribe_confirm")
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function subscribeAction(Request $request)
    {
        $message = 'collector_confirm_error';
        $status = 'error';
        $em = $this->getDoctrine()->getManager();
        $email = $em->getRepository('CeBundle:Email')->getEmailByToken($request->get('token'));
        if ($email) {
            $message = 'collector_skip_confirmition';
            $status = 'success';

            $email->setIsConfirm(true);
            $em->persist($email);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add($status, $message);

        return new RedirectResponse($this->generateUrl('homepage'));
    }
}