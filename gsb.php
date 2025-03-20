<?php
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method)
{
    case 'GET' : 
        // Retrive medicament 
        if( !empty($_GET["id"])) 
        { 
            $id=intval($_GET["id"]); 
            getMedicament ($id); 
        }
        else 
        {
            getMedicaments(); 
        } 
        break;
    case 'POST' : 
        // Ajouter un medicament 
        AddMedicament() ; 
        break; 
    case 'PUT': 
        // Modifier un medicament 
        $id = intval($_GET["id"]); 
        updateMedicament ($id); 
        break; 
    case 'DELETE': 
        // Supprimer un medicament 
        $id = intval($_GET["id"]); 
        deleteMedicament($id); 
        break; 
        default: 
        // Invalid Request Method 
        header ("HTTP/1.0 405 Method Not Allowed") ; 
        break; 
}

function getMedicaments ( ) 
{
global $conn; 
$query = "SELECT * FROM medicaments" ; 
$response = array (); 
$conn->query("SET NAMES utf8"); 
$result = $conn->query ($query) ; 
while ( $row = $result->fetch() ) 
{
    $response[] = $row; 
} 
$result->closeCursor(); 
header ('Content-Type: application/json'); 
echo json_encode ($response, JSON_PRETTY_PRINT);
}

function getMedicament ($id=0) 
{ 
    global $conn; 
    $query = "SELECT * FROM medicaments"; 
    if($id != 0) 
    { 
        $query .= " WHERE id=".$id." LIMIT 1"; 
    } 
    $conn->query ("SET NAMES utf8"); 
    $result = $conn->query ($query); 
    while ( $row = $result->fetch() ) 
    {
        $response [] = $row; 
    }
    header ('Content-Type: application/json'); 
    echo json_encode ($response, JSON_PRETTY_PRINT);
}
function AddMedicament() 
{ 
    global $conn;

    // Récupérer les données envoyées par la requête POST
    $nom = $_POST["nom"]; 
    $effet_secondaire = isset($_POST["effets_secondaires"]) ? $_POST["effets_secondaires"] : []; // Tableau des effets secondaires sélectionnés
    $effet_therapeutique = isset($_POST["effets_therapeutiques"]) ? $_POST["effets_therapeutiques"] : []; // Tableau des effets thérapeutiques sélectionnés

    // Requête pour insérer le médicament dans la table Médicaments
    $query = "INSERT INTO Medicaments (nom) VALUES (?)";

    // Préparer la requête
    if ($stmt = $conn->prepare($query)) {
        
        // Lier le paramètre
        $stmt->bind_param("s", $nom);

        // Exécuter la requête
        if ($stmt->execute()) {
            $medicament_id = $stmt->insert_id; // Récupérer l'id du médicament ajouté
            
            // Si des effets secondaires sont sélectionnés, les associer au médicament
            if (!empty($effet_secondaire)) {
                foreach ($effet_secondaire as $effet_id) {
                    $query_comporte = "INSERT INTO Comporte (id, id_1) VALUES (?, ?)";
                    if ($stmt_comporte = $conn->prepare($query_comporte)) {
                        $stmt_comporte->bind_param("ii", $medicament_id, $effet_id);
                        $stmt_comporte->execute();
                        $stmt_comporte->close();
                    }
                }
            }

            // Si des effets thérapeutiques sont sélectionnés, les associer au médicament
            if (!empty($effet_therapeutique)) {
                foreach ($effet_therapeutique as $effet_id) {
                    $query_contient = "INSERT INTO Contient (id, id_1) VALUES (?, ?)";
                    if ($stmt_contient = $conn->prepare($query_contient)) {
                        $stmt_contient->bind_param("ii", $medicament_id, $effet_id);
                        $stmt_contient->execute();
                        $stmt_contient->close();
                    }
                }
            }

            // Réponse de succès
            $response = array(
                'status' => 1,
                'status_message' => 'Médicament et effets associés ajoutés avec succès.'
            );
        } else {
            // Si l'insertion du médicament échoue
            $response = array(
                'status' => 0,
                'status_message' => 'Erreur lors de l\'ajout du médicament.'
            );
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Erreur de préparation de la requête.'
        );
    }

    // Définir le type de contenu en JSON et retourner la réponse
    header('Content-Type: application/json'); 
    echo json_encode($response);
}

function updateMedicament($id) 
{
    global $conn;
    $_PUT = array();
    parse_str(file_get_contents('php://input'), $_PUT);
    
    // Récupération des nouvelles valeurs pour le médicament
    $nom = $_PUT["nom"];
    $effet_secondaire = $_PUT["effet_secondaire"];  // Tableau d'IDs d'effets secondaires à associer
    $effet_therapeutique = $_PUT["effet_therapeutique"];  // Tableau d'IDs d'effets thérapeutiques à associer
    
    // Mise à jour des informations du médicament
    $query = "UPDATE Medicaments SET nom='".$nom."' WHERE id=".$id;
    $conn->query("SET NAMES utf8");

    if ($conn->query($query)) {
        // Mettre à jour les effets secondaires associés au médicament
        // D'abord, supprimer les anciennes associations
        $delete_query = "DELETE FROM Comporte WHERE id=".$id;
        $conn->query($delete_query);

        // Insérer les nouvelles associations d'effets secondaires
        foreach ($effet_secondaire as $effet_id) {
            $insert_query = "INSERT INTO Comporte (id, id_1) VALUES (?, ?)";
            if ($stmt = $conn->prepare($insert_query)) {
                $stmt->bind_param("ii", $id, $effet_id);
                $stmt->execute();
            }
        }

        // Mettre à jour les effets thérapeutiques associés au médicament
        // D'abord, supprimer les anciennes associations
        $delete_query_et = "DELETE FROM Contient WHERE id=".$id;
        $conn->query($delete_query_et);

        // Insérer les nouvelles associations d'effets thérapeutiques
        foreach ($effet_therapeutique as $effet_id) {
            $insert_query_et = "INSERT INTO Contient (id, id_1) VALUES (?, ?)";
            if ($stmt = $conn->prepare($insert_query_et)) {
                $stmt->bind_param("ii", $id, $effet_id);
                $stmt->execute();
            }
        }

        // Si tout a réussi
        $response = array(
            'status' => 1,
            'status_message' => 'Médicament mis à jour avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Échec de la mise à jour du médicament.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function deleteMedicament($id) 
{
    global $conn;

    // Supprimer d'abord les associations d'effets secondaires
    $delete_comporte_query = "DELETE FROM Comporte WHERE id=".$id;
    $conn->query("SET NAMES utf8");
    $conn->query($delete_comporte_query);

    // Supprimer ensuite les associations d'effets thérapeutiques
    $delete_contient_query = "DELETE FROM Contient WHERE id=".$id;
    $conn->query($delete_contient_query);

    // Supprimer enfin le médicament
    $query = "DELETE FROM Medicaments WHERE id=".$id;
    if ($conn->query($query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Médicament supprimé avec succès.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'La suppression du médicament a échoué.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

?>