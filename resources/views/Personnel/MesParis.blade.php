@extends('Personnel.Accueil')
@section('content')
 <!-- Start Featured Product -->
 <section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">

        </div>
        <div class="row">
            @foreach($tournois as $tournoi)
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Card with an image on top -->
                    <div class="card">
                        <a href="Pronostic/{{$tournoi->idtournoi}}/{{$tournoi->idparticipant}}/{{$statut}}"><img src="data:image/JPEG;base64,{{ $tournoi->imagetournoi }}" class="card-img-top" alt="..."></a>
                        <div class="card-body">
                        <h5 class="card-title">{{$tournoi->nomtournoi}}</h5>
                        <p class="card-text">{{$tournoi->description}}</p>
                        
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>
            </div>
            @endforeach
        </div>
        @if($statut=="personnel")
        <a href="LoginParticipant" type="button" class="btn btn-primary">Se connecter</a>
        <a href="LoginNouveau" type="button" class="btn btn-primary">S'inscrire</a>
        @endif
    </div>
</section>
@endsection