GitHub Notifications
====================

GitHub Notifications was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is a simple command line tool to mark all notifications about issues or rejected PRs as read on a given organization. Feel free to check out the [releases](https://github.com/GrahamCampbell/GitHub-Notifications/releases), [security policy](https://github.com/GrahamCampbell/GitHub-Notifications/security/policy), [license](LICENSE), [code of conduct](.github/CODE_OF_CONDUCT.md), and [contribution guidelines](.github/CONTRIBUTING.md).

![Banner](https://user-images.githubusercontent.com/2829600/71477091-0f3c7780-27e0-11ea-88f6-077601e11046.png)

<p align="center">
<a href="https://github.com/GrahamCampbell/GitHub-Notifications/actions?query=workflow%3ATests"><img src="https://img.shields.io/github/workflow/status/GrahamCampbell/GitHub-Notifications/Tests?label=Tests&style=flat-square" alt="Build Status"></img></a>
<a href="https://github.styleci.io/repos/124759574"><img src="https://github.styleci.io/repos/124759574/shield" alt="StyleCI Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"></img></a>
<a href="https://packagist.org/packages/graham-campbell/github-notifications"><img src="https://img.shields.io/packagist/dt/graham-campbell/github-notifications?style=flat-square" alt="Packagist Downloads"></img></a>
<a href="https://github.com/GrahamCampbell/GitHub-Notifications/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/GitHub-Notifications?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

[PHP](https://php.net) 7.2+ is required. To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer global require graham-campbell/github-notifications
```

Alternatively, you can simply clone the repo and run `composer install` in the folder.


## Authentication

You'll also need to create yourself a [personal access token](https://github.com/settings/tokens) for GitHub's API with access to the `notifications` scope. 

## Usage

By default, we'll try and read your personal access token for GitHub from the `GITHUB_TOKEN` environment variable, however you can also specify a token with the `--token` command-line flag.

To clear all issue notifications for the Laravel organization:

```bash
$ notifications clear laravel
```

Or, if you are specifying a token:

```bash
$ notifications clear laravel --token {...}
```


## Building

The following documentation is for contributors to this package only.

To build the `phar` file, run:

```bash
$ make composer-install
$ make box-compiler
```


## Security

If you discover a security vulnerability within this package, please send an e-mail to Graham Campbell at graham@alt-three.com. All security vulnerabilities will be promptly addressed.


## License

GitHub Notifications is licensed under [The MIT License (MIT)](LICENSE).
