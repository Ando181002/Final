<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
</head>
<body>
@extends('Utilisateur.Accueil')

@section('content')
<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
 <section class="bg-light">
    <div class="container py-5">
        <p>Ato no atao ny contenu</p>
        <h5 class="card-title">Réinitialisation mot de passe</h5>
        <form action="{{ url('reinitialiser') }}" method="POST">
            @csrf
            <div class="row mb-3">
              <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Ancien mot de passe</label>
              <div class="col-md-8 col-lg-9">
                <input type="password" class="form-control" name="ancien">
              </div>
            </div>

            <div class="row mb-3">
              <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
              <div class="col-md-8 col-lg-9">
                <input type="password" class="form-control" name="nouveau">
              </div>
            </div>

            <div class="row mb-3">
              <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmer nouveau mot de passe</label>
              <div class="col-md-8 col-lg-9">
                <input type="password" class="form-control" name="confirmation">
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Valider</button>
            </div>
          </form><!-- End Change Password Form -->
    </div>
</section>
</div>
</div>
</section>
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