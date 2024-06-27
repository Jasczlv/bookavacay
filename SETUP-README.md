## First steps to run this properly

npm i  
composer i  
cp .env.example .env //remember to go to .env file after this, to insert your data to connect to your database!
php artisan key:generate

## Model if needed

php artisan make:model Name //PascalCase and singular so if table name is Movies seeder name must be Movie for best practice

## Remember

to access data from your Model inside the controller you need to get it by using for example //$movies = Movie::all(); or something else using queries like the following: //$movies = where("column_name", "==" , "something")->get();
