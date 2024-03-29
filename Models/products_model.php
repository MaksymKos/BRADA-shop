<?php class Products_model
{
    public $products;

    public function __construct()
    {
        global $connect;

        $sql_query = "SELECT p.*, pcrs.name AS producer 
        FROM products as p 
        LEFT JOIN producers AS pcrs
        ON pcrs.id = p.producer
        ORDER BY id DESC";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            $this->products = $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function get_product_media($id)
    {
        global $connect;

        $sql_query = "SELECT * FROM products_media WHERE product_id = $id";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function get_product_video($id)
    {
        global $connect;

        $sql_query = "SELECT * FROM products_media WHERE product_id = $id AND media_type = 'video'";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function get_cart_variants($variants)
    {
        global $connect;

        $sql_query = "SELECT DISTINCT p.name, p.price, po.quantity, po.*, pm.image_path FROM products AS p 
        LEFT JOIN product_options AS po 
        ON p.sku = po.sku 
        LEFT JOIN products_media AS pm
        ON p.id = pm.product_id AND pm.media_type = 'main'
        WHERE (";
// print_r($_SESSION['cart']);
        foreach ($variants as $item) {
            $sql_query .= "(po.sku = '" . $item['sku'] . "' and po.size = '" . $item['size'] . "') OR ";
        }

        $sql_query = substr($sql_query, 0, -4) . ")";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function get_order_products($variants, $id)
    {
        global $connect;

        $sql_query = "SELECT DISTINCT p.name, p.price, po.quantity, po.*, pm.image_path, op.id AS prod_id, op.quantity AS order_quantity FROM products AS p 
        LEFT JOIN product_options AS po 
        ON p.sku = po.sku 
        LEFT JOIN products_media AS pm
        ON p.id = pm.product_id AND pm.media_type = 'main'
        LEFT JOIN order_products AS op
        ON po.sku = op.sku and po.size = op.size and op.order_id = '$id'
        WHERE (";
// print_r($_SESSION['cart']);
        foreach ($variants as $item) {
            $sql_query .= "(po.sku = '" . $item['sku'] . "' and po.size = '" . $item['size'] . "') OR ";
        }

        $sql_query = substr($sql_query, 0, -4) . ")";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function get_all_available_products() {
        global $connect;

        $query = "SELECT * from product_options WHERE quantity > 0";

        try {
            $rows = $connect->query($query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function get_variant($sku, $size)
    {
        global $connect;

        $sql_query = "SELECT p.name, po.quantity, po.size, po.sku, pm.image_path FROM products as p 
        LEFT JOIN product_options as po 
        ON p.sku = po.sku 
        LEFT JOIN products_media as pm
        ON p.id = pm.product_id AND pm.media_type = 'main'
        WHERE po.sku = '$sku' and po.size ='$size'";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function getProduct($sku)
    {
        global $connect;

        $sql_query = "SELECT p.*, p.id AS product_id, coll.name AS collection, po.*, pm.*, pcrs.name AS producer
        FROM products AS p 
        LEFT JOIN product_options AS po 
        ON p.sku = po.sku 
        LEFT JOIN products_media AS pm
        ON p.id = pm.product_id
        LEFT JOIN producers AS pcrs
        ON pcrs.id = p.producer
        LEFT JOIN collections as coll
        ON coll.id = p.collection
        WHERE p.sku = '$sku'";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function getProductInfo($sku)
    {
        global $connect;

        $sql_query = "SELECT p.*, po.size, po.quantity FROM products as p 
        LEFT JOIN product_options as po 
        ON p.sku = po.sku 
        WHERE p.sku = '$sku'";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }
            return $rows->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public static function sort_options_middleware($data)
    {
        $newArr = [];

        foreach ($data as $item) {
            $found = false;
            foreach ($newArr as &$newItem) {
                if ($item['id'] == $newItem['id'] && $item['sku'] == $newItem['sku']) {

                    $found = true;
                    if (is_array($newItem['size'])) {
                        if ($item['quantity'] > 0) {
                            $newItem['size'][] = $item['size'];
                        }
                    }
                }
            }
            if (!$found) {
                $size_value = $item['size'];
                $item['size'] = [];

                if ($item['quantity'] > 0) {
                    $item['size'][] = $size_value;
                }

                if(count($item['size'])) {
                    $newArr[] = $item;
                }
            }
        }
        return $newArr;
    }

    public static function get_collection($collection_name, $brand = false)
    {
        global $connect;
        if ($collection_name != 'all') {
            $condition = "WHERE c.name = '$collection_name'";
        }

        if ($collection_name == 'all') {
            $condition = '';
        };

        if ($collection_name == 'Жіночий одяг') {
            $condition = "WHERE c.name LIKE 'Жін%'";
        };

        if ($collection_name == 'Чоловічий одяг') {
            $condition = "WHERE c.name NOT LIKE 'Жін%'";
        };

        if ($brand) {
            $condition = "WHERE prodcr.name = '$collection_name'";
        }

        $sql_query = "SELECT p.*, c.name AS collection, prodcr.name AS producer, po.size, po.quantity, pm.*
        FROM products p
        LEFT JOIN product_options po
        ON p.sku = po.sku
        LEFT JOIN products_media as pm
        ON p.id = pm.product_id AND pm.media_type = 'main'
        LEFT JOIN collections as c
        ON p.collection = c.id
        LEFT JOIN producers as prodcr
        ON p.producer = prodcr.id" . " " . $condition . " ORDER BY p.id DESC";

        try {
            $rows = $connect->query($sql_query);
            if (!$rows) {
                throw new Exception($connect->error);
            }

            $fetchedRows = $rows->fetch_all(MYSQLI_ASSOC);
            $result = self::sort_options_middleware($fetchedRows);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}
