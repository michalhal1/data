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
            width: 50%;
            padding-right: 5%;
        }

        .btn {
            margin: 0px 0px 12px 10px;

        }

        .wrapper {
            width: 90%;
            margin: 0 auto;
            padding-top: 0px;
            padding-left: 50px;
        }

      


    
    </style>

    <div class="wrapper">
        <div class="container-fluid">



            <br />
          
                <!--a href="offname_add.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowy realizujący</a -->
                <a href="lists.php" class="btn btn-secondary ml-2">Powrót</a>

            
            <br />
            <div id="result">
        
</body>

</html>


<style>
        .wrapper {
            width: auto;
            white-space: nowrap;


        }

        table tr td:last-child {
            width: 10%;
            padding: 0px;
            white-space: nowrap;
        }

        .table-responsive {
             table-layout: fixed;
             width: 100%;


         }

        


table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
    writing-mode: vertical-lr;
    text-orientation: mixed;
    text-align: right;
}


td, th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;

 
}

.table th {
vertical-align: middle;
    
}

tr:nth-child(even) {
  background-color: #dddddd;
 
}
    </style>





    
</head>

<body>

    <!-- <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left"></h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowy przetarg</a>
                     -->


    <?php
    //fetch.php
    require_once "config.php";
    $output = '';

   
        $query = "SELECT * from errors_view order by 2";
    
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
    <th>Numer przetargu</span></th>
  
    <th>Numer zadania </th>
    <th>Osoba odpowiedzialna</th>
    <th>BŁĘDNE STATUSY ZADANIA LUB WYNIK</th>
    <th>DATA OGŁOSZENIA PO DACIE ZGŁOSZENIA</th>
    <th>ZADANIE BEZ OFERT</th>
    <th>ZADANIA W TOKU Z DATĄ ZŁOŻENIA</th>
    <th>ZADANIA W TOKU Z DATĄ ROZSTRZYGNIĘCIA</th>
    <th>BRAK DATY ROZSTRZYGNIĘCIA</th>
    <th>BRAK SZANSY SAP LUB DATY STARTU KONTR.</th>
    <th>BRAK ZWYCIĘZCY</th>
    <th>BRAK OFERT LUB >2 OFERTY Z GI</th>
    <th>BRAK LICZBY JEDNOSTEK</th>
    <th>PODWÓJNY PRZETARG</th>
    
    </tr>
 ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
   <tr>
    <td class="a" nowrap>' . $row["tend_number"] . '</td>
    <td nowrap><em>' . $row["jb_number"] . '</em></td>
    <td nowrap>' . $row["tend_creation_worker"] . '</td>
    
    <td nowrap>' . $row["błąd_statusów"] . '</td>
    <td nowrap>' . $row["bład_data_złożenia_data_ogłoszenia"] . '</td>
    <td nowrap>' . $row["brak_ofert_zadanie_puste"] . '</td>
    <td nowrap>' . $row["data_złożenia_minęła_zadanie_w_toku"] . '</td>
    <td nowrap>' . $row["data_rozstrz_zad_w_toku"] . '</td>
    <td nowrap>' . $row["brak_daty_rozsztrz_zad_zl"] . '</td>
    <td nowrap>' . $row["brak_szansySAP_lub_startu_kontraktu"] . '</td>
    <td nowrap>' . $row["brak_zwycięzcy"] . '</td>
    <td nowrap>' . $row["liczba_ofert_GI_inna_niz_1"] . '</td>
    <td nowrap>' . $row["stawka_brak_jednostek"] . '</td>
    <td nowrap>' . $row["podwojony_przetarg"] . '</td>


    <td width=100>
   
     </td>
     
</td>
   </tr>
  ';
        }
        echo $output;
    } else {
        echo 'Nie ma błędów.';
    }

    ?>


    
    
    
    
</body>

</html>