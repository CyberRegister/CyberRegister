# Cyber Register
[![Build Status](https://travis-ci.org/annejan/cyber-register.svg)](https://travis-ci.org/annejan/cyber-register)
[![CodeClimate maintainability](https://api.codeclimate.com/v1/badges/0cd3ddb9f5bc622869c8/maintainability)](https://codeclimate.com/github/annejan/cyber-register/maintainability)
[![CodeClimate test coverage](https://api.codeclimate.com/v1/badges/0cd3ddb9f5bc622869c8/test_coverage)](https://codeclimate.com/github/annejan/cyber-register/test_coverage)
[![Codacy grade](https://api.codacy.com/project/badge/Grade/00f75cc741ef48969d38866e9789e3f7)](https://www.codacy.com/app/annejan/cyber-register?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=annejan/cyber-register&amp;utm_campaign=Badge_Grade)
[![Codacy coverage](https://api.codacy.com/project/badge/Coverage/00f75cc741ef48969d38866e9789e3f7)](https://www.codacy.com/app/annejan/cyber-register?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=annejan/cyber-register&amp;utm_campaign=Badge_Coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/annejan/cyber-register/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/annejan/cyber-register/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/annejan/cyber-register/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/annejan/cyber-register/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/annejan/cyber-register/badges/build.png?b=master)](https://scrutinizer-ci.com/g/annejan/cyber-register/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/annejan/cyber-register/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

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

Cyber Register is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

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
