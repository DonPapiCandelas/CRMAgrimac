<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item user-menu">
            <div class="nav-link">
                <img src="{$settings['url']}/assets/img/user2-160x160.jpg" class="d-none user-image img-circle elevation-2" alt="{$user->fullname}">
                <span>{$user->fullname}</span>
            </div>
        </li>
        <li class="nav-item">
            <a href="{$settings['url']}/logout" class="nav-link" title="Salir">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar elevation-4 sidebar-dark-olive">
    <a href="{$settings['url']}" class="brand-link navbar-light d-flex justify-content-center">
        <img src="{$settings['url']}/assets/img/logo.png" alt="{$settings['systemname']}" class="brand-image mx-0" height="48">
        <span class="brand-text text-dark font-weight-light h6">CRM</span>
    </a>

    <div class="sidebar">
        {$menu}
    </div>
</aside>