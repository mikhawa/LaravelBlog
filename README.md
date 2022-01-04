# LaravelBlog

Version 8 de Laravel pour suivre le tuto version blog de https://www.udemy.com/course/le-guide-de-laravel-8

Pour revoir le début, cliquez sur ce lien : https://github.com/mikhawa/LaravelBlog/tree/V1

## V2

### Le Contrôleur Article

Dans `routes\web.php` nous n'avons plus que

    use App\Http\Controllers\ArticleController;
    use Illuminate\Support\Facades\Route;

    // contrôleur ressource
    Route::resource('articles', ArticleController::class);

Qui appelle `app\Http\Controllers\ArticleController.php`
