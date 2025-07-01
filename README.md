# FileAnonymizer

A PHP tool to export and anonymize files based on YAML-configurable rules.

## Features
- Exports all files from one or more source folders, preserving the folder structure.
- Anonymizes files according to patterns (e.g. `*.csv`, `**/*.png`), with customizable replacement text.
- Files not matching any anonymization rule are simply copied.

## Usage with GitHub Container Registry (ghcr.io)
You can use the pre-built image from GitHub Packages.

**Important:** Do not mount your entire project directory to `/app` as it will overwrite the application code inside the container. Instead, only mount the necessary files and folders (config, input, output).

### Example
Suppose you have the following structure:
```
/tmp/
  config.yaml
  input/
  output/   # (can be empty, will be filled by the tool)
```
Run:
```bash
docker run --rm \
  -v $(pwd)/config.yaml:/app/config.yaml \
  -v $(pwd)/input:/app/input \
  -v $(pwd)/output:/app/output \
  ghcr.io/nyamort/file-anonymizer:latest config.yaml output/
```
- `config.yaml` is your configuration file.
- `input/` is your input folder (as referenced in your config).
- `output/` is your output folder (will be created if it doesn't exist).

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
  - "input/"
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
To anonymize all `.csv` and `.png` files in `input/` and export to `output/`:
```bash
docker run --rm \
  -v $(pwd)/config.yaml:/app/config.yaml \
  -v $(pwd)/input:/app/input \
  -v $(pwd)/output:/app/output \
  ghcr.io/nyamort/file-anonymizer:latest config.yaml output/
```
Or without Docker:
```bash
php src/anonymizer.php config.yaml output/
```

## Dependencies
- PHP >= 8.0
- [symfony/yaml](https://packagist.org/packages/symfony/yaml)

## License
MIT
