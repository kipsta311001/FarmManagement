<?php
function getPage($db)
{

    $lesPages['accueil'] = "actionAccueil;0";
    $lesPages['inscription'] = "actionInscription;0";
    $lesPages['login'] = "actionConnexion;0";
    $lesPages['deconnexion'] = "actionDeconnexion;0";
    $lesPages['maintenance'] = "actionMaintenance;0";
    $lesPages['listeChamps'] = "actionlisteChamps;0";
    $lesPages['ajoutChamp'] = "actionAjoutChamps;0";
    $lesPages['sol'] = "actionSol;0";
    $lesPages['semis'] = "actionSemis;0";
    $lesPages['culture'] = "actionCulture;0";
    $lesPages['traitement'] = "actionTraitement;0";
    $lesPages['engrais'] = "actionEngrais;0";
    $lesPages['recolte'] = "actionRecolte;0";
    $lesPages['intervention'] = "actionlisteIntervention;0";

    if ($db != null) {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 'login';
        }

        if (!isset($lesPages[$page])) {
            $page = 'login';
        } 
        $explose = explode(";", $lesPages[$page]); // Nous découpons la ligne du tableau sur le  // caractère « ; » Le résultat est stocké dans le tableau $explose
        $role = $explose[1]; // Le rôle est dans la 2ème partie du tableau $explose
        if ($role != 0) { // Si mon rôle nécessite une vérification
            if (isset($_SESSION['login'])) {  // Si je me suis authentifié
                if (isset($_SESSION['role'])) {  // Si j’ai bien un rôle
                    if ($role != $_SESSION['role']) { // Si mon rôle ne correspond pas à celui qui est nécessaire //pour voir la page
                        $contenu = 'actionConnexion';  // Je le redirige vers l’accueil, car il n’a pas le bon rôle
                    } else {
                        $contenu = $explose[0];
                        // Je récupère le nom du contrôleur, car il a le bon rôle
                    }
                } else {
                    $contenu = 'actionConnexion';
                }
            } else {
                $contenu = 'actionConnexion';  // Page d’accueil, car il n’est pas authentifié
            }
        } else {
            $contenu = $explose[0]; //  Je récupère le contrôleur, car il n’a pas besoin d’avoir un rôle
        }

    } else {
        $contenu = 'actionMaintenance';
    }
    return $contenu;
}
?>