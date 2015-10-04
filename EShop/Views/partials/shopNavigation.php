<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li><a href="<?= \DF\Services\RouteService::getUrl('home', '') ?>" class="active">Home</a></li>
                        <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                <li><a href="<?= \DF\Services\RouteService::getUrl('categories', '') ?>">Categories</a></li>
                                <li><a href="<?= \DF\Services\RouteService::getUrl('home', 'login') ?>">Login</a></li>
                                <li><a href="<?= \DF\Services\RouteService::getUrl('home', 'register') ?>">Register</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>