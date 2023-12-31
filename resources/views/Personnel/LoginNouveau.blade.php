@extends('Personnel.Accueil')
@section('content')
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Orange</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Veuillez vous connectez</h5>
                    <p class="text-center small">Entrez votre email et mot de passe</p>
                  </div>

                  <form class="row g-3 needs-validation" action="{{url('traitementLogin');}}" method="post">
                    @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Veuillez entrer votre email.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="mdp" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Veuillez entrer votre mot de passe!</div>
                    </div>
                    <?php 
                      $error="";
                      if(isset($erreur)){
                        $error=$erreur;
                      }
                    ?>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label" style="color: red;">{{ $error;}}</label>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Se connecter</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
@endsection