# Tools for creating Laravel core modules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-core-modules/core-modules-maker.svg?style=flat-square)](https://packagist.org/packages/laravel-core-modules/core-modules-maker)
[![Tests Action Status](https://img.shields.io/github/actions/workflow/status/laravel-core-modules/core-modules-maker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laravel-core-modules/core-modules-maker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laravel-core-modules/core-modules-maker/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/laravel-core-modules/core-modules-maker/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-core-modules/core-modules-maker.svg?style=flat-square)](https://packagist.org/packages/laravel-core-modules/core-modules-maker)
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square" alt="MIT Software License"></a>


## About Laravel Core Modules Maker

This is a simple and extensible package for improving development time via service and repository for Laravel.


Created by [Corine BOCOGA](https://corine.b.github)

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/core-modules-maker.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/core-modules-maker)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).


## Table of Contents

- [Guide](#guide)
- [Installation](#installation)
- [Configuration](#configuration)
- [Commands](#commands)
- [Advanced Topics](#advanced-topics)
- [FAQ](#faq)
- [Troubleshooting](#troubleshooting)
- [Errors To Ignore](#errors-to-ignore)
- [Security Vulnerabilities](#security-vulnerabilities)
- [Code of Conduct](#code-of-conduct)
- [Changelog](#Changelog)
- [Contributing](#👊🏻-contributing)
- [Credits](#credits)
- [License](#license)


## Documentation for older versions

You are reading the documentation for `6.x`.

- If you're using **Laravel 8** please see the [docs for `4.x`](https://github.com/BenSampo/laravel-enum/blob/v4.2.0/README.md).
- If you're using **Laravel 7** please see the [docs for `2.x`](https://github.com/BenSampo/laravel-enum/blob/v2.2.0/README.md).
- If you're using **Laravel 6** or below, please see the [docs for `1.x`](https://github.com/BenSampo/laravel-enum/blob/v1.38.0/README.md).

Please see the [upgrade guide](./UPGRADE.md) for information on how to upgrade to the latest version.

## Guide

I wrote a blog post about using laravel-enum: https://corine.b.github/blog/using-service-repository-in-laravel

## Installation

You can install the package via composer:

```bash
composer require laravel-core-modules/core-modules-maker:version
```

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag="core-modules-maker"
```

This is the contents of the published config file:

```php
return [
];
```

## Commands

### Migration Management

The command allows you to effortlessly create new migration files within your Laravel application. Migrations are an essential part of managing your database schema, and this command streamlines the process for you

You can use the following Artisan command to generate a new migration class file:

```bash
php artisan generate:migration {name} [options]
```

- **`{name}`**: The name of the migration file (e.g., `CreateUsersTable`).
- **`[options]`**: Optional. Additional options or flags for migration generation.


#### **Create a new migration file**

To create a new migration file with the specified **`{name}`**, run the following command:

```bash
php artisan generate:migration {name}
```

#### **Example**

You can use the following Artisan command to generate a new migration class:

```bash
php artisan generate:migration CreateUsersTable
```
Replace CreateUsersTable with your desired migration name. This command streamlines the process of creating migration files within your Laravel application.

#### **Additional Options**
You have the flexibility to customize your migration using optional **`[options]`**. Below are examples of how to use these options:


##### **Create Table**

This option facilitates the generation of a migration file designed for creating a new database table. By employing the --create flag, you can specify your intent to create a table. To personalize the process, replace the {table} placeholder with your preferred table name. The following is the command structure:

```bash
php artisan generate:migration {name} --create={table}
```

- **`{name}`**: The name of the migration file (e.g., `CreateUsersTable`).
- **`--create`**: This flag indicates that the migration file is intended for creating a new table.
- **`{table}`**: Replace this placeholder with the name of the table you wish to create. e.g., `users`.

##### **Example**

Suppose you want to create a table named "posts." You can use the following command:

```bash
php artisan generate:migration CreatePostsTable --create=posts
```
This will generate a migration file for creating the "posts" table in your database.

***Note:*** The {table} value should be specified by you to define the name of the table you intend to create.


##### **Specify Columns**
To define specific columns for your migration, use the **`--columns`** option. For example:

You can define specific columns for your migration using the **`--columns`** option. This feature allows you to customize the structure of the table you are creating. The following is the command structure:
 Here's an example of how to use it:

```bash
php artisan generate:migration {name} --create={table} [--columns='{"column1": {"type": "datatype1", "options": "value"}, "column2": {"type": "datatype2", "options": "value"}, ...}']
```

- **`{name}`**: The name of the migration file.
- **`--create`**: This flag indicates that the migration file is intended for creating a new table.
- **`{table}`**: The name of the table you want to create.
- **`--columns`**: This flag allows you to specify the columns you want to include in your table.  The value should be a JSON-encoded schema object that defines the column names, types, and any additional attributes like default values or nullable properties.


- **`JSON Structure`**: The JSON-encoded schema should consist of key-value pairs, where each key represents a column name, and the corresponding value is a nested object defining the column properties. Here's a breakdown of the schema structure:
    - **`key`**: Represents the JSON-encoded object key value.
        - **`"name"`**: Represents the column name.
    - **`value`**: Corresponding value is a nested object defining the column properties.
    Specifies the data type of the column, e.g., "string," "integer," "decimal," etc. Replace "" with the desired data type.
        - **`"type": "string"`**: Specifies the data type of the column, e.g., **`"string"`**, **`"text"`**, **`"integer"`**, **`"decimal"`**, **`"enum"`**,  etc. Replace **`"string"`** with the desired data type.
        - **`"default: ""`**: Optionally, you can set a default value for the column. Replace "" with the desired default value.
        - **`"nullable": false`**: Specifies that the column cannot have NULL values (change to **true** if it can be nullable).

    Within the JSON structure, define each column with its name as the key and a nested object containing its type and any additional attributes.

##### **Example**

Suppose you want to create a migration file named "CreateProductsTable" and create a **`"products`** table with specific columns such as **`"reference"`**, **`"name"`**, **`"price"`**, and **`"description"`**. You can use the following command:

```bash
php artisan generate:migration CreateProductsTable --create=products --columns='{"reference": {"type": "string"}, "name": {"type": "string"}, "price": {"type": "decimal", "default": "0.00"}, "description": {"type": "string", "nullable": true}}'
```
In the provided example, we are creating a migration file named "CreateProductsTable" to generate a "products" table with the following columns:

- **`reference`**: of type `string`.
- **`name`**: of type `string`.
- **`price`**: of type `decimal` with a default value of `"0.00"`.
- **`description`**: of type `string`, which is nullable.

The **`--columns`** option allows you to define each column's data type and additional options, such as default values and whether the column is nullable.

This command streamlines the process of creating migration files with specific column structures tailored to your database schema requirements.


##### **Editing Database Table Schema with Laravel Migrations**

In Laravel, you can efficiently manage and modify your database table schema using migrations. This allows you to make changes to your tables without directly modifying the database, ensuring that your changes are version-controlled and can be rolled back if needed. This guide explains how to edit a database table schema using Laravel migrations.


```bash
php artisan generate:migration {name} --action={action_option} --table={exist_table_name} [--columns={table_schema}]
```

- **`{name}`**: This is a placeholder for the name of the migration file that you should provide. It's advisable to use a descriptive name that reflects the purpose or changes you intend to make to the database table schema.
For example, if you're adding new columns to a table, you might name it something like AddColumnsToProductsTable.

- **`--action`**: This is an optional flag that indicates the type of action you want to perform on the database table. It can have values like **`add`**, **`modify`**, or **`delete`** to specify the nature of the schema changes. If not provided, the default action may be assumed.

- **`{action_option}`**: This is a placeholder for the specific action option you want to perform, such as **`add`**, **`modify`**, or **`delete`**. You should replace it with the appropriate action based on your schema changes.

- **`--table`**: This flag allows you to specify the name of the existing database table that you intend to modify. Replace **`{exist_table_name}`** with the actual name of the table you want to edit.

- **`{exist_table_name}`**: This is a placeholder for the name of the existing database table that you want to modify. You should replace it with the actual name of the table you intend to edit.

- **`--columns`**: This flag is used to specify the schema changes you want to make to the table, particularly when **`adding`**, **`modifying`**, or **`deleting`** columns. Replace **`{table_schema}`** with the actual schema changes you want to apply..

- **`{table_schema}`**: This is a placeholder for the schema changes you want to make to the table, such as **`adding`** or **`modifying`** columns. You should replace it with the specific schema changes you want to apply in JSON or other appropriate format.

- **`--action={action_option}`**: This is an optional flag that allows you to specify the action you want to perform with the migration. The **`{action_option}`** placeholder should be replaced with the desired action. Common actions include **`add`**, **`modify`**, or **`delete`**. If not specified, the default action is usually assumed to be **`add`**.

- **`--table={exist_table_name}`**: This is an optional flag where you should replace **`{exist_table_name}`** with the name of the existing table you want to modify. It indicates the specific table for which the migration will make changes. If you're creating a new table, you don't need to use this flag.

- **`--columns={table_schema}`**: This is an optional flag where you should replace **`{table_schema}`** with a JSON-encoded schema definition that describes the changes you want to make to the table. This includes specifying the names, types, and attributes of the columns you're adding or modifying.

In summary, this command syntax allows you to generate a Laravel migration file with a specific name, action, and optional parameters to define the target table and the schema changes you want to apply. Migrations are a powerful way to version-control and manage database schema changes in your Laravel application.


To create a new migration file for editing a database table schema, use the following command:

##### **Editing Database Table Schema by Adding New Columns to an Existing Table**

In Laravel, you can efficiently modify your application's database structure by creating migrations. This section outlines how to use the `php artisan generate:migration` command to generate a migration file specifically designed for adding new columns to an existing database table.


#### Usage

To create a migration for adding new columns to an existing table, you can use the following command:

```bash
php artisan generate:migration {name} --action=add --table={exist_table_name} [--columns={table_schema}]
```

- **`{name}`**: The name of the migration file (e.g., `AddColumnsToProductsTable`).

- **`--action=add`**: This flag specifies that the migration file is intended to add new columns to the existing table.

- **`--table={exist_table_name}`**: This is an optional flag where you should replace **`{exist_table_name}`** with the name of the existing table you want to modify. It indicates the specific table for which the migration will make changes. If you're creating a new table, you don't need to use this flag.

- **`--columns={table_schema}`**: This is an optional flag where you should replace **`{table_schema}`** with a JSON-encoded schema definition that describes the changes you want to make to the table. This includes specifying the names, types, and attributes of the columns you're adding or modifying.


##### **Example**

Let's say you have an existing table named "products" in your Laravel application's database, and you want to add two new columns: "color" and "size." You can use the following command to create a migration file for this task:

```bash
php artisan generate:migration AddColorAndSizeToProductsTable --action=add --table=products --columns='{"color": {"type": "string"}, "size": {"type": "string"}}'
```
This example demonstrates how to structure the command to create a migration file that adds the specified columns to your existing "products" table.

##### **Editing Database Table Schema by Altering Existing Column Schemas of an Existing Table**

In Laravel, you can easily modify your application's database schema by creating migrations. This section outlines how to use the `php artisan generate:migration` command to generate a migration file designed for altering the schema of existing columns within an existing database table.


##### Usage

To create a migration file for this purpose, you can use the following command format:

```bash
php artisan generate:migration {name} --action=alter --table={existing_table_name} [--columns={altered_columns_schema}]
```

- **`{name}`**: The name of the migration file (e.g., `AlterProductColumns`).

- **`--action=alter`**: Indicate that the migration's purpose is to alter the schema of existing columns within the table.

- **`--table={exist_table_name}`**: This is an optional flag where you should replace **`{exist_table_name}`** with the name of the existing table you want to modify. It indicates the specific table for which the migration will make changes. If you're creating a new table, you don't need to use this flag.

- **`--columns={altered_columns_schema}`**: This is an optional flag where you should replace **`{altered_columns_schema}`** with a JSON-encoded schema definition that describes the changes you want to make to the table. This includes specifying the names, types, and attributes of the columns you're adding or modifying.


##### **Example**

Let's consider a scenario where you have an existing table named "products" in your Laravel application's database. You want to modify two existing columns: "price" and "description," altering their data types and adding constraints. You can use the following command to generate a migration file for this task:

```bash
php artisan generate:migration AlterProductColumns --action=alter --table=products --columns='{"price": {"type": "decimal", "precision": 10, "scale": 2}, "description": {"type": "text", "nullable": true}}'
```
This example demonstrates how to structure the command to create a migration file that alters the schema of the specified columns within your existing "products" table.

##### **Editing Database Table Schema by Deleting Existing Columns from an Existing Table**

In Laravel, managing and adapting your application's database schema is a fundamental aspect of development. This section outlines how to leverage the `php artisan generate:migration` command to create a migration file tailored for removing existing columns from an established database table.

##### Usage

To create a migration file for this purpose, you can utilize the following command format:

```bash
php artisan generate:migration {name} --action=delete --table={existing_table_name} [--columns={deleted_columns}]
```

- **`{name}`**: The name of the migration file (e.g., `DeleteColumnsFromUsersTable`).

- **`--action=delete`**: This flag specify that the migration's primary objective is to delete existing columns from the table.

- **`--table={exist_table_name}`**: Employ this optional flag to specify the name of the existing table from which columns will be removed. It identifies the target table for the migration. If you're creating a new table, you don't need to use this flag.

- **`--columns={deleted_columns}`**: This is an optional flag that permits you to provide a JSON-encoded definition of the columns you intend to delete from the table. Include the names of the columns you wish to remove.

##### **Example**

Consider a scenario where you have an existing table named "users" in your Laravel application's database. You need to remove two columns: "phone_number" and "address." You can use the following command to generate a migration file for this task:

```bash
php artisan generate:migration DeletePhoneAndAddressColumnsFromUsersTable --action=delete --table=users --columns='["phone_number", "address"]'
```
This example illustrates how to structure the command to create a migration file tailored for removing the specified columns from your existing "users" table.

##### **Editing Database Table Schema by Modifying an Existing Table**

In Laravel, the ability to adapt and refine your application's database schema is crucial. This section outlines how to utilize the `php artisan generate:migration` command to create a migration file tailored for the purpose of modifying an existing database table.


##### Usage
To create a migration file for this purpose, you can employ the following command format:

```bash
php artisan generate:migration {name} --action=modify --table={existing_table_name} [--changes={table_modifications}]
```

- **`{name}`**: The name of the migration file (e.g., `ModifyProductTable`).

- **`--action=modify`**: Indicate that the migration's objective is to modify the structure of an existing table.

- **`--table={exist_table_name}`**: Utilize this optional flag to specify the name of the existing table that requires modifications. It identifies the target table for the migration. If you're creating a new table, you don't need to use this flag.

- **`--changes={table_modifications}`**: This is an optional flag that enables you to provide a JSON-encoded definition of the changes you intend to apply to the table. These changes may include altering columns, adding or dropping indexes, or making other adjustments to the table's structure.

##### **Example**

Imagine a scenario where you have an existing table named "products" in your Laravel application's database. You need to modify this table by altering the "price" column, adding an "is_featured" column, and creating a new index on the "name" column. You can employ the following command to generate a migration file for this task:

```bash
php artisan generate:migration ModifyProductTable --action=modify --table=products --changes='{"modify": {"price": {"type": "decimal", "precision": 10, "scale": 2}, "add": {"is_featured": {"type": "boolean", "default": false}}, "index": {"name": {"type": "index"}}}}'
```
This example demonstrates how to structure the command to create a migration file tailored for modifying the specified elements within your existing "products" table.

***Note:*** By using the **`--action`** option appropriately for your migration needs, you can generate migration files tailored to your specific database schema changes, whether it's **`adding`** or **`modifying`** or **`deleting`** columns.

The **`--action`** option provides clarity and customization when working with migration files that involve various database schema changes.

##### **Specify Database Connection**

By default, migrations use the default database connection configured in your Laravel application. However, you can specify a different database connection using the **`--connection`** option. Here's how to use it in combination with other migration options:


```bash
php artisan generate:migration {name} --create={table} [--connection={connection_name}]
```
- **`{name}`**: The name of the migration file.
- **`--create`**: This flag indicates that the migration file is intended for creating a new table.
- **`{table}`**: The name of the table you want to create.
- **`--connection`**: This flag allows you to specify a different database connection when generating the migration file.
- **`{connection_name}`**: The name of the table you want to create.

##### **Example**

Suppose you've made changes to your migration files and need to re-run them to update your database schema. You can use the **`--connection`** option to ensure that the migrations are executed using a specific database connection, regardless of their previous status.

```bash
php artisan generate:migration CreateNewsTable --create=news --connection=redis
```
This option is useful when you have multiple database connections configured in your Laravel application, and you want to create a migration for a specific connection.

Use the **`--connection`** option when you need to perform migrations on a database connection other than the default. This can be particularly useful in multi-database Laravel applications.

##### **Generate a Migration with a Model**

In Laravel, it's common to create migrations for database tables that are associated with Eloquent models. The **`php artisan generate:migration`** command allows you to generate a migration file along with an associated Eloquent model using the **`--model`** option. Here's how to use it:


```bash
php artisan generate:migration {name} --create={table} [--model={model_class}]
```
- **`{name}`**: The name of the migration file.
- **`--create`**: This flag indicates that the migration file is intended for creating a new table.
- **`{table}`**: The name of the table you want to create.
- **`--model`**: This flag allows you to generate an associated Eloquent model along with the migration.
- **`{model_class}`**: The name of the Eloquent model you want to generate. The name of the model class you want to associate with the migration
 

##### **Example**
Suppose you want to create a migration file named "CreatePostsTable" to generate a "posts" table and associate it with an existing model class called "Post." You can use the following command:

```bash
php artisan generate:migration CreateProductsTable --create=products --model=Product
```
By specifying the model, you establish a connection between the migration and the model, making it easier to work with the table and its data using Laravel's Eloquent ORM.

By including the **`--model`** option and specifying the "Post" model class, you link the migration to the "Post" model. This association allows you to use Eloquent methods and relationships seamlessly with the "posts" table.
This command will generate a migration file for creating the "products" table, and it will also create an Eloquent model named "Product" associated with this table.

Use the **`--model`** option to streamline the process of ceating migrations and models for your application's database tables.


##### **Specify a Custom Migration Path**

By default, Laravel stores migration files in the `database/migrations` directory. However, you can specify a custom path for your migration files using the **`--path`** option when generating a migration file. Here's how to use it in combination with other migration options:


```bash
php artisan generate:migration {name} --create={table} [--path={custom_path}]
```
- **`{name}`**: The name of the migration file.
- **`--create`**: This flag indicates that the migration file is intended for creating a new table.
- **`{table}`**: The name of the table you want to create.
- **`--path`**: This flag allows you to specify a custom path for storing the migration file.
- **`{custom_path}`**: The custom path where you want to store the migration file.
 

##### **Example**

Suppose you want to store a migration file in a custom directory named "custom_migrations" instead of the default **`database/migrations`** directory. You can use the **`--path`** option to specify the custom path:

```bash
php artisan generate:migration CreateProductsTable --create=products --path=modules/Products/database/migrations
```
By using the **`--path`** option, you can organize your migration files in a way that suits your project's structure and preferences. This can be particularly useful when working on complex projects with specific directory layouts.

The **`--path`** option is valuable when you need to keep your migration files separate from the default **`database/migrations`** directory, making it easier to manage migrations in larger projects.

***Note:*** Keep in mind that you should provide the relative path from the root of your Laravel project when using the `--path` option.

##### **Force Migration File Execution**

In certain situations, you may need to forcefully generate a migration file, even if a migration file with the same name already exists. The **`--force`** option permits you to do just that. The following is the command structure:

```bash
php artisan generate:migration {name} --create={table} [--force]
```
- **`{name}`**: The name of the migration file.
- **`--create`**: This flag indicates that the migration file is intended for creating a new table.
- **`{table}`**: The name of the table you want to create.
- **`--force`**: This flag allows you to forcefully generate a migration file, regardless of whether a file with the same name already exists.

##### **Example**:

Suppose you've made changes to your migration files and need to re-run them to update your database schema. You can use the --force option to ensure that the migrations are executed again, regardless of their previous status.

```bash
php artisan generate:migration CreateUsersTable --create=users --force
```

***Note:*** Use the **`--force`** option with caution, as it will overwrite any existing migration file with the same name. This can be useful when you need to regenerate a migration file with updated specifications for a table or when resolving conflicts during development.


### Model Management

In Laravel, models play a crucial role in building robust applications by defining the structure and behavior of your data. The `php artisan generate:model` command simplifies the process of creating models, making it easier to establish database connections, relationships, and custom configurations.

You can use the following Artisan command to generate a new model class file:

```bash
php artisan generate:model {name} [options]
```

- **`{name}`**: Replace **`{name}`** with the name of your desired model class. This command will create a new model file with this name.
- **`[options]`**: Optional. Additional options or flags to customize the model generation process.


#### **Generate a new model file**
To create a new model file with the specified **`{name}`**, run the following command:

```bash
php artisan generate:model {name} --table={table_name}
```
- **`{name}`**: Replace **`{name}`** with the name of your desired model class. This command will create a new model file with this name.
- **`--table={table_name}`**: Specify the database table to associate with the model. This option establishes the relationship between the model and the table.

#### **Example**

Let's say you want to create a model for managing "Product" entities in your application and associate it with the "products" database table. You can use the following command:

```bash
php artisan generate:model Product --table=products
```
This command will generate a new "Product" model in your Laravel project, associated with the "products" table. It provides you with a starting point for defining the behavior and properties of your model.

#### **Additional Options**
In addition to the basic model generation, the `php artisan generate:model` command provides extra options to tailor the model creation process to your needs. Let's explore these options to enhance your Laravel application development:

- [**Generate a Pivot Model:**](#generate-a-pivot-model) Simplify many-to-many relationships by creating pivot models with ease. The `--pivot` option streamlines the generation of models tailored for pivot tables, often used in many-to-many relationships.

- [**Specify Fillable Attributes:**](#specify-fillable-attributes) Customize the fillable attributes for your model using the `--fillable` option. This feature grants precise control over which attributes can be mass-assigned in your model.

- [**Create a repository:**](#create-a-repository) Use the `--repository` option to generate a model along with an associated repository. This is beneficial when following the repository pattern in your application.

- [**Specify a Custom Connection:**](#specify-a-custom-connection) You can designate a specific database connection by using the `--connection` option. This allows you to associate a model with a particular database when generating it for a specific table.


##### **Generate a Pivot Model**

Simplify many-to-many relationships in Laravel by generating pivot models effortlessly with the **`--pivot`** option in the **`php artisan generate:model`** command.

To generate a new model for a pivot table, you can use the following command:

```bash
php artisan generate:model {name} --table={table_name} [--pivot]
```
- **`{name}`**: The name of your desired model class.
- **`--table={table_name}`**: Specify the database table to associate with the model. This option establishes the relationship between the model and the table.
- **`--pivot`**: This option tells Laravel to generate a model specifically for a pivot table. Pivot tables are typically used in many-to-many relationships to connect two other tables.

##### **Example**:

Let's say you have a pivot table named `user_products` that connects `products` and `users` tables in a many-to-many relationship. You can use the following command to generate a pivot model for this table:

```bash
php artisan generate:model UserProduct --table=user_products --pivot
```
This command will create a `UserProduct` model file, allowing you to work with the pivot table in your Laravel application.

***Note:*** The **`--pivot`** option streamlines pivot model creation, making it easier to manage complex many-to-many relationships in your Laravel application. Simplify your code, enhance organization, and build with confidence.


##### **Specify Fillable Attributes**

You can define the fillable attributes for your model using the --fillable option:

```bash
php artisan generate:model {name} --table={table_name} [--fillable={attributes}]
```
- **`{name}`**: The name of your desired model class.
- **`--table={table_name}`**: Specify the database table to associate with the model. This option establishes the relationship between the model and the table.
- **`{table_name}`**: Replace this placeholder with the name of the table you wish to establishes relationship with.
- **`--fillable={attributes}`**: This option allows you to specify the fillable attributes for your model. Replace **`{attributes}`** with the names of the attributes you want to make fillable.


##### **Example**

Let's say you want to create a "Product" model associated with the "products" table and define the fillable attributes "name," "description," and "price." You can use the following command:

```bash
php artisan generate:model Product --table=products --fillable=name,description,price
```
This command will generate a "Product" model associated with the "products" table and set the specified attributes as fillable.


***Note:*** By using the **`--fillable`** option with the **`php artisan generate:model`** command, you can efficiently customize your model's fillable attributes and tailor them to your Laravel application's needs.


##### **Create a repository**

To generate a new model along with a repository, you can use the following command:

```bash
php artisan generate:model {name} --table={table_name} [--repository] [--repository-namespace[={namespace}]]
```
- **`{name}`**: The name of your desired model class.
- **`--table={table_name}`**: Specify the database table to associate with the model. This option establishes the relationship between the model and the table.
- **`--repository`**: This option tells Laravel to create a repository alongside the model. A repository is a common design pattern used to abstract database interactions and keep your code organized.
- **`{table_name}`**: Replace this placeholder with the name of the table you wish to establishes relationship with.
- **`--repository-namespace={namespace}`**: Optionally, you can use this flag to specify a custom namespace for the generated repository. Replace **`{namespace}`** with the desired namespace for your repository.

##### **Example**
Let's say you want to create a `Product` model, associate it with the `products` database table, generate a corresponding repository, and place the repository in a custom namespace named `App\\Repositories\\Products`. You can use the following command:


```bash
php artisan generate:model Product --table=products --repository --repository-namespace=App\\Repositories\\Products
```
This command will generate both a `Product` model associated with the `products` table and a `ProductRepository` class in the `App\Repositories\Product` namespace in your Laravel project. You can then use the repository to encapsulate database operations related to the `Product` model.


***Note:*** By using the **`--repository`** and **`--repository-namespace`** options along with the **`php artisan generate:model`** command, you can enhance the maintainability and organization of your Laravel application, especially when dealing with complex data operations.


##### **Specify a Custom Connection**

To generate a new model and associate it with a specific database table while specifying a custom database connection (if needed), you can use the following command:

By default, migrations use the default database connection configured in your Laravel application. However, you can specify a different database connection using the **`--connection`** option. Here's how to use it in combination with other migration options:


```bash
php artisan generate:model {name} --table={table_name} [--connection[={connection_name}]]
```
- **`{name}`**: The name of your desired model class.
- **`--table={table_name}`**: Specify the database table to associate with the model. This option establishes the relationship between the model and the table.
- **`{table_name}`**: Replace this placeholder with the name of the table you wish to establishes relationship with.
- **`--connection`**: This flag allows you to specify a different database connection when generating the migration file.
- **`--connection={connection_name}`**: Optionally, you can use this flag to specify a custom database connection. If you omit this flag, Laravel will use the default connection defined in your database configuration.

- **`{connection_name}`**: The name of the table you want to create.

##### **Example**

Suppose you've made changes to your migration files and need to re-run them to update your database schema. You can use the **`--connection`** option to ensure that the migrations are executed using a specific database connection, regardless of their previous status.

```bash
php artisan generate:model New --create=news --connection=mongodb
```
This command will generate a **`New`** model associated with the **`news`** table and ensure that it uses the "pgsql" database connection in your Laravel application.


***Note:*** By using the **`--connection`** option with the php artisan generate:model command, you can customize the database connection for your model, especially when working with multiple database connections in your application.


##### ***Note***

The `php artisan generate:model` command empowers you to streamline model creation in your Laravel projects. With options for generating **`repositories`**, **`pivot`** models, specifying **`fillable`** attributes, and **`custom database connections`**, you have the tools to design and organize your application's data layer effectively. Whether you're building a simple application or a sophisticated system, using these model management options will contribute to the maintainability and scalability of your Laravel project.


## Repository Management

### Command Overview

The `generate:repository` command allows you to generate repository classes in your Laravel project. Repositories are a common design pattern used to abstract database interactions and provide a clear separation between your application's business logic and data access.

### Command Signature

```bash
php artisan generate:repository 
    {name : The name of the repository}
    {--model= : The name of the associated model repository}
    {--modules : The base path to the repository class}
    {--base_path : The base path to the repository class}
    {--path= : The path to the repository class}
    {--namespace= : The namespace of the repository class}
    {--force : Force create the repository}
```

### Command Options
- **`{name}`**: The name of the repository you want to generate.
- **`--model`**: (Optional) The name of the associated model for the repository.
- **`--modules`**: (Optional) The base path to the repository class.
- **`--base_path`**: (Optional) The base path to the repository class.
- **`--path`**: (Optional) The path to the repository class.
- **`--namespace`**: (Optional) The namespace of the repository class.
- **`--force`**: (Optional) Use this flag to force the creation of the repository, even if it already exists.

### Command Usage

#### Basic Usage

To generate a repository, you can run the following command:


```bash
php artisan generate:repository {name}
```
Replace `{name}` with the desired name of your repository.

#### Associating a Model
You can associate a model with the repository using the `--model` option. This is useful when you have a specific model that the repository will interact with.
```bash
php artisan generate:repository {name} [--model={model_name}]
```
Replace `{model_name}` with the name of the associated model.

##### Example
Let's say you want to create a repository named `ProductRepository` associated with the `Product` model. You can run the following command:

```bash
php artisan generate:repository ProductRepository --model=Product
```
This will generate the `ProductRepository` class in the specified namespace, associated with the `Product` model.


#### Customizing Namespace
You have the flexibility to customize the namespace of the generated repository using the `--namespace` option. This allows you to place the repository in a specific namespace that aligns with your project's structure.

To customize the namespace, simply add the `--namespace` option followed by the desired namespace when running the `generate:repository` command. Here's an example:


##### Example
Let's say you want to create a repository named `ProductRepository` associated with the `Product` model, and you want it to be in the `App\\Repositories\\Products` namespace. You can run the following command:

```bash
php artisan generate:repository ProductRepository --model=Product --namespace=App\\Repositories\\Products
```
In the example above, the repository will be generated in the `App\Repositories\Products` namespace, associated with the `Product` model.

Customizing the namespace provides you with better organization and ensures that your repository is placed in the appropriate directory within your Laravel project.

#### Customizing Paths

In addition to customizing the namespace, you also have the flexibility to customize the repository's base path and path using various options:

- `--base_path`: Specifies the base path to the repository class.
- `--modules`: Specifies the base path to the repository class.
- `--path`: Specifies the path to the repository class.

Here's how you can use these options when running the `generate:repository` command:


```bash
php artisan generate:repository {name} [--base_path] [--path={custom_path}] [--modules]
```
- Replace `{name}` with the desired name of your repository.
- `--path`: Use this flag to indicate where you want to place the repository class.
- `{custom_path}`: Set the path to the repository class.
- `--modules`: Use this flag to indicate that the repository class should be located within the `Modules` directory.

Customizing these paths allows you to control where the generated repository class is placed within your Laravel project's directory structure.

To customize the paths, include the relevant options when running the `generate:repository` command. Here are examples:

##### Customizing the Base Path

```bash
php artisan generate:repository {name} [--base_path] [--modules]
```
In this example, the repository will be generated within the `Modules` directory as the base path.

##### Customizing the Path

```bash
php artisan generate:repository {name} [--path={custom_path}]
```
In this case, the repository will be generated within the `Custom` directory as the path.


##### Example
Let's say you want to create a repository named `ProductRepository` associated with the `Product` model, and you want it to be in at root of the laravel projet folder in the modules folder of a specific path. You can run the following command:

```bash
php artisan generate:repository ProductRepository --model=Product --base_path --modules path=Products\Repositories
```
This will generate the `ProductRepository` class in the specified namespace, associated with the `Product` model.


***Note:*** Customizing the paths provides you with fine-grained control over the location of your repository class, allowing you to maintain a clean and organized project structure that suits your project's needs.

#### Forcing Repository Creation
If you want to force the creation of the repository even if it already exists, you can use the `--force` flag.

```bash
php artisan generate:repository {name} [--force]
```

#### Example

```bash
php artisan generate:repository ProductRepository --force
```

### Conclusion
The `generate:repository` command simplifies the creation of repository classes in your Laravel project, allowing you to maintain a clean and organized separation of concerns between your application's logic and data access.
Use this command to streamline your repository creation process and enhance the maintainability of your Laravel applications.



## Service Management

### Command Overview
The `generate:service` command is a powerful tool for generating service classes in your Laravel project. Services help encapsulate your application's business logic and maintain separation of concerns, making your codebase more organized and maintainable.

### Command Signature

```bash
php artisan generate:service 
    {name : The name of the service}
    {--base_path : The base path to the service class}
    {--path= : The path to the service class}
    {--namespace= : The namespace of the service class}
    {--modules : The base path folder of the service class}
    {--model= : The name of the associated model service}
    {--dto : The associated DTO (Data Transfer Object) for the service}
    {--force : Force create the service}
```

### Command Options
- **`{name}`**: The name of the service you want to generate.
- **`--model`**: (Optional) The name of the associated model for the service.
- **`--modules`**: (Optional) The base path to the service class within the "Modules" directory.
- **`--base_path`**: (Optional) The base path to the service class.
- **`--path`**: (Optional) The path to the service class.
- **`--dto`**: (Optional) The name of the associated Data Transfer Object (DTO) for the service.
- **`--namespace`**: (Optional) The namespace of the service class.
- **`--force`**: (Optional) Use this flag to force the creation of the service, even if it already exists.

### Command Usage

#### Basic Usage

To generate a service, run the following command:

```bash
php artisan generate:service {name}
```
Replace `{name}` with the desired name of your service.

#### Associating a Model and DTO
You can associate a model and a Data Transfer Object (DTO) with the service using the `--model` and `--dto` options, respectively. This is useful when your service interacts with specific model entities and requires a DTO to handle data transfer.

To associate a model with the service, use the `--model` option followed by the model's name:

```bash
php artisan generate:service {name} [--model={model_name}]
```

In the above command:

- **`{name}`**: The name of your desired service class.
- **`--model`**: This option allows you to specify the model that your service will be associated with. By associating a model with your service, you can easily access and manipulate data related to that model within your service's methods.

- **`{model_name}`**: Replace this placeholder with the name of the model you want to associate with your service.

##### Example
Let's say you want to create a ProductService associated with the Product model. You can use the following command:

```bash
php artisan generate:service ProductService --model=Product
```

***Note:*** This command will generate the ProductService class and establish its association with the Product model, making it convenient to perform operations on product data within the service.


##### ***Note***
To associate a DTO with the service, you can simply use the --dto option without specifying a name. This will make the DTO option optional:

```bash
php artisan generate:service {name} [--dto[=dto_name]]
```
In the above command:

- **`{name}`**: The name of your desired service class.
- **`--dto`**: This option allows you to specify the Data Transfer Object (DTO) that your service will be associated with. A DTO is used for handling data transfer between your service and other parts of your application.
- **`[dto_name]`**: Optionally, you can provide the name of the DTO you want to associate with your service. If you omit the dto_name, it will be assumed as optional.


##### Example
Let's say you want to create a `UserService` associated with a DTO named `UserDTO`. You can use the following command:

```bash
php artisan generate:service UserService --dto=UserDTO
```

***Note:*** This command will generate the `UserService` class and establish its association with the `UserDTO` for handling data transfer within the service. If you don't specify a DTO name, the `--dto` option becomes optional, allowing you to decide later if you want to associate a DTO with your service.

By associating a model and DTO with your service, you can streamline data handling and improve the organization of your Laravel application.

#### Example
For example, to generate a `ProductRESTfulReadWriteService` associated with the `Product` model and using `CreateProductDTO` and `UpdateProductDTO` for data transfer, you can run the following command:
```bash
php artisan generate:service ProductRESTfulReadWriteService --model=Product --dto
```

This command will generate the `ProductRESTfulReadWriteService` classes associated with the `Product` model and utilizing the `CreateProductDTO` and `UpdateProductDTO` for data transfer.

#### Customizing Namespace

When generating a service using the `generate:service` command, you can customize the namespace for your service class by using the `--namespace` option. Here's how it works:

```bash
php artisan generate:service {name} --namespace={namespace_value}
```
In the above command:

- **`{name}`**: The name of your desired service class.
- **`--namespace`**: This flag allows you to specify the desired namespace for the service class. When generating a service using the `generate:service` command, you can use this option to define the namespace in which the service class will be placed. It provides flexibility in organizing your Laravel application's codebase.
- **`{namespace_value}`**: Replace this placeholder with the custom namespace you want to use for your service class. When using the `--namespace` option with the `generate:service` command, `{namespace_value}` should be replaced with the desired namespace you intend to assign to your service class. This allows you to effectively organize your Laravel application's codebase.
- **`--namespace={namespace_value}`**: When running the `generate:service` command, you can utilize this option to set a custom namespace for your service class. Simply replace `{namespace_value}` with your desired namespace when executing the command. This feature enables you to efficiently organize your Laravel application's codebase.

##### Example

To illustrate how to use the `--namespace` option, let's say you want to create a service class named `UserService` and place it in the `App\\Services\\Products` namespace. You can use the following command:

```bash
php artisan generate:service UserService --namespace=App\\Services\\Products
```
This command will generate the `UserService` class within the `App\\Services\\Products` namespace, helping you organize your services according to your application's structure.

#### Forcing Service Creation
If you want to force the creation of the service even if it already exists, you can use the `--force` flag.

```bash
php artisan generate:repository {name} [--force]
```

#### Example

```bash
php artisan generate:repository ProductRepository --force
```

### Conclusion

The `generate:service` command simplifies the creation of service classes in your Laravel project, allowing you to maintain a clean and organized separation of concerns and encapsulate your application's business logic effectively.

Use this command to streamline your service creation process and enhance the maintainability of your Laravel applications.


### DTO (Data Transfer Object) Management
#### Command Overview

In Laravel, DTOs (Data Transfer Objects) are essential for handling data transfer between different parts of your application. The `php artisan generate:dto` command simplifies the process of creating new DTO classes in your Laravel project.

You can use the following Artisan command to generate a new DTO class file:

```bash
php artisan generate:dto {name} [options]
```
- **`{name}`**: The name of your desired DTO class. This command will create a new DTO file with this name.
- **`[options]`**: Optional. Additional options or flags to customize the DTO generation process.

#### Command Signature

```bash
php artisan generate:service 
                    {name : The name of the DTO class}
                    {--model= : The name the associate model dto}
                    {--modules : The base path to the dto class}
                    {--base_path : The base path to the dto class}
                    {--path= : The path to the dto class}
                    {--namespace= : The namespace of the dto class}
                    {--api-version=v1 : Specify the API version for the dto}
                    {--force : Force create the dto}';
```

#### Command Options
```bash
- **`{name}`**: The name of the dto you want to generate.
- **`--model`**: (Optional) The name of the associated model for the dto.
- **`--modules`**: (Optional) The base path to the dto class.
- **`--base_path`**: (Optional) The base path to the dto class.
- **`--path`**: (Optional) The path to the dto class.
- **`--namespace`**: (Optional) The namespace of the dto class.
- **`--force`**: (Optional) Use this flag to force the creation of the dto, even if it already exists.
```

#### Command Usage

##### Basic Usage

To generate a dto, run the following command:

```bash
php artisan generate:dto {name}
```
- **`{name}`**: Replace {name} with the name of your desired DTO class. This command will create a new DTO file with this name.

###### Example
Let's say you want to create a DTO for handling user data transfers in your application. You can use the following command:

```bash
php artisan generate:dto UserDTO
```
This command will generate a new `UserDTO` class in your Laravel project, which you can use for structuring and managing user-related data transfers.


##### Additional Options

In addition to the basic DTO generation, the `php artisan generate:dto` command provides extra options to tailor the DTO creation process to your needs.

##### Specify Associated Model
You can specify an associated model for your DTO using the `--model` option. This is useful when your DTO is closely tied to a particular model's data structure:

```bash
php artisan generate:dto {name} --model={model_name}
```
- **`{name}`**: The name of your desired DTO class. This command will create a new DTO file with this name.
- **`--model`**: Optional. Additional options or flags to customize the DTO generation process.
- **`{model_name}`**: Optional. Additional options or flags to customize the DTO generation process.
- **`--model={model_name}`**: Specify the name of the associated model. This option helps you define the relationship between the DTO and the model.

###### Example
Let's say you want to create a DTO for handling user data transfers in your application associate with model. You can use the following command:

```bash
php artisan generate:dto UserDTO --model=User
```
This command will generate a new UserDTO class in your Laravel project, which you can use for structuring and managing user-related data transfers.

##### Customize Namespace
You can customize the namespace for your DTO class using the --namespace option:

```bash
php artisan generate:dto {name} [--namespace={namespace_value}]
```
- **`{name}`**: Represents the name of your intended DTO class. Executing this command will generate a new DTO file with the specified name.

- **`--namespace`**: This option is optional but provides you with the ability to define a custom namespace for the DTO.
- **`{namespace_value}`**: This parameter is also optional and allows you to specify the desired namespace you intend to assign to your DTO class.

This feature empowers you to structure and manage your DTOs in a way that aligns with your application's architecture and code organization preferences.

###### Example
To illustrate how to use the `--namespace` option when generating a DTO, let's assume you want to create a DTO named `UserDTO` and place it within the `App\DTOs` namespace. You can accomplish this by running the following command:

```bash
php artisan generate:dto ProductDTO --namespace=App\\DTOs
```
This command will generate the `UserDTO` class with the specified namespace, ensuring that it's organized in the `App\DTOs` namespace within your Laravel application.


***Note:*** By using the `--namespace` option with the `php artisan generate:dto` command, you can tailor the namespace of your DTO class to suit your Laravel application's structure and organization. This allows you to keep your codebase neat and well-structured.

##### Specify API Version
If your DTOs are related to a specific API version, you can specify it using the `--api-version` option:

```bash
php artisan generate:dto {name} [ --api-version={version}]
```
- **`{name}`**: The name of your desired DTO class. This command will create a new DTO file with this name.
- **`--api-version`**: Optional. This flag allows you to specify the API version for the DTO.
- **`{version}`**: Optional. The version number you want to associate with the DTO.
- **`--api-version={version}`**: Specify the API version for the DTO. This option helps you categorize and manage DTOs based on different API versions.

###### Example
For example, let's say you're developing an e-commerce application with multiple API versions, and you need to create DTOs specific to version 2.0 of your API. You can use the following command to generate a DTO associated with API version 2.0:

```bash
php artisan generate:dto ProductDTO --api-version=v2
```
This command will create a ProductDTO class linked to API version 2.0, allowing you to maintain different DTOs for various API versions in your Laravel application.


***Note:*** By using the `--api-version` option with the `php artisan generate:dto` command, you can efficiently categorize and manage DTOs based on different API versions in your Laravel application. This organization helps ensure that your data transfer objects align with the specific requirements and changes of each API version, enhancing the maintainability and scalability of your application's data handling.


##### Force DTO Creation
If you want to forcefully generate a DTO file, even if a DTO file with the same name already exists, you can use the `--force` option:

```bash
php artisan generate:dto {name} [--force]
```
- **`{name}`**: The name of your desired DTO class. This command will create a new DTO file with this name.
- **`--force`**: This option allows you to create the DTO file forcefully, overwriting any existing file with the same name.

###### Example
For instance, let's say you want to create a DTO for managing user data transfers in your application associated with a model. You can use the following command to forcefully generate the DTO, ensuring that it's created or updated regardless of any existing file:

```bash
php artisan generate:dto UserDTO --force
```
By employing the --force option with the php artisan generate:dto command, you can efficiently create and manage DTOs in your Laravel application. This can be particularly helpful when you need to ensure that the DTO remains in sync with your data structure, even if you've made changes to it.


***Note:*** Using the `--force` option enhances your ability to create and organize DTOs in your Laravel application. It ensures that your data transfer processes remain streamlined and structured, adapting to any changes in your application's data model.


#### Conclusion
DTOs are an integral part of managing data transfer in modern Laravel applications. By using the `php artisan generate:dto` command with various options, you can easily create and customize DTO classes to suit your specific application requirements.


## Create DTO (Data Transfer Object) Management

### Command Overview
In Laravel, managing DTOs is crucial for structuring data transfers within your application. The `php artisan generate:create-dto` command simplifies the process of creating new DTOs specifically designed for creating resources.
You can use the following Artisan command to generate a new create DTO class file:

```bash
php artisan generate:create-dto {name} [options]
```
- **`{name}`**: The name of the dto you want to generate.
- **`[options]`**: Optional. Additional options or flags to customize the create DTO generation process.

#### Command Signature

```bash
php artisan generate:create-dto 
                    {name : The name of the DTO class}
                    {--model= : The name the associate model dto}
                    {--modules : The base path to the dto class}
                    {--base_path : The base path to the dto class}
                    {--path= : The path to the dto class}
                    {--namespace= : The namespace of the dto class}
                    {--api-version=v1 : Specify the API version for the dto}
                    {--force : Force create the dto}';
```

#### Command Options
- **`{name}`**: The name of the create-dto you want to generate.
- **`--model=`**: Optional. The name of the associated model for the DTO.
- **`--modules`**: Optional. If you want to package the DTO class within a "modules" folder, you can use this option. It allows you to organize your DTOs within a specific directory named "modules."
- **`--base_path`**: Optional. This option allows you to specify the base path for the DTO class. If you want the DTO class to be located at the root of the Laravel project, you can use this option.
- **`--path=`**: Optional. This option allows you to specify a custom path for the DTO class within your Laravel project. You can use it to define the location of the DTO class.
- **`--namespace=`**: Optional. The namespace of the DTO class.
- **`--api-version=`**: Optional. Specify the API version for the DTO.
- **`--force`**: Optional. Force create the DTO, overwriting existing files with the same name.

#### Command Usage

##### Basic Usage
To generate a create DTO, run the following command:

```bash
php artisan generate:create-dto {name}
```
Replace `{name}` with the desired name of your create DTO.

##### Additionnal Options
In addition to the basic usage, the `php artisan generate:create-dto` command provides several additional options for more customization:

- [**`--model={model_name}`**](#specify-the-associated-model-of-the-create-dto): Specifies the name of the associated model for the DTO. This option helps you define the relationship between the DTO and the model.

- [**`--base_path`**](#customizing-base-path-for-create-dto): Specifies the base path to the DTO class. You can use this option to define the root directory for your DTOs.

- [**`--modules`**](#organizing-create-dto-within-modules): Sets the base path folder for the DTO class. Use this option if you want to organize your DTOs within a specific directory.

- [**`--path={path}`**](#custom-path-for-create-dto): Sets the path to the DTO class. Use this option to specify the location of the DTO class within your project.

- [**`--namespace[={namespace}]`**](#customizing-create-dto-namespace): Defines the namespace of the DTO class. You can use this option to place your DTOs within a specific namespace.

- [**`--api-version[={version}]`**](#specify-create-dto-api-version): Specifies the API version for the DTO. Use this option if your DTOs are related to a specific API version.

- [**`--force`**](#force-create-dto-creation): If you want to forcefully generate a DTO file, even if a DTO file with the same name already exists, you can use the --force option.


These additional options allow you to tailor the DTO generation process to your specific project requirements, providing flexibility and organization in managing your DTOs.


##### Specify the Associated Model
You can specify an associated model for your create DTO using the `--model` option. This is useful when your create DTO is closely tied to a particular model's data structure:

```bash
php artisan generate:create-dto {name} [--model={model_name}]
```
- **`{name}`**: The name of the create-dto you want to generate.
- **`--model=`**: Optional. The name of the associated model for the DTO.
- **`{model_name}`**: Optional. The name of the associated model for the DTO.
- **`--model={model_name}`**: Specify the name of the associated model. This option helps you define the relationship between the create DTO and the model.

###### Example
Let's say you want to create a create DTO for handling user data transfers during resource creation in your application associated with the `User` model. You can use the following command:

```bash
php artisan generate:create-dto UserCreateDTO --model=User
```
This command will generate a new `UserCreateDTO` class in your Laravel project, which you can use for structuring and managing user-related data transfers during resource creation.

##### Force Creation
If you want to forcefully generate a create DTO file, even if a create DTO file with the same name already exists, you can use the `--force` option:
This is useful when your create DTO is closely tied to a particular model's data structure:

```bash
php artisan generate:create-dto {name} [--force]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--force`**: Optional. This option allows you to create the create DTO file forcefully, overwriting any existing file with the same name.

###### Example
Let's say you want to create a create DTO for handling user data transfers during resource creation in your application associated with the `User` model. You can use the following command to force the creation, even if a `UserCreateDTO` file already exists:


```bash
php artisan generate:create-dto UserCreateDTO --force
```
This command will generate a new `UserCreateDTO` class in your Laravel project, which you can use for structuring and managing user-related data transfers during resource creation.


***Note:*** The `--force` option is a valuable tool when you need to generate a create DTO file without being hindered by existing files with the same name. It enables you to overwrite any pre-existing create DTO file and ensure that your Laravel project maintains the desired structure and organization.


##### Specify API Version

If your create DTOs are related to a specific API version, you can specify it using the `--api-version` option:

```bash
php artisan generate:create-dto {name} [--api-version[={version}]]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--api-version`**: Optional. This option allows you to specify the desired API version for the create DTO.
- **`{version}`**: Optional. The version number you want to associate with the create DTO.
- **`--api-version[={version}]`**: Use this option to specify the API version for the create DTO. It helps categorize and manage create DTOs based on different API versions.

###### Example
Let's say you have an API with version `v2`, and you want to create a create DTO named `ProductCreateDTO` for that version. You can use the following command:

```bash
php artisan generate:create-dto ProductCreateDTO --api-version=v2
```
This command will generate a `ProductCreateDTO` class associated with API version `v2` in your Laravel project.

***Note:*** Utilizing the --api-version option when generating create DTOs can be particularly useful for organizing and managing your DTOs based on different API versions within your Laravel application. This allows for efficient data transfer and structuring processes tailored to specific API requirements.

##### Customizing Namespace
You can customize the namespace for your create DTO class using the `--namespace` option:

```bash
php artisan generate:create-dto {name} [--namespace[={namespace_value}]]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--namespace`**: Optional. This option allows you to specify the desired namespace for the create DTO.
- **`{namespace_value}`**: Optional. The custom namespace you want to associate with the create DTO class.
- **`--namespace[={namespace_value}]`**: Use this option to set the desired namespace for the create DTO class. It enables you to efficiently organize your create DTOs within your Laravel application.

###### Example
To illustrate how to use the `--namespace` option when generating a create DTO, let's assume you want to create a create DTO named `UserCreateDTO` and place it within the `App\DTOs` namespace. You can accomplish this by running the following command:


```bash
php artisan generate:create-dto UserCreateDTO --namespace=App\\DTOs
```
This command will generate the `UserCreateDTO` class with the specified namespace, ensuring that it's organized in the `App\DTOs` namespace within your Laravel application.

***Note:*** These command descriptions and examples provide you with a comprehensive understanding of how to use the `php artisan generate:create-dto` command to efficiently manage Data Transfer Objects (DTOs) in your Laravel application. Utilize the various options and examples to tailor DTO generation according to your specific project requirements, enhancing data transfer and structuring processes.


#### Customizing DTO Directory Structure

When generating Data Transfer Objects (DTOs) with the `php artisan generate:create-dto` command, you have the flexibility to customize the directory structure in which the DTOs are generated. You can combine the following options to create a directory structure that suits your project's organization:

- **`--base_path`**: Use this option if you want to generate the DTO within the base path of your Laravel project. It sets the root directory for your DTOs.

- **`--modules`**: If your project follows a modular structure and you want to package the DTO within a "modules" folder, use this option.

- **`--path`**: This option allows you to define a custom path where the create DTO class should be generated within your Laravel project. You can specify a path relative to your project's root directory.

Here's how you can use these options to create a custom directory structure for your create DTOs:

```bash
php artisan generate:create-dto {name} [--base_path] [--modules] [--path[={path}]]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--base_path`**: Optional. Use this option to generate the create DTO class at the root of your Laravel project. When included, the create DTO will be placed at the root of your project, allowing for organization outside the app folder.
- **`--modules`**: Optional. This option allows you to generate the create DTO class within a `modules` folder in your Laravel project.
- **`--path`**: Optional. Use this option to define a custom path where the create DTO class should be generated within your Laravel project.
- **`{path}`**: Optional. Specify the custom path where the create DTO should be created.
- **`--path[={path}]`**: Use this option to set a custom path for creating the create DTO. It allows you to specify the location of the DTO class within your project based on your project's structure.


##### Custom Path for DTO
To specify a custom path for DTO generation, you can use the `--path` option:

```bash
php artisan generate:create-dto {name} [--path[={path}]]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--path`**: Optional. Use this option to define a custom path where the create DTO class should be generated within your Laravel project.
- **`{path}`**: Optional. Specify the custom path where the create DTO should be created.
- **`--path[={path}]`**: Use this option to set a custom path for creating the create DTO. It allows you to specify the location of the DTO class within your project based on your project's structure.

###### Example
To create a create DTO within a custom path, such as `app/DTOs`, you can use the following command:


```bash
php artisan generate:create-dto OrderCreateDTO --path=app/DTOs
```
This command will generate the OrderCreateDTO class in the specified custom path, allowing you to organize your DTOs according to your project's structure.

***Note:*** The `--path` option provides flexibility in determining the location where your create DTOs are generated, allowing you to adhere to your project's organization conventions.


##### Customizing Base Path
You can customize the base path for your create DTO class using the `--base_path` option:

```bash
php artisan generate:create-dto {name} [--base_path]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--base_path`**: Optional. Use this option to generate the create DTO class at the root of your Laravel project. When included, the create DTO will be placed at the root of your project, allowing for organization outside the app folder.

###### Example
To generate a create DTO class at the root of your Laravel project, you can use the following command:

```bash
php artisan generate:create-dto UserCreateDTO --base_path
```
This command will create the UserCreateDTO class at the root of your Laravel project.


##### Organizing within Modules
You can customize the base path for your create DTO class using the `--modules` option:

```bash
php artisan generate:create-dto {name} [--modules]
```
- **`{name}`**: The name of your desired create DTO class. This command will create a new DTO file with this name.
- **`--modules`**: Optional. This option allows you to generate the create DTO class within a `modules` folder in your Laravel project.

###### Example
To generate a create DTO within a `modules` folder at the root of your Laravel project, you can use the following command:

```bash
php artisan generate:create-dto ProductCreateDTO --modules
```
This command will create the `ProductCreateDTO` class within a `modules` folder.


##### Extra

You can combine these options to create a custom directory structure tailored to your project's needs. Here are some examples:

- To place create DTOs within a `modules` folder at the base path:

```bash
php artisan generate:create-dto {name} [--base_path] [--modules]
```

***Example:***
```bash
php artisan generate:create-dto UserCreateDTO --base_path  --modules
```

- To generate create DTOs within a custom folder at the base path:

```bash
php artisan generate:create-dto {name} [--base_path] [--path[={path}]]
```

***Example:***
```bash
php artisan generate:create-dto UserCreateDTO --base_path --path=Custom/Folders
```

- To organize create DTOs within a `modules` folder at the base path and specify a custom path:

```bash
php artisan generate:create-dto {name} [--base_path] [--modules] [--path[={path}]]
```
This combination offers flexibility in structuring your create DTOs to meet your project's specific requirements.

***Example:***
```bash
php artisan generate:create-dto UserCreateDTO --base_path  --modules --path=Custom/Folders
```
This example generates a `UserCreateDTO` class with a directory structure that includes a `modules` folder and a custom path named`Custom/Folders`

***Note:*** By combining these options, you can tailor the organization of your create DTOs to align with your project's specific requirements. Whether you prefer to keep them within the base path, package them in a `modules` folder, or specify a custom path, these options provide you with the flexibility needed for efficient DTO management within your Laravel application.


***Note:*** These command descriptions and examples provide you with a comprehensive understanding of how to use the `php artisan generate:create-dto` command to efficiently manage Data Transfer Objects (DTOs) in your Laravel application. Utilize the various options and examples to tailor DTO generation according to your specific project requirements, enhancing data transfer and structuring processes.

### Conclusion
Managing DTOs is essential for organizing data transfers in your Laravel application. The `php artisan generate:create-dto` command simplifies the process, allowing you to create custom DTOs tailored to your project's needs. By using the provided options, you can efficiently structure and manage your DTOs, enhancing data transfer and structuring processes.


## Update DTO (Data Transfer Object) Management

### Command Overview
In Laravel, managing DTOs is crucial for structuring data transfers within your application. The `php artisan generate:update-dto` command simplifies the process of creating new DTOs specifically designed for creating resources.
You can use the following Artisan command to generate a new update DTO class file:

```bash
php artisan generate:update-dto {name} [options]
```
- **`{name}`**: The name of the dto you want to generate.
- **`[options]`**: Optional. Additional options or flags to customize the update DTO generation process.

#### Command Signature

```bash
php artisan generate:update-dto 
                    {name : The name of the DTO class}
                    {--model= : The name the associate model dto}
                    {--modules : The base path to the dto class}
                    {--base_path : The base path to the dto class}
                    {--path= : The path to the dto class}
                    {--namespace= : The namespace of the dto class}
                    {--api-version=v1 : Specify the API version for the dto}
                    {--force : Force update the dto}';
```

#### Command Options
- **`{name}`**: The name of the update-dto you want to generate.
- **`--model=`**: Optional. The name of the associated model for the DTO.
- **`--modules`**: Optional. If you want to package the DTO class within a "modules" folder, you can use this option. It allows you to organize your DTOs within a specific directory named "modules."
- **`--base_path`**: Optional. This option allows you to specify the base path for the DTO class. If you want the DTO class to be located at the root of the Laravel project, you can use this option.
- **`--path=`**: Optional. This option allows you to specify a custom path for the DTO class within your Laravel project. You can use it to define the location of the DTO class.
- **`--namespace=`**: Optional. The namespace of the DTO class.
- **`--api-version=`**: Optional. Specify the API version for the DTO.
- **`--force`**: Optional. Force update the DTO, overwriting existing files with the same name.

#### Command Usage

##### Basic Usage
To generate a update DTO, run the following command:

```bash
php artisan generate:update-dto {name}
```
Replace `{name}` with the desired name of your update DTO.

##### Additionnal Options
In addition to the basic usage, the `php artisan generate:update-dto` command provides several additional options for more customization:

- [**`--model={model_name}`**](#specify-the-associated-model-of-the-update-dto): Specifies the name of the associated model for the DTO. This option helps you define the relationship between the DTO and the model.

- [**`--base_path`**](#customizing-base-path-for-update-dto): Specifies the base path to the DTO class. You can use this option to define the root directory for your DTOs.

- [**`--modules`**](#organizing-update-dto-within-modules): Sets the base path folder for the DTO class. Use this option if you want to organize your DTOs within a specific directory.

- [**`--path={path}`**](#custom-path-for-update-dto): Sets the path to the DTO class. Use this option to specify the location of the DTO class within your project.

- [**`--namespace[={namespace}]`**](#customizing-update-dto-namespace): Defines the namespace of the DTO class. You can use this option to place your DTOs within a specific namespace.

- [**`--api-version[={version}]`**](#specify-update-dto-api-version): Specifies the API version for the DTO. Use this option if your DTOs are related to a specific API version.

- [**`--force`**](#force-update-dto-creation): If you want to forcefully generate a DTO file, even if a DTO file with the same name already exists, you can use the --force option.


These additional options allow you to tailor the DTO generation process to your specific project requirements, providing flexibility and organization in managing your DTOs.


##### Specify the Associated Model
You can specify an associated model for your update DTO using the `--model` option. This is useful when your update DTO is closely tied to a particular model's data structure:

```bash
php artisan generate:update-dto {name} [--model={model_name}]
```
- **`{name}`**: The name of the update-dto you want to generate.
- **`--model=`**: Optional. The name of the associated model for the DTO.
- **`{model_name}`**: Optional. The name of the associated model for the DTO.
- **`--model={model_name}`**: Specify the name of the associated model. This option helps you define the relationship between the update DTO and the model.

###### Example
Let's say you want to update a update DTO for handling user data transfers during resource creation in your application associated with the `User` model. You can use the following command:

```bash
php artisan generate:update-dto UserUpdateDTO --model=User
```
This command will generate a new `UserUpdateDTO` class in your Laravel project, which you can use for structuring and managing user-related data transfers during resource creation.

##### Force Creation
If you want to forcefully generate a update DTO file, even if a update DTO file with the same name already exists, you can use the `--force` option:
This is useful when your update DTO is closely tied to a particular model's data structure:

```bash
php artisan generate:update-dto {name} [--force]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--force`**: Optional. This option allows you to update the update DTO file forcefully, overwriting any existing file with the same name.

###### Example
Let's say you want to update a update DTO for handling user data transfers during resource creation in your application associated with the `User` model. You can use the following command to force the creation, even if a `UserUpdateDTO` file already exists:


```bash
php artisan generate:update-dto UserUpdateDTO --force
```
This command will generate a new `UserUpdateDTO` class in your Laravel project, which you can use for structuring and managing user-related data transfers during resource creation.


***Note:*** The `--force` option is a valuable tool when you need to generate a update DTO file without being hindered by existing files with the same name. It enables you to overwrite any pre-existing update DTO file and ensure that your Laravel project maintains the desired structure and organization.


##### Specify API Version

If your update DTOs are related to a specific API version, you can specify it using the `--api-version` option:

```bash
php artisan generate:update-dto {name} [--api-version[={version}]]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--api-version`**: Optional. This option allows you to specify the desired API version for the update DTO.
- **`{version}`**: Optional. The version number you want to associate with the update DTO.
- **`--api-version[={version}]`**: Use this option to specify the API version for the update DTO. It helps categorize and manage update DTOs based on different API versions.

###### Example
Let's say you have an API with version `v2`, and you want to update a update DTO named `ProductUpdateDTO` for that version. You can use the following command:

```bash
php artisan generate:update-dto ProductUpdateDTO --api-version=v2
```
This command will generate a `ProductUpdateDTO` class associated with API version `v2` in your Laravel project.

***Note:*** Utilizing the --api-version option when generating update DTOs can be particularly useful for organizing and managing your DTOs based on different API versions within your Laravel application. This allows for efficient data transfer and structuring processes tailored to specific API requirements.

##### Customizing Namespace
You can customize the namespace for your update DTO class using the `--namespace` option:

```bash
php artisan generate:update-dto {name} [--namespace[={namespace_value}]]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--namespace`**: Optional. This option allows you to specify the desired namespace for the update DTO.
- **`{namespace_value}`**: Optional. The custom namespace you want to associate with the update DTO class.
- **`--namespace[={namespace_value}]`**: Use this option to set the desired namespace for the update DTO class. It enables you to efficiently organize your update DTOs within your Laravel application.

###### Example
To illustrate how to use the `--namespace` option when generating a update DTO, let's assume you want to update a update DTO named `UserUpdateDTO` and place it within the `App\DTOs` namespace. You can accomplish this by running the following command:


```bash
php artisan generate:update-dto UserUpdateDTO --namespace=App\\DTOs
```
This command will generate the `UserUpdateDTO` class with the specified namespace, ensuring that it's organized in the `App\DTOs` namespace within your Laravel application.

***Note:*** These command descriptions and examples provide you with a comprehensive understanding of how to use the `php artisan generate:update-dto` command to efficiently manage Data Transfer Objects (DTOs) in your Laravel application. Utilize the various options and examples to tailor DTO generation according to your specific project requirements, enhancing data transfer and structuring processes.


#### Customizing DTO Directory Structure

When generating Data Transfer Objects (DTOs) with the `php artisan generate:update-dto` command, you have the flexibility to customize the directory structure in which the DTOs are generated. You can combine the following options to update a directory structure that suits your project's organization:

- **`--base_path`**: Use this option if you want to generate the DTO within the base path of your Laravel project. It sets the root directory for your DTOs.

- **`--modules`**: If your project follows a modular structure and you want to package the DTO within a "modules" folder, use this option.

- **`--path`**: This option allows you to define a custom path where the update DTO class should be generated within your Laravel project. You can specify a path relative to your project's root directory.

Here's how you can use these options to update a custom directory structure for your update DTOs:

```bash
php artisan generate:update-dto {name} [--base_path] [--modules] [--path[={path}]]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--base_path`**: Optional. Use this option to generate the update DTO class at the root of your Laravel project. When included, the update DTO will be placed at the root of your project, allowing for organization outside the app folder.
- **`--modules`**: Optional. This option allows you to generate the update DTO class within a `modules` folder in your Laravel project.
- **`--path`**: Optional. Use this option to define a custom path where the update DTO class should be generated within your Laravel project.
- **`{path}`**: Optional. Specify the custom path where the update DTO should be updated.
- **`--path[={path}]`**: Use this option to set a custom path for creating the update DTO. It allows you to specify the location of the DTO class within your project based on your project's structure.


##### Custom Path for DTO
To specify a custom path for DTO generation, you can use the `--path` option:

```bash
php artisan generate:update-dto {name} [--path[={path}]]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--path`**: Optional. Use this option to define a custom path where the update DTO class should be generated within your Laravel project.
- **`{path}`**: Optional. Specify the custom path where the update DTO should be updated.
- **`--path[={path}]`**: Use this option to set a custom path for creating the update DTO. It allows you to specify the location of the DTO class within your project based on your project's structure.

###### Example
To update a update DTO within a custom path, such as `app/DTOs`, you can use the following command:


```bash
php artisan generate:update-dto OrderUpdateDTO --path=app/DTOs
```
This command will generate the OrderUpdateDTO class in the specified custom path, allowing you to organize your DTOs according to your project's structure.

***Note:*** The `--path` option provides flexibility in determining the location where your update DTOs are generated, allowing you to adhere to your project's organization conventions.


##### Customizing Base Path
You can customize the base path for your update DTO class using the `--base_path` option:

```bash
php artisan generate:update-dto {name} [--base_path]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--base_path`**: Optional. Use this option to generate the update DTO class at the root of your Laravel project. When included, the update DTO will be placed at the root of your project, allowing for organization outside the app folder.

###### Example
To generate a update DTO class at the root of your Laravel project, you can use the following command:

```bash
php artisan generate:update-dto UserUpdateDTO --base_path
```
This command will update the UserUpdateDTO class at the root of your Laravel project.


##### Organizing within Modules
You can customize the base path for your update DTO class using the `--modules` option:

```bash
php artisan generate:update-dto {name} [--modules]
```
- **`{name}`**: The name of your desired update DTO class. This command will update a new DTO file with this name.
- **`--modules`**: Optional. This option allows you to generate the update DTO class within a `modules` folder in your Laravel project.

###### Example
To generate a update DTO within a `modules` folder at the root of your Laravel project, you can use the following command:

```bash
php artisan generate:update-dto ProductUpdateDTO --modules
```
This command will update the `ProductUpdateDTO` class within a `modules` folder.


##### Extra

You can combine these options to update a custom directory structure tailored to your project's needs. Here are some examples:

- To place update DTOs within a `modules` folder at the base path:

```bash
php artisan generate:update-dto {name} [--base_path] [--modules]
```

***Example:***
```bash
php artisan generate:update-dto UserUpdateDTO --base_path  --modules
```

- To generate update DTOs within a custom folder at the base path:

```bash
php artisan generate:update-dto {name} [--base_path] [--path[={path}]]
```

***Example:***
```bash
php artisan generate:update-dto UserUpdateDTO --base_path --path=Custom/Folders
```

- To organize update DTOs within a `modules` folder at the base path and specify a custom path:

```bash
php artisan generate:update-dto {name} [--base_path] [--modules] [--path[={path}]]
```
This combination offers flexibility in structuring your update DTOs to meet your project's specific requirements.

***Example:***
```bash
php artisan generate:update-dto UserUpdateDTO --base_path  --modules --path=Custom/Folders
```
This example generates a `UserUpdateDTO` class with a directory structure that includes a `modules` folder and a custom path named`Custom/Folders`

***Note:*** By combining these options, you can tailor the organization of your update DTOs to align with your project's specific requirements. Whether you prefer to keep them within the base path, package them in a `modules` folder, or specify a custom path, these options provide you with the flexibility needed for efficient DTO management within your Laravel application.


***Note:*** These command descriptions and examples provide you with a comprehensive understanding of how to use the `php artisan generate:update-dto` command to efficiently manage Data Transfer Objects (DTOs) in your Laravel application. Utilize the various options and examples to tailor DTO generation according to your specific project requirements, enhancing data transfer and structuring processes.

### Conclusion
Managing DTOs is essential for organizing data transfers in your Laravel application. The `php artisan generate:update-dto` command simplifies the process, allowing you to update custom DTOs tailored to your project's needs. By using the provided options, you can efficiently structure and manage your DTOs, enhancing data transfer and structuring processes.



## Create Request Class Generation
The `generate:create-request` Artisan command is used to generate a new request class. Request classes are a crucial part of Laravel applications, handling input validation and authorization for incoming requests.

### Command Overview
You can use the following Artisan command to generate a new request class:


```bash
php artisan generate:create-request {name?} [options]

```
- **`{name?}`**: Optional. The name of the create request class you want to generate. If not provided, the command will interactively prompt you for it.
- **`[options]`**: Optional. Additional options or flags to customize the request class generation process.

#### Command Signature

```bash
php artisan generate:create-request 
		    {name? : The name of the create request class}
		    {--base=FormRequest : The base class for the request}
		    {--dir=app/Http/Requests : The directory to store the request}
		    {--namespace=App\\Http\\Requests : The namespace for the request}
		    {--model= : The model class associated with the request}
		    {--controller=App\\Http\\Controllers : Generate a corresponding controller}
		    {--api-version=v1 : Specify the API version for the request}
		    {--dto= : Specify the Data Transfer Object (DTO) class associated with the request}
		    {--dtoNamespace= : Specify the namespace for the DTO class}
		    {--force : Force the generation even if the file already exists}
		    {--validation-rules : Specify the validation rules for the request}
		    {--validation-messages : Specify the validation messages for the request}
		    {--policy : Generate a policy for the request}
		    {--timestamp : Add a timestamp to the filename}
		    {--test : Generate a test for the request}
		    {--interactive : Interactively prompt for missing options}
```

#### Command Options

- **`{name?}`**: Optional. The name of the create request class you want to generate. If not provided, the command will interactively prompt you for it.
- **`--base={base_class}`**: Optional. Specifies the base class for the request. By default, it extends FormRequest, but you can specify a different base class if needed.
- **`--dir={directory}`**: Optional. Specifies the directory where the request class should be stored. The default directory is app/Http/Requests.
- **`--namespace={namespace}`**: Optional. Specifies the namespace for the request class. The default namespace is App\Http\Requests.
- **`--model={model_class}`**: Optional. Specifies the model class associated with the request. This is useful for generating requests tailored to a specific model.
- **`--controller={controller_namespace}`**: Optional. Generates a corresponding controller for the request. By default, it uses the App\Http\Controllers namespace.
- **`--api-version={version}`**: Optional. Specifies the API version for the request. Useful when working with API versions.
- **`--dto={dto_class}`**: Optional. Specifies the Data Transfer Object (DTO) class associated with the request. Allows for tighter integration between requests and DTOs.
- **`--dtoNamespace={dto_namespace}`**: Optional. Specifies the namespace for the DTO class.
- **`--force`**: Optional. Forces the generation of the request class even if a file with the same name already exists.
- **`--validation-rules`**: Optional. Allows you to specify the validation rules for the request. Useful for custom validation logic.
- **`--validation-messages`**: Optional. Allows you to specify custom validation messages for the request.
- **`--policy`**: Optional. Generates a policy for the request, enabling you to define authorization logic.
- **`--timestamp`**: Optional. Adds a timestamp to the filename of the generated request class.
- **`--test`**: Optional. Generates a test class for the request, facilitating test-driven development.
- **`--interactive`**: Optional. Enables interactive prompts for missing options, making it easier to configure the request generation.

#### Command Usage
##### Basic Usage
To generate a create request class, you can run the following command:

```bash
php artisan generate:create-request {name}
```
Replace `{name}` with the desired name of your create request class.

##### Additional Options
In addition to the basic usage, the generate:create-request command provides several additional options for more customization:


##### Define the Directory for the Request
The `--dir` option allows you to define the directory where the request class should be stored. This helps you organize your request classes in a specific directory.

```bash
php artisan generate:create-request {name} [--dir={directory_path}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--dir`**: Optional. The path to the directory where the request class should be stored.
- **`{directory_path}`**: Optional. The path to the directory where the request class should be stored.
- **`--dir[={directory_path}]`**: Specify the directory path where the request class should be stored.

###### Example
Suppose you want to generate a create request class named `CreateProductRequest` and store it in a directory named `Requests` within the `Modules` folder. You can use the following command:

```bash
php artisan generate:create-request CreateProductRequest --dir=app/Http/Requests/V1/Products
```
This command will create the `CreateProductRequest` class and place it in the specified directory path, helping you organize your request classes within your Laravel project.


##### Custom Namespace for the Request
To set a custom namespace for the request class, you can use the `--namespace` option.

```bash
php artisan generate:create-request {name} [--namespace={custom_namespace}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--namespace`**: Optional. This option allows you to specify a custom namespace for the request.
- **`{custom_namespace}`**: Optional. The custom namespace you want to associate with the request class.
- **`--namespace[={custom_namespace}]`**: Use this option to set the desired namespace for the request class, aiding in efficient organization.

###### Example
Suppose you want to create a create request named `CreatePaymentRequest` and place it within the `App\Http\Requests\Payments` namespace. You can achieve this by running the following command:


```bash
php artisan generate:create-request CreatePaymentRequest --namespace=App\\Http\\Requests\\Payments
```
This command will generate the `CreatePaymentRequest` class with the specified namespace, ensuring that it is organized under the `App\Http\Requests\Payments` namespace within your Laravel application.


##### Associate the Request with a Model

To associate the create request with a specific model, you can use the `--model` option. This is helpful when your create request is closely related to a particular model's data structure.


```bash
php artisan generate:create-request {name} [--model={model_name}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--model`**: Optional. Use this option to specify the name of the associated model for the request.
- **`{model_name}`**: Optional. The name of the associated model for the request.
- **`--model[={model_name}]`**: Set the name of the associated model. This option helps establish a relationship between the create request and the model.

###### Example
Suppose you want to create a create request for managing product data during resource creation, and it is associated with the `Product` model. You can use the following command:


```bash
php artisan generate:create-request CreateProductRequest --model=Product
```
This command will generate the `CreateProductRequest` class, indicating that it is closely related to the Product model in your Laravel application.


##### Generate a Corresponding Controller
Use the `--controller` option to generate a corresponding controller for the create request. This simplifies the process of creating a controller that works in tandem with your request.


```bash
php artisan generate:create-request {name} [--controller={controller_namespace}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--controller`**: Optional. This option allows you to specify the namespace for the corresponding controller.
- **`{controller_namespace}`**: Optional. The namespace for the corresponding controller.
- **`--controller[={controller_namespace}]`**: Generate a corresponding controller for the create request, specifying the controller's namespace.

###### Example
Suppose you want to create a create request named CreateCommentRequest and generate a corresponding controller within the `App\Http\Controllers` namespace. You can use the following command:

```bash
php artisan generate:create-request CreateCommentRequest --controller=App\\Http\\Controllers
```
This command will generate both the `CreateCommentRequest` class and a corresponding controller within the specified namespace, streamlining the process of handling requests related to comments in your Laravel application.


##### Specify API Version

When working with API versions, you can utilize the `--api-version` option to specify the version associated with the request. This helps categorize and manage your requests based on different API versions.


```bash
php artisan generate:create-request {name} [--api-version={version}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--api-version`**: Optional. This option allows you to specify the desired API version for the request.
- **`{version}`**: Optional. The version number you want to associate with the request.
- **`--api-version[={version}]`**: Set the API version for the request. This option aids in organizing and managing requests according to different API versions.

###### Example
Suppose you have an API with version `v2`, and you want to create a create request named `CreateProductRequest` for that version. You can use the following command:

```bash
php artisan generate:create-request CreateProductRequest --api-version=v2
```
This command will generate the `CreateProductRequest` class associated with API version `v2` in your Laravel project, allowing you to manage requests specific to that version.


##### Associate with a Data Transfer Object (DTO)

To associate a Data Transfer Object (DTO) class with the create request, you can use the `--dto` option. This is useful when you need to validate and process data using a DTO.

```bash
php artisan generate:create-request {name} [--dto={dto_name}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--dto`**: Optional. Use this option to specify the name of the associated DTO class.
- **`{dto_name}`**: Optional. The name of the associated DTO class.
- **`--dto[={dto_name}]`**: Associate a Data Transfer Object (DTO) class with the create request. This option establishes a connection between the request and the DTO.

###### Example
Suppose you want to create a create request named `CreateOrderRequest` and associate it with a DTO named `CreateOrderDTO`. You can use the following command:

```bash
php artisan generate:create-request CreateOrderRequest --dto=CreateOrderDTO
```
This command will generate the `CreateOrderRequest` class and indicate that it is associated with the `CreateOrderDTO` class. It allows you to validate and process data using the specified DTO.


##### Custom Namespace for the DTO Class
You can set a custom namespace for the DTO class using the `--dtoNamespace` option. This provides flexibility in organizing your DTO classes within your Laravel project.

```bash
php artisan generate:create-request {name} [--dtoNamespace={namespace_value}]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--dtoNamespace`**: Optional. This option allows you to specify a custom namespace for the associated DTO class.
- **`{namespace_value}`**: Optional. The custom namespace you want to associate with the DTO class.
- **`--dtoNamespace[={namespace_value}]`**: Set a custom namespace for the DTO class, enabling efficient organization.

###### Example
Suppose you want to create a create request named `CreateCustomerRequest` and associate it with a DTO class named `CreateCustomerDTO` within the `App\Http\Requests\Customers` namespace. You can use the following command:


```bash
php artisan generate:create-request CreateCustomerRequest --dto=CreateCustomerDTO --dtoNamespace=App\\Http\\Requests\\Customers
```
This command will generate the `CreateCustomerRequest` class and specify that it is associated with the `CreateCustomerDTO` class, which is organized under the custom namespace `App\Http\Requests\Customers`.



##### Forceful Generation
If you want to forcefully generate the request class, even if a file with the same name already exists, you can use the `--force` option. This ensures that the generation process proceeds without any hindrance from existing files.

```bash
php artisan generate:create-request {name} [--force]
```
- **`{name}`**: The name of the create request class you want to generate.
- **`--force`**: Optional. Use this option to forcefully generate the request class, even if a file with the same.

###### Example
Suppose you want to create a create request named `CreateReviewRequest` and ensure that it is generated without any interruptions, even if a file named `CreateReviewRequest.php` already exists. You can use the following command:


```bash
php artisan generate:create-request CreateReviewRequest --force
```
This command will generate the `CreateReviewRequest` class, overwriting any existing file with the same name if the `--force` option is used.

***Note:*** These additional options provide you with enhanced flexibility and customization when generating create request classes in your Laravel application. You can tailor your requests to your project's specific needs, ensuring efficient validation and processing of incoming data.

#### Conclusion




## Generate Controller
The `generate:controller` command is used to generate controller classes in Laravel. Controllers are a crucial part of handling HTTP requests in your application. This command provides various options for customizing the generation of controllers to meet your project's requirements.

### Command Overview
You can use the following Artisan command to generate a new request class:


```bash
php artisan generate:controller {name} [options]

```
- **`{name?}`**: The name of the controller class you want to generate.
- **`[options]`**: Optional. Additional options or flags to customize the controller class generation process.

#### Command Signature

```bash
php artisan generate:controller
                    {name : The name of the controller class} 
                    {--resource : Generate a resource controller}
                    {--namespace= : The namespace for the controller}
                    {--middleware= : Comma-separated list of middleware}
                    {--only= : Comma-separated list of methods to generate (for resource controller)}
                    {--except= : Comma-separated list of methods to exclude (for resource controller)}
                    {--force : Overwrite existing controller if it exists}
                    {--api : Generate a resourceful controller}
                    {--api-rest : Generate a resourceful controller}
                    {--with-form-requests : Generate FormRequest classes}
                    {--request : Generate request}
                    {--route : Generate route}
                    {--repository : Generate repository}
                    {--repository-namespace= : Path of the repository}
                    {--repository-base-path : Repository is at base path}
                    {--provider= : Generate provider}
                    {--bindings : Generate route model bindings for controller methods that require them, automatically injecting the necessary model instances into your method}
                    {--service : Generate a corresponding service class for the controller, separating business logic from the controller itself}
                    {--requests : Generate request classes (form request validation) associated with the controller methods, enhancing your application's validation and security}
```

#### Command Options

- **`{name}`**: The name of the controller class you want to generate.

- **`--resource`**: Generate a resource controller. Resource controllers are used for CRUD operations.

- **`--namespace`**: Specify a custom namespace for the controller class.

- **`--middleware`**: Comma-separated list of middleware to apply to the controller's routes.

- **`--only`**: Comma-separated list of methods to generate when creating a resource controller.

- **`--except`**: Comma-separated list of methods to exclude when creating a resource controller.

- **`--force`**: Overwrite the existing controller if it already exists.

- **`--api or --api-rest`**: Generate a resourceful controller suitable for building RESTful APIs.

- **`--with-form-requests`**: Generate FormRequest classes associated with the controller methods for request validation.

- **`--request`**: Generate a request class associated with the controller.

- **`--route`**: Generate a route class associated with the controller.

- **`--repository`**: Generate a repository class associated with the controller.

- **`--repository-namespace`**: Specify the path or namespace for the repository.

- **`--repository-base-path`**: Place the repository in the base path of your Laravel application.

- **`--provider`**: Generate a provider class associated with the controller.

- **`--bindings`**: Generate route model bindings for controller methods that require them, automatically injecting the necessary model instances into your method.

- **`--service`**: Generate a corresponding service class for the controller, separating business logic from the controller itself.

- **`--requests`**: Generate request classes (form request validation) associated with the controller methods, enhancing your application's validation and security.


#### Command Usage

##### Basic Usage

To generate a new controller, run the following command:

```bash
php artisan generate:controller {name}
```
- **`{name}`**: Replace {name} with the name of your desired DTO class. This command will create a new DTO file with this name.

###### Example
Generate a basic controller class named HomeController:

```bash
php artisan generate:controller HomeController
```
This command will generate a new `HomeController` class in your Laravel project, which you can use for structuring and managing user-related data transfers.

***Note:*** This command generates a new controller class with various customization options.

##### Additional Options
In addition to the basic usage, the generate:create-request command provides several additional options for more customization:

##### Custom Namespace for the Controller

You can generate a resource controller using the `--resource` option. Resource controllers are useful for handling CRUD operations for a resource in your application.

```bash
php artisan generate:controller {name} --resource
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--resource`**: Optional. Use this option to generate a resource controller.

###### Example
To generate a resource controller named `UserController` for managing user resources, you can use the following command:


```bash
php artisan generate:controller UserController --resource
```
This command will create a `UserController` class with the necessary methods for handling resource CRUD operations.


##### Custom Namespace for the Controller

You can set a custom namespace for your controller using the `--namespace` option. This allows you to specify a custom namespace for your controller class.

```bash
php artisan generate:controller {name} --namespace={custom_namespace}
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--namespace`**: Optional. The custom namespace for the controller class.
- **`{custom_namespace}`**: Optional. The custom namespace for the controller class.
- **`--namespace={custom_namespace}`**: Specify the custom namespace for the controller class. This option enables you to organize your controllers within a specific namespace.

###### Example
To generate a controller named `ProductController` and place it within a custom namespace `App\Http\Controllers\Admin`, you can use the following command:

```bash
php artisan generate:controller ProductController --namespace=App\\Http\\Controllers\\Admin
```
This command will create the `ProductController` class within the `App\Http\Controllers\Admin` namespace in your Laravel project.

##### Specify Middleware

You can specify middleware for your controller using the `--middleware` option. Middleware provides a convenient way to filter HTTP requests entering your application.

```bash
php artisan generate:controller {name} --middleware={middleware_list}
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--middleware`**: Optional. A comma-separated list of middleware to apply to the controller.
- **`{middleware_list}`**: Optional. A comma-separated list of middleware to apply to the controller.
- **`--middleware={middleware_list}`**: Specify the middleware to be applied to the controller. This option allows you to define middleware for the controller's routes.

###### Example
To generate a controller named `ProductController` and apply the auth and admin middleware, you can use the following command:

```bash
php artisan generate:controller ProductController --middleware=auth,admin
```
This command will create the `ProductController` class with the specified middleware applied to its routes.project.

##### Specify Methods to Generate (for Resource Controller)
You can specify a parent controller class for your controller using the `--parent` option. This option allows your controller to extend a custom parent controller class.


```bash
php artisan generate:controller {name} --parent={parent_class}
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--parent`**: Optional. The name of the parent controller class to extend.
- **`{parent_class}`**: Optional. The name of the parent controller class to extend.
- **`--parent={parent_class}`**: Specify the parent controller class to extend. This option allows you to create controllers that inherit functionality from a custom parent controller.

###### Example
Suppose you want to generate a controller named `ProductController` that extends a custom parent controller named `BaseController`. You can use the following command:

```bash
php artisan generate:controller ProductController --parent=BaseController
```
This command will create the `ProductController` class that extends the `BaseController` class in your Laravel project.


##### Specify Methods to Generate (for Resource Controller)
When generating a resource controller, you can specify which methods to generate using the `--only` and `--except` options. These options allow you to control the methods that should be included or excluded.


```bash
php artisan generate:controller {name} --only={method_list}
OR
php artisan generate:controller {name} --except={method_list}
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--only=`**: Optional. A comma-separated list of methods to generate for the resource controller.
- **`--except=`**: Optional. A comma-separated list of methods to exclude for the resource controller.
- **`{method_list}`**: Optional. A comma-separated list of methods to generate or exclude.
- **`--only={method_list}`**: Specify the methods to generate for the resource controller.
- **`--except={method_list}`**: Specify the methods to exclude for the resource controller.

###### Example
To generate a resource controller named `ProductController` with only the `index` and `show` methods, you can use the following command:

```bash
php artisan generate:controller ProductController --resource --only=index,show
OR
php artisan generate:controller ProductController --resource --except=create,update
```
This command will create a `ProductController` class with only the specified methods (`index` and `show`) for handling resource operations.

##### Overwrite Existing Controller

You can forcefully generate the controller class, even if a file with the same name already exists, using the `--force` option.


```bash
php artisan generate:controller {name} --force
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--force`**: Optional. Use this option to forcefully generate the controller class, overwriting any existing file with the same name.

###### Example
If you want to create a controller named `UserController` and you're certain that no file with the same name exists or you want to overwrite an existing one, you can use the following command:

```bash
php artisan generate:controller UserController --force
```
This command will generate the `UserController` class and overwrite any existing file with the same name in your Laravel project.


##### Generate an API Resourceful Controller

You can generate an API resourceful controller using the --api or --api-rest option. This type of controller is commonly used for building RESTful APIs.

```bash
php artisan generate:controller {name} --api
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--api`**: Optional. Use this option to generate an API resourceful controller.

###### Example
To generate an API resourceful controller named ApiController, you can use the following command:

```bash
php artisan generate:controller ApiController --api
```
This command will create an ApiController class with the necessary methods for building a RESTful API.

##### Generate FormRequest Classes

You can generate FormRequest classes associated with your controller methods using the `--with-form-requests` option. FormRequest classes are useful for validating incoming HTTP requests.


```bash
php artisan generate:controller {name} --with-form-requests
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--with-form-requests`**: Optional. Use this option to generate FormRequest classes for your controller methods.

###### Example
To generate FormRequest classes for a controller named `ProductController`, you can use the following command:

```bash
php artisan generate:controller ProductController --with-form-requests
```
This command will create FormRequest classes associated with the methods of the `ProductController` in your Laravel project.

##### Specify the API Version
When working with API versions, you can use the `--api-version` option to specify the version for the controller and related components. This is useful for categorizing controllers and resources based on different API versions.

```bash
php artisan generate:controller {name} --api-version={version}
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--api-version`**: Optional. The API version for the controller and related components.
- **`{version}`**: Optional. The version number for the controller and related components.
- **`--api-version={version}`**: Use this option to specify the API version for the controller. It helps categorize controllers and resources based on different API versions.

###### Example
Suppose you're working with API version `v2`, and you want to create an API controller named `ProductController` for that version. You can use the following command:

```bash
php artisan generate:controller ProductController --api-version=v2
```
This command will generate a `ProductController` class associated with API version `v2` in your Laravel project.

##### Generate Request Classes (Form Request Validation)

You can generate request classes for your controller methods, which enhance your application's validation and security, using the `--requests` option.

```bash
php artisan generate:controller {name} --requests
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--requests`**: Optional. Use this option to generate request classes (Form Request validation) associated with the controller methods.

###### Example
To generate request classes for a controller named `ProductController`, you can use the following command:

```bash
php artisan generate:controller ProductController --requests
```
This command will create request classes associated with the methods of the `ProductController` in your Laravel project.

##### Generate Repository Classes
You can generate repository classes for your controller using the `--repository` option. Repository classes are useful for abstracting database interactions.

```bash
php artisan generate:controller {name} --repository
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--repository`**: Optional. Use this option to generate repository classes for the controller.

###### Example
To generate a controller named `ProductController` with associated repository classes, you can use the following command:

```bash
php artisan generate:controller ProductController --repository
```
This command will create repository classes associated with the `ProductController` in your Laravel project.


##### Generate Repository Classes
You can specify the namespace for the repository classes using the `--repository-namespace` option.

```bash
php artisan generate:controller {name} --repository [--repository-namespace[={repository_namespace}]]
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--repository`**: Optional. Use this option to generate repository classes for the controller.
- **`--repository-namespace`**: Optional. The namespace for the repository classes.
- **`{repository_namespace}`**: Optional. The namespace for the repository classes.
- **`--repository-namespace={repository_namespace}`**: Specify the namespace for the repository classes associated with the controller.


###### Example
To generate a controller named `ProductController` with associated repository classes in the `App\Repositories` namespace, you can use the following command:

```bash
php artisan generate:controller ProductController --repository --repository-namespace=App\\Repositories
```
This command will create repository classes in the specified `App\Repositories` namespace in your Laravel project.

##### Repository Base Path

You can generate repository classes for your controller at the base path of your Laravel project using the `--repository-base-path` option.

```bash
php artisan generate:controller {name} --repository [--repository-base-path[={repository_namespace}]]
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--repository`**: Optional. Use this option to generate repository classes for the controller.
- **`--repository-base-path`**: Optional. Use this option to generate repository classes at the base path of your Laravel project.

###### Example
To generate a controller named `ProductController` with associated repository classes in the `App\Repositories` namespace, you can use the following command:

```bash
php artisan generate:controller ProductController --repository --repository-base-path
```
This command will create repository classes at the base path of your Laravel project.


##### Generate Route Model Bindings

You can generate route model bindings for controller methods that require them, automatically injecting the necessary model instances into your method, using the `--bindings` option.


```bash
php artisan generate:controller {name} --bindings
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--bindings`**: Optional. Use this option to generate route model bindings for controller methods.

###### Example
To generate a controller named `ProductController` with route model bindings for specific methods, you can use the following command:

```bash
php artisan generate:controller ProductController --bindings
```
This command will generate route model bindings for the methods of the `ProductController` in your Laravel project.

***Note:*** These options provide you with flexibility and customization when generating controller classes in your Laravel application. You can tailor the generation process to meet your project's specific requirements, making it efficient and organized.

##### Generate a Corresponding Service Class

You can generate a corresponding service class for your controller using the `--service` option. Service classes are useful for separating business logic from the controller itself.


```bash
php artisan generate:controller {name} --service
```
- **`{name}`**: The name of the controller class you want to generate.
- **`--service`**: Optional. Use this option to generate a corresponding service class for the controller.

###### Example
To generate a controller named `ProductController` with a corresponding service class, you can use the following command:

```bash
php artisan generate:controller ProductController --service
```
This command will create both a `ProductController` class and a corresponding service class in your Laravel project.

***Note:*** These options provide you with flexibility and customization when generating controller classes in your Laravel application. You can tailor the generation process to meet your project's specific requirements, making it efficient and organized.


#### Conclusion
## Testing

```bash
composer test
```

## Features

A list of Larastan features can be found [here](docs/features.md).

## FAQ

Answer frequently asked questions here.

## Troubleshooting

Answer frequently asked questions here.


## Errors To Ignore

Some parts of Laravel are currently too magical for Larastan/PHPStan to understand.
We listed common [errors to ignore](docs/errors-to-ignore.md), add them as needed

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Code of Conduct

In order to ensure that the community is welcoming to all, please review and abide by the [Code of Conduct](CODE_OF_CONDUCT.md).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 👊🏻 Contributing

Thank you for considering contributing to Larastan. All the contribution guidelines are mentioned [here](CONTRIBUTING.md).

## Credits

- [Corine BOCOGA](https://github.com/cocorine999)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
