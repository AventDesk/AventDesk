<?php


namespace Avent\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Label
 * @package Avent\Entity
 * @Entity(repositoryClass="LabelRepository")
 * @Table(name="labels")
 */
class Label
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    protected $label_id;

    /**
     * @ManyToMany(targetEntity="Ticket", mappedBy="labels")
     * @var ArrayCollection
     */
    protected $tickets = null;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $name;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getLabelId()
    {
        return $this->label_id;
    }

    /**
     * @param int $label_id
     */
    public function setLabelId($label_id)
    {
        $this->label_id = $label_id;
    }

    /**
     * @return Ticket
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param Ticket $ticket
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}

// EOF
