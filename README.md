# LaravelBlog

Version 8 de Laravel pour suivre le tuto version blog de https://www.udemy.com/course/le-guide-de-laravel-8

## Pour créer un nouveau projet

dans la console (le dernier paramètre est le dossier créé pour le projet)

    composer create-project --prefer-dist laravel/laravel LaravelBlog

### Cloner le projet

dans la console

    clone https://github.com/mikhawa/LaravelBlog.git

puis installer les dépendances depuis la console

    ..\LaravelBlog\composer install

### Ouvrir le projet dans Virtual Studio Code

dans la console:

    ..\LaravelBlog\ code .

Quelques extensions pour VSC :

-   Laravel Blade Snippets
-   PHP Namespace Resolver

### Installation de cocur/slugify

Pour les slugs, dans la console

    composer require cocur/slugify

Pour supprimer une dépendance

    composer remove cocur/slugify

Pour mettre à jour les dépendances

    composer update

### Artisan

Pour utiliser les commandes en mode console:

    php artisan

### Lancement du serveur

    php artisan serve

### Paramètres de connexion

dans .env

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=laravelblog
    DB_USERNAME=root
    DB_PASSWORD=

puis dans `routes/web.php`

    Route::get('/env',function(){
        dd(env('DB_DATABASE'));
    });

Ce qui nous affiche lorsque l'on clique sur http://127.0.0.1:8000/env

"laravelblog"

-   Le `function(){}` est une fonction de `closure`

Pour être certain que la configuration du .env soit mis à jour, vous pouvez utiliser la commande:

    php artisan config:clear

### Les routes

Pour envoyer un simple texte (ou number)

dans `routes/web.php`

    Route::get('/hello',function(){
        return "Hello World";
    });

Pour une redirection

dans `routes/web.php`

    Route::redirect('/redirect','/hello');

Pour permettre toutes les requêtes http:

dans `routes/web.php`

    Route::any('/tous',function(){
        return "Est accepté pour toutes les méthodes
                get, post, put, delete, etc...";
    });

Pour récupérer une variable de l'URL:

dans `routes/web.php`

    Route::get('/art/{id}',function($id){
        return $id;
    });

Pour récupérer des variables de l'URL mais permettre une optionelle `{var?}` et la variable a une valeur par défaut dans le closure :

dans `routes/web.php`

    Route::get('/art/{id}/comment/{author?}',function($id, $author = 'Anonyme'){
        return "$author a écrit un commentaire sur l'article numéro : $id";
    });

Pour créer un préfixe de route, on utilise `prefix` et `group`, et on met ensuite nos routes dedans :

dans `routes/web.php`

    Route::prefix('administration')->group(function(){
        Route::get('user',function(){
            return "Gestion des utilisateurs";
        });
        Route::get('articles',function(){
            return "Gestion des articles";
        });
        Route::get('comment',function(){
            return "Gestion des commentaires";
        });
    });

### Les réponses

Pour envoyer directement une `response` depuis la route :

dans `routes/web.php`

    ...
    Route::get('/hello',function(){
        return response("Hello World",202);
    });
    ...

Pour envoyer du json:

dans `routes/web.php`

    Route::get('/json',function(){
        return response()->json([
            'name'=>"Michaël",
            'age'=>44,
        ]);
    });

### Les vues

Ou "views" qu'on trouve dans le dossier `resources/views`

On va utiliser Blade comme moteur de template. Il suffira d'écrire le nom du fichier suivi de `.blade.php`

On crée un fichier vierge dans `resources/views` que l'on nomme `testview.blade.php`, on y ajoute une ligne de texte comme

    Affichage de testview

Puis dans `routes/web.php`

    Route::get('/testview', function () {
        return view('testview');
    });

On peut l'afficher en allant à cette URL : http://127.0.0.1:8000/testview

#### Pour mettre les vues dans des sous-dossier :

On crée un dossier `folder` dans `resources/views` puis on crée `testview2.blade.php` dedans, on y ajoute une ligne de texte comme

    Vue dans un dossier (folder)

