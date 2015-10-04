<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                <tr class="cart_menu">
                    <td class="image">Item</td>
                    <td class="price">Price</td>
                    <td class="quantity">Quantity</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($model->products as $product): ?>
                    <tr>
                        <td class="cart_description">
                            <h4><a href="<?= \DF\Services\RouteService::$basePath . "products/" . $product['id']; ?>"><?= $product['name']; ?></a></h4>
                        </td>
                        <td class="cart_price">
                            <p><?= $product['price']; ?></p>
                        </td>
                        <td class="cart_quantity">
                            <p><?= $product['quantity']; ?></p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="<?= \DF\Services\RouteService::$basePath . "account/cart/product/" . $product['id'] . "/remove"; ?>"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>