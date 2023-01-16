<!------------------------------------------------------------
---------Fond noir transparent lors des popups----------------
------------------------------------------------------------->

<div id="background"></div>

<!------------------------------------------------------------
---------Popup des règles-------------------------------------
------------------------------------------------------------->

<div class="position-popup" id="popupForm">
    <div class="form-popup">
        <h2 class="title-popup rouge-pastel">Rappel des Règles</h2>
        <div class="content-popup">
            <p>À chaque partie, le joueur choisit l'une ces trois actions :</p>
            <p class="regles_signes pierre mots-gras">pierre</p>
            <p class="regles_signes papier mots-gras">papier</p>
            <p class="regles_signes ciseaux mots-gras">ciseaux</p>
            <p>La <strong class="mots-gras">pierre</strong> bat les <strong class="mots-gras">ciseaux</strong> en les émoussant.</p>
            <p>Le <strong class="mots-gras">papier</strong> bat la <strong class="mots-gras">pierre</strong> en l'enveloppant.</p>
            <p>Les <strong class="mots-gras">ciseaux</strong> battent le <strong class="mots-gras">papier</strong> en la coupant.</p>
            <p>
                Il peut y avoir des matchs nulles si le joueur et Bender choisissent
                la même action.
            </p>
        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('popupForm')"></button>
</div>

<!------------------------------------------------------------
---------Popup du login---------------------------------------
------------------------------------------------------------->

<div class="position-popup" id="login">
    <div class="form-popup">
        <span class="title-popup border-radius-top jaune">Vous n'avez pas de compte ?</span>
        <div class="content-popup creation_compte">
            <button class="button-popup jaune" onclick="closeForm('login'); openForm('register');">Créer un nouveau compte</button>
        </div>
        <span class="title-popup border-top cyan ombre-top">Vous avez déjà un compte ?</span>
        <div class="content-popup connexion">
            <form action="index.php" method="POST" class="flex-login">
                <div class="input icon_username">
                    <input name="username" type="text" maxlength="25" placeholder="Nom d'utilisateur / Adresse email" class="input-username" required>
                </div>
                <div class="input icon_password">
                    <input name="password" type="password" placeholder="Mot de passe" class="input-password" required>
                </div>
                <span class="mots_gras">Mot de passe oublié ?</span>
                <button type="submit" class="button-popup cyan">Se connecter</button>
                <input type="hidden" name="name" value="login">
            </form>
        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('login')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup de register------------------------------------
------------------------------------------------------------->

<div class="position-popup" id="register">
    <div class="form-popup">
        <span class="title-popup border-radius-top jaune">Création de compte</span>
        <div class="content-popup">
            <form action="index.php" method="POST" class="flex-login">
                <div class="first-step-register" id="first-step">
                    <span>1/2 - Vos identifiants</span>
                    <input name="email" type="email" placeholder="Taper votre email..." required>
                    <input type="password" name="password" placeholder="Taper votre mot de passe..." required>
                    <input type="password" name="confirmPassword" placeholder="Confirmer le mot de passe" required>
                    <input type="hidden" name="name" value="register">
                </div>
                <div class="second-step-register" id="second-step">
                    <span>2/2 - Personnalisation</span>
                    <input name="pseudo" type="text" placeholder="Taper votre pseudo..." required>
                    <select name="avatar" id="f_selectTrie" onchange="changeAvatar()" required>
                        <?php $avatar_profile = array_avatars($dbh);
                        foreach ($avatar_profile as $avatar) { ?>
                            <option value="<?= $avatar['image'] ?>"><?= $avatar['name'] ?></option>
                        <?php } ?>
                    </select>
                    <img src="medias/avatars/avatars_fry.png" alt="avatar" id="avatar" width="50px">
                    <button type="submit">Terminer</button>
                </div>
            </form>
        </div>
        <div class="first-step-register" id="first-step-buttons">
            <button onclick="closeForm('register'); openForm('login');">Précédent</button>
            <button onclick="nextstep();">Suivant</button>
        </div>
        <div class="second-step-register" id="second-step-buttons">
            <button onclick="previousstep()">Précédent</button>

        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('login'); closeForm('register');">✖</button>
</div>

<!------------------------------------------------------------
---------Popup de déconnection--------------------------------
------------------------------------------------------------->

<div class="position-popup" id="deconnection">
    <div class="form-popup">
        <h2 class="title-popup rouge-pastel">Se déconnecter</h2>
        <div class="content-popup">
            <span class="choice">Etes-vous sur de vouloir vous déconnecter ?</span>
            <button onclick="document.location.href='/deconnection.php'" class="button-popup rouge-pastel">Oui je veux me déconnecter</button>
            <button onclick="document.location.href='/index.php'" class="button-popup jaune">C'était une erreur, annuler</button>
            <div class="bender_terminator"></div>
        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('deconnection')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup du tableau des scores--------------------------
