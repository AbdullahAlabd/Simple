# Simple

Simple is a real-time (one to one) chat app made with Laravel and Vue.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

To be able to run the project on your system you should have:
*Git *PHP v7.3.5+ Mysql v14.14+ *Node v8.12.0+ *NPM v6.4.1+ *Composer v1.8.6+

Note: you might be able to run the project on older versions than versions mentioned above but to avoid any issues we recommend you to use the recommended versions

### Installation

A step by step series of examples that tell you how to get a development env running

    Clone gitHub repo:
        git clone https://github.com/Abdullahalabd/Simple.git

    Inside project directory run these commands to install project dependencies:
        composer install
        npm instal

    Then to be able to run the project:
         *at the project directory take a copy of .env.example name it .env and enter you DB host credentials
         *set a key for Laravel's encrypter by running: php artisan key:generate
         *create a link to Storage folder by running: php artisan storage:link

    And finally to run the project:
        php artisan serve

## Deployment

//todo
Add additional notes about how to deploy this on a live system

## Built With

-   [Laravel](https://laravel.com/docs/5.8) - Web Framework For PHP
-   [Vue](https://vuejs.org/) - UI Framework

## Authors

-   **Nour Mohammed** - _Initial work_ - [Nour-7](https://github.com/Nour-7)
-   **Abdullah Al-Abd** - _Initial work_ - [Abdullahalabd](https://github.com/Abdullahalabd)

## License
//todo
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments
-   //todo
-   Hat tip to anyone whose code was used
-   Inspiration
-   etc
