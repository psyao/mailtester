<?php namespace Codeception\Module;

use Codeception\Module;
use Codeception\Module\MailTester\MailTestable;
use Codeception\Module\MailTester\MailTesterFactory;
use Codeception\Module\MailTester\MailTesterMessage;

class MailTester extends Module implements MailTestable
{
    /**
     * @var MailTestable
     */
    protected $tester;

    /**
     * @var array
     */
    protected $config = array('provider');

    /**
     * @var array
     */
    protected $requiredFields = array('provider');

    /**
     * @return void
     */
    public function _initialize()
    {
        $factory = new MailTesterFactory();

        $this->tester = $factory->make($this->config);
    }

    /**
     * @return void
     */
    public function deleteAllEmails()
    {
        $this->tester->deleteAllEmails();
    }

    /**
     * @return array
     */
    public function getAllEmails()
    {
        $emails = $this->tester->getAllEmails();

        if (empty($emails))
        {
            $this->fail('No messages returned.');
        }

        return $emails;
    }

    /**
     * @return MailTesterMessage
     */
    public function getLastEmail()
    {
        return $this->tester->getLastEmail();
    }

    /**
     * @param $expected
     *
     * @return void
     */
    public function seeInLastEmail($expected)
    {
        $email = $this->getLastEmail();
        $this->assertEmailBodyContains($expected, $email);
    }

    /**
     * @param $expected
     *
     * @return void
     */
    public function dontSeeInLastEmail($expected)
    {
        $email = $this->getLastEmail();
        $this->assertNotEmailBodyContains($expected, $email);
    }

    /**
     * @param $expected
     *
     * @return void
     */
    public function seeLastEmailWasSentTo($expected)
    {
        $email = $this->getLastEmail();
        $this->assertEmailWasSentTo($expected, $email);
    }

    /**
     * @param $expected
     *
     * @return void
     */
    public function dontSeeLastEmailWasSentTo($expected)
    {
        $email = $this->getLastEmail();
        $this->assertNotEmailWasSentTo($expected, $email);
    }

    /**
     * @param $expected
     *
     * @return void
     */
    public function seeLastEmailWasSentFrom($expected)
    {
        $email = $this->getLastEmail();
        $this->assertEmailWasSentFrom($expected, $email);
    }

    /**
     * @param $expected
     *
     * @return void
     */
    public function dontSeeLastEmailWasSentFrom($expected)
    {
        $email = $this->getLastEmail();
        $this->assertNotEmailWasSentFrom($expected, $email);
    }

    /**
     * @param string            $body
     * @param MailTesterMessage $email
     */
    public function assertEmailBodyContains($body, MailTesterMessage $email)
    {
        $this->assertContains($body, $email->getBody());
    }

    /**
     * @param string            $body
     * @param MailTesterMessage $email
     */
    public function assertNotEmailBodyContains($body, MailTesterMessage $email)
    {
        $this->assertNotContains($body, $email->getBody());
    }

    /**
     * @param string            $recipient
     * @param MailTesterMessage $email
     */
    public function assertEmailWasSentTo($recipient, MailTesterMessage $email)
    {
        $this->assertContains("<{$recipient}>", $email->getRecipients());
    }

    /**
     * @param string            $recipient
     * @param MailTesterMessage $email
     */
    public function assertNotEmailWasSentTo($recipient, MailTesterMessage $email)
    {
        $this->assertNotContains("<{$recipient}>", $email->getRecipients());
    }

    /**
     * @param string            $sender
     * @param MailTesterMessage $email
     */
    public function assertEmailWasSentFrom($sender, MailTesterMessage $email)
    {
        $this->assertContains("<{$sender}>", $email->getSender());
    }

    /**
     * @param string            $sender
     * @param MailTesterMessage $email
     */
    public function assertNotEmailWasSentFrom($sender, MailTesterMessage $email)
    {
        $this->assertNotContains("<{$sender}>", $email->getSender());
    }
}