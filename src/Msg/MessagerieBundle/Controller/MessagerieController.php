<?php

namespace Msg\MessagerieBundle\Controller;

use Msg\MessagerieBundle\Entity\Membre;
use Msg\MessagerieBundle\Entity\Message;
use Msg\MessagerieBundle\Entity\Discussion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MessagerieController extends Controller{

    public function messagerieAction(){
    	/* s'assurer qu'une session est ouverte avant de lancer la messagerie */
			$session = $this->get('session');
			$session->set('membreEnLigne', 1);
        return $this->render('MsgMessagerieBundle:Messagerie:index.html.twig');
    }

    public function getMembreSessionAction(Request $request){
    	$em = $this->getDoctrine()->getManager();
		/* ce id doit etre le id de l'utilisateur ou du membre de la session  en cour (récuperé automatiquement lors de l'autentification)*/
		$id=$this->get('session')->get('membreEnLigne');
		//$id = $this->get('session')->get('membreEnLigne',1);

		/*dans mon implementation, le nom de la session est membreEnLigne, qui a pour valeur l'id du membre connecté*/
	    $RAW_QUERY = 'SELECT * FROM membre WHERE membre.id = :id;';
        $membre = $em->getConnection()->prepare($RAW_QUERY);
        $membre->bindValue('id', $id);
        $membre->execute();
        $membre = $membre->fetch();
        return new Response(json_encode($membre));
    }

    public function answerMessageAction(Request $request){
    	$data = json_decode($request->getContent(), true);
    	$em = $this->getDoctrine()->getManager();

        if($request->isXMLHttpRequest()){
        $RAW_QUERY = 'SELECT * FROM message WHERE message.discussion_id = :discussionId AND message.id >:idLastMsg AND message.destinateur_id = :destinataireCurId;';
        $allpost = $em->getConnection()->prepare($RAW_QUERY);
        $allpost->bindValue('discussionId',$request->get("idDisc"));
        $allpost->bindValue('idLastMsg', $request->get("idLastMsgDisc"));
        $allpost->bindValue('destinataireCurId', $request->get("destinataireCurId"));
        $allpost->execute();
        $allpost = $allpost->fetchAll();
        $msgParse = [];
        foreach ($allpost as $post) {
        	$msgItem = [];
        	$destinateur = $em->getRepository('MsgMessagerieBundle:Membre')->find($post['destinateur_id']);
        	$msgItem['id']=$post['id'];
        	$msgItem['dateSend']=$post['dateSend'];
        	$msgItem['contenu']=$post['contenu'];
        	$msgItem['destinateur']= array('username' => $destinateur->getUsername(), 
	        	'avatar'=>$destinateur->getAvatar());
        	$msgParse[] = $msgItem;
        }
            return new Response(json_encode($msgParse));
        }else
            return new response("n est pas une requete de type XMLHttpRequest");
    }

    public function getAllMembresAction(Request $request){
		$em = $this->getDoctrine()->getManager();
	    $RAW_QUERY = 'SELECT * FROM membre;';
        $membres = $em->getConnection()->prepare($RAW_QUERY);
        $membres->execute();
        $membres = $membres->fetchAll();
        return new Response(json_encode($membres));
    }
/*
    public function getAllDiscussionAction(Request $request){
    	$em = $this->getDoctrine()->getManager();
        if($request->isXMLHttpRequest()){
	        $discussions = $em->getRepository('MsgMessagerieBundle:Discussion')->findAll();
	        $discussionsParse = [];
	        foreach ($discussions as $discussion) {
	        	$allMsg = $discussion->getMessages();
	        	$lastMsg = "";
	        	foreach ($allMsg as $msg) {
	        		$lastMsg = $msg->getContenu();
	        	}

	        	foreach ($allMsg as $msg) {
		        	$destinataire = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinataireId());	       
	        	$discussionsParse[] = array('date'=>$discussion->getDate(),
	        								'nombre_messages'=>count($allMsg),
	        								'last_message'=>$lastMsg,
	        								'messages'=> array('destinataire'=>array('id'=>$destinataire->getId(), 'username'=> $destinataire->getUsername(),
	        									'avatar'=> $destinataire->getAvatar())));		        	
	        		break;
	        	}

	        }

            return new Response(json_encode($discussionsParse));
        }else
            return new response("n est pas une requete de type XMLHttpRequest");
    }
*/
    public function getDiscussionsMembreAction(Request $request){
    	$em = $this->getDoctrine()->getManager();
    	$discussions = $em->getRepository('MsgMessagerieBundle:Discussion')->findAll();
    	$membreCur = $em->getRepository('MsgMessagerieBundle:Membre')->find( $this->get('session')->get('membreEnLigne'));

        $discussionsParse = [];
        foreach ($discussions as $discussion) {
        	$allMsg = $discussion->getMessages();
        	$lastMsg = "";
        	$destinataire = new Membre();
        	foreach ($allMsg as $msg) {
        		if( $msg->getDestinateurId() == $membreCur->getId() || $msg->getDestinataireId() == $membreCur->getId()){
	        		$destinateur = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinateurId());
	        		$destinataire = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinataireId());
	        		$lastMsg = $msg->getContenu();
	        		$messageDisc[] = array('id'=>$msg->getId(), 'contenu'=> $msg->getContenu(), 'dateSend'=>$msg->getDateSend(),
	        			'destinateur'=>array('id'=>$destinateur->getId(), 'avatar'=>$destinateur->getAvatar(),
	        				'username'=>$destinateur->getUsername()),
	        			'destinataire'=>array('id'=>$destinataire->getId()));
        		}
        	}
        	foreach ($allMsg as $msg){
        		if( $msg->getDestinateurId() == $membreCur->getId() || $msg->getDestinataireId() == $membreCur->getId()){
	        		if($msg->getDestinataireId() == $membreCur->getId())
	        			$destinataire = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinateurId());  
	        		else
	        			$destinataire = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinataireId());
	    			$discussionsParse[] = array('id'=>$discussion->getId() , 
	    				'date'=>$discussion->getDate(),
									'nombre_messages'=>count($allMsg),
									'last_message'=>$lastMsg,
									'interlocuteur'=>array('id'=>$destinataire->getId(), 'username'=> $destinataire->getUsername(), 'avatar'=> $destinataire->getAvatar()),
									'messages' => $messageDisc);
									$messageDisc = [];			        		
	        	}
        		break;
        	}
        }

        return new Response(json_encode($discussionsParse));
     
    }

    public function getMessageDiscussionAction(Request $request){
    	$em = $this->getDoctrine()->getManager();
    	$allDiscussion = $em->getRepository('MsgMessagerieBundle:Discussion')->findAll();
    	$membreCur = $em->getRepository('MsgMessagerieBundle:Membre')->find( $this->get('session')->get('membreEnLigne'));

        if($request->isXMLHttpRequest()){
	        $id = $request->get("id");
	        $membreRecept = $em->getRepository('MsgMessagerieBundle:Membre')->find($id);
	        
	        foreach($allDiscussion as $disc){
	            $messageite = $disc->getMessages();
	            foreach ($messageite as $messageitem) {
	                if( $messageitem->getDestinateurId() == $membreCur->getId() && $messageitem->getDestinataireId() == $membreRecept->getId()){
	                	$messageParse = [];
	                	foreach ($messageite as $msg) {
		                	
		                	$destinateur = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinateurId());
		                	$messageParse[] = array('date'=>$msg->getDateSend(), 'contenu'=> $msg->getContenu(), 'destinateur'=>array('id'=> $destinateur->getId(),
		                		'username'=>$destinateur->getUsername(), 'avatar'=>$destinateur->getAvatar()));
	                	}
	                	return new Response(json_encode($messageParse));

	                }// reponse de recepteur en cour qui devient le destinataire
	                elseif( $messageitem->getDestinateurId() == $membreRecept->getId() && $messageitem->getDestinataireId() == $membreCur->getId()){
	                	$messageParse = [];
	                	foreach ($messageite as $msg) {

		                	$destinateur = $em->getRepository('MsgMessagerieBundle:Membre')->find($msg->getDestinateurId());
		                	$messageParse[] = array('date'=>$msg->getDateSend(), 'contenu'=> $msg->getContenu(), 'destinateur'=>array('id'=> $destinateur->getId(),
		                		'username'=>$destinateur->getUsername(), 'avatar'=>$destinateur->getAvatar()));
	                	}

	                    return new Response(json_encode($messageParse));
	                }
	                else;               
	                break;
	            }
	        }
	        return new Response(json_encode([]));
        }else
            return new response("n est pas une requete de type XMLHttpRequest");
    }

    public function sendMessageAction(Request $request){
    	$data = json_decode($request->getContent(), true);
    	$message = new Message();
    	$discussion = new Discussion();
    	$em = $this->getDoctrine()->getManager();
        $allMessage = $em->getRepository('MsgMessagerieBundle:Message')->findAll();
        $allDiscussion = $em->getRepository('MsgMessagerieBundle:Discussion')->findAll();
        $membreCur = $em->getRepository('MsgMessagerieBundle:Membre')->find( $this->get('session')->get('membreEnLigne'));
        $membreRecept = $em->getRepository('MsgMessagerieBundle:Membre')->find($data['idDestinataire']);

		$message->setContenu($data['message']);
		$message->setDateSend(new \Datetime());
		$message->setDestinateurId($membreCur->getId());
		$message->setDestinataireId($membreRecept->getId());

        $trouv = false;
        foreach($allDiscussion as $disc){
            $messageite = $disc->getMessages();
            foreach ($messageite as $messageitem) {
                if( $messageitem->getDestinateurId() == $membreCur->getId() && $messageitem->getDestinataireId() == $membreRecept->getId()){
                    $discExit = $em->getRepository('MsgMessagerieBundle:Discussion')->find($messageitem->getDiscussion()->getId());
                    $discExit->addMessage($message);
                    $trouv = true;
                }// reponse de recepteur en cour qui devient le destinataire
                elseif( $messageitem->getDestinateurId() == $membreRecept->getId() && $messageitem->getDestinataireId() == $membreCur->getId()){
                    $discExit = $em->getRepository('MsgMessagerieBundle:Discussion')->find($messageitem->getDiscussion()->getId());
                    $discExit->addMessage($message);
                    $trouv = true;
                }
                else;               
                break;
            }
            if($trouv)
                break;
        }

        if(!$trouv){
            $discussion->setDate(new \Datetime());
            $discussion->addMessage($message);
            
            $em->persist($discussion);
        }
		$membreCur->addMessage($message);
        $em->persist($message);
        $em->flush();
		 /* on recupere le message que l'on vient d'envoyer*/
	    $RAW_QUERY = 'SELECT * FROM message WHERE message.destinateur_id = :destinateurId ORDER BY id DESC;';
        $allpost = $em->getConnection()->prepare($RAW_QUERY);
        $allpost->bindValue('destinateurId', $this->get('session')->get('membreEnLigne'));
        $allpost->execute();
        $allpost = $allpost->fetchAll();
        $lastpost = $allpost[0];
		$response = new Response(json_encode($lastpost));
		$response->headers->set('Content-Type', 'application/json');
		return $response;    		
    }

    /*
    public function findDiscussion(){
        $em = $this->getDoctrine()->getManager();
        $allDiscussion = $em->getRepository('MsgMessagerieBundle:Discussion')->findAll();
        $membreCur = $em->getRepository('MsgMessagerieBundle:Membre')->find(11);
        $membreRecept = $em->getRepository('MsgMessagerieBundle:Membre')->find(7);
        foreach($allDiscussion as $disc){
            $messageite = $disc->getMessages();
            foreach ($messageite as $messageitem) {
                if( $messageitem->getDestinateurId() == $membreCur->getId() && $messageitem->getDestinataireId() == $membreRecept->getId()){
                    $discExit = $em->getRepository('MsgMessagerieBundle:Discussion')->find($messageitem->getDiscussion()->getId());
                    return $discExit;
                }// reponse de recepteur en cour qui devient le destinataire
                elseif( $messageitem->getDestinateurId() == $membreRecept->getId() && $messageitem->getDestinataireId() == $membreCur->getId()){
                    $discExit = $em->getRepository('MsgMessagerieBundle:Discussion')->find($messageitem->getDiscussion()->getId());
                    $discExit->addMessage($message);
                    return $discExit;
                }
                else;  
            }
        }
        return false;
    }
    */
}
