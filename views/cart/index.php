<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Каталог</h2>
                    <div class="panel-group category-products">
                        <?php foreach ($categories as $categoryItem): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="/category/<?php echo $categoryItem['id'];?>">
                                            <?php echo $categoryItem['name'];?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Товары</h2>
                    
                    <?php if ($productsInCart): ?>
                        <p>Вы выбрали такие товары</p>
                        <table class="table-bordered table-striped table">
                            <tr>
                                <th>Код товара</th>
                                <th>Название</th>
                                <th>Стоимость</th>
                                <th>Количество, шт‚</th>
                            </tr>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['code'];?></td>
                                    <td>
                                        <a href="/product/<?php echo $product['id'];?>">
                                            <?php echo $product['name'];?>
                                        </a>
                                    </td>
                                    <td><?php echo $product['price'];?></td>
                                    <td><?php echo $productsInCart[$product['id']];?></td>
                                    <td>
                                        <a href="/cart/delete/<?php echo $product['id'];?>"
                                           class="btn btn-default delete-from-cart" >
                                           <i class="fa fa-shopping-cart"></i> Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                <tr>
                                    <td colspan="3">Общая стоимость</td>
                                    <td><?php echo $totalPrice; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <a href="/cart/checkout"
                                           class="btn btn-default checkout-from-cart" >
                                           <i class="fa fa-shopping-cart"></i> Оформить заказ</a>
                                    </td>
                                </tr>
                            
                        </table>
                    <?php else: ?>
                        <p>корзина пуста</p>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>