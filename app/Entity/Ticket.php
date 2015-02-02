<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Avent\ValueObject\Timestamp;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Ticket
 * @package Avent\Entity
 * @Entity(repositoryClass="Avent\Repository\TicketRepository")
 * @Table(name="ticket")
 */
class Ticket implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $ticket_id;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    protected $ticket_title;

    /**
     * @Column(type="text")
     * @var string
     */
    protected $ticket_body;

    /**
     * @ManyToMany(targetEntity="Label", inversedBy="tickets")
     * @JoinTable(name="ticket_labels",
     *      joinColumns={@JoinColumn(name="ticket_id", referencedColumnName="ticket_id")},
     *      inverseJoinColumns={@JoinColumn(name="label_id", referencedColumnName="label_id")}
     * )
     * @var ArrayCollection
     */
    protected $labels;

    /**
     * @ManyToOne(targetEntity="Person", inversedBy="opened_tickets")
     * @JoinColumn(name="creator", referencedColumnName="person_id")
     * @var Person
     */
    protected $creator;

    /**
     * @ManyToOne(targetEntity="Person", inversedBy="assigned_tickets")
     * @JoinColumn(name="assignee", referencedColumnName="person_id")
     * @var Person
     */
    protected $assignee;

    /**
     * @ManyToOne(targetEntity="TicketStatus", inversedBy="tickets")
     * @JoinColumn(name="status_id", referencedColumnName="status_id")
     * @var TicketStatus
     */
    protected $status;

    /**
     * @ManyToOne(targetEntity="TicketPriority", inversedBy="tickets")
     * @JoinColumn(name="priority_id", referencedColumnName="priority_id")
     * @var TicketPriority
     */
    protected $priority;

    /**
     * @Embedded(class="Avent\ValueObject\Timestamp", columnPrefix=false)
     * @var Timestamp
     */
    protected $timestamp;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }

    /**
     * @param int $ticket_id
     */
    public function setTicketId($ticket_id)
    {
        $this->ticket_id = $ticket_id;
    }

    /**
     * @return string
     */
    public function getTicketTitle()
    {
        return $this->ticket_title;
    }

    /**
     * @param string $ticket_title
     */
    public function setTicketTitle($ticket_title)
    {
        $this->ticket_title = $ticket_title;
    }

    /**
     * @return string
     */
    public function getTicketBody()
    {
        return $this->ticket_body;
    }

    /**
     * @param string $ticket_body
     */
    public function setTicketBody($ticket_body)
    {
        $this->ticket_body = $ticket_body;
    }

    /**
     * @return ArrayCollection
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param Label $label
     */
    public function setLabel(Label $label)
    {
        $label->addTicket($this);
        $this->labels[] = $label;
    }

    /**
     * @return Person
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param Person $creator
     */
    public function setCreator(Person $creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return Person
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param Person $assignee
     */
    public function setAssignee(Person $assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @return TicketStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param TicketStatus $status
     */
    public function setStatus(TicketStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return TicketPriority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param TicketPriority $priority
     */
    public function setPriority(TicketPriority $priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return Timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param Timestamp $timestamp
     */
    public function setTimestamp(Timestamp $timestamp)
    {
        $this->timestamp = $timestamp;
    }
}

// EOF
