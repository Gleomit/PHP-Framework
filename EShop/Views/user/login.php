<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="login-form">
                    <h2>Login to your account</h2>
                    <?php
                    echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                        ->initTextField()
                        ->setName('username')->setAttribute('placeholder', 'Username')
                        ->create()
                        ->initPasswordField()
                        ->setName('password')->setAttribute('placeholder', 'Password')
                        ->create()
                        ->initSubmitButton()
                        ->setValue('Register')
                        ->setAttribute('class', 'btn btn-default')
                        ->create()
                        ->setAction(\DF\Services\RouteService::getUrl('account', 'login'))
                        ->setMethod('POST')
                        ->render();
                    ?>
                </div><!--/login form-->
            </div>
        </div>
    </div>
</section>
