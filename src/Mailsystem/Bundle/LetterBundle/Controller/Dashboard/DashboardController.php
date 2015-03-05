<?php

namespace Mailsystem\Bundle\LetterBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 *
 * @package Mailsystem\Bundle\LetterBundle\Controller\Dashboard
 */
class DashboardController extends Controller
{
    /**
     * @Route(
     *      "/recent_letters/{widget}",
     *      name="dashboard_recent_letters",
     *      requirements={"widget"="[\w-]+"}
     * )
     * @Template("MailsystemLetterBundle:Dashboard:recentLetters.html.twig")
     */
    public function recentMaillistsAction($widget)
    {
        return [
            'widgetName' => 'recent_letters'
        ];
    }
}
