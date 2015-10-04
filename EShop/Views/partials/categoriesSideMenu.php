<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <div class="panel panel-default">
                <?php foreach($model->categories as $category): ?>
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="<?= \DF\Services\RouteService::getUrl('categories', '', [$category['id']]); ?>"><?= $category['name']; ?></a></h4>
                </div>
                <?php endforeach; ?>
            </div>
        </div><!--/category-products-->
    </div>
</div>