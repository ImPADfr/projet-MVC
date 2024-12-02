<?php require APPROOT . '/views/bases/header.php'; ?>

  <a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Retour</a>
  <?php if(!empty($_SESSION['flashFailure'])) {
    flash('flashFailure');
  }   ?>
  <div class="card card-body bg-light mt-5">
    <h2>Modifier le post </h2>
    <br>
    <form action="<?php echo URLROOT; ?>/posts/modifPost/<?= $data['posts']->id; ?>" method="POST">
      <div class="form-group">
        <label for="title">Titre: <sup>*</sup></label>
        <input type="text" name="title" value="<?= strip_tags($data['posts']->title) ?>" class="form-control form-control-lg">
        <?php if(!empty($_SESSION['flashTitle'])) {
            flash('flashTitle');
        }   ?>
      </div>
      <div class="form-group">
        <label for="content">Contenu: <sup>*</sup></label>
        <textarea name="content" class="form-control form-control-lg"><?= htmlspecialchars_decode($data['posts']->content) ?></textarea>
        <?php if(!empty($_SESSION['flashContent'])) {
            flash('flashContent');
        } ?>
        <?php if(!empty($_SESSION['flashFailure'])) {
          flash('flashFailure');
        } ?>
      </div>
      <input type="submit" class="btn btn-success" value="Publier">
    </form>
  </div>

<?php require APPROOT . '/views/bases/footer.php'; ?>