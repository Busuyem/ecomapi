PROJECT DOCUMENTATION

A) Get the project running with the following steps
    i) composer install/update
    ii) cp .env.example .env
    iii) php artisan key:gen
    iv) create db and supply the credentials in .env
    v) php artisan migrate
    vi) php artisan serve

B) Product CRUD
i) GET all products endpoint
    https://127.0.0.8000/api/products
ii) POST product endpoint
    https://127.0.0.8000/api/products
iii) GET show product endpoint
    https://127.0.0.8000/api/products/{id}
iv) PUT update product endpoint
    https://127.0.0.8000/api/products/{id}
v) DELETE product endpoint
    https://127.0.0.8000/api/products/{id}

C) Category CRUD
i) GET all categories endpoint
    https://127.0.0.8000/api/category
ii) POST category endpoint
     https://127.0.0.8000/api/category
iii) GET show category endpoint
    https://127.0.0.8000/api/category/{id}
iv) PUT update category endpoint
     https://127.0.0.8000/api/category/{id}
v) DELETE category endpoint
     https://127.0.0.8000/api/category/id

D) Cart CRUD
i) GET all carts endpoint
    https://127.0.0.8000/api/cart
ii) POST cart endpoint
    https://127.0.0.8000/api/cart
iii) GET show cart endpoint
    https://127.0.0.8000/api/cart/{id}
iv) PUT update cart endpoint
     https://127.0.0.8000/api/cart/{id}
v) DELETE cart endpoint
     https://127.0.0.8000/api/cart/{id}


