<?php

namespace Mailsystem\Bundle\MaillistBundle\Form\Handler;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use Mailsystem\Bundle\MaillistBundle\Entity\Maillist;

/**
 * Class MaillistHandler
 *
 * @package Mailsystem\Bundle\MaillistBundle\Form\Handler
 */
class MaillistHandler
{
    /** @var FormInterface */
    protected $form;

    /** @var Request */
    protected $request;

    /** @var EntityManager */
    protected $em;

    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param EntityManager $em
     */
    public function __construct(FormInterface $form, Request $request, EntityManager $em)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->em      = $em;
    }

    /**
     * Process form
     *
     * @param Maillist $entity
     *
     * @return bool  True on successful processing, false otherwise
     */
    public function process(Maillist $entity)
    {
        $this->getForm()->setData($entity);

        if (in_array($this->request->getMethod(), array('POST', 'PUT'))) {
            $this->getForm()->submit($this->request);

            if ($this->getForm()->isValid()) {
                $this->em->persist($entity);
                $this->em->flush();

                return true;
            }
        }

        return false;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
}
