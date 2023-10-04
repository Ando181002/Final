@extends('Utilisateur.Accueil')
@section('content')
 <!-- Start Featured Product -->
 <section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            @php
                if ($statut=="personnel") {
                    $chemin="UListeTournoi";
                }
                else{
                    $chemin="UPronostic";
                }
            @endphp
            <form class="row g-3" method="get" action="{{$chemin}}">
                @csrf
                <div class="col-md-2">
                    <select name="type" class="form-control" >
                        <option value="1">Tous</option>
                        <option value="2">Mes paris</option>
                    </select>
                  </div>
                <div class="col-md-2">
                    <select name="idtypetournoi" class="form-control" >
                            <option value=""></option>
                        @foreach ($typetournoi as $type)
                          <option value="{{$type->idtypetournoi}}">{{$type->nomtypetournoi}}</option>
                          @endforeach
                      </select>
                </div>
                <div class="col-md-2">
                  <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
              </form><!-- End No Labels Form -->
        </div>
        <div class="row">
            <?php for ($i=0; $i <count($tournois) ; $i++) { ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Card with an image on top -->
                        <div class="card">
                            @if($statut=="participant" && $participer[$i]==0)
                                <a href="Pronostiquer/{{$tournois[$i]->idtournoi}}"><img src="data:image/JPEG;base64,{{ $tournois[$i]->imagetournoi }}" class="card-img-top" alt="..."></a>
                            @else
                                <a href="{{$route}}?id={{$tournois[$i]->idtournoi}}"><img src="data:image/JPEG;base64,{{ $tournois[$i]->imagetournoi }}" class="card-img-top" alt="..."></a>
                            @endif
                            <div class="card-body">
                            <h5 class="card-title">{{$tournois[$i]->nomtournoi}}</h5>
                            <p class="card-text">{{$tournois[$i]->description}}</p>
                            </div>
                        </div><!-- End Card with an image on top -->
                        @if($statut=="participant" && $participer[$i]==1)
                            <?php $erreur=" "; ?>
                            <a href="participerPronostic/{{$tournois[$i]->idtournoi}}/{{$erreur}}/" type="button" class="btn btn-primary">Participer</a>
                        @endif
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</section>
@endsection