# Authenticated
All software, mobile applications and websites require an authentication software to manage their accesses to users and software, using a role and permission model.  So I decided to create one under a free and open-source license (MIT) for everyone to use.  The software uses a micro-service architecture using REST APIs.

So far, I created the CRUD API.  You can see its code under the CRUD folder below.  The code is written in the Rodson DSL, in the json file.  The PHP file contains specific input validation.

## Discussion
You can discuss this application on:

* [Hacker News](https://news.ycombinator.com/item?id=13056386)
* [Reddit](https://www.reddit.com/r/irestful/comments/5fchvw/created_the_crud_api_of_an_authentication_software/)
* [Facebook](https://www.facebook.com/steve.rodrigue.tech/posts/1769694656628480)
* [Twitter](https://twitter.com/irestful/status/803272583693168641)

## Requirements
* [PHP7](http://php.net/downloads.php)
* [Virtualbox](https://www.virtualbox.org/)
* [Vagrant](https://www.vagrantup.com/)

## Compile the Rodson code to PHP7

To compile the code to PHP, simply clone this repository, then go in its root and execute this command in the CLI:

```bash
php bin/rodson.php --input src/iRESTful/Products/Authenticated/CRUD/authenticated.json --output build/Products/Authenticated/CRUD;
```

The compiled code will be created in this folder: build/Products/Authenticated/CRUD

## Execute the compiled PHP7 code in development:

To execute the compiled code using Vagrant, simply go in the root of the compiled code:

```bash
cd build/Products/Authenticated/CRUD;
```

Then boot the virtual machine and ssh into it:

```bash
vagrant up;
vagrant ssh;
```

Then, install the application:

```bash
cd /vagrant/;
php composer.phar install;
```

Run its tests:

```bash
vendor/bin/phpunit -c .;
```

## What's next?
This example showed how to compile an existing CRUD API built with Rodson.  In the next few days, I'll create a fully working authentication software with Rodson.  I'll also add the Rodson documentatin at the root of this git repo.  Stay tuned!

The production versions will use [Docker](https://www.docker.com/) and [Docker-machine](https://docs.docker.com/machine/).

## Follow me
* Reddit: [/r/irestful](http://reddit.com/r/irestful)
* Twitter: [@irestful](https://twitter.com/irestful)
* [Facebook](https://www.facebook.com/steve.rodrigue.tech/?fref=ts)
