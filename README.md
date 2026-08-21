# Tudoo
**Laravel Task Management App**: A simple task management application built with Laravel.

## Features
### Projects
- Create projects
- Edit project names
- Delete projects and their associated tasks

### Tasks
- Create tasks under a selected project
- Set task priority: low, medium, high
- Edit task names and priorities
- Delete tasks
- Drag and drop tasks to reorder them
- Persist task ordering
- Tasks are displayed based on the selected project

## Tech Stack
- **PHP 8.3**
- **Laravel 13**
- **MySQL**
- **Tailwind CSS**
- **SortableJS**

## Requirements
Before running the application, make sure you have:
- PHP 8.3+
- Composer
- Node.js and npm
- MySQL

## Installation
Clone the repository:
```bash
git clone <repo-url>
cd <project-directory>
```

Install PHP dependencies:
```bash
composer install
```

Create the environment file:
```bash
cp .env.example .env
```

Configure the database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tudoo
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Generate the application key:
```bash
php artisan key:generate
```

Install frontend dependencies:
```bash
npm install
```

Run the migrations:
```bash
php artisan migrate
```

Build the frontend assets:
```bash
npm run build
```

Start the application:
```bash
php artisan serve
```

## Screenshots
### Task
![Empty index page](screenshots/task-index1.png)
![Work: Index page](screenshots/task-index2.png)
![Trip: Index page](screenshots/task-index3.png)

### Project
![Projects page](screenshots/project-index.png)


## Implementation Notes

- Tasks belong to projects through an Eloquent relationship
- Deleting a project cascades to its associated tasks
- Task ordering is persisted using `position` field and updated through `reorder()` method