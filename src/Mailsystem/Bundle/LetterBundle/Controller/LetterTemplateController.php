<?php

namespace Mailsystem\Bundle\LetterBundle\Controller;

use FOS\Rest\Util\Codes;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Mailsystem\Bundle\LetterBundle\Entity\LetterTemplate;

/**
 * Class LetterTemplateController
 * @Route("/letter-template")
 *
 * @package Mailsystem\Bundle\LetterBundle\Controller
 */
class LetterTemplateController extends Controller
{
    /**
     * @Route("/view/{id}", name="mailsystem_letter_template_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_letter_template_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="MailsystemLetterBundle:LetterTemplate"
     * )
     *
     * @param LetterTemplate $letterTemplate
     *
     * @return array
     */
    public function viewAction(LetterTemplate $letterTemplate)
    {
        return [
            'entity' => $letterTemplate,
        ];
    }

    /**
     * @Route(name="mailsystem_letter_template_index")
     * @Template
     * @AclAncestor("mailsystem_letter_template_view")
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('mailsystem_letter_template.entity.class')
        ];
    }

    /**
     * @Route("/update/{id}", name="mailsystem_letter_template_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_letter_template_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="MailsystemLetterBundle:LetterTemplate"
     * )
     *
     * @param LetterTemplate $letterTemplate
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(LetterTemplate $letterTemplate)
    {
        return $this->update($letterTemplate);
    }

    /**
     * @Route("/create", name="mailsystem_letter_template_create")
     * @Template("MailsystemLetterBundle:LetterTemplate:update.html.twig")
     * @Acl(
     *      id="mailsystem_letter_template_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="MailsystemLetterBundle:LetterTemplate"
     * )
     */
    public function createAction()
    {
        return $this->update(new LetterTemplate());
    }

    /**
     * @Route("/delete/{id}", name="mailsystem_letter_template_delete", requirements={"id"="\d+"})
     * @Acl(
     *      id="mailsystem_letter_template_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="MailsystemLetterBundle:LetterTemplate"
     * )
     * @param LetterTemplate $letterTemplate
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction(LetterTemplate $letterTemplate)
    {
        /** @var EntityManager $em */
        $entityManager = $this->get('doctrine.orm.entity_manager');

        $entityManager->remove($letterTemplate);
        $entityManager->flush();

        return new JsonResponse('', Codes::HTTP_OK);
    }

    /**
     * @param LetterTemplate $letterTemplate
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function update(LetterTemplate $letterTemplate)
    {
        $handler = $this->get('mailsystem_letter_template.form.handler');

        if ($handler->process($letterTemplate)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('mailsystem.letter.template.entity.saved')
            );

            return $this->get('oro_ui.router')->redirectAfterSave(
                [
                    'route'      => 'mailsystem_letter_template_update',
                    'parameters' => ['id' => $letterTemplate->getId()]
                ],
                [
                    'route'      => 'mailsystem_letter_template_view',
                    'parameters' => ['id' => $letterTemplate->getId()]
                ],
                $letterTemplate
            );
        }

        return [
            'entity' => $letterTemplate,
            'form'   => $handler->getForm()->createView()
        ];
    }
}
