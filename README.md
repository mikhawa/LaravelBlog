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

Pour ajouter des articles à la volée
