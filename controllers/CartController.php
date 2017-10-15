<?php

class CartController
{
    
    public function actionAdd($id){
        Cart::addProduct($id);
        
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        return true;
    }
    
    public function actionAddAjax($id){
        echo Cart::addProduct($id);
        return true;   
    }
    
    public function actionIndex(){
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $productsInCart = false;
        
        $productsInCart = Cart::getProducts();
        
        if($productsInCart){
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);
            
            $totalPriсe = Cart::getTotalPrice($products);
            
        }
        
        require_once ROOT.'/views/cart/index.php';
        
        return true;
    }
    
    public function actionDelete($id){
        Cart::deleteProduct($id);
        
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        return true;
    }
    
    public function actionCheckout(){
        
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $result = false;
        
        if(isset($_POST['submit'])){
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            
            $errors = false;
            if(!User::checkName($userName)){
                $errors[] = 'Invalid name';
            }
            if(User::checkPhone($userPhone)){
                $errors[] = 'Invalid phone';
            }
            
            if($errors == false){
                
                $productsInCart = Cart::getProducts();
                if(User::isGuest()){
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }
                
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);
                if ($result){
                    $adnminEmail = '';
                    $message = '/admin/orders';
                    $subject = 'Новый заказ';
                    mail($adnminEmail, $subject, $message);
                    
                    Cart::clear();
                    
                }
                else{
                    
                    $productsInCart = Cart::getProducts();
                    $productsIds = array_keys($productsInCart);
                    $products = Product::getProductsByIds($productsIds);
                    $totalPrice = Cart::getTotalPrice($products);
                    $totalQuantity = Cart::countItem();
                }
            }
        } else {
            $productsInCart = Cart::getProducts();
            
            if($productsInCart == false){
                header("Location: /");
            } else {
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItem();
                
                $userName = false;
                $userPhone = false;
                $userComment = false;
                
                if(User::isGuest()){
                    
                } else {
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    
                    $userName = $user['name'];
                }
            }
        }
        
        require_once(ROOT . '/views/cart/checkout.php');
        
        return true;
    }
}
