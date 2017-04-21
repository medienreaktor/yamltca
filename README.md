# TYPO3 Extension ``yamltca``

Generate TCA (Table Configuration Array) from YAML files.

__Notice:__ This is just a proof of concept. It works, but usage is experimental.

## Features

* Generate TCA from YAML files
* Generate and merge TCA-overrides from YAML files

## Installation

Just install the extension via Extension Manager.

## Usage

### Generate TCA

In your extension, place YAML files corresponding to your tables, e.g.:

__Configuration/TCA/your_table.yaml__

    your_table:
      ctrl:
        label: 'header'
        label_alt: 'subheader,bodytext'
        sortby: 'sorting'
        ...
      columns:
        header:
          label: 'Header'
          config:
            type: 'input'
            size: 50
            max: 255
        subheader:
          label: 'Subheader'
          ...

TCA will automatically be generated upon your YAML files (please clear all caches after changes to these files). You are free to mix and match between TCA in PHP and TCA in YAML files.

### Generate TCA-overrides

In the exact same way, place TCA overrides in your extension in YAML files, e.g.:

__Configuration/TCA/Overrides/tt_content.yaml__

    tt_content:
      columns:
        header:
          config:
            size: 20
            max: 20
      ...

TCA will be generated and merged automatically.
