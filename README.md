unioPHP
=======

[![Releases](https://img.shields.io/github/release/gimu/douzo.js.svg?style=flat-square)](https://github.com/gimu/unio-php/releases) [![Issues](https://img.shields.io/github/issues/gimu/douzo.js.svg?style=flat-square)](https://github.com/gimu/unio-php/issues)                         

A lightweight PHP framework based on the MVC pattern. It also includes a simple MySQL-PDO-Database library.

## Basics and How To's
Part of the routing is (currently) done with a .htaccess file, which will probably be replaced in the near future.
URL requests should look like this: `/controller/method/parameter`.     

Naming convention (comes with next update):

- Model `nameModel.php` can `@extend BaseModel`
- View `name.php`
- Controller `nameController.php` can `@extend BaseController`

Database library documentation coming soon.

## Installing and running
Simply clone/copy this project to your working Apache webserver and import the demo sql file if necessary.

### Configuration
See `/app/config/config.php`.

## Demo
A small application comes with this build.

### Showcase
[eCommerce+](http://gimu.org/ecommerce) was certainly built on this framework.                  
More information [here](http://gimu.org/ecommerce#technology) - a live demo can be found [here](http://gimu.org/ecommerce/demo).

## License
unioPHP is licensed under the [MIT](http://opensource.org/licenses/MIT) License.
