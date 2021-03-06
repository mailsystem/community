<?php
namespace Mailsystem\Bundle\LetterBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;

/**
 * Class LoadDashboardData
 *
 * @package Mailsystem\Bundle\LetterBundle\Migrations\Data\ORM
 */
class LoadDashboardData extends AbstractDashboardFixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'Oro\Bundle\UserBundle\Migrations\Data\ORM\LoadAdminUserData',
            'Oro\Bundle\UserBundle\Migrations\Data\ORM\UpdateUserEntitiesWithOrganization'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $mainDashboard = $this->findAdminDashboardModel($manager, 'main');
        if ($mainDashboard) {
            $mainDashboard->addWidget(
                $this->createWidgetModel('recent_letters', [0, 20])
            );

            $manager->flush();
        }
    }
}
