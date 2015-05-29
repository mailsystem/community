<?php

namespace Mailsystem\Bundle\RecipientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Mailsystem\Bundle\MaillistBundle\Entity\Maillist;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\UserBundle\Entity\User;

use Oro\Bundle\OrganizationBundle\Entity\Organization;

/**
 * Entity : Recipient
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(
 *      name="mailsystem_recipient",
 *      indexes={@ORM\Index(name="IDX_MAILSYSTEM_RECIPIENT_OWNER",columns={"user_owner_id"})}
 * )
 * @Config(
 *  routeName="mailsystem_recipient_index",
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
class Recipient
{
    /**
     * Recipient Id
     *
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User Recipient Owner
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=0
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $owner;

    /**
     * Owner - Organization
     *
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\Organization")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $organization;

    /**
     * Recipient First Name
     *
     * @var string
     *
     * @ORM\Column(name="first_name", type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=1
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $firstName;

    /**
     * Recipient Last Name
     *
     * @var string
     *
     * @ORM\Column(name="last_name", type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=2
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $lastName;

    /**
     * Recipient Email
     *
     * @var string
     *
     * @ORM\Column(name="email", type="text", nullable=false)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=3
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $email;

    /**
     * Recipient's Phone
     *
     * @var string
     *
     * @ORM\Column(name="phone", type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=4
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $phone;

    /**
     * Recipient's Skype
     *
     * @var string
     *
     * @ORM\Column(name="skype", type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=5
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $skype;

    /**
     * Recipient Position
     *
     * @var string
     *
     * @ORM\Column(name="position", type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=6
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $position;

    /**
     * Recipient Company
     *
     * @var string
     *
     * @ORM\Column(name="company", type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=7
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $company;

    /**
     * Recipient's Date of Birth
     *
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=8
     *   },
     *   "email"={
     *      "available_in_template"=true
     *   },
     *   "dataaudit"={
     *      "auditable"=true
     *    }
     * })
     */
    protected $birthDate;

    /**
     * @var string Recipient's description
     *
     * @ORM\Column(type="text", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=9
     *   },
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
     * @var ArrayCollection $maillists Maillists, assigned to Recipient
     * @ORM\ManyToMany(targetEntity="Mailsystem\Bundle\MaillistBundle\Entity\Maillist", inversedBy="recipients")
     * @ORM\JoinTable(name="mailsystem_maillist_recipient")
     */
    protected $maillists;

    /**
     * @var \DateTime Create Date
     *
     * @ORM\Column(name="created_at", type="datetime")
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
     *    },
     *   "entity"={"label"="oro.ui.created_at"}
     * })
     */
    protected $createdAt;

    /**
     * @var \DateTime Update Date
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @ConfigField(
     * defaultValues={
     *   "importexport"={
     *      "order"=11
     *   },
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
     * @return string|null
     */
    public function __toString()
    {
        return (string)$this->email;
    }

    /**
     * Construstor
     */
    public function __construct()
    {
        $this->maillists = new ArrayCollection();
    }

    /**
     * Get Id of Recipient
     * @return int|null Recipient's Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Owner of Recipient
     *
     * @param User $owner
     *
     * @return Recipient
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get Owner of Recipient
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Get Id Of Owner
     * @return int|mixed
     */
    public function getUserOwnerId()
    {
        if ($this->owner instanceof User) {
            return $this->owner->getId();
        } else {
            return 0;
        }
    }

    /**
     * Set organization
     *
     * @param Organization $organization
     *
     * @return Recipient
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
     * Get organization id
     * @return int
     */
    public function getOrganizationId()
    {
        if ($this->getOrganization() instanceof Organization) {
            $this->getOrganization()->getId();
        } else {
            return 0;
        }
    }

    /**
     * Set First Name
     *
     * @param string|null $firstName
     *
     * @return Recipient
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get First Name
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set Last Name
     *
     * @param string|null $lastName
     *
     * @return Recipient
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get Last Name
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set Email
     *
     * @param string|null $email
     *
     * @return Recipient
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Phone
     *
     * @param string|null $phone
     *
     * @return Recipient
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get Phone
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set Skype
     *
     * @param string|null $skype
     *
     * @return Recipient
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get Skype
     *
     * @return string|null
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set Position
     *
     * @param string|null $position
     *
     * @return Recipient
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get Position
     *
     * @return string|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set Company
     *
     * @param string|null $company
     *
     * @return Recipient
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get Company
     *
     * @return string|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set Date Of Birth
     *
     * @param string|null $birthDate
     *
     * @return Recipient
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get Date Of Birth
     *
     * @return string|null
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set Description
     *
     * @param string|null $description
     *
     * @return Recipient
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set CreatedAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recipient
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
     * @return Recipient
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

    /**
     * Add Maillist
     *
     * @param Maillist $maillist
     *
     * @return Recipient
     */
    public function addMaillist(Maillist $maillist)
    {
        $this->maillists[] = $maillist;

        return $this;
    }

    /**
     * Remove Maillist
     *
     * @param Maillist $maillist
     */
    public function removeMaillist(Maillist $maillist)
    {
        $this->maillists->removeElement($maillist);
    }

    /**
     * Get Maillists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMaillists()
    {
        return $this->maillists;
    }
}
