Follow the following steps for a successful installation of the application
1. composer install
2. npm install
3. run [cp .env.example .env] [to create the env file]
4. create a database in your local server
4. update this section in the .env file to suit your database details:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hp
    DB_USERNAME=root
    DB_PASSWORD=
5. run php artisan key:generate [to generate app key]
6. Run the migrations [php artisan migrate]
7. Run the seeders [AdminRoleSeeder, SuperRoleSeeder]
    [php artisan db:seed AdminRoleSeeder]
    [php artisan db:seed SuperRoleSeeder]
8. Run [php artisan serve] to serve the application in a specific url [http://127.0.0.1:8000/], then your browser, fill the url link
9. Run [npm run dev] to serve your app with frontend assets
10.Once the app has launched, Dropdown at account to register, [this part is where the superadmin will be registered]
11. Go ahead, login and create departments and services and through to hospitals,
12. Best of Luck


