<?php
class Controller {
    
    function consultMedicaments()
 {
    session_start();
 // recherche des médicaments : appel de la fonction getMedicaments() du modèle
 $medicaments = getMedicaments();

 // inclusion du fichier d'affichage des médicaments de la vue
 require_once "vue/medicaments.php";
 }

 function chargementFormAjoutMedicament()
{
// inclusion du formulaire d'ajout d'un médicament
require_once "vue/formAjoutMedicament.html";
}

function ajoutMedicament()
{
    session_start();
// récupération des données (champs) du formulaire

$nom = htmlspecialchars($_POST["nom"]);
$effet_secondaire = htmlspecialchars($_POST["effet_secondaire"]);
$effet_therapeutique = htmlspecialchars($_POST["effet_therapeutique"]);

// ajout du médicament : appel de la fonction insertMedicament() du modèle
insertMedicament($nom, $effet_secondaire, $effet_therapeutique);

 // recherche des medicaments : appel de la fonction getMedicaments() du modèle
 $medicaments = getMedicaments();

 // inclusion du fichier d'affichage des medicaments de la vue
 require_once "vue/medicaments.php";
}

function modifMedicament()
{
    session_start();
// récupération des données du formulaire
$id = htmlspecialchars($_POST["id"]);
$nom = htmlspecialchars($_POST["nom"]);
$effet_secondaire = htmlspecialchars($_POST["effet_secondaire"]);
$effet_therapeutique = htmlspecialchars($_POST["effet_therapeutique"]);
// mise à jour du médicament : appel de la fonction updateMedicament() du modèle
updateMedicament($id, $nom, $effet_secondaire, $effet_therapeutique);

// recherche des voitures : appel de la fonction getMedicaments() du modèle
$medicaments = getMedicaments();

// inclusion du fichier d'affichage des medicaments de la vue
require_once "vue/medicaments.php";
}

function supprMedicament($id)
{
    
// suppression du médicament : appel de la fonction deleteMedicament() du modèle
deleteMedicament($id);

// recherche des médicaments : appel de la fonction getMedicaments() du modèle
$medicaments = getMedicaments();

// inclusion du fichier d'affichage des médicaments de la vue
require_once "vue/medicaments.php";
}

function chargementFormConnexion()
{
require_once "vue/formConnexion.php";
}
}
