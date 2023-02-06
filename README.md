Laravel Service Base
====================

A base setup for use in Laravel applications, designed to facilitate clean architecture, CQRS, and DDD. This
repository is intended as a starting point for building scalable, modular, and framework independent project which is
ready to microservice. Utilizing technologies such as Docker, Laravel, Octane, Elasticsearch, and MariaDB.

Installation
------------

To run this repo, follow these steps:

1. Clone the repository:

`git clone https://github.com/hweihwang/laravel-service-base.git`

2. Navigate to the project directory:

`cd laravel-service-base`

3. Make the `make.sh` script executable:

`chmod +x ./make.sh`

4. Run the script:

`./make.sh`

5. Your application should now be running at `http://localhost:19000`


Running Tests
-------------
To run the tests, run the following command:

`docker-compose run test-runner php artisan test`

Prerequisites
-------------

Before running this repo, ensure that you have Docker installed on your system.

Technologies Used
-----------------

- Docker
- Laravel
- Laravel Octane
- Elasticsearch
- MariaDB