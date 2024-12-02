<?php require APPROOT . '/views/bases/header.php'; ?>

  <div class="row mb-3">
    <div class="col-md-6">
      <h1>Posts</h1>
    </div>
    <?php if (!empty($_SESSION['flashAdd'])) { 
      flash('flashAdd'); 
    } ?>
    <?php if (!empty($_SESSION['flashDelete'])) {
      flash('flashDelete');
    } ?>
    <div class="col-md-6">
      <a href="<?php echo URLROOT; ?>/posts/addPost" class="btn btn-primary pull-right">
        <i class="fa fa-pencil"></i> Ajouter un post
      </a>
    </div>
  </div>
  <?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
      <!-- ici on affiche avec la syntaxe des objets en PHP car dans la requête on spécifie PDO::FETCH_OBJ -->
      <h4 class="card-title"><?= strip_tags($post->title); ?></h4>
      <div class="bg-light p-2 mb-3">
        Publié par <?php echo htmlspecialchars($post->nom); ?> le <?php echo $post->dateCreated; ?>
      </div>
      <p class="card-text"><?= htmlspecialchars_decode($post->content); ?></p>
       <!-- redirection à faire sur la structure du router : controller Name/methodName/params -->
      <a href="<?php echo URLROOT; ?>/posts/details/<?php echo $post->postId; ?>" class="btn btn-dark">Voir plus</a>
    </div>
  <?php endforeach; ?>

<?php require APPROOT . '/views/bases/footer.php'; ?>