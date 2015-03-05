<?php

namespace Mailsystem\Bundle\MaillistBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 *
 * @package Mailsystem\Bundle\MaillistBundle\Controller\Dashboard
 */
class DashboardController extends Controller
{
    /**
     * @Route(
     *      "/recent_maillists/{widget}",
     *      name="dashboard_recent_maillists",
     *      requirements={"widget"="[\w-]+"}
     * )
     * @Template("MailsystemMaillistBundle:Dashboard:recentMaillists.html.twig")
     */
    public function recentMaillistsAction($widget)
    {
        return [
            'widgetName' => 'recent_maillists'
        ];
    }
}
