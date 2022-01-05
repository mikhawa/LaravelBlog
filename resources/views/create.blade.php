@extends('base')

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
<form action="/articles" method="POST" class="form-example">
    <!-- blade pour passer le token de sécurité @crsf -->
    @csrf
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