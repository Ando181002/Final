<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
    <!-- Favicons -->
    <link href="assets/img/orange.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  
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
</head>
<body>
@extends('Personnel.Accueil')
@section('content')
    <!-- Hero Section Begin -->
    <section class="hero-section set-bg" data-setbg="assets/img/fond.png">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="hs-item">
                      <div class="container">
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="hs-text">
                                      <h2>{{$evenement->descri}}</h2>
                                      <h4>{{$evenement->dateevent}} à {{$evenement->Lieu->nomlieu}}</h4>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- Hero Section End -->
  <section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
  <!-- Schedule Section Begin -->
 <section class="schedule-section spad">
  <div class="container">
              <div class="schedule-text">
                  <h4 class="st-title">{{$evenement->titre}}</h4>
                  <div class="st-table">
                      <table>
                          <tbody>
                            @foreach($activite as $acte)
                              <tr>
                                <td>{{$acte->Activite->nomactivite}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#resultat{{$acte->idactiviteevent}}">
                                        S'inscrire
                                    </button>
                                    <div class="modal fade" id="resultat{{$acte->idactiviteevent}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Inscription</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row g-3" method="post" action="/{{$acte->idactiviteevent}}/addResultatMatch">
                                                        @csrf
                                                        <div class="col-md-6">
                                                            <label for="inputEmail5" class="form-label">sxdfs</label>
                                                            <input type="equipe1" class="form-control" name="score1">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="inputPassword5" class="form-label">dfgd</label>
                                                            <input type="equipe2" class="form-control" name="score2">
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-primary">Valider</button>
                                                        </div>
                                                    </form><!-- End Multi Columns Form -->
                                                </div><!-- End Vertically centered Modal-->
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                    </div>
              </div>
  </div>
</section>
</div>
</div>
</section>

                      </div>
                    </div><!-- End Bordered Tabs -->
      
                  </div>
                </div>
      
              </div>
            </div>
          </section>
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
  <script src="{{ url('assets/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ url('assets/js/jquery.slicknav.js') }}"></script>
  <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
</body>
</html>