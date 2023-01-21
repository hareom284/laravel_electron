
## Laravel and Electron Setup

## Installation

```bash
  git clone https://github.com/hareom284/laravel-electron.git
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

  <p>
  
  copy your all  folder under php directory and paste it here in php directory this step is configure all your php related dependencies to work and run 
  laravel and you don't need to start xampp
  
  </p>
  
  <b>✨✨You can find php folder under the directory of xampp or lampp✨✨</b>
  
  
  
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



