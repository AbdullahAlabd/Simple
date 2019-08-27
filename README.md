# Simple [![Open Source Love svg1](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)](https://github.com/ellerbrock/open-source-badges/)[![PyPI license](https://img.shields.io/pypi/l/ansicolortags.svg)](https://pypi.python.org/pypi/ansicolortags/)

Simple is a real-time (one to one) chat app made with Laravel and Vue.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

To be able to run the project on your system you should have:
*Git *PHP v7.3.5+ Mysql v14.14+ *Node v8.12.0+ *NPM v6.4.1+ *Composer v1.8.6+

Note: you might be able to run the project on older versions than versions mentioned above but to avoid any issues we recommend you to use the recommended versions

### Installation

A step by step series of examples that tell you how to get a development env running

    1. Clone gitHub repo:
        git clone https://github.com/Abdullahalabd/Simple.git

    2. For next steps you have to change your currend directory to the project directory by running:
        cd Simple
    
    3. To install project dependencies:
        composer install
        npm instal

    4. To be able to run the project:
         *Take a copy of .env.example file and name it .env or by running: cp .env.example .env
         *Edit .env file and fill your DB_ host credentials.
         *Migrate project's DB tables to your DB by running: php artisan migrate 
         *Set a key for Laravel's encrypter by running: php artisan key:generate
         *Create a link to Storage folder by running: php artisan storage:link

    5. Finally to run the project:
        php artisan serve


## Built With

-   [Laravel](https://laravel.com/docs/5.8) - Web Framework For PHP
-   [Vue](https://vuejs.org/) - UI Framework

## Authors

-   **Nour Mohammed** - Design & Deveopment - [Nour-7](https://github.com/Nour-7)
-   **Abdullah Al-Abd** - Design & Deveopment - [Abdullahalabd](https://github.com/Abdullahalabd)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Acknowledgments
-   //todo
