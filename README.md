# LaravelBlog

Version 8 de Laravel pour suivre le tuto version blog de https://www.udemy.com/course/le-guide-de-laravel-8

---

## Navigation

---

### V1

-   création ou clonage d'un nouveau projet
-   chargement des dépendances
-   Extensions pour VSC
-   Lancement du serveur avec Artisan
-   Les routes
-   Les réponses
-   Les vues
-   Les modèles
-   Tinker
-   Les migrations
-   Les contollers

https://github.com/mikhawa/LaravelBlog/tree/V1

---

### V2

-   Début du blog
-   Controller Article
-   Validation de formulaires
-   Requests personnalisés
-   Erreurs personnalisées
-   Middleware

https://github.com/mikhawa/LaravelBlog/tree/V2

---

### V3

-   Bootstrap
-   Bootswatch
-   Fontawesome

https://github.com/mikhawa/LaravelBlog/tree/V3

---

### V4

-   Création du modèle Article
-   Modification et migration
-   Seeder - ajout à la volée dans la table
-   Faker - Créations de données à la volée
-   Récupération de tous les articles de la table
-   Affichage des articles dans la vue
-   Pagination automatique
-   Pagination personnalisée

https://github.com/mikhawa/LaravelBlog/tree/V4

---

## V5

#### Observer

Ouvrir la commande :

    php artisan make:observer ArticleObserver --model=Article

Un fichier est créé `app\Observers\ArticleObserver.php`

Lors de la création d'un article, on souhaîte créer un slug du titre dans notre observer

    public function created(Article $article)
    {
        // On va sluggifié le titre de l'article
        $instance = new Slugify();
        $article->slug = $instance->slugify($article->title);
        $article->save();
    }

Ensuite nous ouvrons `app\Providers\AppServiceProvider.php` pour activer l'observer

    ...
    namespace App\Providers;
    //chargement
    use App\Models\Article;
    use App\Observers\ArticleObserver;
    ...
    public function created(Article $article)
    {
        // On va sluggifié le titre de l'article
        $instance = new Slugify();
        $article->slug = $instance->slugify($article->title);
        $article->save();
    }

Nous pouvons le tester avec tinker:

    php artisan tinker
    $article = new Article();
    $article->title = "My title";
    $article->subtitle = "My subtitle";
    $article->content = "My content";
    $article->save();
    exit;

Puis nous pourvons voir dans notre base de donnée le résultat

On efface les artciles de la DB puis on peut relancer seed

    php artisan db:seed --class=ArticleSeeder

Le DB sera remplie avec des articles dont le slug est créé

#### Helpers

La documentation des multiples helpers:

https://laravel.com/docs/8.x/helpers

On peut récupérer tous les helpers avec composer

    composer require laravel/helpers

puis changer dans `app\Observers\ArticleObserver.php`

    ...
    use App\Models\Article;
    use Illuminate\Support\Str;

    class ArticleObserver
    {
        /**
         * Handle the Article "created" event.
         *
         * @param  \App\Models\Article  $article
         * @return void
         */
        public function created(Article $article)
        {
            // On va sluggifié le titre de l'article avec le helper
            $article->slug = Str::slug($article->title, '-');
            $article->save();
        }
    ...

#### Routes dynamiques

Dans `routes\web.php` on va renommer les chemin et ajouter le {slug} comme paramètre et article au singulier comme nom

    ...
    Route::get('/articles', [MainController::class, 'articles'])->name('articles');
    Route::get('/articles/{slug}', [MainController::class, 'show'])->name('article');
    ...

Dans la vue `resources\views\articles.blade.php` on va changer les liens vers le détail d'un article:

    ...
    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ $article->subtitle }}</p>
                    <a href="{{ route('article',$article->slug) }}" class="btn btn-primary">
                        Lire la suite
                        <i class="fas fa-arrow-right"></i>
                    </a>
    ...

On doit ensuite modifier notre `app\Http\Controllers\MainController.php`

    ...
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        // on vérifie si on récupère bien l'article
        dd($article);
        return view('article', [
            'article' => $article
        ]);
    }
    ...

On devrait récupérer l'article grâce à son slug avec dd() - dump and die

On crée ensuite notre vue `resources\views\article.blade.php`

    @extends('base')

    @section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <h1 class="display-4 text-center">{{ $article->title }} </h1>
        <div class="d-flex justify-content-center my-5">
            <a class="btn btn-primary" href="{{ route('articles') }}">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
        <h4 class="text-center my-2 pt-2">{{ $article->subtitle }}</h5>
    </div>
        <div class="container">
            <p class="text-justify">{{ $article->content }}</p>
        </div>
    @endsection

#### Authentification

On va ouvrir la commande :

    composer require laravel/ui

qui va nous permettre de créer un système d'authentification ( https://laravel.com/docs/7.x/authentication ici celui de laravel 7, mais encore compatible)

    php artisan ui vue --auth

On indique "non" pour ne pas remplacer `home.blade.php`

ça nous a importé de nombreux fichiers:

-   modification de la route
-   modification et création de contrôleurs
-   modification et création de vues et de ressources

commençons par modifier `routes\web.php` en ajoutant cet use:

    ...
    use Illuminate\Support\Facades\Auth;
    ...

et en supprimant cette ligne inutile :

    ...
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    ...

Attention de garder ceci:

    ...
    // routes liées à l'authentification
    Auth::routes();
    ...

Il va permettre le routing de connexion, que l'on peut teste ici:

http://127.0.0.1:8000/login

et

http://127.0.0.1:8000/register

##### Modification des vues d'auth

On ouvre `resources\views\auth\login.blade.php` et `resources\views\auth\register.blade.php` et on change

    @extends('layouts.app')

Par

    @extends('base')

Ceci permettant de garder notre design de base sur les 2 URL précédentes.

##### Inscription et connexion automatique

On peut dés à présent s'inscrire à cette adresse :

http://127.0.0.1:8000/register

L'insertion se fait bien dans la table `user` et on est redirigé vers /home

##### Afficher le status connecté/déconnecté

dans le fichier `resources\views\include\navbar.blade.php`

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}">
        <i class="fas fa-house-user"></i>
          Accueil</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('articles') }}">Articles</a>
          </li>

        </ul>
        <ul class="navbar-nav ml-auto">
            {{-- si la personne est connectée --}}
            @if (Auth::user())
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                       <button type="submit" class="btn">Déconnexion</button>
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <button type="submit" class="btn">Connexion</button>
                    </a>
                </li>
            @endif

          </ul>
      </div>
    </div>
    </nav>

On prépare la vue du système de connexion/déconnexion

On ouvre `app\Http\Controllers\Auth\RegisterController.php` et `app\Http\Controllers\Auth\RegisterController.php` et on modifie `$redirectTo` pour rediriger vers l'accueil après une inscription ou une connexion:

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

##### Pour voir les routes

Dans la console :

    php artisan route:list
