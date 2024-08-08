<?php
require 'functions.php';

$user = getCurrentUser();
$loginTime = isset($_COOKIE['login_time']) ? $_COOKIE['login_time'] : null;
$currentTime = time();
$timeLeft = $loginTime ? 24 * 60 * 60 - ($currentTime - $loginTime) : null;
$hours = $timeLeft !== null ? floor($timeLeft / 3600) : null;
$minutes = $timeLeft !== null ? floor(($timeLeft % 3600) / 60) : null;
$seconds = $timeLeft !== null ? $timeLeft % 60 : null;

$birthday = $user ? getBirthday($user) : null;
$daysUntilBirthday = null;
if ($birthday) {
    $currentDate = new DateTime();
    $birthdayDate = new DateTime($birthday);
    $birthdayDate->setDate($currentDate->format('Y'), $birthdayDate->format('m'), $birthdayDate->format('d'));
    if ($currentDate > $birthdayDate) {
        $birthdayDate->modify('+1 year');
    }
    $daysUntilBirthday = $currentDate->diff($birthdayDate)->days;
}

$services = [
    'Массажная терапия' => 'Расслабьтесь и восстановите силы с помощью нашего массажа всего тела.',
    'Процедуры по уходу за лицом' => 'Оживите свою кожу с помощью наших эксклюзивных процедур по уходу за лицом.',
    'Маникюр и педикюр' => 'Побалуйте себя нашими услугами маникюра и педикюра.',
    'Укладка волос' => 'Придайте себе новый вид с помощью наших профессиональных услуг по укладке волос.',
    'Спа-пакеты' => 'Воспользуйтесь нашими специальными спа-пакетами, чтобы получить незабываемые впечатления.'
];

$promotions = [
    'Специальное предложение на лето' => 'Получите скидку 20% на все услуги этим летом!',
    'Новый клиент' => 'Впервые посетивший сайт получает бесплатный маникюр с любым уходомза лицом', 
    'Скидка на день рождения' => 'Отпразднуйте свой день рождения со скидкой 5% на все услуги.'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SPA Salon</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Добро пожаловать в СПА-салон!</h1>
        <nav>
            <?php if ($user): ?>
                <span>Logged in as <?php echo htmlspecialchars($user); ?></span>
                <a href="logout.php">Выход</a>
            <?php else: ?>
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <section class="hero">
            <img src="images/spa_hero.jpg" alt="SPA Salon" class="hero-image">
            <div class="hero-text">
                <h2>Расслабьтесь, Восстановите силы и Оживите кожу</h2>
                <p>Воспользуйтесь лучшими услугами в области красоты и хорошего самочувствия в нашем спа-салоне.</p>
            </div>
        </section>
        <section class="services">
            <h2>Наши услуги</h2>
            <ul>
                <?php foreach ($services as $service => $description): ?>
                    <li><strong><?php echo htmlspecialchars($service); ?></strong>: <?php echo htmlspecialchars($description); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="promotions">
            <h2>Текущие рекламные акции</h2>
            <ul>
                <?php foreach ($promotions as $title => $details): ?>
                    <li><strong><?php echo htmlspecialchars($title); ?></strong>: <?php echo htmlspecialchars($details); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php if ($user): ?>
            <section class="user-info">
                <p>Добро пожаловать, <?php echo htmlspecialchars($user); ?>!</p>
                <p>Осталось время для получения вашей персональной скидки: <?php echo "$hours часов, $minutes минут, $seconds секунд"; ?></p>
                <?php if ($daysUntilBirthday === 0): ?>
                    <p>С Днем рождения! Сегодня вы получаете скидку 5% на все услуги!</p>
                <?php elseif ($daysUntilBirthday !== null): ?>
                    <p>Дней до твоего дня рождения: <?php echo $daysUntilBirthday; ?></p>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 SPA Salon. All rights reserved.</p>
    </footer>
</body>
</html>