------------------------------------------------------------->

<div class="position-popup" id="scoreboard">
    <div class="form-popup">
        <span class="title-popup border-radius-top purple">Tableau des scores</span>
        <?php $scoreboard = recuperation_scoreboard($dbh); ?>
        <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse">
            <?php for ($i = 0; $i < 10; $i++) { ?>
                <tr>
                    <td><img src="<?= $scoreboard[$i]['image']; ?>" alt="avatar" class="img-profile"></td>
                    <td><span><?= $scoreboard[$i]['pseudo']; ?></span></td>
                    <td><span><?= $i + 1; ?></span></td>
                    <td><span><?= $scoreboard[$i]['wins']; ?></span></td>
                    <td><span><?= $scoreboard[$i]['looses']; ?></span></td>
                    <td><span><?= $scoreboard[$i]['nuls']; ?></span></td>
                </tr>
            <?php } ?>
        </table>
        <?php if(userConnected()){ ?>
            <span class="title-popup border-radius-top purple">Mon score</span>
            <table>
                <tr>
                    <td><img src="<?= $_SESSION['image'] ?>" alt="avatar" class="img-profile"></td>
                    <td><span><?= $_SESSION['pseudo'] ?></span></td>
                    <td><span><?= $_SESSION['userPos']['rank'] ?></span></td>
                    <td><span><?= $_SESSION['stats_user']['wins']; ?></span></td>
                    <td><span><?= $_SESSION['stats_user']['looses']; ?></span></td>
                    <td><span><?= $_SESSION['stats_user']['nuls']; ?></span></td>
                </tr>
            </table>
        <?php } ?>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('scoreboard')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup pour modifier le profil des joueurs------------
------------------------------------------------------------->

<div class="position-popup" id="profil">
    <div class="form-popup">
        <span class="title-popup border-radius-top cyan">Votre profil</span>
        <div class="content-popup">
            <form action="index.php" method="POST" class="flex-login">
                <select name="avatar" id="f_selectTrie" required>
                    <?php $avatar_profile = array_avatars($dbh);
                    foreach ($avatar_profile as $avatar) { ?>
                        <option value="<?= $avatar['id'] ?>" <?php if ($_SESSION['avatar_id'] == $avatar['id']) {
                                                                    echo 'selected';
                                                                } ?>><?= $avatar['name']  ?></option>
                    <?php } ?>
                </select>
                <div class="input icon_username">
                    <input name="pseudo" type="text" maxlength="25" placeholder="<?= $_SESSION['pseudo']; ?>" class="input-login">
                </div>
                <div class="input icon_email">
                    <input name="email" type="email" placeholder="<?= $_SESSION['email'] ?>" class="input-login">
                </div>
                <input type="hidden" name="name" value="modification_profil">
                <button type="submit" class="button-popup cyan">Modifier le profil</button>
            </form>
            <button onclick="closeForm('profil'); openForm('modification_password');" class="button-popup jaune">Changer de mot de passe</button>
            <button onclick="closeForm('profil'); openForm('delete_profil');" class="button-popup rouge-pastel">Supprimer votre compte</button>
        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('profil')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup pour modifier le mot de passe du joueur--------
------------------------------------------------------------->

<div class="position-popup" id="modification_password">
    <div class="form-popup">
        <span class="title-popup border-radius-top jaune">Changer mon mot de passe</span>
        <div class="content-popup">
            <form action="index.php" method="POST" class="flex-login">
                <div class="input icon_password">
                    <input name="password" type="password" placeholder="Taper votre mot de passe..." required>
                </div>
                <div class="input icon_password">
                    <input name="confirmPassword" type="password" placeholder="Votre nouveau mot de pase..." required>
                </div>
                <input type="hidden" name="name" value="modification_password">
                <div class="footer-popup">
                    <button onclick="closeForm('modification_password'); openForm('profil');" class="button-popup bouton-gauche rouge-pastel">Annuler</button>
                    <button type="submit" class="button-popup bouton-droite jaune">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('modification_password')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup pour supprimer le profil du joueur-------------
------------------------------------------------------------->

<div class="position-popup" id="delete_profil">
    <div class="form-popup">
        <span class="title-popup border-radius-top rouge-pastel">Supprimer votre compte</span>
        <div class="content-popup">
            <span>Êtes-vous sûr de vouloir supprimer votre compte ?</span>
            <form action="index.php" method="POST" class="flex-login">
                <input type="hidden" name="name" value="delete_profil">
                <button type="submit" class="button-popup rouge-pastel">Supprimer le profil</button>
            </form>
            <button onclick="closeForm('delete_profil'); openForm('profil');" class="button-popup jaune">C'était une erreur, annuler</button>
            <div class="bender_remove"></div>
        </div>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('delete_profil')">✖</button>
</div>