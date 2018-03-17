<?php

namespace MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
	{
	    $authenticationUtils = $this->get('security.authentication_utils');

	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();

	    return $this->render(
	        'MessagerieBundle:Security:login.html.twig',
	        array(
	            // last username entered by the user
	            'last_username' => $lastUsername,
	            'error'         => $error,
	        )
	    );
	}

	public function checkAction()
	{
		throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
	}


	public function logoutAction()
	{
		throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
	}

    public function createAction(Request $request, $username, $firstname, $lastname, $password)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new \MessagerieBundle\Entity\Membre;
        $user->setSurname($firstname);
        $user->setName($lastname);
        $user->setUsername($username);
        $password = $this->get('security.password_encoder')->encodePassword($user, $password);
        $user->setPassword($password);
        $roles = ['ROLE_USER'];
        $roles[] = 'ROLE_MANAGER';
        $roles[] = 'ROLE_ADMIN';
        $user->setRoles($roles);

        $em->persist($user);
        $em->flush();

        return new Response("New admin $username created.");

    }
}
