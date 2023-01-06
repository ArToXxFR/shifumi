<footer>
        <button class="connection-button score purple" onclick=""> <img class="icon-button" src="img/icon_tableau.svg" alt="icon de tableau">Tableau des scores<img class="icon-button" src="img/fleche.svg" alt="flèche"> </button>
        <?php if (userConnected()) { ?>
                <button onclick="" class="profile cyan"><img src="<?= $_SESSION['image'] ?>" alt='avatar' class="img-profile"><span><?= htmlspecialchars($_SESSION['pseudo']) ?></span></button>
                <button onclick="openForm('deconnection')" class="deconnection-button rouge-pastel"> <img class="icon-button" src="img/icon_exit.svg" alt="icon exit">Se déconnecter<img class="icon-button" src="img/fleche.svg" alt="flèche"></button>
        <?php } else { ?>
                <button class="connection-button cyan" onclick="openForm('login')"> <img class="icon-button" src="img/login.svg" alt="icon de login">Se connecter<img class="icon-button" src="img/fleche.svg" alt="flèche"> </button>
        <?php } ?>
</footer>