# FileAnonymizer

A PHP tool to export and anonymize files based on YAML-configurable rules.

## Features
- Exports all files from one or more source folders, preserving the folder structure.
- Anonymizes files according to patterns (e.g. `*.csv`, `**/*.png`), with customizable replacement text.
- Files not matching any anonymization rule are simply copied.

## Usage with GitHub Container Registry (ghcr.io)
You can use the pre-built image from GitHub Packages:

```bash
docker run --rm -v $(pwd):/app ghcr.io/nyamort/fileanonymizer:latest config.yaml output/
```
- Replace `config.yaml` with your config file path (relative to your current directory)
- Replace `output/` with your desired output directory (relative to your current directory)

## Manual Installation
1. Clone the repository or copy the files into a folder.
2. Install PHP dependencies:
   ```bash
   composer install
   ```

## Usage (without Docker)

```bash
php src/anonymizer.php <config.yaml> <output_dir>
```
- `<config.yaml>`: path to the YAML configuration file
- `<output_dir>`: directory where files will be exported (structure preserved)

### Example configuration (`config.yaml`)
```yaml
directories:
  - "data/input/"
anonymize:
  - files: "**/*.png"
    replacement: "Anonymized PNG"
  - files: "*.csv"
    replacement: "Anonymized CSV"
  - files: "**/*.csv"
    replacement: "Anonymized CSV"
```

## Explanation
- `directories`: list of folders to scan (wildcards supported)
- `anonymize`: list of rules, each rule contains:
  - `files`: glob pattern to target files
  - `replacement`: text to replace the file content

## Example
To anonymize all `.csv` and `.png` files in `data/input/` and export to `data/output/`:
```bash
docker run --rm -v $(pwd):/app ghcr.io/nyamort/fileanonymizer:latest config.yaml data/output/
```
Or without Docker:
```bash
php src/anonymizer.php config.yaml data/output/
```

## Dependencies
- PHP >= 8.0
- [symfony/yaml](https://packagist.org/packages/symfony/yaml)

## License
MIT
