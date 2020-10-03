1. Composer install to install all relevant packages

2. For API please use this collection link https://www.getpostman.com/collections/118ee86d0264769ea7d2

3. For view the result to below


To create all table please run the below command.

    php artisan migrate

Exercise 1

Please run below command to start the server

    php artisan serve

2 i. http://localhost:8000/routers


3 Please run 

    php artisan db:seed 3

4. Please user the url http://localhost:8000/canvas to see the result




Exercise 2
  1.a. telnet to server ->  http://localhost:8000/telnet

  1.b. ssh to server ->  http://localhost:8000/ssh

  1.c. get list of files ->  http://localhost:8000/files

  1.e. copy files ->  http://localhost:8000/copyFiles

  1.f. diskfreeSpace ->  http://localhost:8000/diskfreeSpace

  2. please use the url http://localhost:8000/fileExtract 

  5. I have attached the sql file to see. path sql/


Exercise 3.
  Please below the postman collection link
  https://www.getpostman.com/collections/118ee86d0264769ea7d2
    If any error you are facing to access the api. Please run the below command
    
    php artisan passport:install
    
  I have created
  a.http://localhost:8000/api/auth/signup, api/auth/login

  b.http://localhost:8000/api/router

  c.http://localhost:8000/api/router/update/ip

  d.http://localhost:8000/api/router/fetch/sapip

  e.http://localhost:8000/api/router

  f.http://localhost:8000/api/router/delete/ip


