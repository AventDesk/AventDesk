<?php


namespace Avent\Entity;

use Avent\Core\Entity\EntityInterface;
use Avent\Core\Entity\ToArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class TicketStatus
 * @package Avent\Entity
 * @Entity(repositoryClass="TicketStatusRepository")
 * @Table(name="ticket_status")
 */
class TicketStatus implements EntityInterface
{
    use ToArrayTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $status_id;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $status_name;

    /**
     * @OneToMany(targetEntity="Ticket", mappedBy="ticket_id")
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
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param int $status_id
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return $this->status_name;
    }

    /**
     * @param string $status_name
     */
    public function setStatusName($status_name)
    {
        $this->status_name = $status_name;
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
        $ticket->setStatus($this);
        $this->tickets[] = $ticket;
    }
}

// EOF
