<?php namespace Codeception\Module\MailTester;

class MailTesterMessage
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $sender;
    /**
     * @var array
     */
    protected $recipients = [];
    /**
     * @var string
     */
    protected $body;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (integer)$id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param $sender
     *
     * @return $this
     */
    public function setSender($sender)
    {
        $this->sender = (string)$sender;

        return $this;
    }

    /**
     * @return array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param $recipients
     *
     * @return $this
     */
    public function setRecipients($recipients)
    {
        $this->recipients = (array)$recipients;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = (string)$body;

        return $this;
    }
}