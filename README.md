# Project Dashboard with Laravel

## Features
- Authentication 
- Authorization 
- can track before and after state of a project with Laravel Events
- can invite other users

## Installation and Setup

install required dependencies
```bash
composer install
```
```bash
npm install
```
copy `.env.example` file to `.env` :
```
cp .env.example .env
```
And migrate
```
php artisan migrate
```
To populate data :
```
php artisan db:seed
```
To compile and hot reload, run:
```bash
npm run dev
```
Start your development server
```
php artisan serve
```


