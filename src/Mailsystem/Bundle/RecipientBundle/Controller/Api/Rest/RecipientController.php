<?php

namespace Mailsystem\Bundle\RecipientBundle\Controller\Api\Rest;

use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
/**
 * @RouteResource("recipient")
 * @NamePrefix("oro_api_")
 */
class RecipientController extends RestController implements ClassResourceInterface
{
    /**
     * REST GET list
     *
     * @QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      nullable=true,
     *      description="Page number, starting from 1. Defaults to 1."
     * )
     * @QueryParam(
     *      name="limit",
     *      requirements="\d+",
     *      nullable=true,
     *      description="Number of items per page. defaults to 10."
     * )
     * @ApiDoc(
     *      description="Get all Recipient items",
     *      resource=true
     * )
     * @AclAncestor("mailsystem_recipient_view")
     * @return Response
     */
    public function cgetAction()
    {
        return $this->handleGetListRequest();
    }
    /**
     * REST GET item
     *
     * @param string $id
     *
     * @ApiDoc(
     *      description="Get Recipient item",
     *      resource=true
     * )
     * @AclAncestor("mailsystem_recipient_view")
     * @return Response
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }
    /**
     * REST PUT
     *
     * @param int $id Recipient item id
     *
     * @ApiDoc(
     *      description="Update Recipient",
     *      resource=true
     * )
     * @AclAncestor("mailsystem_recipient_update")
     * @return Response
     */
    public function putAction($id)
    {
        return $this->handleUpdateRequest($id);
    }
    /**
     * Create new recipient
     *
     * @ApiDoc(
     *      description="Create new Recipient",
     *      resource=true
     * )
     * @AclAncestor("mailsystem_recipient_create")
     */
    public function postAction()
    {
        return $this->handleCreateRequest();
    }
    /**
     * REST DELETE
     *
     * @param int $id
     *
     * @ApiDoc(
     *      description="Delete Recipient",
     *      resource=true
     * )
     * @AclAncestor("magecore_private_demo_delete")
     * @return Response
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }
    /**
     * Get entity Manager
     *
     * @return ApiEntityManager
     */
    public function getManager()
    {
        return $this->get('mailsystem_recipient.recipient.manager.api');
    }
    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->get('mailsystem_recipient.form.type.recipient.api');
    }
    /**
     * @return ApiFormHandler
     */
    public function getFormHandler()
    {
        return $this->get('mailsystem_recipient.form.handler.recipient.api');
    }
}
