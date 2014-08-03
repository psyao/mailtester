<?php namespace Codeception\Module\MailTester\Providers;

use Codeception\Module\MailTester\MailTestable;
use Codeception\Module\MailTester\MailTesterMessage;
use GuzzleHttp\Client;

class MailTrap implements MailTestable
{
    use ProviderTrait;

    /**
     * @var Client
     */
    protected $mailtrap;
    /**
     * @var string
     */
    protected $base_url = 'https://mailtrap.io/api/v1/';

    function __construct(array $config)
    {
        $this->config = $config;
        $this->requiredFields = ['api_token', 'inbox_id'];

        $this->validateConfig();

        $this->mailtrap = new Client(['base_url' => $this->base_url]);
        $this->mailtrap->setDefaultOption('query', ['api_token' => $this->config['api_token']]);
    }

    /**
     * @return void
     */
    public function deleteAllEmails()
    {
        $inboxId = $this->config['inbox'];

        $this->mailtrap->patch("inboxes/{$inboxId}/clean");
    }

    /**
     * @return array
     */
    public function getAllEmails()
    {
        $inboxId = $this->config['inbox_id'];

        return $this->mailtrap->get("inboxes/{$inboxId}/messages")->json();
    }

    /**
     * @return MailTesterMessage
     */
    public function getLastEmail()
    {
        $inboxId = $this->config['inbox_id'];
        $messageId = $this->getAllEmails()[0]['id'];

        $email = $this->mailtrap->get("/api/v1/inboxes/{$inboxId}/messages/{$messageId}")->json();

        return $this->populateMessage($messageId, $email);
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
            ->setSender($email['from_email'])
            ->setRecipients($email['to_email'])
            ->setBody((string)$email['html_body']);

        return $message;
    }
}