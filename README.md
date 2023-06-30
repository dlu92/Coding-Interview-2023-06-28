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

## Preparation

To set up the local environment, follow these steps:

1. Install the necessary dependencies:
    > composer install

2. Initialize the database:
    > php artisan migrate

5. Run tests:
    > phpunit