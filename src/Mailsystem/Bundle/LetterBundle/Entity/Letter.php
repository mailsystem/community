<?php

namespace Mailsystem\Bundle\LetterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Mailsystem\Bundle\LetterBundle\Model\ExtendLetter;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\UserBundle\Entity\User;

use Oro\Bundle\OrganizationBundle\Entity\Organization;

/**
 * Entity : Letter
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *      name="mailsystem_letter",
 *      indexes={@ORM\Index(name="IDX_MAILSYSTEM_LETTER_OWNER",columns={"user_owner_id"})}
 * )
 * @Config(
 *  routeName="mailsystem_letter_index",
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
class Letter extends ExtendLetter
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
     *      "order"=0
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $subject;

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
    protected $body;

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
     * __toString()
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->subject;
    }

    /**
     * Get Id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Owner
     *
     * @param User $owner
     *
     * @return Letter
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get Owner
     *
     * @return User|null
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set organization
     *
     * @param Organization $organization
     * @return Letter
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
     * Set Subject
     *
     * @param string|null $subject
     *
     * @return Letter
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get Subject
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set Body
     *
     * @param string|null $body
     *
     * @return Letter
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get Body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set CreatedAt
     *
     * @param \DateTime $createdAt
     *
     * @return Letter
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get CreatedAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set UpdatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Letter
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get UpdatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * prePersist
     *
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * preUpdate
     *
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}
