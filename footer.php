<div class="footer">
    <button class="connection-button score purple" onclick="">Tableau des scores</button>
    <?php if(userConnected()){ ?>
            <button onclick="" class="profile cyan"><img src="<?= $_SESSION['image'] ?>" alt='avatar' class="img-profile"><span><?= $_SESSION['pseudo']?></span></button>
            <button onclick="document.location.href='deconnection.php'" class="deconnection-button rouge-pastel">Se déconnecter</button>
    <?php } else { ?>
            <button class="connection-button cyan" onclick="openForm('login')">Se connecter</button>
    <?php } ?>
</div>