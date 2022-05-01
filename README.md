# Avast

### Setup
- clone repo in to the directory in your local machine
- open directory with cloned repo
- run `docker-compose build`
- run `docker-compose up -d` then wait some time
- run `docker-compose exec avast bash` to login into the shell of the container
- run `cd /app && composer install` to install dependencies
- run `sh export.sh -v config.xml redis 6379 1` where are:
  - redis - default redis host in the container;
  - 6379 - default redis port number;
  - 1 - default redis db;
  - -v - non required parameter to display all existing key from the current redis DB
- it works!