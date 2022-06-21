<?php

session_start();

//zmienna sesyjna , po kliknięciu w stronę zapamiętuje parametr
if (isset($_SESSION["logid"])) {
   $logid = $_SESSION['logid'];
 } else {
   header("location:login.php");
};


echo "<div style='text-align:right'>"; 
echo "<div style='padding-right:30px';>";
echo $_SESSION['logid'];
?>

 <a href="log_out.php" title="Wyloguj się"  data-toggle="tooltip"><span class="fa fa-sign-out"></span></a>

 </div>

<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Baza przetargowa</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

  <style>
    .input-group-prepend {
      width: 55%; 
      padding-right: 5%;
    }

    .btn {
      margin: 0px 0px 10px 10px;

    }

    .container {
      min-width: 90%;
    }
   
    div.horizontalgap {
  float: left;
  overflow: hidden;
  height: 1px;
  width: 40px;
}

  </style>

  <div class="container">
    <br />
    <h2 align="center">Baza przetargowa</h2><br />
    <div class="form-row">

      <div class="input-group-prepend">
        
        <span class="input-group-addon"></span>


        <input type="text" name="search_text" id="search_text" placeholder="Szukaj po numerze przetargu, nazwie zamawiającego lub dacie złożenia..." class="form-control" />
      </div>

      <a href="tender_create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowy przetarg</a>
      <div class="horizontalgap" style="width:2%"></div>

      <a href="lists.php" class="btn btn-primary pull-right"><i class="fa fa-list"></i> Listy rozwijane</a>
      <div class="horizontalgap" style="width:2%"></div>

      <a href="excel.php" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Export do pliku</a>


    </div>
    <br />
    <div id="result"></div>
  </div>
</body>

</html>


<script>
  $(document).ready(function() {

    load_data();


    function load_data(query) {
      $.ajax({
        url: "fetch.php",
        method: "POST",
        data: {
          query: query
        },
        success: function(data) {
          $('#result').html(data);
        }
      });
    }
    $('#search_text').keyup(function() {
      var search = $(this).val();
      if (search != '') {
        load_data(search);
      } else {
        load_data();
      }
    });
  });
  
</script>

