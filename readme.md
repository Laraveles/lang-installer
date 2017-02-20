## Laraveles Lang Installer

This package makes it easy to add the default language files translated into Spanish to Laravel.
The generated files are based in https://github.com/Laraveles/lang-spanish.

## Installation

You can install the package via composer:

``` bash
composer global require nerdify/laraveles-lang-installer
```

Make sure to place the `$HOME/.composer/vendor/bin` directory in your $PATH so the `laraveles-lang` executable can be located by your system.

#### Add lang files

You can run the `generate` command to add the files:

``` bash
laraveles-lang generate
```