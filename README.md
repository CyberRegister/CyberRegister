# Cyberregister
[![Build Status](https://travis-ci.org/CyberRegister/CyberRegister.svg)](https://travis-ci.org/CyberRegister/CyberRegister)
[![CodeClimate maintainability](https://api.codeclimate.com/v1/badges/d06b9ceaf76db20fd066/maintainability)](https://codeclimate.com/github/CyberRegister/CyberRegister/maintainability)
[![CodeClimate test coverage](https://api.codeclimate.com/v1/badges/d06b9ceaf76db20fd066/test_coverage)](https://codeclimate.com/github/CyberRegister/CyberRegister/test_coverage)
[![Codacy grade](https://api.codacy.com/project/badge/Grade/372524fda06445b7a6197030f6eda63c)](https://www.codacy.com/app/CyberRegister/CyberRegister?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=CyberRegister/CyberRegister&amp;utm_campaign=Badge_Grade)
[![Codacy coverage](https://api.codacy.com/project/badge/Coverage/372524fda06445b7a6197030f6eda63c)](https://www.codacy.com/app/CyberRegister/CyberRegister?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=CyberRegister/CyberRegister&amp;utm_campaign=Badge_Coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/badges/build.png?b=master)](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/CyberRegister/CyberRegister/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![StyleCI](https://styleci.io/repos/120670007/shield?branch=master)](https://styleci.io/repos/120670007)
[![Badges](https://img.shields.io/badge/badges-12-green.svg)](https://shields.io)
[![Cyberveiligheid](https://img.shields.io/badge/Cyberveiligheid-97%25-yellow.svg)](https://eurocyber.nl)

Installation:
```bash
composer install
cp .env.example .env      # Edit config
php artisan key:generate
php artisan migrate
yarn install
yarn production
```
## License

Cyberregister is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Development

Running the development server:
```bash
php artisan serve
```
Frontend development:
```bash
yarn dev
```
With live-reload:
```bash
yarn watch
```
## Running tests
 
Run all the tests
```bash
phpunit
```
Run a test suite (for a list of availabe suites, see `/phpunit.xml`)
```bash 
phpunit --testsuite <suite_name>
```
Run a specific test file
```bash
phpunit tests/<optional_folders>/TestFileName
```
Run a specific test case
``bash
phpunit --filter <test_case_name>
``
Generate code coverage
```bash
phpunit --coverage-html docs/coverage
```
This will create the code coverage docs in `docs/coverage/index.html`
