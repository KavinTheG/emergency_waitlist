# Emergency Waitlist

## Overview

This project is an implemenation an emergency waitlist app. The stack used is detailed below

- HTML and CSS
  - structure the layout and style of the website
- Javascript
  - Used for client-side rendering
  - retrieves data from backend endpoints
- PHP
  - Used for server-side rendering
  - provides endpoints to query data from the database
- Postgres
  - SQL database

     
## Design

The document [design_system](./docs/design_system.md) in the docs section covers the design methodology of this project.


## Database

### Tables

The database consists of SQL tables **patients** and **staff**. 

As show in the image below, patients consists of userid, name, severity of injury, and approximate wait time.
![patient_table](https://github.com/user-attachments/assets/cabb1b63-bdf1-4bc3-b10c-723b11bd6a83)

Staff contains information on each staff's staffid and password. 
![staff_table](https://github.com/user-attachments/assets/fff97249-db78-4fd5-94d6-94297c44a6b2)


## Usage

To deploy the app, users must first clone the repository.

```
git clone git@github.com:KavinTheG/emergency_waitlist.git
```

Users must the change directory into the project directory

```
cd emergency_waitlist
```

Finally, users must enter the following command to locally deploy this app.

```
php -S localhost:8001
```

Users may visit localhost:8001 on a browser to interact with this app. 


### Website

#### Login Page

#### Patient Wait Time

#### Admin Page

#### Treating Patients
