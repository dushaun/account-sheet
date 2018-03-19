# Account Sheet

Quick account api in Laravel

## Installation & Setup
This project was developed in the PHP framework Laravel, the best way to run it is through its dedicated dev environment called Valet.

Valet requires macOS and [Homebrew](http://brew.sh/). Before installation, you should make sure that no other programs (such as Apache or Nginx) are binding to your local machine's port 80.

To get Valet up and running, you should do the following:

* Install or update Homebrew to the latest version using ```brew update```.
* Install PHP 7.2 using Homebrew via ```brew install homebrew/php/php72```.
* Install Valet with [Composer](https://getcomposer.org/) via ```composer global require laravel/valet```. Make sure the  ```~/.composer/vendor/bin``` directory is in your system's "PATH".
* Run the ```valet install``` command. This will configure and install Valet and DnsMasq, and register Valet's daemon to launch when your system starts.

Next, [download](https://github.com/dushaunac/account-sheet) or clone the project into a designated dev folder such as ```~/Sites```. That folder will be the one that Valet "parks" itself to serve the project website. To do this, you will need to do the following:

* In terminal ```cd ~/Sites``` and run ```valet park```. This command will register your current working directory as a path that Valet should search for sites.
* Next, ```cd account-sheet/``` to run ```valet link```, following with ```valet secure```
* Once that's done, run ```valet domain app```, to designate a TLD. Then we can run ```valet links``` to check our domain for the project
* To check that Valet is working open ```https://account-sheet.app``` in your browser to see if it is serving.
* If Valet is working, continue with the setup steps below. Otherwise, refer to the offical [Valet documentation](https://laravel.com/docs/5.6/valet)

Before using the app, please make sure you make your own ```.env``` file from the ```.env.example``` in the root directory of this project. After that, run the following commands:

* ```composer install``` to download the php packages
* ```php artisan key:generate``` to give the project a unique key that Laravel can work with

The project setup is now complete and ready for use.

That should be it. Now you should be able to launch the website to use the features required for this challenge. If you get stuck on any part of this installation process, please have a look at the documentation:

* [Laravel Valet](https://laravel.com/docs/5.6/valet)
* [Homebrew](http://brew.sh/)
* [Composer](https://getcomposer.org/doc/)

_Parts of the text above have been sourced from some of the documention linked above_

## Epic Selection

I decided to go for all epics provided. I thought they were good challenges I wanted to take on, and also learn from. For example, the usage of ```similar_text()``` for the search in the 3rd epic. I have split the three epics within the API as well, this is to keep it organised and make sure each epic can be tested independently of each other.

## API Interaction

| Domain | Method   | URI                                 | Name | Action                                              | Middleware |
|--------|----------|-------------------------------------|------|-----------------------------------------------------|------------|
|        | GET      | /                                   |      | Closure                                             | web        |
|        | GET      | api/e1/account/{guid}/balance       |      | App\Http\Controllers\E1\AccountController@balance   | api        |
|        | GET      | api/e1/account/{guid}/details       |      | App\Http\Controllers\E1\AccountController@details   | api        |
|        | GET      | api/e1/customer/account/{guid}      |      | App\Http\Controllers\E1\CustomerController@account  | api        |
|        | GET      | api/e1/customer/debt                |      | App\Http\Controllers\E1\CustomerController@debt     | api        |
|        | GET      | api/e2/account/{guid}/balance       |      | App\Http\Controllers\E2\AccountController@balance   | api        |
|        | GET      | api/e2/account/{guid}/details       |      | App\Http\Controllers\E2\AccountController@details   | api        |
|        | GET      | api/e2/customer/{id}/account/{guid} |      | App\Http\Controllers\E2\CustomerController@account  | api        |
|        | GET      | api/e2/customer/{id}/debt           |      | App\Http\Controllers\E2\CustomerController@debt     | api        |
|        | GET      | api/e3/customer/{id}/balances       |      | App\Http\Controllers\E3\CustomerController@balances | api        |
|        | GET      | api/e3/customer/{id}/search         |      | App\Http\Controllers\E3\CustomerController@search   | api        |

* ```{guid}``` represents the account id
* ```{id}``` represents the customer id

#### The only routes that allow request queries are the ones for the 3rd epic:

* ```https://account-sheet.app/api/e3/customer/{id}/balances``` with the option to add ```?min=&max=``` for request queries
* ```https://account-sheet.app/api/e3/customer/{id}/search``` with the option to add ```?firstname=&lastname=``` for request queries

_Please look at the examples in the Feature Tests to get an idea of how they are used_

## Testing

I wrote some tests for this challenge as well. This is to make sure all epics are tested for the desired functionality. You can find them in ```tests/Feature```.

These tests are ran by PHPUnit. If you don't have it installed, you can run ```brew install phpunit``` to install. Once this has completed, you should be able to run ```phpunit``` in the root directory of this challenge and they should run.

The tests themselves describe what they are doing and sometimes the limitations of the epic.