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


  </style>


  <div class="container">
    <br />
    <h2 align="center">Baza przetargowa</h2><br />
    <div class="form-row">

      <div class="input-group-prepend">
        
        <span class="input-group-addon"></span>


        <input type="text" name="search_text" id="search_text" placeholder="Szukaj po numerze przetargu, NIP lub dacie złożenia..." class="form-control" />
      </div>

      <a href="tender_create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowy przetarg</a>
      <a href="contractor_ne.php" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Nowy zamawiający</a>

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