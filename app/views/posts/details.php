<?php require APPROOT . '/views/bases/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Retour</a>
<br>
<h1><?= htmlspecialchars($data['posts']->title) ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Publié par <?= htmlspecialchars($data['posts']->userNom) ?> le <?= $data['posts']->dateCreated; ?>
</div>
<p><?= htmlspecialchars_decode($data['posts']->content) ?></p>
<hr>
<div class="d-flex justify-content-between">
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['posts']->id_user) { ?>
        <a href="<?php echo URLROOT; ?>/posts/modifPost/<?= $data['posts']->id; ?>" class="btn btn-dark">Modifier</a>
        <a href="<?php echo URLROOT; ?>/posts/deletePost/<?= $data['posts']->id; ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce post?')">Supprimer</a>
    <?php } ?>
</div>


<div class="comment-section">
  <?php if(!empty($_SESSION['flashComment'])) {
    flash('flashComment');
  } ?>
  <?php if(!empty($_SESSION['flashCommentFailure'])) {
    flash('flashCommentFailure');
  } ?>
  <h2>Commentaires</h2>
  <?php foreach($data['comments'] as $comment) : ?>
    <div class="comment">
      <div class="comment-header">
        <i class="fas fa-user-circle comment-icon"></i>
        <div class="comment-user">
          <div class="comment-author">Publié par : <?= htmlspecialchars($comment->userNom) ?> le <?= $comment->date ?></div>
        </div>
      </div>
      <div class="comment-body">
        <p><?= htmlspecialchars_decode($comment->comment) ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>


<!-- Formulaire pour ajouter un commentaire -->
<h3>Ajouter un commentaire</h3>
<form action="<?= URLROOT; ?>/posts/addComment/<?= $data['posts']->id; ?>" method="POST">
  <div class="form-group">
    <textarea name="body" class="form-control"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Commenter</button>
</form>



<?php require APPROOT . '/views/bases/footer.php'; ?>