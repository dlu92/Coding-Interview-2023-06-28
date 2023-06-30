# InnoTest

## Use Case

InnoTest is a company that has an app in the market which allows users to take tests for different competitive exams. Each exam corresponds to a different application, but all the questions are managed through a single database.

## Classification of Tests and Questions

The tests group questions and can be classified into 4 types based on the desired test:

- Titles (1): Includes questions related to the Spanish Constitution.
- Topics (2): Includes questions related to a specific topic of the competitive exam.
- Practice Tests (3): Includes questions for a possible exam simulation, but not official.
- Official Exams (4): Includes questions from an official exam conducted in a previous session.

Within an exam, there are blocks that represent the sections to be evaluated for each candidate. Each exam has its own block configuration. Thus, the hierarchy is as follows: Block => Specific Type of Test => Questions for that test.

## Database

With this information, we have a database consisting of 5 tables:

### Table: questions

It stores the question statements.

### Table: question_blocks

It stores the block to which each question belongs. The available blocks are:

- Spelling (1)
- Knowledge (2)
- English (3)
- Psychometric (4)
- Official Exams (5)
- Hypothetical Scenarios (6)

### Table: test_configs

It stores the names of the tests classified by their types. The types of tests are:

- Titles (1)
- Topics (2)
- Practice Tests (3)
- Official Exams (4)

### Table: question_tests

It stores the relationship between questions, tests, and exams.

### Table: question_responses

It stores the responses for each question and whether they are correct.

## First Exercise

Create an endpoint that, based on the examID, test type ID, and block ID, returns a list of tests if there are at least 5 questions linked to the test.

## Second Exercise

Now, there is a requirement to store the state of each question, which can be one of the following:

1. Published
2. Expired
3. Repealed
4. Obsolete

### Requirements:

- Modify the database to allow storing the state of each question. A question can only have one state, but it is required to track the historical states of the question.
- Create a second version of the endpoint developed in the first exercise that retrieves the tests if there are at least 5 questions in the "Published" state. The endpoint should maintain backward compatibility with the previous version.

## Third Exercise

The client complains that it takes too long to grade the tests and requests optimization of the current logic to minimize the execution time as much as possible.

### Requirements:

- Review the `/api/corregirTest` endpoint and achieve the following:
  - Improve code quality to ensure maintainability over time and prevent unknown errors.
  - Optimize the code to reduce the grading time for a 100-question test.

#

## Project memory

For the completion of this test, the SQL file containing the basic structure to perform the exercises has been integrated into a migration. Similarly, the JSON template file has been integrated into the test, responsible for the correction endpoint of exercise 3.

You will also find in this test an InnoTest.postman_collection.json file for importing into Postman, with all the necessary configurations and endpoints to test all the exercises.

This test includes unit tests to validate the exercises, a service abstraction layer, and DTOs for cleaner and scalable development.

Lastly, this project has been developed in a Docker environment that provides all the necessary tools for project execution and proper support. The environment includes a PHP container, MariaDB, Redis, and PhpMyAdmin. You can find the environment in my GitHub repository.

https://github.com/dlu92/laravel-dev-docker-environment

## Preparation

To set up the local environment, follow these steps:

1. Install the necessary dependencies:
    > composer install

2. Initialize the database:
    > php artisan migrate

5. Run tests:
    - First option:
    > phpunit
    - Second option:
    > ./vendor/bin/phpunit