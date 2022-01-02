
# Symfony Command Test

symfony-test is a command line project to download jsonl file and parse it to csv

## Installation

### Requirement
- composer https://getcomposer.org/download
- symfony https://symfony.com/doc/current/setup.html

### Installation


### Locally, if you have PHP
- clone from repo https://github.com/mhseptiadi/symfony-test
- run `composer install`

### Command

#### Console

##### Help
```shell
Description:
  Parse a json file

Usage:
  jsonl-parse [options]

Options:
  -u, --url[=URL]       Url where jsonl file comes from [default: "https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl"]
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  Parse a jsonl file from url
```

##### Parse from url
```shell
./bin/console jsonl-parse -u http://localhost/PROJECTS/data.jsonl
```

#### Testing 
```shell
 ./bin/phpunit
 ```

#### Code linter
```shell
./vendor/bin/php-cs-fixer fix ./src/
./vendor/bin/php-cs-fixer fix ./tests/
```

## Project Briefs

### External Module Used
`friendsofphp/php-cs-fixer` is used for maintain code standard.
`phpunit/phpunit` is used for creating unit test.

### Structure 
#### Commands Folder
This Command folder contain file `ParseCommand.php` file to be loaded.
#### Services Folder
- `ParseService.php` is service file to start parsing process. This include download jsonl file and parse it to object to be saved to csv
- `OrderService.php` is service file to process logic from json object to Order class.
#### Classes Folder
- `OrderClass.php` is class reference for OrderService.
- `DiscountClass.php` is class to calculate discounts.
- `UnitClass.php` is class to calculate unit related variables.

## Author
- Name: Muhammad Hasan Septiadi
- Email: mh@septiadi.com
- LinkedIn: https://www.linkedin.com/in/mhseptiadi/
