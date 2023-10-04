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
@extends('Admin.AccueilAdmin')

@section('contenu')  
    <section class="section profile">
        <div class="row"> 
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-bordered"> 
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Détails</button>
                            </li> 
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier</button>
                            </li> 
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Activités</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#participant">Participants</button>
                              </li>              
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Classements</button>
                            </li>  
                        </ul>
                        <div class="tab-content pt-2">  
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">A propos</h5>
                                <p class="small fst-italic">{{$ficheevent->descri}}</p>  
                                <h5 class="card-title">Details de l'évènement</h5>  
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Titre</div>
                                    <div class="col-lg-9 col-md-8">{{$ficheevent->titre}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Fin inscription</div>
                                    <div class="col-lg-9 col-md-8">{{$ficheevent->fininscription}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Lieu</div>
                                    <div class="col-lg-9 col-md-8">{{$ficheevent->Lieu->nomlieu}}</div>
                                </div>            
                            </div>
  
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form class="row g-3">
                                    <div class="col-12">
                                        <label for="inputEmail4" class="form-label">Titre</label>
                                        <input type="text" class="form-control" name="titre" id="titre" value="{{$ficheevent->titre}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputPassword4" class="form-label">Fin inscription</label>
                                        <input type="datetime-local" class="form-control" name="fininscription" value="{{$ficheevent->fininscription}}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Description</label>
                                        <input name="descri" class="form-control" style="height: 100px" value="{{$ficheevent->descri}}">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Lieu</label>
                                        <select name="idlieu" class="form-control" >
                                          @foreach ($lieu as $typee)
                                            <option value="{{$typee->idlieu}}">{{$typee->nomlieu}}</option>
                                            @endforeach
                                        </select>               
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                    </div>
                                </form><!-- Vertical Form -->
                            </div>
                            <div class="tab-pane fade pt-3" id="profile-settings">  
                                <table class="table" style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Activite</th>
                                            <th scope="col">Nombre de joueur</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activiteevent as $activite)
                                        <tr>
                                            <td>{{$activite->Activite->TypeActivite->nomtypeactivite}}</td>
                                            <td>{{$activite->Activite->nomactivite}}</td>
                                            <td>{{$activite->nbjoueurparactivite}}</td>
                                            <td>              
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal{{$activite->idactiviteevent}}">
                                                    <i class="ri-edit-box-fill"></i>
                                                </button>
                                                <div class="modal fade" id="basicModal{{$activite->idactiviteevent}}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modifier activite</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="row g-3" method="post" action="/{{$ficheevent->idevenement}}/updateActiviteEvent">
                                                                    @csrf
                                                                    <input type="hidden" name="idactiviteevent" value="{{$activite->idactiviteevent}}">
                                                                    <div class="col-12">
                                                                        <label for="inputNanme4" class="form-label">Type activite</label>
                                                                        <select name="idtypeactivite" class="form-control" >
                                                                          @foreach ($typeactivite as $typeact)
                                                                            <option value="{{$typeact->idtypeactivite}}">{{$typeact->nomtypeactivite}}</option>
                                                                            @endforeach
                                                                        </select>               
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="inputNanme4" class="form-label">Activite</label>
                                                                        <select name="idactivite" class="form-control" >
                                                                          @foreach ($activitee as $acte)
                                                                            <option value="{{$acte->idactivite}}">{{$acte->nomactivite}}</option>
                                                                            @endforeach
                                                                        </select>               
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="inputPassword4" class="form-label">Nombre de joueur</label>
                                                                        <input type="text" class="form-control" name="nbjoueurparactivite" value="{{$activite->nbjoueurparactivite}}" required>
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                                                    </div>
                                                                </form><!-- End Multi Columns Form -->                         
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- End Basic Modal--> 
                                            </td>
                                            <td>                
                                                <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered{{$activite->idactiviteevent}}">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </a>
                                                <div class="modal fade" id="verticalycentered{{$activite->idactiviteevent}}" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form methodd="get" action="#">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="idequipe" value="">
                                                                    Etes-vous sûre de vouloir supprimer cette ligne?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-primary">Supprimer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div><!-- End Vertically centered Modal-->
                                            </td> 
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                                    Ajouter
                                </button>
                                <div class="modal fade" id="verticalycentered" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ajouter activite</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="row g-3" method="post" action="/{{$ficheevent->idevenement}}/addActiviteEvent">
                                                    @csrf
                                                    <div class="col-12">
                                                        <label for="inputNanme4" class="form-label">Type activite</label>
                                                        <select name="idtypeactivite" class="form-control" >
                                                          @foreach ($typeactivite as $typeact)
                                                            <option value="{{$typeact->idtypeactivite}}">{{$typeact->nomtypeactivite}}</option>
                                                            @endforeach
                                                        </select>               
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="inputNanme4" class="form-label">Activite</label>
                                                        <select name="idactivite" class="form-control" >
                                                          @foreach ($activitee as $acte)
                                                            <option value="{{$acte->idactivite}}">{{$acte->nomactivite}}</option>
                                                            @endforeach
                                                        </select>               
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="inputPassword4" class="form-label">Nombre de joueur</label>
                                                        <input type="text" class="form-control" name="nbjoueurparactivite" value="" required>
                                                    </div>
                                                    <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                                    </div>
                                                </form><!-- End Multi Columns Form -->
                                            </div><!-- End Vertically centered Modal-->
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Bordered Tabs -->
                            <div class="tab-pane fade pt-3" id="participant">
                                <nav>
                                    <p class="breadcrumb-item">Actuellement <span class="card-title">100 paticipants</span></p>
                                </nav>
                                <nav>
                                    <p class="breadcrumb-item">Cagnote <span class="card-title">500000 Ar</span></p>
                                </nav>
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">Trigramme</th>
                                        <th scope="col">Nom</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">ANY</th>
                                        <td>Ando</td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>              
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <form class="row g-3" method="get" action="#">
                                    <div class="col-md-2">    
                                    <select name="idtypedepense" class="form-select">
                                        <option value="">Globale</option>
                                        <option value="">Eliminatoire</option>
                                        <option value="">Qualification</option>
                                    </select>
                                    </div>
                                    <div class="col-md-2">
                                      <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                  </form><!-- End No Labels Form -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Rang</th>
                                            <th scope="col">Trigramme</th>
                                            <th scope="col">Points</th>
                                            <th scope="col">Lot</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>ANY</td>
                                            <td>950</td>
                                            <td>100000Ar</td>
                                        </tr>
                                    </tbody>
                                </table>          
                            </div>
                        </div>
                    </div>
                </div>  
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