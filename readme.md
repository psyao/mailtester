# MailTester

This package is a [Codeception](http://codeception.com/) module that allows you to test that email are sent to a real SMTP server.


## Installation

Install MailTester through Composer by adding in your composer.json:

```js
"require": {
    "codeception/codeception": "~2.0",
    "psyao/mailtester": "~1.1"
}
```


## Configuration

First enable the module in the suite config, for example, in functional.suite.yml and choose the provider you want to use:

```yml
class_name: FunctionalTester
modules:
    enabled: [Filesystem, FunctionalHelper, MailTester]
    config:
        MailTester:
            provider: "MailCatcher"
```

Currently there is two providers supported.

### MailCatcher

[MailCatcher](http://mailcatcher.me/) runs a super simple SMTP server which catches any message sent to it to display in a web interface. You need it installed on your development server.

```yml
class_name: FunctionalTester
modules:
    ...
    config:
        MailTester:
            provider: "MailCatcher"
            MailCatcher:
                url: 'http://192.168.10.10'
                port: '1080'
```

### MailTrap

[MailTrap](https://mailtrap.io/) is an online fake SMTP server for development teams to test, view and share emails sent from the development and staging environments.

```yml
class_name: FunctionalTester
modules:
    ...
    config:
        MailTester:
            provider: "MailTrap"
            MailTrap:
                api_token: 'myw0nd3rfu7ap1t0k3n'
                inbox_id: '1337'
```


## Example usage

```php
<?php
$I = new FunctionalTester($scenario);
$I->wantTo('send an email');

$I->amOnPage('/contact');

$I->fillField("Your Email", 'john@example.com');
$I->click("Send Email");

$I->seeInLastEmail('Someone tried to get in touch with you!');
$I->seeLastEmailWasSentFrom('john@example.com');
$I->seeLastEmailWasSentTo('patrick@example.com');

$I->dontSeeInLastEmail('Foo');
$I->dontSeeLastEmailWasSentFrom('bar@example.com');
$I->dontSeeLastEmailWasSentTo('baz@example.com');
```


## Methods

See [MailTester.php](https://github.com/psyao/mailtester/blob/master/src/Codeception/Module/MailTester.php) for available methods.


## Changelog

- 1.1 : Added new provider (mailtrap.io)
- 1.0 : First version


## License

Released under the same license as Codeception: MIT