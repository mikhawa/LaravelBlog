# LaravelBlog

Version 8 de Laravel pour suivre le tuto version blog de https://www.udemy.com/course/le-guide-de-laravel-8

Pour revoir le début, cliquez sur ce lien : https://github.com/mikhawa/LaravelBlog/tree/V1

Pour revoir le chapitre précédent, cliquez sur ce lien : https://github.com/mikhawa/LaravelBlog/tree/V3

## V4

### Création du modèle Article

Dans la console on ajoute le -m pour avoir la migration incluse :

    php artisan make:model Article -m

Sont créés `app\Models\Article.php` et `database\migrations\2022_01_05_145503_create_articles_table.php`

Dans la migration on va ajouter les champs souhaités

    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('slug')->nullable();
            $table->text('content');
            $table->timestamps();
        });
    }

Dans la console :

    php artisan migrate

#### Seeder

Pour ajouter des articles à la volée dans la console :

    php artisan make:seed ArticleSeeder

`database\seeders\ArticleSeeder.php` est généré.

Ensuite regardons la doc sur Faker : https://github.com/fzaninotto/Faker

Puis dans `database\seeders\ArticleSeeder.php`

    namespace Database\Seeders;

    use App\Models\Article;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

    class ArticleSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            // utilisation de faker https://github.com/fzaninotto/Faker
            $faker = Factory::create();

            for ($i = 0; $i < 26; $i++) {

                Article::create([
                    'title' => $faker->sentence(),
                    'subtitle' => $faker->sentence(),
                    'content' => $faker->text(600),
                ]);
            }
        }
    }

Ensuite on va exécuter dans le cmd :

    php artisan db:seed --class=ArticleSeeder

Et 26 articles sont bien insérés

#### Récupération des articles en base de données

Dans `routes\web.php` on va créer une route pour nos articles

    ...
    Route::get('/articles', [MainController::class, 'articles']);

Dans `app\Http\Controllers\MainController.php` on va créer notre méthode publique

    public function articles()
    {
        // récupération de tous les articles
        $articles = Article::all();
        dd($articles);
        return view('articles');
    }

Ensuite modification :

    public function articles()
    {
        // récupération de tous les articles
        $articles = Article::all();
        return view('articles',[
            'articles' => $articles
        ]);
    }

Puis dans la vue `resources\views\articles.blade.php`

    @extends('base')

    @section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <h1 class="display-2 text-center">Nos articles</h1>
        <div class="articles row justify-content-center">
            @foreach($articles as $article)
                <div class="col-md-6">
                    <div class="card my-3">
                        <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ $article->subtitle }}</p>
                        <a href="#" class="btn btn-primary">
                            Lire la suite
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @endsection
