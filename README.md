# Laravel Immutable Attributes

Make attributes on your Laravel models immutable...i.e. after the model is created, the value of the immutable attributes cannot change when updating records with Eloquent.

## Installation

**Requirements**: This package requires PHP 7.1.3 or higher and Laravel 5.7

```sh
$ composer require zablockibros/laravel-immutable
```

The package will automatically register its service provider.

## Define Immutable Attributes

Define the attributes to be immutable on your model:
```php
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use ZablockiBros\Immutable\Traits\HasImmutableAttributes;
 
class YourModel extends Model
{
    use HasImmutableAttributes;
    
    /**
     * @var array
     */
    protected $immutable = [
        'name',
        'sku',
    ];
```

In this example, `name` and `sku` can be set on model creation, however, the attributes will not persist changes of their value to a database on update.

## Copyright and License

[MIT License](LICENSE.md).

Copyright (c) 2019 Justin Zablocki
