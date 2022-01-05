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

#### Créer des request personnalisés

dans la console:

    php artisan make:request ArticleRequest

Un fichier est créé `app\Http\Requests\ArticleRequest.php`, et dedans nous allons indiquer les règles et permettre l'autorisation:

    class ArticleRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            // on autorise
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            // on met nos règles
            return [
                'name' => 'required|min:5|max:255',
                'email' => 'required|min:5|max:255|email',
            ];
        }
    }

Et dans `app\Http\Controllers\ArticleController.php`

    ...
    use App\Http\Requests\ArticleRequest;
    ...
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * on importe ArticleRequest
     */
    public function store(ArticleRequest $request)
    {
        $validated = $request->validate();
        // on arrive ici si les paramètres sont valides, sinon on est redirigé sur le formulaire

    }

#### Créer des erreurs personnalisées

Dans `app\Http\Requests\ArticleRequest.php` dans la class ArticleRequest

    /**
     * Get the validation errors messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Le champs name est requis',
            'email.required' => 'Le mail est requis',
            'email.email' => 'Le mail n\'est pas valide',
            'email.min' => 'Le champs doit faire au moins 5 caractères',
        ];
    }

### Le Middleware

C'est la partie qui gère les accès HTTP.

On en trouve déjà par défaut dans le dossier `app\Http\Middleware`

Ils sont appelés dans le kernel : `app\Http\Kernel.php`

Dans `routes\web.php`

    // pour tester un middleware par défaut (guest => non connecté)
    Route::get('/test', function () {
        return response("Hello World", 200);
    })->middleware('guest');

    // pour tester un middleware par défaut (auth.basic => connecté basique)
    Route::get('/test2', function () {
        return response("Hello World", 200);
    })->middleware('auth.basic');

#### Pour créer un middleware personnel

Dans la console:

    php artisan make:middleware AuthMiddleware

`app\Http\Middleware\AuthMiddleware.php` est céé.

On doit le rajouter au Kernel : `app\Http\Kernel.php`

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'custom.auth' => \App\Http\Middleware\AuthMiddleware::class,
    ];

On modifie `app\Http\Middleware\AuthMiddleware.php`

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class AuthMiddleware
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|  \Illuminate\Http\RedirectResponse)  $next
         * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
         */
        public function handle(Request $request, Closure $next)
        {
            // si on a un utilisateur connecté
            $user = Auth::user();
            // sinon
            if (!$user) {
                return redirect("/test");
            }
            return $next($request);
        }
    }

Puis on crée une route dans `routes\web.php` pour vérifier la redirection

    // pour tester un middleware fait main
    Route::get('/test3', function () {
        return response("Hello World", 200);
    })->middleware('custom.auth');
