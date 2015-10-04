<div class="col-sm-9 padding-right">
    <div class="product-details"><!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img src="images/product-details/1.jpg" alt="" />
            </div>
        </div>
        <div class="col-sm-7">
            <div class="product-information"><!--/product-information-->
                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                <h2><?= $model->product['name']; ?></h2>
								<span>
									<span>$<?= $model->product['price']; ?></span>
									<label>Quantity:<?= $model->product['quantity']; ?></label>
									<button type="button" class="btn btn-fefault cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        Add to cart
                                    </button>
								</span>
                <p><b>Availability:</b> In Stock</p>
                <?php
                if(\DF\Services\RoleService::isAdministrator() || \DF\Services\RoleService::isEditor()) { ?>
                    <p>
                        <?php
                            echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                            ->initTextField()
                            ->setName('quantity')
                            ->setAttribute('placeholder', 'Change quantity')
                            ->create()
                            ->initSubmitButton()
                            ->setValue('Change')
                            ->create()
                            ->setMethod('POST')
                            ->setAction(\DF\Services\RouteService::$basePath . '/products/' . $model->product['id'] . '/quantity')
                            ->render();
                        ?>
                    </p>
                    <p>
                        <?php
                        echo \DF\Helpers\ViewHelpers\FormViewHelper::init()
                            ->initTextField()
                            ->setName('categoryId')
                            ->setAttribute('placeholder', 'Change category(Id)')
                            ->create()
                            ->initSubmitButton()
                            ->setValue('Change')
                            ->create()
                            ->setMethod('POST')
                            ->setAction(\DF\Services\RouteService::$basePath . '/products/' . $model->product['id'])
                            ->render();
                        ?>
                    </p>
                <?php } ?>
            </div><!--/product-information-->
        </div>
    </div><!--/product-details-->

    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li><a href="#details" data-toggle="tab">Details</a></li>
                <li class="active"><a href="#reviews" data-toggle="tab">Reviews (<?= count($model->comments); ?>)</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="details" >
                <p></p>
            </div>

            <div class="tab-pane fade active in" id="reviews" >
                <div class="col-sm-12">
                    <?php foreach($model->comments as $comment): ?>
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i><?= $comment['username'] ?></a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i><?= $comment['comment_date']; ?></a></li>
                    </ul>
                    <p><?= $comment['comment_data']; ?></p>
                    <?php endforeach; ?>

                    <p><b>Write Your Review</b></p>
                    <form action="<?= \DF\Services\RouteService::$basePath . '/products/' . $model->product['id'] . '/comment' ?>" method="POST">
                        <textarea name="commentText"></textarea>
                        <button type="submit" class="btn btn-default pull-right">
                    Submit
                        </button>
                        <input type="hidden" name="csrf_token" value="<?= \DF\Helpers\Csrf::getCSRFToken(); ?>">
                    </form>

                </div>
            </div>

        </div>
    </div><!--/category-tab-->
</div>