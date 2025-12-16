<?php

require "../Controller/TrajetController.php";

$trajetController= new TrajetController();
$trajets=$trajetController->getDisponibleTrajet();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php include 'header.php' ?>
</br>
</br>
    <table>
        <tr>
            <th>Ville de départ</th>
            <th>Ville d'arrivée</th>
            <th>Date de départ</th>
            <th>Date d'arrivée</th>
            <th>Places totales</th>
            <th>Places disponibles</th>
            <th>Actions</th>
        </tr>


        <?php foreach($trajets as $trajet){?>

        <tr>
            <td><?php echo $trajet['start_city']?></td>
            <td><?php echo $trajet['end_city']?></td>
            <td><?php echo $trajet['departure_date']?></td>
            <td><?php echo $trajet['arrival_date']?></td>
            <td><?php echo $trajet['total_seat']?></td>
            <td><?php echo $trajet['available_seat']?></td>

            <?php if(isset($_SESSION['user_id'])){?>
            <?php $isAuthor=$trajetController->isAuthor($_SESSION['user_id'],$trajet['id']) ?>

            <?php if ($isAuthor){?>
            <td> <a href="edit_trajet.php?id=<?php echo $trajet['id']?>"><button>Modifier<button></a></td>
            <td>
                <form action="delete_trajet.php" method="POST">
                    <input type="hidden" name="trajet_id" value="<?php echo $trajet['id']?>">
                    <button type="submit" onclick="return confirm('supprimer?')">Supprimer</button>
                </form>
            </td>
            <?php }}}?>
        </tr>
    </table>
</body>
</html>
