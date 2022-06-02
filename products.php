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
            <h2 class="mt-5">Wyszukaj produkt</h2><br />
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

            <div class="form-row">

                <div class="input-group-prepend">
                    <span class="input-group-addon"></span>
                    <input type="text" name="search_text" id="search_text" placeholder="Szukaj po produkcie lub grupie..." class="form-control" />
                </div>

                <!--a href="offname_add.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nowy realizujący</a -->
                <a href="lists.php" class="btn btn-secondary ml-2">Powrót</a>

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
                url: "products_fetch.php",
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