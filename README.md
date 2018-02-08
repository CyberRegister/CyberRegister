# Cyber Register
<p align="center">
<a href="https://travis-ci.org/annejan/cyber-register"><img src="https://travis-ci.org/annejan/cyber-register.svg" alt="Build Status"></a>
<a href="https://codeclimate.com/github/annejan/cyber-register/maintainability"><img src="https://api.codeclimate.com/v1/badges/0cd3ddb9f5bc622869c8/maintainability" /></a>
<a href="https://codeclimate.com/github/annejan/cyber-register/test_coverage"><img src="https://api.codeclimate.com/v1/badges/0cd3ddb9f5bc622869c8/test_coverage" /></a>
<a class="badge-align" href="https://www.codacy.com/app/annejan/cyber-register?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=annejan/cyber-register&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/00f75cc741ef48969d38866e9789e3f7"/></a>
<a class="badge-align" href="https://www.codacy.com/app/annejan/cyber-register?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=annejan/cyber-register&amp;utm_campaign=Badge_Coverage"><img src="https://api.codacy.com/project/badge/Coverage/00f75cc741ef48969d38866e9789e3f7"/></a>
</p>

Installation:
```bash
composer install
cp .env.example .env      # Edit config
php artisan key:generate
php artisan migrate
yarn install
yarn run prod
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
yarn run dev
```
With live-reload:
```bash
yarn run watch
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
 ```bash
 phpunit --filter <test_case_name>
 ```
 Generate code coverage
 ```bash
 phpunit --coverage-html docs/coverage
 ```
 This will create the code coverage docs in `docs/coverage/index.html`
