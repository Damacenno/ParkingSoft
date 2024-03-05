<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/javascript.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="icon" href="../assets/img/logo.png">
    <title><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')) . " | ParkingSoft" ?></title>
</head>
<div class="sidebar">
    <ul>
        <li class="<?php echo (basename($_SERVER['PHP_SELF'], '.php') == "home") ? "active" : ''; ?>"><a
                href="home.php"><i class="fas fa-chart-bar"></i> Home</a></li>
        <li><a href="dashboard.php"><i
                    class="<?php echo (basename($_SERVER['PHP_SELF'], '.php') == "Dashboard") ? "active" : ''; ?> fas fa-tachometer-alt"></i>
                Dashboard</a></li>
        <li><a href="configuracoes.php"><i
                    class="<?php echo (basename($_SERVER['PHP_SELF'], '.php') == "Configuracoes") ? "active" : ''; ?> fas fa-cogs"></i>
                Configurações</a></li>
        <li><a href="relatar.php" target="_blank"><i
                    class="<?php echo (basename($_SERVER['PHP_SELF'], '.php') == "Relatar") ? "active" : ''; ?> fas fa-chart-line"></i>
                Suporte</a></li>
    </ul>
</div>
<div class="content_header">
    <h4><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')) ?></h4>
    <button type="button" id="sidebar_active" class="btn btn-info">
        <i class="fas fa-align-left"></i>
    </button>
</div>