Puis dans `routes/web.php`, on va utiliser le . dans le retour de view() pour indiquer qu'on est dans un dossier

    Route::get('/testviewinfolder', function () {
        return view('folder.testview2');
    });

On peut l'afficher en allant à cette URL : http://127.0.0.1:8000/testviewinfolder

#### Pour passer une variabler à la vue

dans `routes/web.php`

    Route::get('/testviews/{id}', function ($id) {
        return view('testviews',[
            'id' => $id
        ]);
    });

Puis on crée `testviews.blade.php` contenant

    {{ $id }}

On peut l'afficher en allant à cette URL : http://127.0.0.1:8000/testviews/8

#### Pour importer un fichier dans un fichier blade

On crée un fichier `navbar.blade.php` à la racine de view contenant

    <ul>
        <li>Lien 1</li>
        <li>Lien 2</li>
        <li>Lien 3</li>
    </ul>

on modifie le fichier `testview.blade.php` et on inclu la navbar avec `@include('navbar')` contenant

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>testview</title>
    </head>
    <body>
        <h1>tesview</h1>
        <nav>@include('navbar')</nav>
    </body>
    </html>

#### Héritage des vues

On crée `base.blade.php` dans view avec l'include, mais également le champs `@yield('content')` que l'on pourra surcharger:

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Base</title>
    </head>
    <body>
        @include('navbar')
        @yield('content')
    </body>
    </html>

Puis dans `testview.blade.php` on va étendre `@extends('base')` base.blade.php puis remplir le `@yield('content')` on utilisant les commandes `@section('content')` et `@endsection` ou `@stop` contenant

    @extends('base')

    @section('content')
        <p>Du texte</p>
    @endsection

On peut l'afficher en allant à cette URL : http://127.0.0.1:8000/testview

#### Faire du PHP dans Blade

On peut directement faire du php dans blade en utilisant `@php` et `@endphp` !

    @extends('base')

    @section('content')
        <p>Du texte</p>
        <p>@php
            for($i=1;$i<=5;$i++){
                echo "$i ";
            }
        @endphp</p>
    @endsection

### Les modèles

Ils se trouvent dans `app/Models`.

Il y a un modèle par défaut: `User.php`

    <?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use HasFactory, Notifiable;

        /**
         * The attributes that are mass assignable.
         * Champs dans la DB
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'email',
            'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         * Champs cachés
         *
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * The attributes that should be cast to native types.
         * Champs typés
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
    }

#### Pour créer un modèle

On va taper dans la console :

    php artisan make:model Cat

Le modèle est généré dans `app/Models` et se nomme `Cat.php`

    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Cat extends Model
    {
        use HasFactory;
    }

### tinker

Va permettre de tester notre application via artisan

    php artisan tinker

    $cat = new Cat();
    $cat->name = "lulu";
    $cat->age = 5;
    $cat;
    $cat->save();

On obtiendra une erreur car nous n'avons pas de migrations

    exit;

### Les migrations

Dans `database/migrations` il y a déjà des fichiers de migrations liés à `users`.

Pour migrer:

    php artisan migrate

Pour créer un fichier de migration pour la table `cats`

    php artisan make:migration create_cats_table

Et dans le fichier créé `2022_01_04_121842_create_cats_table.php`:

    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

On va rajouter les champs voulus:

    public function up()
    {
        Schema::create('cats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->timestamps();
        });
    }

Ensuite on va migrer ce fichier:

    php artisan migrate

! La table est le nom du modèle mis au pluriel !

Puis on va réutiliser `Tinker`:

    php artisan tinker

    $cat = new Cat();
    $cat->name = "lulu";
    $cat->age = 5;
    $cat;
    $cat->save();

Pour créer le modèle Dog et sa migration plus rapidement en une action:

    php artisan make:model Dog -m

puis

    php artisan migrate

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Cubet Techno Labs](https://cubettech.com)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[Many](https://www.many.co.uk)**
-   **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
-   **[DevSquad](https://devsquad.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
