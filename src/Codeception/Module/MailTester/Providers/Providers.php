<?php namespace Codeception\Module\MailTester\Providers;

use Codeception\Exception\ModuleConfig;

abstract class Providers
{
    /**
     * @var array
     */
    protected $config = array();
    /**
     * @var array
     */
    protected $requiredFields = array();

    /**
     * @return void
     * @throws ModuleConfig
     */
    protected function validateConfig()
    {
        $fields = array_keys($this->config);

        if (array_intersect($this->requiredFields, $fields) != $this->requiredFields)
        {
            throw new ModuleConfig(
                get_class($this),
                "\nOptions: " . implode(', ', $this->requiredFields) . " are required.\n
                Please, update the configuration and set all the required fields\n\n"
            );
        }
    }
} 