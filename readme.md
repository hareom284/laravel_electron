
## Laravel and Electron Setup

## Installation

```bash
  git clone https://github.com/zawzawwin-dev/laravel-electron.git
```

```bash
 cd laravel-electron
```
```bash
  npm install
```
```bash
 cd www
```
```bash
 composer install
```
```bash
 cp .env.example .env
```
```bash
 php artisan migrate
```
```bash
 cd ..
```
```bash
 npm run electron:start
```

<span style="">Congratulation 🎉! You are app is running now!Go to www directory edit start
working on laravel project and that can build electron app</span>

## Build into exe file

```bash
 npm run electron:build
```
<strong style="color:#fc0390">you must have in laravel-electron direcory</strong>

## Tech Stack 

-  [x]  sqlite
-  [x]  electron-builder
-  [x]  laravel 
-  [x]  freshui



