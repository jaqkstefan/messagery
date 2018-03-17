<?php

namespace Msg\MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Msg\MessagerieBundle\Repository\MessageRepository")
 */
class Message
{

    /**
    * @ORM\ManyToOne(targetEntity="Msg\MessagerieBundle\Entity\Membre",
    inversedBy="messages")
    * @ORM\JoinColumn(nullable=false)
    */
    private $membre;

    /**
    * @ORM\ManyToOne(targetEntity="Msg\MessagerieBundle\Entity\Discussion",
    inversedBy="messages", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $discussion;
   
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSend", type="datetime")
     */
    private $dateSend;

    /**
     * @var int
     *
     * @ORM\Column(name="destinataire_id", type="integer")
     */
    private $destinataireId;

    /**
     * @var int
     *
     * @ORM\Column(name="destinateur_id", type="integer")
     */
    private $destinateurId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set dateSend
     *
     * @param \DateTime $dateSend
     *
     * @return Message
     */
    public function setDateSend($dateSend)
    {
        $this->dateSend = $dateSend;

        return $this;
    }

    /**
     * Get dateSend
     *
     * @return \DateTime
     */
    public function getDateSend()
    {
        return $this->dateSend;
    }


    /**
     * Set destinataireId
     *
     * @param integer $destinataireId
     *
     * @return Message
     */
    public function setDestinataireId($destinataireId)
    {
        $this->destinataireId = $destinataireId;

        return $this;
    }

    /**
     * Get destinataireId
     *
     * @return int
     */
    public function getDestinataireId()
    {
        return $this->destinataireId;
    }

    /**
     * Set destinateurId
     *
     * @param integer $destinateurId
     *
     * @return Message
     */
    public function setDestinateurId($destinateurId)
    {
        $this->destinateurId = $destinateurId;

        return $this;
    }

    /**
     * Get destinateurId
     *
     * @return int
     */
    public function getDestinateurId()
    {
        return $this->destinateurId;
    }

    /**
     * Set message
     *
     * @param \Msg\MessagerieBundle\Entity\Message $message
     *
     * @return Message
     */
    public function setMessage(\Msg\MessagerieBundle\Entity\Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \Msg\MessagerieBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set discussion
     *
     * @param \Msg\MessagerieBundle\Entity\Discussion $discussion
     *
     * @return Message
     */
    public function setDiscussion(\Msg\MessagerieBundle\Entity\Discussion $discussion)
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * Get discussion
     *  
     * @return \Msg\MessagerieBundle\Entity\Discussion
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * Set membre
     *
     * @param \Msg\MessagerieBundle\Entity\Membre $membre
     *
     * @return Message
     */
    public function setMembre(\Msg\MessagerieBundle\Entity\Membre $membre)
    {
        $this->membre = $membre;

        return $this;
    }

    /**
     * Get membre
     *
     * @return \Msg\MessagerieBundle\Entity\Membre
     */
    public function getMembre()
    {
        return $this->membre;
    }
}
