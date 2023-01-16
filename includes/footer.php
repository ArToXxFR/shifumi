<footer>
        <button class="connection-button score purple" onclick="openForm('scoreboard')">Tableau des scores</button>
        <?php if (userConnected()) { ?>
                <button onclick="openForm('profil')" class="profile cyan"><img src="<?= $_SESSION['image'] ?>" alt='avatar' class="img-profile"><span><?= htmlspecialchars($_SESSION['pseudo']) ?></span></button>
                <button onclick="openForm('deconnection')" class="deconnection-button rouge-pastel"><span>Se déconnecter</span></button>
        <?php } else { ?>
                <button class="connection-button cyan" onclick="openForm('login')">Se connecter</button>
        <?php } ?>
</footer>