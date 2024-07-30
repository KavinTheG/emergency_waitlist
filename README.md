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

### Patient Table Repopulation

As patients are treated, they will be removed from the database. Since eventually all patients will be removed, users can vis the link below to repopulate the **patients** table. This feature was implemented for testing purposes.

```http://localhost:8001/test.html```

### Website

#### Login Page
Users will be greeted with the following site. Patients will use this login page to verify their credential. Users must click on the *Admin Login* button to login as an admin.
![patient_login](https://github.com/user-attachments/assets/089ad67c-40ef-4e86-b5b0-39c981678549)

#### Patient Wait Time
After loggin in, patients will be shown their approximate wait time. As we have entered the credentials of John Doe, we can see that the value shown below matches the wait time shown in the database.
![patient_wait_time](https://github.com/user-attachments/assets/2952c8a8-c720-408c-b166-5f824b5e37c0)

#### Admin Page
If the user has logged in as an admin, they will be greeted with a list of patients as shown below. Admins are able to treat the highest priority patient which is determine by their approximate wait time and severity of injury. 
![patient_list](https://github.com/user-attachments/assets/edb3edba-13e3-4738-a39d-e15c77dcab8b)

#### Treating Patients
We can observe that by treating patients, we are removing patients from the database as well as decreasing the wait time for every patient. 

![patients_treated](https://github.com/user-attachments/assets/0ffc99fa-d474-4ab6-8f46-7c6a10295b3e)
