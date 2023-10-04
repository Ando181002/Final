@extends('Personnel.Accueil')
@section('content')
 <!-- Start Featured Product -->
 <section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">

        </div>
        <div class="row">
            @foreach($evenement as $event)
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Card with an image on top -->
                    <div class="card">
                        <div class="card-body">
                        <a href="DetailEvent?id={{$event->idevenement}}&statut={{$statut}}"<h5 class="card-title">{{$event->titre}}</h5></a>
                        <p class="card-text">{{$event->descri}}</p>
                        <p class="card-text">{{$event->Lieu->nomlieu}}</p>
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection