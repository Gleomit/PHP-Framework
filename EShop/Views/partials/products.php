<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Features Items</h2>
        <?php foreach($model->products as $product): ?>
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="images/home/product1.jpg" alt="" />
                        <h2>Quantity: <?= $product['quantity']; ?></h2>
                        <h2>$<?= $product['price']; ?></h2>
                        <p><?= $product['name']; ?></p>
                        <a href="<?= \DF\Services\RouteService::$basePath . "products/" . $product['id'] . '/add'; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </div>
                    <div class="product-overlay">
                        <div class="overlay-content">
                            <h2>$<?= $product['price']; ?></h2>
                            <p><?= $product['name']; ?></p>
                            <a href="<?= \DF\Services\RouteService::$basePath . "products/" . $product['id'] . '/add'; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div><!--features_items-->
</div>