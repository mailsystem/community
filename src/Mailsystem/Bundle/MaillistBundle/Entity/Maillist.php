<?php

namespace Mailsystem\Bundle\MaillistBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\UserBundle\Entity\User;

use Oro\Bundle\OrganizationBundle\Entity\Organization;

/**
 * Entity : Maillist
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *      name="mailsystem_maillist",
 *      indexes={@ORM\Index(name="IDX_MAILSYSTEM_MAILLIST_OWNER",columns={"user_owner_id"})}
 * )
 * @Config(
 *  routeName="mailsystem_maillist_index",
 *  defaultValues={
 *      "entity"={"icon"="icon-envelope"},
 *      "ownership"={
 *        "owner_type"="USER",
 *        "owner_field_name"="owner",
 *        "owner_column_name"="user_owner_id",
 *        "organization_field_name"="organization",
 *        "organization_column_name"="organization_id"
 *      },
 *      "security"={
 *          "type"="ACL",
 *          "group_name"=""
 *      },
 *      "dataaudit"={
 *        "auditable"=true
 *      },
 *  }
 * )
 */
class Maillist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     * defaultValues={
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $owner;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $organization;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=10
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $description;

    /**
     * @var ArrayCollection $recipients
     * @ORM\ManyToMany(targetEntity="Mailsystem\Bundle\RecipientBundle\Entity\Recipient", mappedBy="maillists")
     */
    protected $recipients;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @ConfigField(
     * defaultValues={
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    },
     *   "entity"={"label"="oro.ui.created_at"}
     * })
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    },
     *    "entity"={"label"="oro.ui.updated_at"}
     * })
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->name;
    }

    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param User $owner
     *
     * @return Maillist
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set organization
     *
     * @param Organization $organization
     *
     * @return SalesFunnel
     */
    public function setOrganization(Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param $name
     *
     * @return Maillist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $description
     *
     * @return Maillist
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Maillist
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return Maillist
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Add recipient
     *
     * @param \Mailsystem\Bundle\RecipientBundle\Entity\Recipient $recipient
     *
     * @return Maillist
     */
    public function addRecipient(\Mailsystem\Bundle\RecipientBundle\Entity\Recipient $recipient)
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    /**
     * Remove recipients
     *
     * @param \Mailsystem\Bundle\RecipientBundle\Entity\Recipient $recipient
     */
    public function removeRecipient(\Mailsystem\Bundle\RecipientBundle\Entity\Recipient $recipient)
    {
        $this->recipients->removeElement($recipient);
    }

    /**
     * Get recipients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }
}
