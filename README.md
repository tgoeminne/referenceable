# Referenceable plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require tgoeminne/referenceable
```

$this->addBehavior('Referenceable',[
    'field' => 'reference',
]);

Will add a reference number consisting of 2 letters and 6 digits between (111111 and 999999). Also make sure you create the field reference in your table.
