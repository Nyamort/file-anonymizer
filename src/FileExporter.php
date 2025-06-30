<?php
namespace FileAnonymizer;

class FileExporter
{
    public static function getRelativePath(string $baseDir, string $filePath): string
    {
        return ltrim(str_replace($baseDir, '', $filePath), '/\\');
    }

    public static function getOutputPath(string $outputDir, string $relativePath): string
    {
        return rtrim($outputDir, '/\\') . '/' . $relativePath;
    }
}
