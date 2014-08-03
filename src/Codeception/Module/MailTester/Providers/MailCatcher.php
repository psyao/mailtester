<?php namespace Codeception\Module\MailTester\Providers;

use Codeception\Module\MailTester\MailTestable;
use Codeception\Module\MailTester\MailTesterMessage;
use GuzzleHttp\Client;

class MailCatcher extends Providers implements MailTestable
{
    /**
     * @var Client
     */
    protected $mailcatcher;
    /**
     * @var array
     */
    protected $requiredFields = ['url', 'port'];

    function __construct(array $config)
    {
        $this->config = $config;

        $this->validateConfig();

        $url = $this->config['url'] . ':' . $this->config['port'];
        $this->mailcatcher = new Client(['base_url' => $url]);
    }

    /**
     * @return void
     */
    public function deleteAllEmails()
    {
        $this->mailcatcher->delete('/messages');
    }

    /**
     * @return array
     */
    public function getAllEmails()
    {
        return $this->mailcatcher->get('/messages')->json();
    }

    /**
     * @return MailTesterMessage
     */
    public function getLastEmail()
    {
        $id = $this->getAllEmails()[0]['id'];

        $email = $this->mailcatcher->get("/messages/{$id}.json");

        return $this->populateMessage($id, $email);
    }

    /**
     * @param $id
     * @param $email
     *
     * @return MailTesterMessage
     */
    protected function populateMessage($id, $email)
    {
        $message = new MailTesterMessage();

        $message->setId($id)
            ->setSender($email->json()['sender'])
            ->setRecipients($email->json()['recipients'])
            ->setBody((string)$email->getBody());

        return $message;
    }
}