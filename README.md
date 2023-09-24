# Tools for creating Laravel core modules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-core-modules/core-modules-maker.svg?style=flat-square)](https://packagist.org/packages/laravel-core-modules/core-modules-maker)
[![Tests Action Status](https://img.shields.io/github/actions/workflow/status/laravel-core-modules/core-modules-maker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/laravel-core-modules/core-modules-maker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style Action Status](https://img.shields.io/github/actions/workflow/status/laravel-core-modules/core-modules-maker/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/laravel-core-modules/core-modules-maker/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-core-modules/core-modules-maker.svg?style=flat-square)](https://packagist.org/packages/laravel-core-modules/core-modules-maker)
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square" alt="MIT Software License"></a>


## About Laravel Core Modules Maker

This is a simple and extensible package for improving development time via service and repository for Laravel.

- Enum key value pairs as class constants
- Full-featured suite of methods
- Enum instantiation
- Flagged/Bitwise enums
- Type hinting
- Attribute casting
- Enum artisan generator
- Validation rules for passing enum key or values as input parameters
- Localization support
- Extendable via Macros

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

##### **Note**
The {table} value should be specified by you to define the name of the table you intend to create.


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


#### Usage

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

#### Usage

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


#### Usage
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

##### **Note**
By using the **`--action`** option appropriately for your migration needs, you can generate migration files tailored to your specific database schema changes, whether it's **`adding`** or **`modifying`** or **`deleting`** columns.

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

##### **Note**
Keep in mind that you should provide the relative path from the root of your Laravel project when using the --path option.

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
##### **Note**
Use the **`--force`** option with caution, as it will overwrite any existing migration file with the same name. This can be useful when you need to regenerate a migration file with updated specifications for a table or when resolving conflicts during development.


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

##### **Note**
The **`--pivot`** option streamlines pivot model creation, making it easier to manage complex many-to-many relationships in your Laravel application. Simplify your code, enhance organization, and build with confidence.


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

##### **Note**
By using the **`--fillable`** option with the **`php artisan generate:model`** command, you can efficiently customize your model's fillable attributes and tailor them to your Laravel application's needs.


##### **Create a repository**

To generate a new model along with a repository, you can use the following command:

```bash
php artisan generate:model {name} --table={table_name} [--repository] [--repository-namespace={namespace}]
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

##### **Note**
By using the **`--repository`** and **`--repository-namespace`** options along with the **`php artisan generate:model`** command, you can enhance the maintainability and organization of your Laravel application, especially when dealing with complex data operations.


##### **Specify a Custom Connection**

To generate a new model and associate it with a specific database table while specifying a custom database connection (if needed), you can use the following command:

By default, migrations use the default database connection configured in your Laravel application. However, you can specify a different database connection using the **`--connection`** option. Here's how to use it in combination with other migration options:


```bash
php artisan generate:model {name} --table={table_name} [--connection={connection_name}]
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

##### **Note**
By using the **`--connection`** option with the php artisan generate:model command, you can customize the database connection for your model, especially when working with multiple database connections in your application.


#### **Note**

The php artisan generate:model command empowers you to streamline model creation in your Laravel projects. With options for generating **`repositories`**, **`pivot`** models, specifying **`fillable`** attributes, and **`custom database connections`**, you have the tools to design and organize your application's data layer effectively. Whether you're building a simple application or a sophisticated system, using these model management options will contribute to the maintainability and scalability of your Laravel project.


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


#### Customizing Paths and Namespace
You can customize the repository's base path, path, and namespace using the `--modules`, `--base_path`, `--path`, and `--namespace` options.


#### Forcing Repository Creation
If you want to force the creation of the repository even if it already exists, you can use the `--force` flag.

#### Example
Let's say you want to create a repository named `ProductRepository` associated with the `Product` model, and you want it to be in the `App\\Repositories\\Products` namespace. You can run the following command:

```bash
php artisan generate:repository ProductRepository --model=Product --namespace=App\\Repositories\\Products
```
This will generate the `ProductRepository` class in the specified namespace, associated with the `Product` model.

### Conclusion
The `generate:repository` command simplifies the creation of repository classes in your Laravel project, allowing you to maintain a clean and organized separation of concerns between your application's logic and data access.

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
