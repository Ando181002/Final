<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ url('assets/img/orange.png') }}" rel="icon">
  <link href="{{ url('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ url('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ url('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ url('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ url('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
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
                @if($erreur!=" ")
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                  {{$erreur}}
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
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
   <!-- Vendor JS Files -->
   <script src="{{ url('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
   <script src="{{ url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ url('assets/vendor/chart.js/chart.min.js') }}"></script>
   <script src="{{ url('assets/vendor/echarts/echarts.min.js') }}"></script>
   <script src="{{ url('assets/vendor/quill/quill.min.js') }}"></script>
   <script src="{{ url('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
   <script src="{{ url('assets/vendor/tinymce/tinymce.min.js') }}"></script>
   <script src="{{ url('assets/vendor/php-email-form/validate.js') }}"></script>
 
   <!-- Template Main JS File -->
   <script src="{{ url('assets/js/main.js') }}"></script>
 
 </body>
 
 </html>