# Cyber Register
<p align="center">
<a href="https://travis-ci.org/annejan/cyber-register"><img src="https://travis-ci.org/annejan/cyber-register.svg" alt="Build Status"></a>
</p>

Installation:
```bash
composer install
cp .env.example .env      # Edit config
php artisan key:generate
php artisan migrate
npm install
npm run prod
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
npm run dev
```
With live-reload:
```bash
npm run watch
```
## Running tests
 
 Run all the tests
 ```bash
phpunit
```
 
 Run a test suite (for a list of availabe suites, see `/phpunit.xml`)
```bash 
 phpunit --testsuite suite_name>
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