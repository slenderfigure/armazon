<?php

class DBRequest {
    private $dbh;
    private $conn;
    private $login;

    public function __construct() {
        require_once 'Controller.class.php';

        $this->dbh = new Controller('localhost', 'armazon', 'root', 'Adisonpaque2454!');
        $this->conn = $this->dbh->connect();
    }

    public function createAccount(
        $fullname, 
        $login, 
        $password, 
        $seller = 0
    ) {
        $query = 'INSERT INTO users (fullName, login, password, seller)
            VALUES (?, ?, ?, ?);';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $fullname, PDO::PARAM_STR);
        $stmt->bindParam(2, $login,    PDO::PARAM_STR);
        $stmt->bindParam(3, $password, PDO::PARAM_STR);
        $stmt->bindParam(4, $seller,   PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function verifyUserCredentials($value, $type) {
        $isValid = false;

        switch($type) {
            case 'login':
                $query = 'SELECT login FROM users WHERE login = ?;';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $value, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->login = $stmt->fetch()[0];
                    $isValid = true;
                }
                break;
            case 'password':
                $query = 'SELECT password FROM users WHERE login = ?;';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->login, PDO::PARAM_STR);
                $stmt->execute();

                if (password_verify($value, $stmt->fetch()[0])) {
                    $isValid = true;
                }
                break;
            default:
                $isValid = false;
        }

        return $isValid;
    }

    public function getUserLogin() {
        return $this->login;
    }

    public function getAccountInfo($login) {
        $query = 'SELECT fullName, avatar, seller, acct_creation
            FROM users WHERE login = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $login, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function sellerEnrollment(
        $login, 
        $shopname, 
        $productType
    ) {
        $query = 
        'UPDATE users SET seller = 1 WHERE login = ?;
        INSERT INTO sellers(sellerId, shop_name, product_type)
        VALUES(?, ?, ?);';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $login,       PDO::PARAM_STR);
        $stmt->bindParam(2, $login,       PDO::PARAM_STR);
        $stmt->bindParam(3, $shopname,    PDO::PARAM_STR);
        $stmt->bindParam(4, $productType, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function updateAvatar($login, $avatar) {
        $query = 'UPDATE users SET avatar = ? WHERE login = ?;';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(1, $avatar, PDO::PARAM_STR);
        $stmt->bindParam(2, $login,  PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function createProductListing(
        $seller,
        $productName, 
        $price, 
        $productDetails, 
        $freeshipping, 
        $categoryId, 
        array $imagesToUpload
    ) {
        include '../include/generate_image_dir.inc.php';

        $insert = 'INSERT INTO products (product_name, listed_price, current_price, product_details, free_shipping, categoryId, seller)
            VALUES ( ?, ?, ?, ?, ?, ?, ?);';

        $stmt = $this->conn->prepare($insert);
        $stmt->bindParam(1, $productName,    PDO::PARAM_STR);
        $stmt->bindParam(2, $price,          PDO::PARAM_STR);
        $stmt->bindParam(3, $price,          PDO::PARAM_STR);
        $stmt->bindParam(4, $productDetails, PDO::PARAM_STR);
        $stmt->bindParam(5, $freeshipping,   PDO::PARAM_INT);
        $stmt->bindParam(6, $categoryId,     PDO::PARAM_INT);
        $stmt->bindParam(7, $seller,         PDO::PARAM_STR);
        $stmt->execute();

        $productId  = $this->conn->lastInsertId();
        $dbImageURI = array ();

        if ($imagesToUpload !== null) {
            for($i = 0; $i < count($imagesToUpload['name']); $i++) {
                $name = $imagesToUpload['name'][$i];
                $tmp_name = $imagesToUpload['tmp_name'][$i];
                array_push($dbImageURI, saveProductImage($productId, $name, $tmp_name));
            }
        }

        if (count($dbImageURI) > 0) {
            foreach($dbImageURI as $image) {
                $insert = 'INSERT INTO images (url, productId) VALUES (?, ?);';
                $stmt = $this->conn->prepare($insert);
                $stmt->bindParam(1, $image,     PDO::PARAM_STR);
                $stmt->bindParam(2, $productId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        return $stmt->rowCount();
    }

    public function getProducts($categoryId = '', $productId = '', $seller = null) {
        switch (true) {
            case ($categoryId !== ''):
                $query = 'SELECT * FROM products WHERE categoryId = ?;';
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(1, $categoryId, PDO::PARAM_INT);
                break;
            case ($productId !== ''):
                $query = 'SELECT * FROM products WHERE productId = ?;';
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(1, $productId, PDO::PARAM_INT);
                break;
            case ($seller !== null):
                $query = 'SELECT * FROM products WHERE seller = ?;';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $seller, PDO::PARAM_STR);
                break;
            default: 
                $query = 'SELECT * FROM products;';
                $stmt  = $this->conn->prepare($query);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductImages($productId) {
        $query = 'SELECT * FROM images WHERE productId = ?;';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(1, $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProduct(
        $productId,
        $productName, 
        $price, 
        $productDetails, 
        $freeshipping, 
        $categoryId, 
        array $imagesToDel = null,
        array $imagesToUpload
    ) {
        $query = 
        'UPDATE products 
        SET product_name = ?,
            current_price = ?,
            product_details = ?,
            free_shipping = ?,
            categoryId = ?
        WHERE productId = ?;';

        $stmt = $this->conn->prepare($query);        
        $stmt->bindParam(1, $productName,    PDO::PARAM_STR);
        $stmt->bindParam(2, $price,          PDO::PARAM_STR);
        $stmt->bindParam(3, $productDetails, PDO::PARAM_STR);
        $stmt->bindParam(4, $freeshipping,   PDO::PARAM_INT);
        $stmt->bindParam(5, $categoryId,     PDO::PARAM_INT);
        $stmt->bindParam(6, $productId,      PDO::PARAM_INT);
        $stmt->execute();

        if ($imagesToDel !== null) {
            foreach($imagesToDel as $imageId) {
                $query = 'DELETE FROM images WHERE imageId = ?;';
                $stmt  = $this->conn->prepare($query); 
                $stmt->bindParam(1, $imageId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        if (count($imagesToUpload) > 0) {
            foreach($imagesToUpload as $image) {
                $query = 'INSERT INTO images (url, productId) VALUES (?, ?);';
                $stmt  = $this->conn->prepare($query);
                $stmt->bindParam(1, $image,     PDO::PARAM_STR);
                $stmt->bindParam(2, $productId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        return $stmt->rowCount();
    }

    public function deleteProduct($productId) {
        $query = 'DELETE FROM products WHERE productId = ?;';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(1, $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }
    
    public function __destruct() {
        $this->conn = null;
    }
}