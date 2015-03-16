<?php

namespace Mailsystem\Bundle\LetterBundle\Controller;

use Doctrine\ORM\EntityManager;

use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Mailsystem\Bundle\LetterBundle\Entity\Letter;

/**
 * Class LetterController
 * @Route("/letter")
 *
 * @package Mailsystem\Bundle\LetterBundle\Controller
 */
class LetterController extends Controller
{
    /**
     * @Route("/view/{id}", name="mailsystem_letter_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_letter_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="MailsystemLetterBundle:Letter"
     * )
     * @param Letter $letter
     * @return array
     */
    public function viewAction(Letter $letter)
    {
        return [
            'entity' => $letter,
        ];
    }

    /**
     * @Route(name="mailsystem_letter_index")
     * @Template
     * @AclAncestor("mailsystem_letter_view")
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('mailsystem_letter.entity.class')
        ];
    }

    /**
     * @Route("/update/{id}", name="mailsystem_letter_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_letter_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="MailsystemLetterBundle:Letter"
     * )
     * @param Letter $letter
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Letter $letter)
    {
        return $this->update($letter);
    }

    /**
     * @Route("/create", name="mailsystem_letter_create")
     * @Template("MailsystemLetterBundle:Letter:update.html.twig")
     * @Acl(
     *      id="mailsystem_letter_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="MailsystemLetterBundle:Letter"
     * )
     */
    public function createAction()
    {
        return $this->update(new Letter());
    }

    /**
     * @Route("/delete/{id}", name="mailsystem_letter_delete", requirements={"id"="\d+"})
     * @Acl(
     *      id="mailsystem_letter_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="MailsystemLetterBundle:Letter"
     * )
     * @param Letter $letter
     * @return JsonResponse
     */
    public function deleteAction(Letter $letter)
    {
        /** @var EntityManager $em */
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $entityManager->remove($letter);
        $entityManager->flush();

        return new JsonResponse('', Codes::HTTP_OK);
    }

    /**
     * @param Letter $letter
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(Letter $letter)
    {
        $handler = $this->get('mailsystem_letter.form.handler');

        if ($handler->process($letter)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('mailsystem.letter.entity.saved')
            );

            return $this->get('oro_ui.router')->redirectAfterSave(
                [
                    'route' => 'mailsystem_letter_update',
                    'parameters' => ['id' => $letter->getId()]
                ],
                [
                    'route' => 'mailsystem_letter_view',
                    'parameters' => ['id' => $letter->getId()]
                ],
                $letter
            );
        }

        return [
            'entity' => $letter,
            'form' => $handler->getForm()->createView()
        ];
    }
}
