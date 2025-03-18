<?php
session_start();

$produse = [
    'sexy.jpg' => ['denumire' => '212 Sexy Men', 'pret' => 100],
    'adidas.jpg' => ['denumire' => 'Adidas Dive', 'pret' => 150],
    'aigner.png' => ['denumire' => 'Aigner Pour Homme', 'pret' => 200],
];

if (isset($_POST['adaugare_in_cos'])) {
    $produs = $_POST['produs'];
    $cantitate = $_POST['cantitate'];

    if (!isset($_SESSION['cos'][$produs])) {
        $_SESSION['cos'][$produs] = ['cantitate' => 0, 'pret' => $produse[$produs]['pret']];
    }
    $_SESSION['cos'][$produs]['cantitate'] += $cantitate;
}

if (isset($_GET['cancel']) && isset($_SESSION['cos'][$_GET['cancel']])) {
    unset($_SESSION['cos'][$_GET['cancel']]);
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Shopping Cart</h1>

    <div class="container">
        <div class="produse">
            <?php foreach ($produse as $imagine => $detalii): ?>
                <div class="produs">
                    <img src="images/<?= $imagine ?>" alt="<?= $detalii['denumire'] ?>">
                    <h3><?= $detalii['denumire'] ?></h3>
                    <p>Preț: <?= $detalii['pret'] ?> MDL</p>
                    <form action="index.php" method="POST">
                        <label for="cantitate">Cantitate:</label>
                        <input type="number" name="cantitate" value="1" min="1" required>
                        <input type="hidden" name="produs" value="<?= $imagine ?>">
                        <button type="submit" name="adaugare_in_cos" class="btn-verde">Adaugă în coș</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="cos">
            <h2>Coșul meu</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produs</th>
                        <th>Cantitate</th>
                        <th>Preț Unitar</th>
                        <th>Total</th>
                        <th>Acțiune</th>
                    </tr>
                    <!-- modified -->
                </thead>
                <tbody>
                    <?php if (isset($_SESSION['cos']) && !empty($_SESSION['cos'])): ?>
                        <?php $totalCos = 0; ?>
                        <?php foreach ($_SESSION['cos'] as $produs => $detalii): ?>
                            <tr>
                                <td><?= $produse[$produs]['denumire'] ?></td>
                                <td><?= $detalii['cantitate'] ?></td>
                                <td><?= $detalii['pret'] ?> MDL</td>
                                <td><?= $detalii['cantitate'] * $detalii['pret'] ?> MDL</td>
                                <td><a href="index.php?cancel=<?= $produs ?>" class="btn-cancel">Cancel</a></td>
                            </tr>
                            <?php $totalCos += $detalii['cantitate'] * $detalii['pret']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="total">Total: <?= $totalCos ?> MDL</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Coșul este gol.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
