<?php require APPROOT . '/views/bases/header.php'; ?>

<div class="container mt-5">
    <h2>Se connecter</h2>
    <form action="<?= URLROOT ?>/users/login" method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
            <?php if(!empty($_SESSION['flashEmail'])) { 
                flash('flashEmail');  
            } ?>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control">
            <?php if(!empty($_SESSION['flashPassword'])) { 
                flash('flashPassword'); 
            } ?>
            <?php if(!empty($_SESSION['flashPassword2'])) {
                flash('flashPassword2');
            } ?>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?php require APPROOT . '/views/bases/footer.php'; ?>