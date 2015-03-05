<?php

namespace Mailsystem\Bundle\RecipientBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 *
 * @package Mailsystem\Bundle\RecipientBundle\Controller\Dashboard
 */
class DashboardController extends Controller
{
    /**
     * @Route(
     *      "/recent_recipients/{widget}",
     *      name="dashboard_recent_recipients",
     *      requirements={"widget"="[\w-]+"}
     * )
     * @Template("MailsystemRecipientBundle:Dashboard:recentRecipients.html.twig")
     */
    public function recentRecipientsAction($widget)
    {
        return [
            'widgetName' => 'recent_recipients'
        ];
    }
}
