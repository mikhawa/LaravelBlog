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

On va installer le token dans le formulaire de `resources\views\create.blade.php`

    ...
    <form action="/articles" method="POST" class="form-example">
    <!-- blade pour passer le token de sécurité @crsf -->
    @csrf
    <div class="form-example">
    ...

Puis on va agir dans `app\Http\Controllers\ArticleController.php` lors de l'envoie du POST avec la commande `dd()`, littéralement dump and die

    public function store(Request $request)
    {
        // dd => dump and die
        dd($request);
    }

Si on ne veut récupérer que les variables POST

    public function store(Request $request)
    {
        // dd => dump and die
        dd($request->all());
    }

Si on ne veut récupérer qu'un champs

    public function store(Request $request)
    {
        // dd => dump and die
        dd($request->input('email'));
    }

Si on ne veut vérifier l'existance d'un champs

    public function store(Request $request)
    {
        if($request->missing('name')){
            die('NOT OK');
        }
        die('OK');
    }

### Système de validation

Pour vérifier que nos champs correspondent à ce que l'on souhaite dans `app\Http\Controllers\ArticleController.php`

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => 'required|min:5|max:255|email',
        ]);
        // on arrive ici si les paramètres sont valides, sinon on est redirigé sur le formulaire

    }

En cas d'erreur, pour les afficher on met dans `resources\views\create.blade.php` avec une création d'une boucle tant que l'on a des erreurs

    @section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

Pour obtenir une erreur spécifique par champs (une seule affichée):

    <form action="/articles" method="POST" class="form-example">
    <!-- blade pour passer le token de sécurité @crsf -->
    @csrf
    <div class="form-example">
      <label for="name">Enter your name: </label>
      <input type="text" name="name" id="name" required>
      @error('name')
      {{ $message }}
      @enderror
    </div>
    <div class="form-example">
      <label for="email">Enter your email: </label>
      <input type="text" name="email" id="email" required>
      @error('email')
      {{ $message }}
      @enderror
    </div>
