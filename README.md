# LaravelBlog

Version 8 de Laravel pour suivre le tuto version blog de https://www.udemy.com/course/le-guide-de-laravel-8

Pour revoir le début, cliquez sur ce lien : https://github.com/mikhawa/LaravelBlog/tree/V1

Pour revoir le chapitre précédent, cliquez sur ce lien : https://github.com/mikhawa/LaravelBlog/tree/V2

## V3

### Bootstrap

Dans la console :

    php artisan make:controller MainController

Le fichier `app\Http\Controllers\MainController.php` est crée

On crée la méthode qui appelle la vue

    class MainController extends Controller
    {
        public function home()
        {
            return view('home');
        }
    }

Puis on crée la vue `resources\views\home.blade.php`

    @extends('base')

    @section('content')
        homepage
    @endsection

Ensuite dans `routes\web.php` on crée la route

    Route::get('/', [MainController::class, 'home']);

Puis on change `resources\views\base.blade.php` pour y mettre la base de bootstrap

    <!doctype html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"    rel="stylesheet"   integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"   crossorigin="anonymous">

        <title>Hello, world!</title>
      </head>
      <body>
        @include('navbar')

        @yield('content')

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"  crossorigin="anonymous"></script>


      </body>
    </html>

On met ensuite un jumbotron bootstrap dans `resources\views\home.blade.php` : https://getbootstrap.com/docs/5.1/examples/jumbotron/

### bootswatch

On va utiliser un thème de bootstrap pour changer un peu :

https://bootswatch.com/

Et je choisis le thème Morph :

https://bootswatch.com/morph/

On télécharge la feuille de style : https://bootswatch.com/5/morph/bootstrap.min.css

Et on le met dans notre dossier `public` => `public\css\bootstrap.min.css`

On modifie dans `resources\views\base.blade.php` grâce à `{{ asset('css/bootstrap.min.css')}}` qui va chercher le fichier dans `public`

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

par

    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">

On peut ensuite changer la `resources\views\include\navbar.blade.php` avec le code trouvé sur le site

###
