<?php
/**
 * Gerardor de Certificados.
 *
 * @author Tiago Ribas <tgoribas@gmail.com>
 */

require 'php/Config.php';
require 'php/Certificate.php';

$config = new Config();
$certificate = new Certificate();
$certificate->getCertificate($config->getFileCSV());

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Great+Vibes&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/style.css" >
    <style>
    .Loading:after { animation: load <?php  echo $certificate->getTotalRow() * 4 ?>s infinite; }
    </style>
</head>

<body>

    <?php
    if (isset($_GET['certificate']) and $_GET['certificate'] == 'start') {
        echo '
        <div id="preloader">
        <div class="col-md-12 m-auto text-dark text-center" style="height: 100%;display: flex;flex-direction: column;justify-content: center;align-items: center;;padding: 0 10%;">
            <div class="Loading"></div>
        </div>
        </div>';

        // Cria uma nova pasta para ser amazenados os certificados
        $newFolder = date("Ymd") . md5(uniqid());
        mkdir(__DIR__ . '/certificate/' . $newFolder, 0777, true);

        foreach ($certificate->dados as $row => $dado) {
            $artigo = ($dado['gender'] == 'm') ? 'o' : 'a';
            echo '
            <div id="content_test_' . $row . '">
                <div id="html-content-holder" class="background-certificate" style="/*clip-path: inset(0 100% 0 0);*/margin:0;">
                    <div class="container-fluid">
                        <div class="text-center">
                            <p class="text-certificate pt-certificate">Certificamos que, <span class="span-mark color-mark">' . $dado['name'] . '</span> portador' . $artigo . ' do RG:' . $dado['doc'] . ',<br>e nascid' . $artigo . ' em ' . $dado['date'] . ' concluiu nesta Instituição de Ensino, o curso de:</p>
                            <p class="text-curso color-mark">' . $dado['course'] . '</p>
                            <p class="text-certificate text-details">Carga horária total de ' . $dado['workload'] . ' horas e realizado de ' . $dado['startMonth'] . ' de ' . $dado['startYear'] . ' á ' . $dado['endMonth'] . ' de ' . $dado['endYear'] . '</p>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } elseif (isset($_GET['certificate']) and $_GET['certificate'] == 'end') {
        $certificate->delImage();
        echo '
        <div class="container-fluider vh-100 bg-success h-100 pt-5 pb-5">
            <div class="col-md-12 m-auto text-dark text-center" style="height: 100%;display: flex;flex-direction: column;justify-content: center;align-items: center;">
                <a href="' . $config->URL . '" class="btn btn-larger btn-success fs-3 px-5 py-2">Certificados Gerados</a>
            </div>
        </div>
        ';
    } else {
        echo '
    <div class="container-fluider vh-100 bg-dark h-100 pt-5 pb-5">
        <div class="container">
            <div class="col-md-12 m-auto text-white text-center">
                <h1 class="mb-5">Gerar Certificados</h1>

                <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Doc.</th>
                        <th scope="col">Data Nasc.</th>
                        <th scope="col">Gênero</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Carga H.</th>
                        <th scope="col">Periodo</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($certificate->dados as $row => $dado) {
                    echo '
                    <tr>
                        <td class="text-start">' . $dado['name'] .'</td>
                        <td class="text-start">' . $dado['doc'] .'</td>
                        <td class="text-start">' . $dado['date'] .'</td>
                        <td class="text-start">' . (($dado['gender']=='m') ? 'Masculino' : 'Feminino') .'</td>
                        <td class="text-start">' . $dado['course'] .'</td>
                        <td class="text-start">' . $dado['workload'] .'</td>
                        <td class="text-start">' . $dado['startMonth'] .' de ' . $dado['startYear'] .' </td>
                    </tr>
                    ';
                }
                echo'
                </tbody>
                </table>
                <a href="?certificate=start" class="btn btn-larger btn-success fs-3 px-5 py-2 mt-5">Gerar Certificados</a>
            </div>
        </div>
    </div>';
    }

    ?>
    
    <!--   Core JS Files   -->
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/html2canvas.js"></script>
    <script>
    <?php
    if (isset($_GET['certificate']) and $_GET['certificate'] == 'start'){
    ?>
    window.onload = function() { 

        document.getElementById("preloader").style.display="block";
        
        total_certificate = <?php echo $certificate->getTotalRow() ?>;
        file_name = <?php echo $certificate->arrayJavascript()?>;

        for (let i = 1; i <= total_certificate; i++) {
            document.body.style.width = '3508px';
            html2canvas(document.getElementById('content_test_' + i),{scrollY: -window.scrollY, scrollX: -window.scrollX}).then(function(canvas) {

                window.scrollTo(0,0);
                getCanvas = canvas;

                var imgageData = getCanvas.toDataURL("image/png");
                var img = imgageData;
                var newFolder = "<?php echo $newFolder ?>";
                var name = file_name[i-1];
                var output = encodeURIComponent(img);
                var Parameters = "image=" + output + "&name=" + name + "&newFolder=" + newFolder + "";

                $.ajax({
                    type: "POST",
                    url: "php/save-certificates.php",
                    data: Parameters,
                    success : function(data)
                    {
                        // alert (data);
                        console.log("screenshot done");
                    }
                }).done(function() {
                    $('body').html(data);
                });

            });
        }
        const time = total_certificate * 3500
        const myTimeout = setTimeout(location, time);
        function location (){
            window.location = "<?php echo $config->URL?>/?certificate=end";
        }
    };
    <?php
    }
    ?>
    </script>
</body>
</html>