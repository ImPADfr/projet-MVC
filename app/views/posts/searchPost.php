<?php require APPROOT . '/views/bases/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Retour</a>
<div class="card card-body bg-light mt-5">
    <?php if (!empty($_SESSION['flashSearch'])) {
         flash('flashSearch'); 
    } ?>
    <h2>Rechercher un post </h2>
    <div>
        <form action="<?php echo URLROOT; ?>/posts/searchPost" method="POST">
            <div class="form-group">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Rechercher un post">
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Rechercher">
            </div>
        </form>
    </div>

    <div class="mt-5">
        <?php if (isset($data['search'])) { ?>
        <h3>Résultats de la recherche : <?= count($data['search']); ?> post trouvé</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Auteur</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['search'] as $search) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($search->title); ?></td>
                            <td><?php echo htmlspecialchars_decode($search->content); ?></td>
                            <td><?php echo htmlspecialchars($search->userNom); ?></td>
                            <td><?php echo $search->dateCreated; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<?php require APPROOT . '/views/bases/footer.php'; ?>