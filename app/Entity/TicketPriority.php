<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class TicketPriority
 * @package Avent\Entity
 * @Entity(repositoryClass="TicketPriorityRepository")
 * @Table(name="ticket_priority")
 */
class TicketPriority implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $priority_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $priority_name;

    /**
     * @OnetoMany(targetEntity="Ticket", mappedBy="ticket_id")
     * @var ArrayCollection
     */
    protected $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getPriorityId()
    {
        return $this->priority_id;
    }

    /**
     * @param int $priority_id
     */
    public function setPriorityId($priority_id)
    {
        $this->priority_id = $priority_id;
    }

    /**
     * @return string
     */
    public function getPriorityName()
    {
        return $this->priority_name;
    }

    /**
     * @param string $priority_name
     */
    public function setPriorityName($priority_name)
    {
        $this->priority_name = $priority_name;
    }

    /**
     * @return ArrayCollection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param Ticket $ticket
     */
    public function setTickets(Ticket $ticket)
    {
        $ticket->setPriority($this);
        $this->tickets[] = $ticket;
    }
}

// EOF
