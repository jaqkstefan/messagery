<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\MessageRepository")
 */
class Message implements \JsonSerializable
{
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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var File
     *
     * @ORM\OneToOne(targetEntity="File", cascade={"persist", "remove"})
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="receivedAt", type="datetimetz")
     */
    private $receivedAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="seenAt", type="datetimetz", nullable=true)
     */
    private $seenAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean", nullable=true)
     */
    private $seen;

    /**
     * @var Membre
     *
     * @ORM\ManyToOne(targetEntity="Membre", inversedBy="messagesSent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @var Membre
     *
     * @ORM\ManyToOne(targetEntity="Membre", inversedBy="messagesReceived")
     * @ORM\JoinColumn(nullable=true)
     */
    private $receiver;

    /**
     * @var Discussion
     *
     * @ORM\ManyToOne(targetEntity="Discussion", inversedBy="messages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $discussion;


    public function __construct() {
        $this->receivedAt = new \DateTime;
        $this->seen = false;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set receivedAt
     *
     * @param \DateTime $receivedAt
     *
     * @return Message
     */
    public function setReceivedAt($receivedAt)
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    /**
     * Get receivedAt
     *
     * @return \DateTime
     */
    public function getReceivedAt()
    {
        return $this->receivedAt;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     *
     * @return Message
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set file
     *
     * @param \MessagerieBundle\Entity\File $file
     *
     * @return Message
     */
    public function setFile($file = null)
    {
        if($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile){
            $file = new \MessagerieBundle\Entity\File($file);
        }
        if($file != null) {
            $this->file = $file;
        }

        return $this;
    }

    /**
     * Get file
     *
     * @return \MessagerieBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set sender
     *
     * @param \MessagerieBundle\Entity\Membre $sender
     *
     * @return Message
     */
    public function setSender(\MessagerieBundle\Entity\Membre $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \MessagerieBundle\Entity\Membre
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param \MessagerieBundle\Entity\Membre $receiver
     *
     * @return Message
     */
    public function setReceiver(\MessagerieBundle\Entity\Membre $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \MessagerieBundle\Entity\Membre
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set discussion
     *
     * @param \MessagerieBundle\Entity\Discussion $discussion
     *
     * @return Message
     */
    public function setDiscussion(\MessagerieBundle\Entity\Discussion $discussion = null)
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * Get discussion
     *
     * @return \MessagerieBundle\Entity\Discussion
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    public function jsonSerialize($reserve = false) {
        $obj = [];
        $obj['id'] = $this->getId();
        $obj['content'] = $this->getContent();
        $obj['seen'] = $this->getSeen();
        if($this->file)
            $obj['file'] = $this->file;
        if($this->sender)
            $obj['sender'] = $this->sender;
        if($this->receiver)
            $obj['receiver'] = $this->receiver;
        if($this->discussion && !$reserve)
            $obj['discussion'] = $this->discussion->jsonSerialize(true);
        if($this->receivedAt)
            $obj['receivedAt'] = $this->receivedAt->format(\DateTime::ISO8601);
        
        return $obj;
    }

    /**
     * Set seenAt
     *
     * @param \DateTime $seenAt
     *
     * @return Message
     */
    public function setSeenAt($seenAt)
    {
        $this->seenAt = $seenAt;

        return $this;
    }

    /**
     * Get seenAt
     *
     * @return \DateTime
     */
    public function getSeenAt()
    {
        return $this->seenAt;
    }
}
