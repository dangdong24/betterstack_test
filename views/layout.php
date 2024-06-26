<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <title>PHP Test Application</title>

  <link href="favicon.ico" type="image/x-icon" rel="icon" />
  <link href="favicon.ico" type="image/x-icon" rel="shortcut icon" />

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/application.css">

  <script type="text/javascript" charset="utf-8" src="js/jquery.min.js"></script>
  <script type="text/javascript" charset="utf-8" src="js/bootstrap.min.js"></script>

  <style>
    .table tbody tr:nth-child(odd) {
      background-color: #f9f9f9;
    }

    .error {
      color: red;
      margin-top: 10px;
    }

    .btn-fancy {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn-fancy:hover {
      background-color: #218838;
    }
  </style>


</head>

<body>

  <div class="container">

    <?= $content ?>

  </div>

</body>

</html>