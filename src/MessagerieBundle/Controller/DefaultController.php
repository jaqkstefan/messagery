<?php

namespace MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use MessagerieBundle\Entity\Message;
use MessagerieBundle\Entity\Membre;
use MessagerieBundle\Entity\Discussion;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MessagerieBundle:Default:index.html.twig');
    }

    public function messageAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté!');

        if($request->isXMLHttpRequest()) {
            if($request->isMethod('POST')) {
                $content = $request->getContent();
                $content = json_decode($content, true);
                $message = new Message;
                $message->setSender($this->getUser());
                $hasFile = false;
                if($request->files->has('file')) {
                    $message->setFile($request->files->get('file'));
                    $hasFile = true;
                }
                $message->setContent($content['content']);
                
                $receiver = $content['receiver'];
                $discussion = $content['discussion'];
                if($hasFile) {
                    $message->setContent($request->request->get('content'));
                    $discussion = $request->request->get('discussion');
                    $receiver = $request->request->get('receiver');
                }

                $em = $this->getDoctrine()->getManager();
                if($receiver) {
                    $receiver = $em->getRepository(Membre::class)->findOneById($receiver);
                    if($discussion)
                        $discussion = $em->getRepository(Discussion::class)->findOneById($discussion);
                    if(!$discussion){
                        $discussion = $em->getRepository(Discussion::class)->findOneBy(['member' => $receiver, 'creator' => $this->getUser()]);
                        if(!$discussion) {
                            $discussion = new Discussion;
                            $discussion->setCreator($this->getUser());
                        }
                    }
                    $discussion->setMember($receiver);
                    $message->setDiscussion($discussion);
                    $message->setReceiver($receiver);
                    $discussion->setLastMessage($message);
                    $em->persist($message);
                    $em->persist($discussion);
                    $em->flush();

                    return new JsonResponse(['message' => $message, 'discussion' => $discussion]);
                }else{
                    return new Response('Destinataire '.$receiver.' non défini ou non trouvé.', 500);
                }
            }else{
                return new Response('Méthode de la requête non autorisée.', 500);
            }
        }else{
            return new Response('Requête HTTP non autorisée.', 500);
        }
    }

    public function messagesAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté!');

        if($request->isXMLHttpRequest()) {
            if($request->isMethod('GET')) {
                $em = $this->getDoctrine()->getManager();
                
                $discussion = $request->query->get('discussion');
                $order = $request->query->get('order');

                if($discussion) {
                    if(!$order) {
                        $dql = 'SELECT m FROM MessagerieBundle:Message m WHERE m.discussion = :discussion AND m.sender <> :sender AND m.seen = 0 ORDER BY m.id ASC';
                        $query = $em->createQuery($dql)
                                    ->setParameter('discussion', $discussion)
                                    ->setParameter('sender', $this->getUser()->getId());
                        
                    }else{
                        $dql = 'SELECT m FROM MessagerieBundle:Message m WHERE m.discussion = :discussion ORDER BY m.id ASC';
                        $query = $em->createQuery($dql)
                                    ->setParameter('discussion', $discussion);
                    }
                    $messages = $query->getResult();
                    $ids = [];
                    foreach ($messages as $key => $message) {
                        if(!$message->getSeen())
                            $ids[] = $message;
                    }
                    if(count($ids) > 0) {
                        $now = new \DateTime;
                        foreach ($ids as $key => $message) {
                            $message->setSeen(true);
                            $message->setSeenAt($now);
                            $em->persist($message);
                        }
                        $em->flush();
                    }
                    

                    return new JsonResponse(['messages' => $messages, 'updates' => $ids]);
                }else{
                    return new Response('Discussion non définie ou non trouvée.', 500);
                }
                
            }else{
                return new Response('Méthode de la requête non autorisée.', 500);
            }
        }else{
            return new Response('Requête HTTP non autorisée.', 500);
        }
    }

    public function seenAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté!');

        if($request->isXMLHttpRequest()) {
            if($request->isMethod('GET')) {
                $em = $this->getDoctrine()->getManager();
                
                $discussion = $request->query->get('discussion');

                if($discussion) {
                    $dql = 'SELECT m FROM MessagerieBundle:Message m WHERE m.discussion = :discussion AND m.sender <> :sender AND m.seen = 1 ORDER BY m.id ASC';
                    $query = $em->createQuery($dql)
                                ->setParameter('discussion', $discussion)
                                ->setParameter('sender', $this->getUser()->getId());
                    $messages = $query->getResult();
                    $seen = [];
                    $past = new \DateTime();
                    $past->modify('-10 minute');
                    foreach ($messages as $key => $message) {
                        if($message->getSeenAt() && $message->getSeenAt() <= $past) {
                            $seen[] = $message;
                        }
                    }
                    return new JsonResponse(['messages' => $seen]);
                }else{
                    return new Response('Discussion non définie ou non trouvée.', 500);
                }
                
            }else{
                return new Response('Méthode de la requête non autorisée.', 500);
            }
        }else{
            return new Response('Requête HTTP non autorisée.', 500);
        }
    }
    
    public function discussionsAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté!');

            if($request->isMethod('GET')) {
                $em = $this->getDoctrine()->getManager();
                
                $user = $this->getUser();
                $user->setLastOnline(new \DateTime);
                $em->persist($user);

                $em->flush();
                $dql = 'SELECT d FROM MessagerieBundle:Discussion d WHERE d.member = :user OR d.creator = :user ORDER BY d.id DESC';
                $query = $em->createQuery($dql)
                            ->setParameter('user', $this->getUser()->getId());
                    
                $discussions = $query->getResult();

                $onlines = [];
                $past = new \DateTime();
                $past->modify('-10 minute');

                foreach ($discussions as $key => $discussion) {
                    if($discussion->getMember()->getId() != $user->getId()) {
                        if($discussion->getMember()->getLastLogin() <= $past) {
                            $onlines[] = $discussion;
                        }
                    }else{
                        if($discussion->getCreator()->getLastLogin() <= $past) {
                            $onlines[] = $discussion;
                        }
                    }
                }

                return new JsonResponse(['onlines' => $onlines, 'discussions' => $discussions, 'past' => $past]);
            }else{
                return new Response('Méthode de la requête non autorisée.', 500);
            }
    }
    
    public function membersAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté!');

        if($request->isXMLHttpRequest()) {
            if($request->isMethod('GET')) {
                $em = $this->getDoctrine()->getManager();
                
                $user = $this->getUser();
                $user->setLastOnline(new \DateTime);
                $em->persist($user);

                $members = $em->getRepository(Membre::class)->findAll();
                $m = [];
                foreach ($members as $key => $member) {
                    if($member->getId() != $this->getUser()->getId())
                        $m[] = $member;
                }

                $em->flush();

                return new JsonResponse(['members' => $m]);
            }else{
                return new Response('Méthode de la requête non autorisée.', 500);
            }
        }else{
            return new Response('Requête HTTP non autorisée.', 500);
        }
    }
}
