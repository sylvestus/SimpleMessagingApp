
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
-After  installation register your user and login to get access tocken the use it to access all other apis


# My API Documentation

## Overview
This API allows you to send messages and manage user phone numbers.

## Authentication
To use this API, you need to authenticate with your API key. Include the API key in the `Authorization` header of each request.

## Endpoints

### 1. Register User

#### Endpoint
`POST /api/auth/register`

#### Description
Registers a user

#### HTTP Method
`POST`

#### Request Body
```json
{"name":"john doe",
"email":"john@gmail.com",
"password":"1234567"}

#### Response Body
```json
{
    "status": true,
    "message": "User Created Successfully",
    "token": "1|FGfxqEWeHDJ7e3gQuEeGOAYoEa1toTcDIHkIMML5"
}

### 2. login User

#### Endpoint
`POST /api/auth/login`

#### Description
Login a user

#### HTTP Method
`POST`

#### Request Body
```json
{
"email":"john3@gmail.com",
"password":"123456"}

#### Response Body
```json
{
    "status": true,
    "message": "User Logged In Successfully",
    "token": "6|p7MSIOK9Vpwme6hnHDvqwD9uiNtxmM4IIwk8bIAc"
}

### 3. Save Phone Numbers

#### Endpoint
`POST /api/auth/save_number`

#### Description
Save Phone Numbers

#### HTTP Method
`POST`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

#### Request Body
```json
{
    "user_id":12,
    "phone_number":"0706666100"}

#### Response Body
```json
{
    "status": 200,
    "message": "User phone number added successfully!!"
}
### 4. list Phone Numbers

#### Endpoint
`GET /api/auth/list_numbers`

#### Description
list saved phone numbers

#### HTTP Method
`GET`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

#### Response Body
```json
{
    "status": 200,
    "data": [
        {
            "id": 13,
            "added_by": 12,
            "user_id": 702658885,
            "phone_number": "+254702658885",
            "created_at": "2024-05-21T10:01:47.000000Z",
            "updated_at": "2024-05-21T10:01:47.000000Z"
        },
        {
            "id": 14,
            "added_by": 12,
            "user_id": 12,
            "phone_number": "+254706666100",
            "created_at": "2024-05-21T10:03:14.000000Z",
            "updated_at": "2024-05-21T10:03:14.000000Z"
        }
    ]
}


### 4. Send Messages

#### Endpoint
`POST /api/custom_message`

#### Description
 Send Messages


#### HTTP Method
`POST`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

 #### Request Body
```json
{"users":["+254706666100"],
"body":"hey this is a test message"}

 #### Response Body
```json
{
    "status": 200,
    "message": "Messages sent successfully!"
}



### 5. list your sent messages

#### Endpoint
`GET /api/sent_messages`

#### Description
sent messages

#### HTTP Method
`GET`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

{
    "status": 200,
    "data": [
        {
            "id": 5,
            "twilio_message_id": "SM4b611b40a2656ac26b0f8c5793cb15f7",
            "body": "hey this is a test message",
            "recipient": "+254706666100",
            "status": "queued",
            "created_at": "2024-05-21T08:26:51.000000Z",
            "updated_at": "2024-05-21T08:26:51.000000Z",
            "added_by": "12"
        }
    ]
}

### 6. list your recieved messages

#### Endpoint
`GET /api/recieved_messages`

#### Description
recieved messages

#### HTTP Method
`GET`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

{
    "status": 200,
    "data": [
        {
            "id": 5,
            "twilio_message_id": "SM4b611b40a2656ac26b0f8c5793cb15f7",
            "body": "hey this is a test message",
            "recipient": "+254706666100",
            "status": "queued",
            "created_at": "2024-05-21T08:26:51.000000Z",
            "updated_at": "2024-05-21T08:26:51.000000Z",
            "added_by": "12"
        }
    ]
}

### 7. Send Email

#### Endpoint
`POST /api/custom_mail`

#### Description
 Send custom_mail

#### HTTP Method
`POST`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

#### Request Body
```json
{"to":"silvanussigei19960@gmail.com",
"subject":"test",
"message":"hey this is a test email"
}


### 8. Update user 

#### Endpoint
`POST /api/user/1/update`

#### Description
 update user 

#### HTTP Method
`PUT`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

#### Request Body
```json
{"name":"john updated doe",
"email":"john3@gmail.com",
"password":"123456"}

#### Response Body
```json
{"name":"john updated doe",
"email":"john3@gmail.com",
"password":"123456"}



### 8. list system users

#### Endpoint
`GET /api/auth/list_system_users`

#### Description
list system users

#### HTTP Method
`GET`

#### Headers
| Key            | Value               |
|----------------|---------------------|
| Content-Type   | application/json    |
| Authorization  | Bearer YOUR_API_KEY |

#### Response Body
```json
{
    "status": 200,
    "data": [
        {
            "id": 12,
            "name": "john updated doe",
            "email": "john3@gmail.com"
        }
    ]
}
