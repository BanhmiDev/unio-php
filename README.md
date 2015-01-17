unioPHP
=======
[![License](http://img.shields.io/badge/license-MIT-red.svg?style=flat-square)](https://github.com/gimu/unio-php/blob/master/LICENSE.txt) [![Releases](https://img.shields.io/github/release/gimu/unio-php.svg?style=flat-square)](https://github.com/gimu/unio-php/releases) [![Issues](https://img.shields.io/github/issues/gimu/unio-php.svg?style=flat-square)](https://github.com/gimu/unio-php/issues)                         

A lightweight PHP framework based on the MVC pattern.            
It also includes a simple MySQL-PDO-Database library.

## Basics and How To's
Part of the routing is done with a simple .htaccess file.              
URL requests should look like this: `/controller/method/parameter`. It will either default to the base-controller or to the error-controller if an invalid url was passed.

Naming convention:

- Model `nameModel.php` can `@extend BaseModel`
- View `name.php`
- Controller `nameController.php` can `@extend BaseController`

Database library documentation coming soon.

## Installing and running
Simply clone/copy this project to your working Apache webserver and import the sql file located in the `sql` directory.

### Configuration
See `/app/config/config.php`.

## Demo
The latest working build is available at [this site](http://gimu.org/unio-php).

### Showcase
[eCommerce+](http://gimu.org/ecommerce) was certainly built on this framework.

## License
unioPHP is licensed under the [MIT](http://opensource.org/licenses/MIT) License.
