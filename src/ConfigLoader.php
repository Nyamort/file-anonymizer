<?php
namespace FileAnonymizer;

use Symfony\Component\Yaml\Yaml;

class ConfigLoader
{
    private $config;

    public function __construct(string $configPath)
    {
        $this->config = Yaml::parseFile($configPath);
    }

    public function getDirectories(): array
    {
        return $this->config['directories'] ?? [];
    }

    public function getAnonymizeRules(): array
    {
        return $this->config['anonymize'] ?? [];
    }
}
