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
        <p>À chaque partie, le joueur choisit l'une de ces trois actions</p>
        <ul>
            <li>pierre</li>
            <li>papier</li>
            <li>ciseaux</li>
        </ul>
        <ol>
            <li><img class="taille-image" src="/icons_jeu/pierre.png" alt="icon pierre"></li>
            <li><img class="taille-image" src="/icons_jeu/papier.png" alt="icon papier"></li>
            <li><img class="taille-image" src="/icons_jeu/ciseaux.png" alt="icon ciseaux"></li>
        </ol>
        <p>La <strong class="mots_gras">pierre</strong> bat les <strong class="mots_gras">ciseaux</strong> en les émoussant.</p>
        <p>Le <strong class="mots_gras">papier</strong> bat la <strong class="mots_gras">pierre</strong> en l'enveloppant.</p>
        <p>Les <strong class="mots_gras">ciseaux</strong> battent le <strong class="mots_gras">papier</strong> en la coupant.</p>
        <p>
            Il peut y avoir des matchs nulles si le joueur et Bender choisissent
            la même action.
        </p>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('popupForm')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup du login---------------------------------------
------------------------------------------------------------->

<div class="position-popup" id="login">
    <div class="form-popup">
        <span class="title-popup border-radius-top jaune">Vous n'avez pas de compte ?</span>
        <button class="button-popup jaune" onclick="closeForm('login'); openForm('register');">Créer un nouveau compte</button>
        <span class="title-popup border-top cyan ombre-top">Vous avez déjà un compte ?</span>
        <form action="index.php" method="POST" class="flex-login">
            <input name="username" type="text" maxlength="25" placeholder="Nom d'utilisateur / Adresse email" class="input-login">
            <input name="password" type="password" placeholder="Mot de passe" class="input-login">
            <span class="mots_gras mots_de_passe_oublie">Mot de passe oublié ?</span>
            <input name="button-login" type="submit" value="Se connecter" class="button-popup cyan">
            <input type="hidden" name="name" value="login">
        </form>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('login')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup de register------------------------------------
------------------------------------------------------------->

<div class="position-popup" id="register">
    <div class="form-popup">
        <span class="title-popup border-radius-top jaune">Création de compte</span>
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
                        <option value="<?= $avatar['image'] ?>"><?= $avatar['nom'] ?></option>
                    <?php } ?>
                </select>
                <img src="/medias/avatars/avatars_fry.png" alt="avatar" id="avatar" width="50px">
                <input type="submit" name="button-register" value="Terminer">
            </div>
        </form>
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
        <span class="choice">Etes-vous sur de vouloir vous déconnecter ?</span>
        <button onclick="document.location.href='/deconnection.php'" class="button-popup rouge-pastel">Oui je veux me déconnecter</button>
        <button onclick="document.location.href='/index.php'" class="button-popup jaune">C'était une erreur, annuler</button>
        <img src="/medias/bender_message/bender_terminator.svg" alt="Au revoir de bender">
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('deconnection')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup du tableau des scores--------------------------
------------------------------------------------------------->

<div class="position-popup" id="scoreboard">
    <div class="form-popup">
        <span class="title-popup border-radius-top">Tableau des scores</span>
    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('scoreboard')">✖</button>
</div>

<!------------------------------------------------------------
---------Popup pour modifier le profil des joueurs------------
------------------------------------------------------------->

<div class="position-popup" id="profil">
    <div class="form-popup">
        <span class="title-popup border-radius-top">Votre profil</span>

    </div>
    <button class="close-popup rouge-pastel" onclick="closeForm('profil')">✖</button>
</div>