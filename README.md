
# Admin App

Admin panel application for managing users, permissions and data import




## Setup and configuration for Linux OS local environment

- Clone the following repository to the local machine:

        git clone git@github.com:vladaj81/admin-app.git


- Create the database with SQL command:

        "CREATE DATABASE admin_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

- In cmd, navigate to do project root path:

        For example: cd /project-folder/admin-app

- Create .env file and copy content from .env.example file.

- Set DB_PASSWORD variable value in .env file to the mysql root user password.

-  Install project dependencies with the following command:

        composer install

- Run DB migrations with the following command:

        php artisan migrate

- Seed DB tables with following commands:

        php artisan db:seed --class=PermissionTableSeeder
        php artisan db:seed --class=CreateAdminUserSeeder
        php artisan db:seed --class=UserSeeder   

- In the root folder run the following commands to install node modules and build assets:

        npm install
        npm run dev



## Accessing the application

- After successful setup, in the root folder of the project, run the application with the following command:

        php artisan serve

- Open the app at this url: http://127.0.0.1:8000/

- Log in as admin with the following credentials:

        email: admin@test.com
        password: admin12345

    or a test user with credentials:

        email: user@test.com
        pass: test12345
## Notes

- This is just the starting version of the project. Due to business and private obligations, I managed to implement only user and permission management, file upload and validation, right up to data import itself.

- Permissions for tabs are configured in the adminLTE config file, and permissions for import types are checked on the back-end.
- Import types are pulled dynamically from importtypes.php config file.

- Regarding the import type from the config that has two files, I set that each file is displayed separately on the front-end, since this way it would not be known into which db table which file should be imported.

- Regarding permissions, by default the admin user is assigned the Admin role and all permissions associated with it. (Role management is not implemented)

- Also, the test user is granted all permissions, without any role.

- You can create additional users with certain permissions through the UI and test functionalities.

- All this can be done much better and in more detail for the needs of the real project.