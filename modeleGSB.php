<?php
// Fonction de connexion au serveur de base de données et à la base de données
function connexionBd() {
    $utilisateur = "root";
    $mot_de_passe = "";
    $serveur_et_base = "mysql:host=localhost;dbname=gsb";
    
    try {
        // Création d'un objet de la classe PDO
        $bd = new PDO($serveur_et_base, $utilisateur, $mot_de_passe);
        // Configuration du jeu de caractères
        $bd->query("SET NAMES utf8");
    } catch(Exception $e) {
        die("Erreur : ".$e->getMessage());
    }

    return $bd;
    
}

function insertMedicament($nom, $effet_secondaire, $effet_therapeutique)
{
    $url = 'http://127.0.0.1//projet_gsb/api/gsb.php';
    $data = array('nom' => $nom, 'effets_secondaires' => $effet_secondaire, $nom, 'effet_therapeutiques' => $effet_therapeutique);

    $options = array( 
        'http' => array( 
            'header' => "Content-type: application/x-www-form-urlencoded\r\n", 
            'method' => 'POST',
            'content' => http_build_query($data) 
                       )
        );
    $context = stream_context_create($options); 
    $result = file_get_contents($url, false, $context);
    Return $result;

}

function updateMedicament($id, $nom, $effet_secondaire, $effet_therapeutique)
{
    //cas modif 
    $medi = $_POST["id"]; 
    $url = "http://127.0.0.1//projet_gsb/api/gsb.php?id=".$medi; 
    $data = array ('nom' => $_POST["nom"], 'effet_secondaire' => $_POST ["effet_secondaire"], 
    'effet_therapeutique' => $_POST ["effet_therapeutique"]); 
    $ch = curl_init ($url); 
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT") ; 
    curl_setopt ($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    $response = curl_exec ($ch); 

    if (!$response) 
    {
    return false; 
    } 
}

function deleteMedicament($id)
{
    $url = "http://127.0.0.1/api/voitures.php?id=".$id; 
                    $ch = curl_init(); 
                    curl_setopt ($ch, CURLOPT_URL, $url); 
                    curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
                    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
                    $response = curl_exec ($ch); 
                    
                    curl_close($ch); 
}

function fillUtilisateurs()
{
// appel de la fonction de connexion à la base de données
// renvoyant une référence à la base de données
$bd = connexionBd();

// requête d'insertion APRES HACHAGE DU MOT DE PASSE
$mdpHache = password_hash("Picsou1", PASSWORD_DEFAULT);
$requete = "INSERT INTO utilisateur
 VALUES
 ('ptronc', '$mdpHache', 'TRONC', 'Paul', 'U')";
// exécution de la requête
$bd->query("SET NAMES utf8");
$bd->query($requete);
// requête d'insertion APRES HACHAGE DU MOT DE PASSE
$mdpHache = password_hash("Donald2", PASSWORD_DEFAULT);
$requete = "INSERT INTO utilisateur
 VALUES
 ('jnastic', '$mdpHache', 'NASTIC', 'Jim', 'A')";
// exécution de la requête
$bd->query("SET NAMES utf8");
$bd->query($requete);

// requête d'insertion APRES HACHAGE DU MOT DE PASSE
$mdpHache = password_hash("Mickey3", PASSWORD_DEFAULT);
$requete = "INSERT INTO utilisateur
 VALUES
 ('phibulaire', '$mdpHache', 'HIBULAIRE', 'Pat', 'U')";
// exécution de la requête
$bd->query("SET NAMES utf8");
$bd->query($requete);

}

function getUtilisateur($emailU, $motDePasseU)
{

// appel de la fonction de connexion à la base de données
// renvoyant une référence à la base de données
$bd = connexionBd(); 

// préparation de la requête de sélection dans la table utilisateurs
$requete = $bd->prepare("SELECT * FROM utilisateurs
 WHERE email = :emailUt");
// exécution de la requête et renvoi du résultat
$bd->query("SET NAMES utf8");
$requete->execute([':emailUt' => $emailU]);
// récupération de la ligne du résultat
$util = $requete->fetch();

if ($util && password_verify($motDePasseU, $util['motDePasse'])) {

    return $util;
} else {
    return false;
}
}



function deconnexion()
{
// démarrage d'une nouvelle session ou reprise d'une session existante :
// doit être la première instruction de la page
session_start();
// suppression des variables de session
$_SESSION = array();
// destruction de la session
session_destroy();
// retour à la page de connexion
require_once "vue/formConnexion.php";
}

function logConnexion($id, $nomUtilisateur)
{
    $bd = connexionBd();
    $requete = $bd->prepare("INSERT INTO logs (id, nomUtilisateur, dateConnexion, heureConnexion) VALUES (:nom, CURDATE(), CURTIME())");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);
    $requete->bindParam(':nom', $nomUtilisateur, PDO::PARAM_STR);
    $requete->execute();
}

function enregistrerConnexion($nomUtilisateur) {
    $bd = connexionBd();
    $requete = $bd->prepare("INSERT INTO logs (nomUtilisateur, dateConnexion, heureConnexion)
                VALUES (:nomUtilisateur, CURDATE(), CURTIME())");
    $bd->query("SET NAMES utf8");
        $requete->execute([':nomUtilisateur' => $nomUtilisateur]);
    }


?>