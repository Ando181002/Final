@extends('Personnel.Accueil')
@section('content')
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">

        </div>
        <div class="pagetitle">
            <h1>Bonjour</h1>
            <nav>
                <p class="breadcrumb-item">Veuillez remplir le formulaire pour participer aux pronostics.</p>
            </nav>
        </div><!-- End Page Title -->
         <!-- Recent Sales -->
         <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title">{{$tournoi->nomtournoi}}</h5>
                <form class="row g-3" action="{{url('inscriptionProno')}}" method="post">
                  @csrf
                  <input type="hidden" value="{{$tournoi->idtournoi}}" name="idtournoi">
                    <div class="col-md-6">
                        <label for="inputEmail5" class="form-label">Equipe1</label>
                        <select name="idequipe1g" id="" class="form-control">
                          @foreach ($equipes as $equipe)
                            <option value="{{$equipe->idequipe}}">{{$equipe->nomequipe}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="inputPassword5" class="form-label">Equipe2</label>
                        <select name="idequipe2g" id="" class="form-control">
                          @foreach ($equipes as $equipe)
                            <option value="{{$equipe->idequipe}}">{{$equipe->nomequipe}}</option>
                            @endforeach
                        </select>                     
                       </div>
                    <div class="col-12">
                      <label for="inputPassword4" class="form-label"> Quel sera le total des points du vainqueur du concours de pronostics ?</label>
                      <input type="text" class="form-control" name="reponsequestion">
                    </div>
                    <div class="col-12">
                      <label for="inputAddress" class="form-label">Code secret</label>
                      <input type="password" class="form-control" placeholder="Entrez votre code secret" name="codesecret">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                  </form><!-- Vertical Form -->
                
              </div>

            </div>
          </div><!-- End Recent Sales -->
    </div>
  </section>
  @endsection