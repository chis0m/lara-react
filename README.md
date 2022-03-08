# Technical assignment back-end engineer

As part of an engineering team, you are working on an online shopping platform. The sales team wants to know which items were added to a basket, but removed before checkout. They will use this data later for targeted discounts.

Using the agreed upon programming language, build a solution that solves the above problem.

**Scope**

* Focus on the JSON API, not on the look and feel of the application.

**Timing**

You have one week to accomplish the assignment. You decide yourself how much time and effort you invest in it, but one of our colleagues tends to say: "Make sure it is good" ;-). Please send us an email (jobs@madewithlove.com) when you think the assignment is ready for review. Please mention your name, Github username, and a link to what we need to review.


# SOLUTION

### Requirement
It is important you have docker installed to test this implementation without hassle

## Installation
```bash
  git clone git@github.com:madewithlove/technical-assignment-back-end-engineer-chis0m.git shopper && cd shopper && ./setup.sh
````
  OR

```bash
  git clone https://github.com/madewithlove/technical-assignment-back-end-engineer-chis0m.git shopper && cd shopper && ./setup.sh
```



### NOTE
This is not a full-blown application. Therefore, to be concise:
- Not all test cases are covered
- Some implementations are deliberately ignored
- Frontend is not completely mobile responsive
- Also, frontend was implement in such a way to quickly test the api


#### APP
````
http://localhost:{port}

E.g using credentials in .env.example http://localhost:8282
````

#### API URL
````
http://localhost:{port}/api

E.g using credentials in .env.example http://localhost:8282/api
````
### TEST CREDENTIALS
user and admin
````
user@gmail.com
admin@gmail.com

password: (Password!2)
````

#### RUN TEST
````
./sail composer test
````

#### STATIC ANALYSIS
````
./sail composer cs
./sail composer phpstan
````

## Features
1. Laravel 9
2. ReactJs
3. Tests - PHPUnit with **Code Coverage**
4. API Documentation - PostMan
5. Docker - Laravel sail
6. Response Cache - Redis
7. Monitoring - Telescope
8. Static Analysis - PHPStan, PHPCS
9. Databases - 2 (test and dev)
10. Laravel Best Practices


### API Collection
[![Run in Postman](https://run.pstmn.io/button.svg)](https://www.postman.com/solar-firefly-907462/workspace/public-test-workspacke/collection/11854559-abc630db-65a6-4574-b47e-36c89a8b4b19)
#### OR
[JSON Link](https://www.getpostman.com/collections/5ffc1ebfc6a53f1ae9ff)
