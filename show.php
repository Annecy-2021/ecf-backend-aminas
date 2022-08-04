<?php

if (!isset($_GET['s'])) {
    header('location: index.php');
    die();
}

require_once 'Model/Student.php';

$student_model = new Student();
$student = $student_model->getOne((int)$_GET['s']);
if (!$student) {
    $error = 'Erreur : Aucun étudiant trouvé.';
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>ECF Backend 2</title>
    </head>
    <body>
        <main class="container">

            <section class="p-5 mb-4 bg-light rounded-3">
                <h1>Interface de gestion des élèves et des examens</h1>
                <?php if (!isset($error)): ?>
                    <h2>Page de l'élève : <?= $student->prenom . ' ' . $student->nom ?></h2>
                <?php else: ?>
                        <p>Erreur : Aucun étudiant trouvé.</p>
                <?php endif; ?>
                <a href="index.php">Retour</a>
            </section>

            <header class="py-3 mb-3 border-bottom">
                <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                    <h1>ECF Backend</h1>

                    <form class="w-100 me-3 row g-3" action="index.php" method="GET">
                        <div class="col">
                            <input type="search" class="form-control" placeholder="Nom" name="nom">
                        </div>
                        <div class="col">
                            <input type="search" class="form-control" placeholder="Prénom" name="prenom">
                        </div>
                        <button class="btn btn-primary col" type="submit">Rechercher</button>
                    </form>
                </div>
            </header>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php die(); endif; ?>

            <section>
                <article class="card">
                    <h5 class="card-header">#<?= $student->id_etudiant ?></h5>
                    <div class="card-body">
                        <h5 class="card-title"><?= $student->prenom . ' ' . $student->nom ?></h5>
                        <p class="card-text">Moyenne générale : <strong><?= $student->moyenne ?>/20</strong></p>

                        <div class="accordion" id="accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#examens">
                                        Examens
                                    </button>
                                </h2>
                                <div id="examens" class="accordion-collapse collapse show" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Matière</th>
                                                    <th scope="col">Note</th>
                                                    <th scope="col"><a href="#">Ajouter une nouvelle note</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($student_model->getNotes($student->id_etudiant) as $note): ?>
                                                    <tr>
                                                        <th scope="row"><?= $note->id_examen ?></th>
                                                        <td><?= $note->matiere ?></td>
                                                        <td><?= $note->note ?></td>
                                                        <td>
                                                            <a href="#">Modifier</a>
                                                            <a class="text-danger" href="#">Supprimer</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#moyenne">
                                        Matières
                                    </button>
                                </h2>
                                <div id="moyenne" class="accordion-collapse collapse show" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Matière</th>
                                                    <th scope="col">Moyenne</th>
                                                    <th scope="col">Moyenne de tous les étudiants</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($student_model->getMoyennes($student->id_etudiant) as $moyenne): ?>
                                                    <tr>
                                                        <th scope="row"><?= $moyenne->matiere ?></th>
                                                        <td><?= $moyenne->moyenne ?></td>
                                                        <td><?= number_format($moyenne->moyenne_g, 2) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
