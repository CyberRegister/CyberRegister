# Cyberregister
![Laravel](https://github.com/CyberRegister/CyberRegister/workflows/Laravel/badge.svg)
![Node.js build and lint](https://github.com/CyberRegister/CyberRegister/workflows/Node.js%20build%20and%20lint/badge.svg)
[![codecov](https://codecov.io/gh/CyberRegister/CyberRegister/branch/master/graph/badge.svg)](https://codecov.io/gh/CyberRegister/CyberRegister)
[![CodeFactor](https://www.codefactor.io/repository/github/cyberregister/cyberregister/badge)](https://www.codefactor.io/repository/github/cyberregister/cyberregister)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister?ref=badge_shield)
[![Badges](https://img.shields.io/badge/badges-6-green.svg)](https://shields.io)
[![Cyberveiligheid](https://img.shields.io/badge/Cyberveiligheid-97%25-yellow.svg)](https://nl.wikipedia.org/wiki/Rian_van_Rijbroek)

Installation:
```bash
composer install
cp .env.example .env      # Edit config
php artisan key:generate
php artisan migrate
php artisan passport:keys
yarn install
yarn build
```

Requires PHP 8.3 or newer.

## License

Cyberregister is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FCyberRegister%2FCyberRegister?ref=badge_large)

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
Run a test suite (for a list of availabe suites, see `/phpunit.xml`)
```bash 
vendor/bin/pest --testsuite <suite_name>
```
Run a specific test file
```bash
vendor/bin/pest tests/<optional_folders>/TestFileName
```
Run a specific test case
``bash
vendor/bin/pest --filter <test_case_name>
``
Generate code coverage
```bash
vendor/bin/pest --coverage-html docs/coverage
```
This will create the code coverage docs in `docs/coverage/index.html`