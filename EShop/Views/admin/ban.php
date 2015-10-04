<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div>
                    <h2>Ban user</h2>
                    <?php
                    echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                        ->initTextField()
                        ->setName('username')->setAttribute('placeholder', 'Username')
                        ->create()
                        ->initSubmitButton()
                        ->setValue('BAN')
                        ->setAttribute('class', 'btn btn-default')
                        ->create()
                        ->setAction(\DF\Services\RouteService::getUrl('admin', 'banuser'))
                        ->setMethod('POST')
                        ->render();
                    ?>

                    <h2>Ban IP</h2>
                    <?php
                    echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                        ->initTextField()
                        ->setName('IP')->setAttribute('placeholder', 'Ip address')
                        ->create()
                        ->initSubmitButton()
                        ->setValue('BAN')
                        ->setAttribute('class', 'btn btn-default')
                        ->create()
                        ->setAction(\DF\Services\RouteService::getUrl('admin', 'banip'))
                        ->setMethod('POST')
                        ->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
