<?php


namespace Avent\Services\Infrastructure;

/**
 * Class MailerService
 * @package Avent\Services\Infrastructure
 */
class MailerService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Swift_Message
     */
    private $message;

    /**
     * @var MailTemplateService
     */
    private $template;

    /**
     * @param \Swift_Mailer $mailer
     * @param \Swift_Message $message
     */
    public function __construct(\Swift_Mailer $mailer, \Swift_Message $message, MailTemplateService $template)
    {
        $this->mailer = $mailer;
        $this->message = $message;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->message->setSubject($subject);
    }

    /**
     * @param array $from
     */
    public function setFrom(array $from)
    {
        $this->message->setFrom($from);
    }

    /**
     * @param array $to
     */
    public function setTo(array $to)
    {
        $this->message->setTo($to);
    }

    /**
     * @param string $name
     */
    public function setTemplate($name)
    {
        $this->template->setTemplateFile($name);
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->template->setTags($tags);
    }

    /**
     * return void
     */
    public function send()
    {
        $this->template->replaceTags();
        $this->message->getBody($this->template->getHtml());

        $this->mailer->send($this->message);
    }
}

// EOF
