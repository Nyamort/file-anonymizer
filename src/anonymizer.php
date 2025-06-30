<?php
require_once __DIR__ . '/../vendor/autoload.php';

use FileAnonymizer\ConfigLoader;
use FileAnonymizer\FileAnonymizer;
use FileAnonymizer\FileExporter;

if ($argc < 3) {
    echo "Usage: php src/anonymizer.php <config.yaml> <output_dir>\n";
    exit(1);
}

$configPath = $argv[1];
$outputDir = rtrim($argv[2], '/\\') . '/';

function rglob_all($baseDir) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $files[] = $file->getPathname();
        }
    }
    return $files;
}

function match_any_pattern($file, $baseDir, $rules) {
    $relative = ltrim(str_replace($baseDir, '', $file), '/\\');
    foreach ($rules as $rule) {
        $pattern = $rule['files'] ?? '';
        if (fnmatch($pattern, $relative, FNM_PATHNAME | FNM_CASEFOLD)) {
            return $rule['replacement'] ?? '[ANONYMIZED]';
        }
    }
    return null;
}

$config = new ConfigLoader($configPath);
$directories = $config->getDirectories();
$rules = $config->getAnonymizeRules();

foreach ($directories as $dirPattern) {
    $baseDir = rtrim(str_replace('*', '', $dirPattern), '/\\');
    $allFiles = rglob_all($baseDir);
    foreach ($allFiles as $file) {
        $relativePath = FileExporter::getRelativePath($baseDir, $file);
        $outputPath = FileExporter::getOutputPath($outputDir, $relativePath);
        $replacement = match_any_pattern($file, $baseDir, $rules);
        if ($replacement !== null) {
            $anonymizer = new FileAnonymizer($replacement);
            $anonymizer->anonymize($file, $outputPath);
        } else {
            $dir = dirname($outputPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            copy($file, $outputPath);
        }
    }
}
