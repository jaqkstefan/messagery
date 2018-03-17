<?php
namespace MessagerieBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;
    function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {

        $user = $token->getUser();
        $now = new \DateTime;
        $user->setLastLogin($now);
        $this->container->get('doctrine')->getManager()->persist($user);
        $this->container->get('doctrine')->getManager()->flush();

        return new RedirectResponse($this->container->get('router')->generate('messagerie_homepage'));
    }
}