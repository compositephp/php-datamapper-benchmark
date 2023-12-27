# PHP DataMappers Benchmark

## Overview
This repository contains benchmarks for some of the most popular PHP DataMapper's, used as a reference for performance 
optimizations in my personal project [compositephp/db](https://github.com/compositephp/db). 

The projects benchmarked include:
- [Doctrine](https://www.doctrine-project.org/)
- [Laravel Eloquent](https://laravel.com/docs/8.x/eloquent)
- [Cycle ORM](https://cycle-orm.dev/)
- [Composite DB](https://github.com/compositephp/db/)

## Methodology
* The benchmark executes 10 000 CRUD (Create, Read, Update, Delete) operations to assess the performance.
* The benchmark tests focus exclusively on the 'DataMapper' component of each project, employing simple queries that do 
not involve relationships, foreign keys, or joins.

Operations include:
1. Creating a new record in the database.
2. Reading the record by primary key.
3. Updating one field for the found record.
4. Deleting the record.

### Database
- MySQL 8.0
- Table used for the benchmark:
```sql
CREATE TABLE IF NOT EXISTS Users
(
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `age` INTEGER NOT NULL,
    `microtime` FLOAT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
```

## Results

### MacBook Pro with Apple M2 Pro Chip and 12‑Core CPU:

| Project          | Time (seconds) | Memory Kb | Memory Peak Mb |
|------------------|----------------|-----------|----------------|
| Laravel Eloquent | 61.51          | 4950.91   | 8.063          |
| Cycle ORM        | 44.32          | 288.15    | 7.007          |
| Doctrine         | 37.45          | 870.24    | 6.408          |
| CompositeDB      | 24.71          | 143.46    | 2.217          |

## Running Locally

### Requirements
* PHP 8.1+
* Docker
* Composer
* PDO_MySQL extension

### Steps
1. Clone or download this repository
2. Run `composer update`
3. Execute `docker-compose up`
4. Run benchmarks for each DataMapper separately:
   * `php src/test-laravel.php`
   * `php src/test-cycle.php`
   * `php src/test-doctrine.php`
   * `php src/test-composite.php`

## Note
This is a synthetic benchmark focused on speed and memory consumption and does not compare the feature list of the projects. 
Feel free to note any problems, inaccuracies, or shortcomings in using these projects and make a pull request to fix them.