<?php


namespace Avent\Services\Infrastructure;

/**
 * Class MailTemplateService
 * @package Avent\Services\Infrastructure
 */
class MailTemplateService
{
    /**
     * @var string
     */
    private $template_file;

    /**
     * @var array
     */
    private $tags;

    /**
     * @var string
     */
    private $html;

    /**
     * @param string $template_file
     * @param array $tags
     */
    public function __construct($template_file = null, array $tags = [])
    {
        $this->template_file = $template_file;
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->template_file;
    }

    /**
     * @param string $template_file
     */
    public function setTemplateFile($template_file)
    {
        $this->template_file = $template_file;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * return void
     */
    public function replaceTags()
    {
        $content = file_get_contents($this->template_file);

        foreach ($this->tags as $key => $value) {
            $this->html = str_replace("%" . strtoupper($key) . "%", $value, $content);
        }
    }
}

// EOF
