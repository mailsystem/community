<?php
namespace Mailsystem\Bundle\DeliveryBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

use Mailsystem\Bundle\DeliveryBundle\Entity\DeliveryMaillist;

class DeliveryMaillistController extends Controller
{
    /**
     * This action is used to render the list of calls associated with the given entity
     * on the view page of this entity
     *
     * @Route("/activity/view/{entityClass}/{entityId}", name="mailsystem_delivery_maillist_view")
     * @AclAncestor("mailsystem_delivery_maillist_view")
     * @Template
     * @param $entityClass
     * @param $entityId
     * @return array
     */
    public function activityAction($entityClass, $entityId)
    {
        return array(
            'entity' => $this->get('oro_entity.routing_helper')->getEntity($entityClass, $entityId)
        );
    }
    /**
     * @Route("/create", name="mailsystem_delivery_maillist_create")
     * @Template("MailsystemDeliveryBundle:DeliveryMaillist:update.html.twig")
     * @Acl(
     *      id="mailsystem_delivery_maillist_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="MailsystemDeliveryBundle:DeliveryMaillist"
     * )
     */
    public function createAction()
    {
        $entity = new DeliveryMaillist();
        $formAction = $this->get('oro_entity.routing_helper')
            ->generateUrlByRequest('mailsystem_delivery_maillist_create', $this->getRequest());
        return $this->update($entity, $formAction);
    }

    /**
     * @Route("/update/{id}", name="mailsystem_delivery_maillist_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="mailsystem_delivery_maillist_update",
     *      type="entity",
     *      permission="EDIT",
     *      class="MailsystemDeliveryBundle:DeliveryMaillist"
     * )
     * @param DeliveryMaillist $entity
     * @return array
     */
    public function updateAction(DeliveryMaillist $entity)
    {
        $formAction = $this->get('router')->generate('mailsystem_delivery_maillist_update', ['id' => $entity->getId()]);
        return $this->update($entity, $formAction);
    }
    /**
     * @Route(name="mailsystem_delivery_maillist_index")
     * @Template
     * @Acl(
     *      id="mailsystem_delivery_maillist_view",
     *      type="entity",
     *      permission="VIEW",
     *      class="MailsystemDeliveryBundle:DeliveryMaillist"
     * )
     */
    public function indexAction()
    {
        return array(
            'entity_class' => $this->container->getParameter('mailsystem_delivery.delivery_maillist.entity.class')
        );
    }

    /**
     * @Route("/view/{id}", name="mailsystem_delivery_maillist_view")
     * @Template
     * @param DeliveryMaillist $entity
     * @return array
     */
    public function viewAction(DeliveryMaillist $entity)
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/widget/info/{id}", name="mailsystem_delivery_maillist_widget_info", requirements={"id"="\d+"})
     * @Template
     * @AclAncestor("magecore_demo_view")
     * @param DeliveryMaillist $entity
     * @return array
     */
    public function infoAction(DeliveryMaillist $entity)
    {
        return [
            'entity' => $entity
        ];
    }
    /**
     * @param DeliveryMaillist $entity
     * @param string $formAction
     *
     * @return array
     */
    protected function update(DeliveryMaillist $entity, $formAction)
    {
        $saved = false;
        if ($this->get('mailsystem_delivery.delivery_maillist.form.handler')->process($entity)) {
            if (!$this->getRequest()->get('_widgetContainer')) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    $this->get('translator')->trans('mailsystem.delivery.controller.delivery_maillist.saved.message')
                );
                return $this->get('oro_ui.router')->redirectAfterSave(
                    ['route' => 'mailsystem_delivery_maillist_update', 'parameters' => ['id' => $entity->getId()]],
                    ['route' => 'mailsystem_delivery_maillist_index'],
                    $entity
                );
            }
            $saved = true;
        }
        return array(
            'entity' => $entity,
            'saved' => $saved,
            'form' => $this->get('mailsystem_delivery.delivery_maillist.form.handler')->getForm()->createView(),
            'formAction' => $formAction
        );
    }
}
