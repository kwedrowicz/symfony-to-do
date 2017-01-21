Symfony TODO
=========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c2f9eb99-e31e-40b9-ab99-451e0b60c7d2/mini.png)](https://insight.sensiolabs.com/projects/c2f9eb99-e31e-40b9-ab99-451e0b60c7d2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/starspire/symfony-to-do/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/starspire/symfony-to-do/?branch=master)
[![Build Status](https://travis-ci.org/starspire/symfony-to-do.svg?branch=master)](https://travis-ci.org/starspire/symfony-to-do)

A simple Symfony ToDo project for training best practices.

Requirements
------------
`Php 7.0|7.1`

Installation
------------
```
php composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console hautelook:fixtures:load
```
