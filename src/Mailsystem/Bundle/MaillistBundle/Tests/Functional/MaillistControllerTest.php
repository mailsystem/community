<?php
namespace Mailsystem\Bundle\MaillistBundle\Tests\Functional;

use Symfony\Component\DomCrawler\Form;
use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

/**
 * @outputBuffering enabled
 * @dbIsolation
 */
class SaasTrialControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->initClient(
            array(),
            array_merge(
                $this->generateBasicAuthHeader(),
                array('HTTP_X-CSRF-Header' => 1)
            )
        );
    }

    /**
     * test index
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->getUrl('mailsystem_maillist_index'));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
    }

    /**
     * test create
     */
    public function testCreate()
    {
        $crawler = $this->client->request('GET', $this->getUrl('mailsystem_maillist_create'));
        /** @var Form $form */
        $name = 'name';
        $form = $crawler->selectButton('Save and Close')->form();
        $form['mailsystem_maillist_request[name]'] = $name;
        $form['mailsystem_maillist_request[description]'] = 'description';
        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);
        $maillist = $this->getContainer()
            ->get('doctrine')
            ->getRepository('MailsystemMaillistBundle:Maillist')
            ->findOneByName($name);
        $this->assertNotNull($maillist);
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
        $this->assertContains("Maillist has been saved successfully", $crawler->html());
    }
}
