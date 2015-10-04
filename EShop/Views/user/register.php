<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>New User Signup!</h2>
                    <?php
                        echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                        ->initTextField()
                        ->setName('username')->setAttribute('placeholder', 'Username')
                        ->create()
                        ->initPasswordField()
                        ->setName('password')->setAttribute('placeholder', 'Password')
                        ->create()
                        ->initPasswordField()
                        ->setName('confirmPassword')->setAttribute('placeholder', 'Confirm Password')
                        ->create()
                        ->initTextField()
                        ->setName('email')->setAttribute('placeholder', 'Email')
                        ->create()
                        ->initSubmitButton()
                        ->setValue('Register')
                        ->setAttribute('class', 'btn btn-default')
                        ->create()
                        ->setAction(\DF\Services\RouteService::getUrl('account', 'register'))
                        ->setMethod('POST')
                        ->render();
                    ?>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section>