<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <div class="panel panel-default">
                <?php
                if(\DF\Services\RoleService::isAdministrator() || \DF\Services\RoleService::isEditor()) {

                        echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                            ->setMethod('POST')
                            ->setAction(\DF\Services\RouteService::getUrl('categories', ''))
                            ->initTextField()
                            ->setName('name')
                            ->create()
                            ->initSubmitButton()
                            ->setValue("Add")
                            ->create()
                            ->render();
                    }
                ?>
                <?php foreach($model->categories as $category): ?>
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="<?= \DF\Services\RouteService::getUrl('categories', '', [$category['id']]); ?>"><?= $category['name']; ?></a>
                        <?php
                        if(\DF\Services\RoleService::isAdministrator() || \DF\Services\RoleService::isEditor()) { ?>
                        <a class="cart_quantity_delete" href="<?= \DF\Services\RouteService::$basePath . "categories/" . $category['id'] . "/delete"; ?>"><i class="fa fa-times"></i></a>
                         <?php } ?>
                    </h4>
                </div>
                <?php endforeach; ?>
            </div>
        </div><!--/category-products-->
    </div>
</div>