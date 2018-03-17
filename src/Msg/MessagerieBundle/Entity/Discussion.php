<?php

namespace Msg\MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discussion
 *
 * @ORM\Table(name="discussion")
 * @ORM\Entity(repositoryClass="Msg\MessagerieBundle\Repository\DiscussionRepository")
 */
class Discussion
{
    /**
    * @ORM\OneToMany(targetEntity="Msg\MessagerieBundle\Entity\Message", mappedBy="discussion")
    */
    private $messages;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Discussion
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add message
     *
     * @param \Msg\MessagerieBundle\Entity\Message $message
     *
     * @return Discussion
     */
    public function addMessage(\Msg\MessagerieBundle\Entity\Message $message)
    {
        $this->messages[] = $message;
        $message->setDiscussion($this);
        return $this;
    }

    /**
     * Remove message
     *
     * @param \Msg\MessagerieBundle\Entity\Message $message
     */
    public function removeMessage(\Msg\MessagerieBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
