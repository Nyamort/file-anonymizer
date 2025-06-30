<?php
namespace FileAnonymizer;

class FileAnonymizer
{
    private $replacement;

    public function __construct(string $replacement)
    {
        $this->replacement = $replacement;
    }

    public function anonymize(string $filePath, string $outputPath): void
    {
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($outputPath, $this->replacement);
    }
}
