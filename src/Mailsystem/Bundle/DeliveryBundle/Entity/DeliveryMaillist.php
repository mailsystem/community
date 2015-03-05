<?php

namespace Mailsystem\Bundle\DeliveryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mailsystem\Bundle\LetterBundle\Entity\LetterTemplate;
use Mailsystem\Bundle\MaillistBundle\Entity\Maillist;
//use Oro\Bundle\CalendarBundle\Entity\CalendarEvent;
use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\UserBundle\Entity\User;

use Symfony\Component\Security\Core\User\UserInterface;

use Mailsystem\Bundle\DeliveryBundle\Model\ExtendDeliveryMaillist;


/**
 * DeliveryMaillist
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="mailsystem_delivery_maillist")
 * @Config(
 *      defaultValues={
 *          "entity"={
 *              "icon"="icon-envelope"
 *          },
 *          "ownership"={
 *              "owner_type"="USER",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="user_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "group_name"=""
 *          },
 *          "grouping"={
 *              "groups"={"activity"}
 *           },
 *          "activity"={
 *              "immutable"=true,
 *              "route"="mailsystem_delivery_maillist_activity_view",
 *              "acl"="magecore_demo_view",
 *              "action_button_widget"="mailsystem_delivery_maillist_button",
 *              "action_link_widget"="mailsystem_delivery_maillist_link"
 *           }
 *      }
 * )
 */
class DeliveryMaillist extends ExtendDeliveryMaillist
{
    /**
     * Entity Name
     */
    const ENTITY_NAME = 'Mailsystem\Bundle\DeliveryBundle\Entity\Maillist';
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ConfigField(defaultValues={"email"={"available_in_template"=true}})
     */
    protected $id;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned
     * @ConfigField(defaultValues={"email"={"available_in_template"=true}})
     */
    protected $owner;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="calendar_user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned
     * @ConfigField(defaultValues={"email"={"available_in_template"=true}})
     */
    protected $calendarOwner;
    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $organization;

    /**
     * @var LetterTemplate
     *
     * @ORM\ManyToOne(targetEntity="Mailsystem\Bundle\LetterBundle\Entity\LetterTemplate")
     * @ORM\JoinColumn(name="letter_template_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $letterTemplate;

    /**
     * @var Maillist
     *
     * @ORM\ManyToOne(targetEntity="Mailsystem\Bundle\MaillistBundle\Entity\Maillist")
     * @ORM\JoinColumn(name="maillist_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $maillist;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @ConfigField(defaultValues={"email"={"available_in_template"=true}})
     */
    protected $notes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @ConfigField(defaultValues={"email"={"available_in_template"=true},"entity"={"label"="oro.ui.created_at"}})
     */
    protected $createdAt;

    public function __construct()
    {
        parent::__construct();
//        $this->calendarEvent = new CalendarEvent();
    }

    /**
     * __toString()
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->id;
    }


    /**
     * get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set user owner
     *
     * @param UserInterface|null $owner User owner
     *
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * get user owner
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * set organization
     *
     * @param Organization $organization Organization
     *
     * @return $this
     */
    public function setOrganization(Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * get organization
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * set letter template
     *
     * @param LetterTemplate $letterTemplate LetterTemplate
     *
     * @return $this
     */
    public function setLetterTemplate(LetterTemplate $letterTemplate = null)
    {
        $this->letterTemplate = $letterTemplate;

        return $this;
    }

    /**
     * get letter template
     *
     * @return LetterTemplate
     */
    public function getLetterTemplate()
    {
        return $this->letterTemplate;
    }

    /**
     * set maillist
     *
     * @param Maillist $maillist Maillist
     *
     * @return $this
     */
    public function setMaillist(Maillist $maillist = null)
    {
        $this->maillist = $maillist;

        return $this;
    }

    /**
     * get maillist
     *
     * @return Maillist
     */
    public function getMaillist()
    {
        return $this->maillist;
    }

    /**
     * set notes
     *
     * @param string $notes Demo Notes
     *
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * get notes
     *
     * @return string|null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * set createdAt
     *
     * @param \DateTime $createdAt Date create
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}