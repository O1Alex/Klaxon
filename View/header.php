<?php

session_start();

?>
<header>

<!-- Header à gauche -->
    <div style="float:left">
        <!-- Administrateur -->
        <?php
        if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin'){?>
            <h1>
                <a href="admin_dashboard.php">KLAXON</a>
            </h1>
        <?php } else { ?>
            <h1>KLAXON</h1>
            <?php } ?>
    </div>


<!-- Header à droite -->
    <div style="float:right">
        <?php if(isset($_SESSION['user_id'])){?>

            <!-- Administrateur -->
            <?php if($_SESSION['user_role']=='admin'){?>
                <nav>
                    <a href="admin_dashboard.php?section=user">Utilisateurs</a>
                    <a href="admin_dashboard.php?section=agence">Agences</a>
                    <a href="admin_dashboard.php?section=trajet">Trajets</a>
                <button><a href="Deconnexion.php">Deconnexion</button>
            </nav>

            <!-- Utilisateur connecté  -->
            <?php } else{?>
                <div style="margin:0 20px">
                <form style="display:inline" action="create_trajet.php">
                    <button  type="submit">Proposer un trajet</button>
            </form>
            <span ><?php $_SESSION['user_name'] ?></span>               <!--A controler-->
             <button><a href="Deconnexion.php">Deconnexion</button>
            </div>
                 <?php }?>
                    <!-- Utilisation non connecté -->

        <?php }else{?>
            <form action="Connexion.php">
                <button type="submit">Formulaire de Connexion</button>
            </form> <?php }?>
    </div>
</header>
