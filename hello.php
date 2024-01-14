<html>
    <head>
        <title>PHP Hello World!</title>
    </head>
    <body>
        <?php
        echo get_include_path();
        include('included.php');
        echo '<h1>Hello World 2024</h1>'; ?>
        <?php
        $databaseHost = getenv('DATABASE_HOST');

        // read configmap from file of configmap
        $configMapData = parse_ini_file('/etc/config/configmap/config.ini', true);
        $databaseUser = $configMapData['database_user'];
        $databasePassword = $configMapData['database_password'];

        echo "Database Host: $databaseHost\n";
        echo "Database User: $databaseUser\n";
        echo "Database Password: $databasePassword\n";
        ?>
        <?php phpinfo(); ?>
    </body>
</html>