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
