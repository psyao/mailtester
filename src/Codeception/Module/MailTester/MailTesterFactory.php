<?php namespace Codeception\Module\MailTester;

use InvalidArgumentException;
use ReflectionClass;
use RuntimeException;

class MailTesterFactory
{
    /**
     * @param array $moduleConfig
     *
     * @return MailTestable
     */
    public function make(array $moduleConfig)
    {
        $name = $this->getProviderName($moduleConfig);
        $config = $this->getProviderConfig($moduleConfig, $name);
        $class = $this->getProviderClass($name);

        return new $class($config);
    }


    protected function getProviderName($config)
    {
        if (!isset($config['provider']))
        {
            $message = "A mail testing provider must be specified.";

            throw new InvalidArgumentException($message);
        }

        return $config['provider'];
    }

    /**
     * @param string $driver
     *
     * @return string
     */
    protected function getProviderClassName($driver)
    {
        $class = new ReflectionClass($this);
        $namespace = $class->getNamespaceName();

        return "{$namespace}\\Providers\\{$driver}";
    }

    protected function getProviderConfig($config, $provider)
    {
        if (!isset($config[$provider]))
        {
            $message = "Config options for [$provider] must be specified.";

            throw new InvalidArgumentException($message);
        }

        return $config[$provider];
    }

    /**
     * @param string $driver
     *
     * @return string
     */
    protected function getProviderClass($driver)
    {
        $provider = $this->getProviderClassName($driver);

        if (!class_exists($provider))
        {
            $message = "Provider class [$provider] does not exist.";

            throw new RuntimeException($message);
        }

        return $provider;
    }

} 