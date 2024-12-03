
this project is like stackoverflow
for this project laravel 11.33.2 version is used


first of you need to clone the repository
```bash
   git clone https://github.com/Maqsad04/newlaravel.git
   cd newlaravel
```

after that you need to install some dependencies
```bash
   composer install
   npm install
```
than
```bash
php artisan migrate
```
this is for migration database files
```bash
npm run build
```

to create .env file from env example
```bash
cp .env.example .env
```
```bash
php artisan key:generate
```

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

lastly
```bash
php artisan serve
```
at the end of installing you need to write this command in order to launch the project
