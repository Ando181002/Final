<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Evenement</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Evenement</h5>
              <!-- Default Table -->
              <div>
              <table class="table" style="margin-top: 20px;">
                <thead>
                  <tr>
                    <th scope="col">Titre</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Fin inscription</th>
                    <th scope="col">Lieu</th>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($evenement as $type)
                  <tr>
                    <td><a href="FicheEvenement/{{$type->idevenement}}">{{ $type->titre }}</a></td>
                    <td>{{ $type->descri }}</td>
                    <td>{{ $type->dateevent }}</td>
                    <td>{{ $type->fininscription }}</td>
                    <td>{{ $type->Lieu->nomlieu }}</td>
                    
                    <td>              
                        <!-- Basic Modal -->
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#basicModal{{$type->idevenement}}">
                        <i class="ri-edit-box-fill"></i>
                        </button>
                        <div class="modal fade" id="basicModal{{$type->idevenement}}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier evenement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" method="POST" action="updateEvenement">
                                          @csrf
                                            <input type="hidden" name="idevenement" value="{{$type->idevenement}}">
                                            <div class="col-12">
                                                <label for="inputNanme4" class="form-label">Titre</label>
                                                <input type="text" class="form-control" name="titre" value="{{$type->titre}}">
                                              </div>
                                              <div class="col-12">
                                                  <label for="inputNanme4" class="form-label">Description</label>
                                                  <input type="text" class="form-control" name="descri" value="{{$type->descri}}">
                                              </div>
                                              <div class="col-12">
                                                <label for="inputNanme4" class="form-label">Date</label>
                                                <input type="date" class="form-control" name="dateevent" value="{{$type->dateevent}}">
                                            </div>
                                              <div class="col-12">
                                                  <label for="inputNanme4" class="form-label">Fin inscription</label>
                                                  <input type="datetime-local" class="form-control" name="fininscription" value="{{$type->fininscription}}">
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
                                </div>
                            </div>
                        </div><!-- End Basic Modal--> 
                    <td>                
                                  <!-- Vertically centered Modal -->
              <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycentered{{$type->idevenement}}">
              <i class="ri-delete-bin-5-fill"></i>
                  </a>
              <div class="modal fade" id="verticalycentered{{$type->idevenement}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <form methodd="POST" action="deleteEvenement">
                    <div class="modal-body">
                      <input type="hidden" name="idevenement" value="{{$type->idevenement}}">
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
                <!-- Vertically centered Modal -->
               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                Ajouter
              </button>
              <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Ajouter evenement</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
               <!-- General Form Elements -->
               <form class="row g-3" method="POST" action="addEvenement" >
                @csrf
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Titre</label>
                  <input type="text" class="form-control" name="titre">
                </div>
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Description</label>
                    <input type="text" class="form-control" name="descri">
                </div>
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Date</label>
                    <input type="date" class="form-control" name="dateevent">
                </div>
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Fin inscription</label>
                    <input type="datetime-local" class="form-control" name="fininscription">
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
                  <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
              </form><!-- Vertical Form -->   
              <!-- End General Form Elements -->                   
              </div><!-- End Vertically centered Modal-->
            </div>
            </div>
          </div>
          @endsection
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>