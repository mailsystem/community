<?php

namespace Mailsystem\Bundle\RecipientBundle\Controller;

use FOS\Rest\Util\Codes;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Mailsystem\Bundle\RecipientBundle\Entity\Recipient;

/**
 * Class RecipientController
 *
 * Class for Manipulate with Recipients
 *
 * @Route("/recipient")
 *
 * @package Mailsystem\Bundle\RecipientBundle\Controller
 */
class RecipientController extends Controller
{
    /**
     * View <Recipient
     *
     * @Route("/view/{id}", name="mailsystem_recipient_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_recipient_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="MailsystemRecipientBundle:Recipient"
     * )
     */
    public function viewAction(Recipient $recipient)
    {
        return [
            'entity' => $recipient,
        ];
    }

    /**
     * Display Datagrid of all Recipients
     *
     * @Route(name="mailsystem_recipient_index")
     * @Template
     * @AclAncestor("mailsystem_recipient_view")
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('mailsystem_recipient.entity.class')
        ];
    }

    /**
     * Update Recipient
     *
     * @Route("/update/{id}", name="mailsystem_recipient_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_recipient_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="MailsystemRecipientBundle:Recipient"
     * )
     */
    public function updateAction(Recipient $recipient)
    {
        return $this->update($recipient);
    }

    /**
     * Create Recipient
     *
     * @Route("/create", name="mailsystem_recipient_create")
     * @Template("MailsystemRecipientBundle:Recipient:update.html.twig")
     * @Acl(
     *      id="mailsystem_recipient_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="MailsystemRecipientBundle:Recipient"
     * )
     */
    public function createAction()
    {
        return $this->update(new Recipient());
    }

    /**
     * Delete Recipient
     *
     * @Route("/delete/{id}", name="mailsystem_recipient_delete", requirements={"id"="\d+"})
     * @Acl(
     *      id="mailsystem_recipient_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="MailsystemRecipientBundle:Recipient"
     * )
     */
    public function deleteAction(Recipient $recipient)
    {
        /** @var EntityManager $em */
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $entityManager->remove($recipient);
        $entityManager->flush();

        return new JsonResponse('', Codes::HTTP_OK);
    }

    /**
     * Create / Update Recipient
     *
     * @param Recipient $recipient
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Recipient $recipient)
    {
        $handler = $this->get('mailsystem_recipient.form.handler');

        if ($handler->process($recipient)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('mailsystem.recipient.entity.saved')
            );

            return $this->get('oro_ui.router')->redirectAfterSave(
                [
                    'route'      => 'mailsystem_recipient_update',
                    'parameters' => ['id' => $recipient->getId()]
                ],
                [
                    'route'      => 'mailsystem_recipient_view',
                    'parameters' => ['id' => $recipient->getId()]
                ],
                $recipient
            );
        }

        return [
            'entity' => $recipient,
            'form'   => $handler->getForm()->createView()
        ];
    }
}
