# Cyberregister
![Laravel](https://github.com/CyberRegister/CyberRegister/workflows/Laravel/badge.svg)
![Node.js build and lint](https://github.com/CyberRegister/CyberRegister/workflows/Node.js%20build%20and%20lint/badge.svg)
[![codecov](https://codecov.io/gh/CyberRegister/CyberRegister/branch/master/graph/badge.svg)](https://codecov.io/gh/CyberRegister/CyberRegister)
[![CodeFactor](https://www.codefactor.io/repository/github/cyberregister/cyberregister/badge)](https://www.codefactor.io/repository/github/cyberregister/cyberregister)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister?ref=badge_shield)
[![REUSE status](https://api.reuse.software/badge/github.com/CyberRegister/CyberRegister)](https://api.reuse.software/info/github.com/CyberRegister/CyberRegister)
[![Badges](https://img.shields.io/badge/badges-8-green.svg)](https://shields.io)
[![Cyberveiligheid](https://img.shields.io/badge/Cyberveiligheid-97%25-yellow.svg)](https://nl.wikipedia.org/wiki/Rian_van_Rijbroek)

A register of cyber security experts, their expertises and PCE points, built
on Laravel 13.

## Requirements

* PHP 8.3 or newer, with the `imagick`, `gd`, `pdo_mysql`, `mbstring`, `bcmath`,
  `intl`, `zip` and `fileinfo` extensions
* Composer 2
* Node 22 or newer, with Yarn
* MySQL or MariaDB

## Installation

```bash
composer install
cp .env.example .env      # Edit config
php artisan key:generate
php artisan migrate
php artisan passport:keys
yarn install
yarn build
```

## Two factor authentication

Accounts can be secured with a time based one time password (Google2FA) and
with a hardware security key over WebAuthn. Both are optional and can be used
together. Users who register neither are not prompted for a second factor.

WebAuthn needs a secure context, so hardware keys only work over HTTPS or on
`localhost`.

## Development

Running the development server:
```bash
php artisan serve
```
Frontend development server (with hot module replacement):
```bash
yarn dev
```
Production build:
```bash
yarn build
```

## Running tests

Run all the tests
```bash
vendor/bin/pest
```
Run a test suite (for a list of available suites, see `/phpunit.xml`)
```bash
vendor/bin/pest --testsuite <suite_name>
```
Run a specific test file
```bash
vendor/bin/pest tests/<optional_folders>/TestFileName
```
Run a specific test case
```bash
vendor/bin/pest --filter <test_case_name>
```
Generate code coverage
```bash
vendor/bin/pest --coverage-html docs/coverage
```
This will create the code coverage docs in `docs/coverage/index.html`

## Static analysis

The code is analysed by [PHPStan](https://phpstan.org/) with
[Larastan](https://github.com/larastan/larastan) at level 8, which is also
enforced in CI:
```bash
vendor/bin/phpstan analyse
```

## Linting the front-end

```bash
yarn lint
```

## Licensing

Cyberregister is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
The Laravel framework is likewise licensed under the [MIT license](http://opensource.org/licenses/MIT).

Licensing follows the [REUSE](https://reuse.software/) specification. Every
file is accounted for, either by the blanket entry in `REUSE.toml` or by a more
specific one, and the full text of every licence used lives in `LICENSES/`.
CI enforces this, and you can check it yourself with:

```bash
reuse lint
```

Not everything in here is MIT, so read `REUSE.toml` before reusing parts of it:

* The **security key illustration** in `public/static` came from Google and
  carries no licence statement, so it is marked
  `LicenseRef-Unverified-Provenance` rather than assumed to be covered by the
  project licence. That identifier grants nothing; it records that the question
  is open.

### Fonts

Type is [IBM Plex](https://www.ibm.com/plex/) Sans and Serif, licensed under
the SIL Open Font License 1.1. It arrives through the `@fontsource` packages
and is served from this application's own origin, so no request goes to a font
CDN when a page is rendered and no font files are committed here.

The Rijksoverheid house style fonts this project used to carry were removed.
The Dutch State reserved its copyright on them under article 15b of the
Auteurswet, and use requires prior written permission from the
Rijksvoorlichtingsdienst unless the work is carried out for the Rijksoverheid,
which is not a claim this project can make.

### Dependency licence choices

`nette/schema` and `nette/utils` reach this project through
`league/commonmark`, which Laravel uses to render Markdown mail. Both are
offered under more than one licence:

> You may use Nette Framework under the terms of either the New BSD License or
> the GNU General Public License (GPL) version 2 or 3. The BSD License is
> recommended for most projects.

The licences are alternatives rather than cumulative, so **this project uses
them under BSD-3-Clause** and takes on no GPL obligation. Scanners that read
the licence list as a conjunction will report these two as copyleft findings;
that reading is wrong, and the choice recorded here is the answer to it.


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister?ref=badge_large)
