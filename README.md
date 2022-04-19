# Domain Driven Laravel Shift Blueprint Addon

Generate a Design Driven DataObject and Factory with `php artisan blueprint:build` command

This plugin is based on [Blueprint Nova Addon](https://github.com/Naoray/blueprint-nova-addon) by [Krishan König](https://github.com/naoray) and the [Tall-blueprint-addon](https://github.com/tanthammar/tall-blueprint-addon) by [TinaH](https://github.com/tanthammar)

# What you get

* For each model you will get a DataObject and and Factory
* A basic PHPUnit or Pest test to test the two
* Contracts for the DataObject and Factory

## Installation
* Install Laravel
* Then Install Blueprint and this package

````bash
composer require --dev arnonm/ddblueprintaddon
````

## Usage
Refer to [Blueprint's Basic Usage](https://github.com/laravel-shift/blueprint#basic-usage)
to get started. Afterwards you can run the `blueprint:build` command to
generate DataObjects and Factories automatically. 



## Credits

- [TinaH](https://github.com/tanthammar) for [TALL-forms Blueprint Addon](https://github.com/tanthammar/tall-blueprint-addon)
- [Krishan König](https://github.com/naoray) for [Blueprint Nova Addon](https://github.com/Naoray/blueprint-nova-addon)
- [Jason McCreary](https://github.com/jasonmccreary) for [Blueprint](https://github.com/laravel-shift/blueprint)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.