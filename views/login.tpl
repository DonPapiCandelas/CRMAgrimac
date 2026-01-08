<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache">
    
    <link rel="stylesheet" href="{$settings['url']}/assets/plugins/font-awesome/files/all.min.css">
    <link rel="stylesheet" href="{$settings['url']}/assets/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <script src="{$settings['url']}/assets/plugins/jquery/jquery.min.js"></script>
    <script src="{$settings['url']}/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <script src="{$settings['url']}/assets/ajax/general.js?v={$v}"></script>
    <script src="{$settings['url']}/assets/ajax/login.js?v={$v}"></script>

    <title>Iniciar sesión</title>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{$settings['url']}">
                <img src="{$settings['url']}/assets/img/logo.png" alt="{$settings['systemname']}" width="180">
            </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingresa tus datos para acceder al sistema.</p>
                <form action="" method="post" autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" autocomplete="off" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" autocomplete="off" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" id="submit" class="btn btn-primary btn-flat btn-block">Iniciar sesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>