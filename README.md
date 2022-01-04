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

Puis on modifie dedans le create()

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

On va créer un formulaire pour la vue `resources\views\create.blade.php`

    @extends('base')

    @section('content')
    <form action="" method="get" class="form-example">
        <div class="form-example">
          <label for="name">Enter your name: </label>
          <input type="text" name="name" id="name" required>
        </div>
        <div class="form-example">
          <label for="email">Enter your email: </label>
          <input type="email" name="email" id="email" required>
        </div>
        <div class="form-example">
          <input type="submit" value="Subscribe!">
        </div>
      </form>
    @endsection

On peut le voir fonctionner http://127.0.0.1:8000/articles/create

ICI modification du formulaire
