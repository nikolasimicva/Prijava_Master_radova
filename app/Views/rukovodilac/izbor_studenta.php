<?php
$this->extend('layout');
$this->section('sidebar');
$link = [
    'Насловна' => 'rukovodilac/home',
    'Oдлука комисије' => 'rukovodilac/odluka',

];
?>
<!-- tabela iz bootstrap teme -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link
        href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"
        rel="stylesheet" />
    <?php
    helper('html');
    helper('auth');
    echo link_tag('css/style.css');
    echo link_tag('css/styles.css');
    ?>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        crossorigin="anonymous"></script>
  


<link rel="stylesheet" href="style.css">

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Корисник
            </div>
            <a class="nav-link" href="index.html">
            </a>
            <div class="sb-sidenav-menu-heading">Статус пријаве
            </div>
            <?php foreach ($link as $text => $url) : ?>
            <li class="nav-item mx-0 mx-lg-1">
                <?= anchor($url, $text, ['class' => 'nav-link']) ?>
            </li>
            <?php endforeach; ?>
            <a class="nav-link" href="index.html">
                Негде тамо далеко
            </a>
            <div class="sb-sidenav-menu-heading">Операције
            </div>
            <a class="nav-link" href="index.html">
                Пријава теме
            </a>
            <div class="sb-sidenav-menu-heading">Брисање теме
            </div>
            <a class="nav-link" href="index.html">
                Размислите прво
            </a>
        </div>
    </div>
</nav>

<?php $this->endSection(); ?>

<?php
$this->section('content');
?>

<!-- tabela iz bootstrap teme -->
<main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Изаберите студента за обраду докумената</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a
                                href="naslovna.php">Насловна</a></li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Taбела са студентима
                        </div>
                        <div class="card-body">
                            
<div class="container">
    <div class="row col-md-9 col-md-offset-2 custyle">
    <table class="table table-striped custab">
        <?php
        $con=mysqli_connect("localhost","root","","etfphpprojekat");
        $data = user_id();
 
       // $query = "SELECT *
       //           FROM users join tema on (users.id=tema.id_student) 
       //           join prijava on (tema.id = prijava.id_rad) 
       //           WHERE prijava.izborno_podrucje_MS = (SELECT naziv from modul where ruk_modula = (select username from users where users.id = '$data') AND tema.status IN (3,4,7))";
        $query = "SELECT *
        FROM users join tema on (users.id=tema.id_student)
        join prijava on (tema.id = prijava.id_rad)
        WHERE prijava.izborno_podrucje_MS IN (SELECT naziv from modul 
        where ruk_modula = (select username from users where users.id = 17) 
        OR zam_ruk_modula = (select username from users where users.id = 17)) AND tema.status IN (3,4,7)";
        $result = mysqli_query($con, $query);
        echo "<table>"; 
        ?>
        <table class="table table-striped custab">
        <thead>
            <tr>
                <th>ID пријаве</th>
                <th>Име и презиме</th>
                <th class="text-center">Пријава</th>
                <th class="text-center">Образложење теме</th>
                <th class="text-center">Биографија</th>

            </tr>
        </thead>
        <?php
        while($row = mysqli_fetch_array($result)){  
             
        echo "<tr>";
        echo "<td class='text-center'>" . $row['id'] . "</td>";
        echo "<td class='text-center'>" . $row['username'] . "</td>";
        ?>
        <td class="text-center"> 
            <?php 
            echo anchor('rukovodilac/prijava_azuriraj/'.$row['id'], 'измени', ['class' => 'btn btn-outline-dark ml-2']); 
            ?>
        </td>
        <td class="text-center"> 
            <?php
            echo anchor('rukovodilac/obrazlozenje_azuriraj/'.$row['id_student'], 'измени', ['class' => 'btn btn-outline-dark ml-2']);
            ?>
        </td>
        <td class="text-center">       
            <?php
            echo anchor('rukovodilac/biografija_azuriraj/'.$row['id_student'], 'измени', ['class' => 'btn btn-outline-dark ml-2']);
            ?>
        </td>

        <?php 
        echo "</tr>"; }
        echo "</table>";
        ?>

    </div>
</div>

                        </div>
                    </div>
                </div>
            </main>

<!-- tabele iz bootstrapa -->
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


<?php $this->endSection(); ?>