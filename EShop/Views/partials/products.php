<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Features Items</h2>
        <?php if(\DF\Services\RoleService::isAdministrator() || \DF\Services\RoleService::isEditor()) { ?>
        <form action="<?= \DF\Services\RouteService::getUrl('products', ''); ?>" method="POST">
            <input type="text" name="productName" placeholder="name">
            <input type="text" name="productPrice" placeholder="price">
            <input type="text" name="categoryId" placeholder="category id">
            <input type="text" name="quantity" placeholder="quantity">
            <input type="hidden" name="csrf_token" value="<?= \DF\Helpers\Csrf::getCSRFToken(); ?>">
            <input type="submit" value="Add Product">
        </form>
        <?php } ?>
        <?php foreach($model->products as $product): ?>
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="images/home/product1.jpg" alt="" />
                        <h2>Quantity: <?= $product['quantity']; ?></h2>
                        <h2>$<?= $product['price']; ?></h2>
                        <p><?= $product['name']; ?></p>
                        <?php if(\DF\Helpers\Session::get('userId') != null): ?>
                        <a href="<?= \DF\Services\RouteService::$basePath . "products/" . $product['id'] . '/add'; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        <?php else: ?>
                        <a href="<?= \DF\Services\RouteService::$basePath . "home/login";?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        <?php endif; ?>
                    </div>
                    <a href="<?= \DF\Services\RouteService::$basePath . "products/" . $product['id']; ?>">
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <h2>$<?= $product['price']; ?></h2>
                                <p><?= $product['name']; ?></p>
                                <?php if(\DF\Helpers\Session::get('userId') != null): ?>
                                    <a href="<?= \DF\Services\RouteService::$basePath . "products/" . $product['id'] . '/add'; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                <?php else: ?>
                                    <a href="<?= \DF\Services\RouteService::$basePath . "home/login";?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div><!--features_items-->
</div>