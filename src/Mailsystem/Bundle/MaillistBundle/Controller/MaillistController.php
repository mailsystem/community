<?php

namespace Mailsystem\Bundle\MaillistBundle\Controller;

use Doctrine\ORM\EntityManager;

use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Mailsystem\Bundle\MaillistBundle\Entity\Maillist;

/**
 * Class MaillistController
 * @Route("/maillist")
 *
 * @package Mailsystem\Bundle\MaillistBundle\Controller
 */
class MaillistController extends Controller
{
    /**
     * @Route("/view/{id}", name="mailsystem_maillist_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_maillist_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="MailsystemMaillistBundle:Maillist"
     * )
     */
    public function viewAction(Maillist $maillist)
    {
        return [
            'entity' => $maillist,
        ];
    }

    /**
     * @Route(name="mailsystem_maillist_index")
     * @Template
     * @AclAncestor("mailsystem_maillist_view")
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('mailsystem_maillist.entity.class')
        ];
    }

    /**
     * @Route("/update/{id}", name="mailsystem_maillist_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_maillist_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="MailsystemMaillistBundle:Maillist"
     * )
     */
    public function updateAction(Maillist $maillist)
    {
        return $this->update($maillist);
    }

    /**
     * @Route("/create", name="mailsystem_maillist_create")
     * @Template("MailsystemMaillistBundle:Maillist:update.html.twig")
     * @Acl(
     *      id="mailsystem_maillist_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="MailsystemMaillistBundle:Maillist"
     * )
     */
    public function createAction()
    {
        return $this->update(new Maillist());
    }

    /**
     * @Route("/delete/{id}", name="mailsystem_maillist_delete", requirements={"id"="\d+"})
     * @Acl(
     *      id="mailsystem_maillist_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="MailsystemMaillistBundle:Maillist"
     * )
     */
    public function deleteAction(Maillist $maillist)
    {
        /** @var EntityManager $em */
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $entityManager->remove($maillist);
        $entityManager->flush();

        return new JsonResponse('', Codes::HTTP_OK);
    }

    /**
     * @param Maillist $maillist
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Maillist $maillist)
    {
        $handler = $this->get('mailsystem_maillist.form.handler');

        if ($handler->process($maillist)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('mailsystem.maillist.entity.saved')
            );

            return $this->get('oro_ui.router')->redirectAfterSave(
                [
                    'route'      => 'mailsystem_maillist_update',
                    'parameters' => ['id' => $maillist->getId()]
                ],
                [
                    'route'      => 'mailsystem_maillist_view',
                    'parameters' => ['id' => $maillist->getId()]
                ],
                $maillist
            );
        }

        return [
            'entity' => $maillist,
            'form'   => $handler->getForm()->createView()
        ];
    }
}
