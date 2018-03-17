<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discussion
 *
 * @ORM\Table(name="discussions")
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\DiscussionRepository")
 */
class Discussion implements \JsonSerializable
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
     * @var Membre
     *
     * @ORM\ManyToOne(targetEntity="Membre", inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @var Membre
     *
     * @ORM\ManyToOne(targetEntity="Membre", inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @var Message
     *
     * @ORM\OneToMany(targetEntity="Message", mappedBy="discussion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $messages;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetimetz")
     */
    private $createdAt;

    /**
     * @var Message
     *
     * @ORM\OneToOne(targetEntity="Message", inversedBy="discussion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lastMessage;


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
     * Set creator
     *
     * @param \stdClass $creator
     *
     * @return Discussion
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \stdClass
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set members
     *
     * @param \stdClass $members
     *
     * @return Discussion
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * Get members
     *
     * @return \stdClass
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Discussion
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set lastMessage
     *
     * @param \stdClass $lastMessage
     *
     * @return Discussion
     */
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;

        return $this;
    }

    /**
     * Get lastMessage
     *
     * @return \stdClass
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime;
    }

    /**
     * Add member
     *
     * @param \MessagerieBundle\Entity\Membre $member
     *
     * @return Discussion
     */
    public function addMember(\MessagerieBundle\Entity\Membre $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \MessagerieBundle\Entity\Membre $member
     */
    public function removeMember(\MessagerieBundle\Entity\Membre $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Add message
     *
     * @param \MessagerieBundle\Entity\Message $message
     *
     * @return Discussion
     */
    public function addMessage(\MessagerieBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \MessagerieBundle\Entity\Message $message
     */
    public function removeMessage(\MessagerieBundle\Entity\Message $message)
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

    /**
     * Set member
     *
     * @param \MessagerieBundle\Entity\Membre $member
     *
     * @return Discussion
     */
    public function setMember(\MessagerieBundle\Entity\Membre $member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \MessagerieBundle\Entity\Membre
     */
    public function getMember()
    {
        return $this->member;
    }

    public function jsonSerialize($reserve = false) {
        $obj = [];
        $obj['id'] = $this->getId();
        if($this->creator)
            $obj['creator'] = $this->creator;
        if($this->member)
            $obj['member'] = $this->member;
        if($this->lastMessage && !$reserve)
            $obj['lastMessage'] = $this->lastMessage->jsonSerialize(true);
        if($this->createdAt)
            $obj['createdAt'] = $this->createdAt->format(\DateTime::ISO8601);
        
        return $obj;
    }
}
