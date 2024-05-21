
## About This Laravel App

This is a simple messaging app with the following capabilities


- Users should be able to register by providing their name, email, and password.
  Passwords should be securely hashed before storing in the database.
- Registered users should be able to log in by providing their email and password,
  retrieve and update details via Api.
- Send emails and send SMS messages via Twilio.
-  MySQL database to store user information and message history.

## Background info
- This is a laravel 9 application
- uses myql database and the dumped schema is in the root dirrectoryif the application  
  you should have php8 and above to install this application

## installation

- To clone this app please use git clone https://github.com/sylvestus/SimpleMessagingApp.git
- cd into the project dirrectory an run run composer install to install its dependancies
- set up your environment variables in the .env file a dummy .env file is in the root dirrectory named as .env.example dump the sql schema to your database and connect 
