<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\UploadedFileInterface as UploadedFile;

require './vendor/autoload.php';
require './mysql.php';
$app = new Slim\App();

$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';


$app->get('/', function($request, $response, $args) {
    echo "coupon HOME";
    exit;    
});
// get user list

$app->get('/user', 'get_user');

$app->get('/status', 'get_status');

$app->get('/cards_status', 'get_cards_status');
//get product list
$app->get('/product', 'get_product');



//get online assembly status  chart
$app->get('/online_assembly_status/{user}', function($request, $response, $args)
{
    online_assembly_status( $args['user']);
});


//get online assembly status  chart
$app->get('/card_order_status/{id}', function($request, $response, $args)
{
    card_order_status( $args['id']);
});

//get if card has benn used
$app->get('/cards_scanned/{id}', function($request, $response, $args)
{
    cards_scanned( $args['id']);
});

//get online gift cards status  chart
$app->get('/cards_order_status/{user}', function($request, $response, $args)
{
    cards_order_status( $args['user']);
});

//get success/fail assembly  chart
$app->get('/closed_assembly/{user}', function($request, $response, $args)
{
    closed_assembly( $args['user']);
});

//get success/fail cards  chart
$app->get('/closed_cards/{user}', function($request, $response, $args)
{
    closed_cards( $args['user']);
});




//get leads cards chart
$app->get('/leads_cards_chart/{time}', function($request, $response, $args)
{
    leads_cards_chart($args['time']);
});


//get leads assembly chart
$app->get('/leads_assembly_chart/{time}', function($request, $response, $args)
{
    leads_assembly_chart($args['time']);
});


//get orders cards chart
$app->get('/card_orders_chart/{time}/{user}', function($request, $response, $args)
{
    card_orders_chart($args['time'], $args['user']);
});

//get orders assembly chart
$app->get('/orders_chart/{time}/{user}', function($request, $response, $args)
{
    orders_chart($args['time'], $args['user']);
});

//get assembly assignment chart
$app->get('/assignment_assembly', 'assignment_assembly');


//get alert cards  chart
$app->get('/alert_cards', 'alert_cards');


//get alert assembly  chart
$app->get('/alert_assembly', 'alert_assembly');

//get cards assignment chart
$app->get('/assignment_cards', 'assignment_cards');

//get cards list
$app->get('/cards', 'get_cards');

//get tags list
$app->get('/tags', 'get_tags');

$app->get('/assign', function ()
{
    assign_coworker("686ee266-5934-3df3-1e06-15b82175e854", date("Y-m-d H:i:s"), 1);
});

//get User Role
$app->get('/user_role/{id}', function($request, $response, $args) {

    user_role($args['id']);

});

//get User Role
$app->get('/one_card/{id}', function($request, $response, $args) {

    one_card($args['id']);

});

//get if product is rated
$app->get('/is_rated/{order_id}/{product_id}', function($request, $response, $args) {

    is_rated($args['order_id'], $args['product_id']);
});
//get logs by order_id
$app->get('/assembly_logs_order/{id}', function($request, $response, $args) {

    assembly_logs_order($args['id']);

});


//get rated products by user ID
$app->get('/user_rating/{id}', function($request, $response, $args) {

    user_rating($args['id']);

});

//get average rate by product ID
$app->get('/average_rating/{id}', function($request, $response, $args) {

    average_rating($args['id']);

});

//get notifications by user ID
$app->get('/notifications/{id}', function($request, $response, $args) {

    get_notifications($args['id']);

});

//set read at true for notifications of one user
$app->get('/read_notifications/{id}', function($request, $response, $args) {

    read_notifications($args['id']);

});
//get cards logs by order_id
$app->get('/cards_logs_order/{id}', function($request, $response, $args) {

    cards_logs_order($args['id']);

});


//getcard payments infog
$app->get('/get_card_payment/{id}', function($request, $response, $args) {

    get_card_payment($args['id']);

});



//get assembly orders by order ID
$app->get('/product_by_order/{id}', function($request, $response, $args) {

    get_product_by_order($args['id']);

});
//get assembly Order list
$app->get('/assembly_order/{limite}/{page}' ,function($request, $response, $args) {
    get_assembly_order($args['page'], $args['limite']);
});


//get Cards Order list
$app->get('/cards_order/{limite}/{page}' ,function($request, $response, $args) {

    get_cards_order($args['page'], $args['limite']);
});

//get Cards Order list
$app->get('/cards_cart/{id}' ,function($request, $response, $args) {

    cards_cart($args['id']);
});

//get single assembly order
$app->get('/one_assembly_order/{id}', function($request, $response, $args) {
    get_assembly_order_id($args['id']);

});

$app->get('/one_card_order/{id}', function($request, $response, $args) {
    get_card_order_id($args['id']);

});

$app->get('/user_card_order/{id}/{page}', function($request, $response, $args) {
    user_card_order($args['id'], $args['page']);

});


//get browsing history

$app->get('/get_history/{user}/{page}', function($request, $response, $args)
{
    get_history( $args['user'], $args['page']);
});


//get single user
$app->get('/user/{id}', function($request, $response, $args) {
    get_user_id($args['id']);
});


//get single product
$app->get('/product/{id}', function($request, $response, $args) {
    get_product_id($args['id']);
});


//add user
$app->post('/add_user', function($request, $response, $args) {


    add_user($request->getParsedBody());//Request object’s <code>getParsedBody()</code> method to parse the HTTP request
});


//add rating
$app->post('/add_rating', function($request, $response, $args) {


    add_rating($request->getParsedBody());//Request object’s <code>getParsedBody()</code> method to parse the HTTP request
});

//add card
$app->post('/add_card', function($request, $response, $args) {

    $files = $request->getUploadedFiles();

    add_card($request->getParsedBody(), $files["file"]);//Request object’s <code>getParsedBody()</code> method to parse the HTTP request
});



//update card
$app->post('/update_card', function($request, $response, $args) {

    $files = $request->getUploadedFiles();

    update_card($request->getParsedBody(), $files["file"]);//Request object’s <code>getParsedBody()</code> method to parse the HTTP request
});




//add browsing history
$app->post('/add_history', function($request, $response, $args) {


    add_history($request->getParsedBody());//Request object’s <code>getParsedBody()</code> method to parse the HTTP request
});


//add order
$app->post('/add_order', function($request, $response, $args) {
    $json = $request->getParsedBody();


    add_order($json);
});


//add card to cart
$app->post('/add_card_cart', function($request, $response, $args) {
    $json = $request->getParsedBody();
    add_card_cart($json);
});


//update card cart
$app->post('/update_card_cart', function($request, $response, $args) {
    $json = $request->getParsedBody();
    update_card_cart($json);
});



//add card order
$app->post('/add_card_order', function($request, $response, $args) {
    $json = $request->getParsedBody();
    add_card_order($json);
});


//add card payment
$app->post('/add_card_payment/{id}', function($request, $response, $args) {
    $json = $request->getParsedBody();
    add_card_payment($json, $args['id']);
});

//add confrim card order
$app->post('/confirm_card_order', function($request, $response, $args) {
    $json = $request->getParsedBody();
    confirm_card_order($json);
});


//search order
$app->post('/assembly_search/{limite}/{page}', function($request, $response, $args) {
    $json = $request->getParsedBody();
    search_order($json, $args['page'], $args['limite']);


});


//search card order
$app->post('/rating_search', function($request, $response, $args) {
    $json = $request->getParsedBody();
    rating_search($json);


});


//Export to txt
$app->post('/export_txt', function($request, $response, $args) {
    $json = $request->getParsedBody();
    export_txt($json);


});




//search card order
$app->post('/card_search/{limite}/{page}', function($request, $response, $args) {
    $json = $request->getParsedBody();
    search_card_order($json, $args['page'], $args['limite']);


});


//update user
$app->put('/update_user', function($request, $response, $args) {
    update_user($request->getParsedBody());
});

//update assembly order
$app->post('/update_assembly_order/{id}', function($request, $response, $args) {
    update_assembly_order($request->getParsedBody(),$args['id'] );
});

//update gift card order
$app->post('/update_card_order/{id}', function($request, $response, $args) {
    update_card_order($request->getParsedBody(),$args['id'] );
});

//delete user
$app->delete('/delete_user', function($request, $response, $args) {
    delete_user($request->getParsedBody());
});



//delete card
$app->delete('/delete_card/{id}', function($request, $response, $args) {
    delete_card($args['id']);
});
//delete card in the cart
$app->delete('/delete_card_cart', function($request, $response, $args) {
    delete_card_cart($request->getParsedBody());
});


$app->run();
echo "App started";
// get user list

function get_user() {

    $db = connect_db();



    $sql = "SELECT workers.worker_id, workers.username, department.name AS department,   roles.name AS role  FROM workers, roles, department WHERE workers.role = roles.role_id AND workers.department = department.id  ORDER BY `worker_id`";


    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data); exit;
}


function read_notifications($id)
{
    $db = connect_db();
    $sql = "update notifications SET `read`= 1"
        . " WHERE `worker_id` = '$id'";

    $exe = $db->query($sql);
    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows)) {
        echo '{"response":"success"}';
        exit;
    }
    else{
        echo '{"response":"failed"}';
        exit;
    }
}

function average_rating($id)
{
    $db = connect_db();
    $sql = "select product_id, AVG(rate)  AS rating from product_rating WHERE product_id='$id' GROUP BY product_id ";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    if ($data[0])
        $data = $data[0];
    echo json_encode($data);
    exit;
}


function user_rating($id)
{

    $db = connect_db();
    $sql = "SELECT DISTINCT `product_id` FROM  product_rating WHERE user_id='$id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    echo json_encode($data);
    exit;
}

function get_notifications($id)
{
    $db = connect_db();
    $sql = "SELECT notifications.*, department.name AS scope_name FROM notifications, department where notifications.scope=department.id AND worker_id='$id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $totalNotif=mysqli_num_rows($exe);



    $sql = "SELECT notifications.*, department.name AS scope_name FROM notifications, department where notifications.scope=department.id AND worker_id='$id' AND notifications.read=0 order by date DESC";
    $exe = $db->query($sql);
    $rowcount=mysqli_num_rows($exe);
    header('Content-Type: application/json');
    $arr = array('totalNotifications'=> $totalNotif ,'totalUnread' => $rowcount,  'data' => $data);


    $db = null;
    echo json_encode($arr);
    exit;
}

function assembly_logs_order($id)
{
    $db = connect_db();
    $sql = "SELECT  assembly_logs.*, workers.username AS name FROM assembly_logs, workers WHERE order_id='$id' AND assembly_logs.worker_id = workers.worker_id order by date DESC";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    $arr = array('order_id'=> $id , 'data' => $data);
    echo json_encode($arr); exit;
}

//get cards orders logs
function cards_logs_order($id)
{
    $db = connect_db();
    $sql = "SELECT  cards_logs.*, workers.username AS name FROM cards_logs, workers WHERE order_id='$id' AND cards_logs.worker_id = workers.worker_id order by date DESC";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    $arr = array('order_id'=> $id , 'data' => $data);
    echo json_encode($arr); exit;
}


function get_product_by_order($id)
{
    $db = connect_db();
    $sql = "SELECT  orders.product_number AS product_id , products.assembly_price AS assembly_price FROM orders, products WHERE orders.product_number= products.product_id AND orders.order_id='$id'";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    $arr = array('order_id'=> $id , 'data' => $data);
    echo json_encode($arr); exit;
}


function get_cards_status() {

    $db = connect_db();
    $sql = "SELECT *  FROM cards_status  `status_id`";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data); exit;
}

function get_status() {
    $db = connect_db();
    $sql = "SELECT *  FROM status  `status_id`";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data); exit;
}
//get sigle user
function get_user_id($user_id) {
    $db = connect_db();

    $sql = "SELECT workers.worker_id, workers.username, department.name AS department,   roles.name AS role  FROM workers, roles, department WHERE workers.role = roles.role_id AND workers.department = department.id  AND workers.worker_id = '$user_id'ORDER BY `worker_id`";

//        $sql = "SELECT * FROM workers WHERE `worker_id` = '$user_id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
    exit;
}



//assignment assembly charts

function assignment_assembly()
{

    $db = connect_db();
    $sql = "SELECT orders.coworker_id AS id, count(orders.order_id) AS total, (SELECT COUNT(order_id) from orders WHERE (status=4 OR status = 5) AND  coworker_id = id) AS cloesed FROM orders WHERE  orders.inserted_date >= now()-interval 12 month  GROUP BY orders.coworker_id";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}


//assignment gift cards charts

function assignment_cards()
{

    $db = connect_db();
    $sql = "SELECT cards_orders.coworker_id AS userid, count(cards_orders.order_id) AS total, (SELECT COUNT(order_id) from cards_orders WHERE (status=4 OR status = 5) AND coworker_id = userid) AS closed FROM cards_orders WHERE cards_orders.inserted_date >= now()-interval 12 month GROUP BY cards_orders.coworker_id";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}


function alert_assembly()
{
    $db = connect_db();
    $sql = "SELECT DISTINCT(orders.order_id), workers.username AS worker_name FROM `orders`, workers WHERE DATE(orders.inserted_date) < DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND orders.status < 4 AND workers.worker_id = orders.coworker_id";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}



//alert cards charts
function alert_cards()
{

    $db = connect_db();
    $sql = "SELECT DISTINCT(cards_orders.order_id), workers.username AS worker_name FROM `cards_orders`, workers WHERE DATE(cards_orders.inserted_date) < DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND cards_orders.status < 4 AND workers.worker_id = cards_orders.coworker_id";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}





function card_orders_chart($time, $user)
{


    switch ($time)
    {
        case 1:
            $group = "GROUP BY YEAR(Date)";
            break;

        case 2:
            $group = "GROUP BY MONTH(Date)";
            break;

        case 3:
            $group = "GROUP BY DAY(Date)";
            break;
    }
    if($user != 0)
        $where = " AND coworker_id=".$user;
    else
        $where="";

    $db = connect_db();
    $sql = "SELECT COUNT(DISTINCT order_id) AS number_order, date(inserted_date) Date  FROM orders, status WHERE  orders.inserted_date >= now()-interval 12 month $where ".$group;
    //"SELECT date(inserted_date) Date , COUNT(DISTINCT order_id)  AS number_orders  from orders WHERE inserted_date >= now()-interval 12 month $where ".$group;
    $exe = $db->query($sql);
    $cards = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    header('Content-Type: application/json');
    $arr = array('cards'=> $cards);

    echo json_encode($arr);
    exit;
}



function leads_cards_chart($time)
{
    switch ($time)
    {
        case 1:
            $group = "GROUP BY YEAR(Date)";
            break;

        case 2:
            $group = "GROUP BY MONTH(Date)";
            break;

        case 3:
            $group = "GROUP BY DAY(Date)";
            break;
    }

    $db = connect_db();
    $sql = "SELECT date(inserted_date) Date, TIMESTAMPDIFF(HOUR, `inserted_date`, `complete_date`) AS lead_time FROM cards_orders WHERE complete_date != '0000-00-00 00:00:00' $group ";
    $exe = $db->query($sql);
    $assembly = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    header('Content-Type: application/json');
    $arr = array('assembly'=> $assembly);

    echo json_encode($arr);
    exit;
}





function leads_assembly_chart($time)
{
    switch ($time)
    {
        case 1:
            $group = "GROUP BY YEAR(Date)";
            break;

        case 2:
            $group = "GROUP BY MONTH(Date)";
            break;

        case 3:
            $group = "GROUP BY DAY(Date)";
            break;
    }

    $db = connect_db();
    $sql = "SELECT date(inserted_date) Date, TIMESTAMPDIFF(HOUR, `inserted_date`, `complete_date`) AS lead_time FROM orders WHERE complete_date != '0000-00-00 00:00:00' $group ";
    $exe = $db->query($sql);
    $assembly = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    header('Content-Type: application/json');
    $arr = array('assembly'=> $assembly);

    echo json_encode($arr);
    exit;
}




function orders_chart($time, $user)
{


    switch ($time)
    {
        case 1:
            $group = "GROUP BY YEAR(Date)";
            break;

        case 2:
            $group = "GROUP BY MONTH(Date)";
            break;

        case 3:
            $group = "GROUP BY DAY(Date)";
            break;
    }
    if($user != 0)
         $where = " AND coworker_id=".$user;
    else
        $where="";

    $db = connect_db();
    $sql = "SELECT date(inserted_date) Date , COUNT(DISTINCT order_id)  AS number_orders  from orders WHERE inserted_date >= now()-interval 12 month $where ".$group;
    $exe = $db->query($sql);
    $assembly = $exe->fetch_all(MYSQLI_ASSOC);
    /*$sql = "SELECT date(inserted_date) Date , COUNT(DISTINCT order_id) AS number_orders   from cards_orders WHERE inserted_date >= now()-interval 12 month $where ".$group;

    $exe = $db->query($sql);
    $cards = $exe->fetch_all(MYSQLI_ASSOC);*/

    $db = null;
    header('Content-Type: application/json');
    $arr = array('assembly'=> $assembly);

    echo json_encode($arr);
    exit;
}



function cards_order_status($user)
{
    if($user != 0)
        $where = " AND coworker_id=".$user;
    else
        $where="";

    $db = connect_db();
    $sql = "SELECT COUNT( DISTINCT cards_orders.order_id) AS number, status.name AS status FROM cards_orders, status WHERE cards_orders.status = status.status_id AND cards_orders.inserted_date >= now()-interval 12 month $where GROUP BY cards_orders.status";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $arr = array('data' => $data);
    $db = null;
    header('Content-Type: application/json');

    echo json_encode($arr);
    exit;

}


function cards_scanned($id)
{
    $db = connect_db();
    $sql = "SELECT  card_id from cards_scanned WHERE card_id = '$id' ";

    $exe = $db->query($sql);
    $data = $rowcount=mysqli_num_rows($exe);
    $db = null;
    header('Content-Type: application/json');

    if ($data)
    {
        echo '{"response":true}';
        exit;
    }
    else{
        echo '{"response":false}';
        exit;
    }

    exit;
}

//get card order status
function card_order_status($id)
{
    $db = connect_db();
    $sql = "SELECT  confirmed from cards_orders WHERE order_id = '$id' GROUP BY confirmed";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    header('Content-Type: application/json');

    echo json_encode($data[0]);
    exit;
}


function online_assembly_status($user)
{
    if($user != 0)
        $where = " AND coworker_id=".$user;
    else
        $where="";

    $db = connect_db();
    $sql = "SELECT COUNT( DISTINCT orders.order_id) AS number, status.name AS status FROM orders, status WHERE orders.status = status.status_id AND orders.inserted_date >= now()-interval 12 month $where GROUP BY orders.status";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $arr = array('data' => $data);
    $db = null;
    header('Content-Type: application/json');

    echo json_encode($arr);
    exit;
}

function closed_cards($user)
{
    if($user != 0)
        $where = " AND coworker_id=".$user;
    else
        $where="";

    $db = connect_db();
    $sql = "SELECT COUNT( DISTINCT order_id) FROM cards_orders WHERE (status = 4 OR status = 5) AND inserted_date >= now()-interval 12 month $where ";
    $exe = $db->query($sql);
    $data = $exe->fetch_all();
    $data = $data[0];
    $closed = $data[0];
    $sql = "SELECT COUNT( DISTINCT order_id)  FROM cards_orders WHERE (status != 4 AND status != 5) AND inserted_date >= now()-interval 12 month $where ";

    $exe = $db->query($sql);
    $data = $exe->fetch_all();
    $data = $data[0];
    $not_closed = $data[0];

    $db = null;
    header('Content-Type: application/json');
    $arr = array('not_closed'=> $not_closed ,'closed' => $closed);

    echo json_encode($arr);
    exit;
}


function closed_assembly($user)
{

    if($user != 0)
        $where = " AND coworker_id=".$user;
    else
        $where="";

    $db = connect_db();
    $sql = "SELECT COUNT( DISTINCT order_id) FROM orders WHERE (status = 4 OR status = 5) AND inserted_date >= now()-interval 12 month $where ";
    $exe = $db->query($sql);
    $data = $exe->fetch_all();
    $data = $data[0];
    $closed = $data[0];
    $sql = "SELECT COUNT( DISTINCT order_id)  FROM orders WHERE (status != 4 AND status != 5) AND inserted_date >= now()-interval 12 month $where ";

    $exe = $db->query($sql);
    $data = $exe->fetch_all();
    $data = $data[0];
    $not_closed = $data[0];

    $db = null;
    header('Content-Type: application/json');
    $arr = array('not_closed'=> $not_closed ,'closed' => $closed);

    echo json_encode($arr);
    exit;

}


// get user role
function user_role($id)
{
    $db = connect_db();
    $sql = "SELECT role FROM workers where worker_id='$id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $data = $data[0];
    $db = null;
    echo json_encode($data); exit;
}

function is_rated($order_id, $product_id)
{

    $db = connect_db();
    $sql = "SELECT id FROM product_rating where order_id='$order_id' and product_id='$product_id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    if(empty($data))
        echo "false";
    else
        echo "true";

    $db = null;
    exit;
}



// get product list
function get_product() {
    $db = connect_db();
    $sql = "SELECT * FROM products";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data); exit;
}



function get_tags()
{
    $db = connect_db();
    $sql = "SELECT * FROM rating_tags";
    mysqli_set_charset($db,"utf8mb4");
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    header('Content-Type: application/json', 'charset=utf8mb4');
    echo json_encode($data); exit;
}


//get one card
function one_card($id)
{
    $db = connect_db();
    $sql = "SELECT * FROM cards where id=$id";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    if(!empty($data))
        $data = $data[0];
    $db = null;
    echo json_encode($data); exit;
}



// get cards list
function get_cards() {
    $db = connect_db();
    $sql = "SELECT * FROM cards";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $arr = array('cards'=> $data);
    $db = null;
    echo json_encode($arr); exit;
}


// get assembly order list
function get_assembly_order( $page, $limite) {



    $start = ($page - 1) * $limite;


    $db = connect_db();
    $sql = "SELECT  DISTINCT(order_id) FROM orders";
    $exe = $db->query($sql);
    $rowcount=mysqli_num_rows($exe);
    $nbPages = ceil($rowcount / $limite);

    $sql = "SELECT DISTINCT(orders.order_id),  orders.customer_id,orders.isell_number,  orders.remark, orders.assembly_date,orders.inserted_date, orders.complete_date,  workers.username AS Assigned, status.name AS status  FROM orders, workers, status, products WHERE workers.worker_id = orders.coworker_id AND orders.product_number= products.product_id AND orders.status = status.status_id ORDER BY  `inserted_date` DESC LIMIT $limite OFFSET $start ";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    //$data = $data[0];
    header('Content-Type: application/json');
    $arr = array('totalOrder'=> $rowcount ,'totalPage' => $nbPages, 'curPage' => (int)$page, 'pageSize' =>  $limite, 'assembles' => $data);

    echo json_encode($arr);

    exit;
}


function cards_cart($userID)
{
    $db = connect_db();
    $sql = "SELECT cards_cart.card_id, cards_cart.price, cards_cart.units AS quantity, cards.stock AS stock, cards.picture AS picture, cards.name AS name from cards_cart, cards WHERE cards_cart.card_id=cards.id AND  customer_id='$userID'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $arr = array('user_id'=> $userID, 'cart'=> $data);
    echo json_encode($arr);

    exit;
}


// get cards order list
function get_cards_order( $page, $limite) {
    $start = ($page - 1) * $limite;


    $db = connect_db();
    $sql = "SELECT  DISTINCT(order_id) FROM cards_orders";
    $exe = $db->query($sql);
    $rowcount=mysqli_num_rows($exe);

    $nbPages = ceil($rowcount / $limite);

    $sql = "SELECT cards_orders.order_id,  cards_orders.customer_id,  cards_orders.remark, 
            cards_orders.complete_date,cards_orders.inserted_date,  workers.username AS Assigned, status.name AS status, cards_orders_details.customer_name AS customer_name,
             cards_orders_details.address AS address, cards_orders_details.zip AS zip, SUM(price) AS total, SUM(cards_orders.units) AS total_cards
            FROM cards_orders, workers, status, cards, cards_orders_details WHERE workers.worker_id = cards_orders.coworker_id AND cards_orders.card_id= cards.id 
            AND cards_orders.status = status.status_id AND cards_orders_details.order_id=cards_orders.order_id GROUP BY order_id  ORDER BY  `inserted_date` DESC LIMIT $limite OFFSET $start ";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $db = null;
    //$data = $data[0];
    // header('Content-Type: application/json');
    $arr = array('totalOrder'=> $rowcount ,'totalPage' => $nbPages, 'curPage' => (int)$page, 'pageSize' =>  $limite, 'cards_orders' => $data);

    echo json_encode($arr);

    exit;
}


//get single card order information
function get_card_order_id($order_id) {

    $db = connect_db();
    $sql = "SELECT cards_orders.*,  workers.username AS Assigned, status.name AS status , cards.name  AS card_name, cards.picture AS picture
      FROM cards_orders, workers, status, cards WHERE workers.worker_id = cards_orders.coworker_id AND cards_orders.status = status.status_id 
        AND cards_orders.card_id= cards.id AND `order_id` = '$order_id' ORDER BY `order_id`";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT * from cards_orders_details WHERE  order_id='$order_id'";
    $exe = $db->query($sql);
    $details = $exe->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT * from cards_orders_payment WHERE  order_id='$order_id'";
    $exe = $db->query($sql);
    $payment = $exe->fetch_all(MYSQLI_ASSOC);
    $sql = "SELECT date from cards_logs WHERE  order_id='$order_id' GROUP BY order_id";
    $exe = $db->query($sql);
    $lastUpdate = $exe->fetch_all(MYSQLI_ASSOC);

    $arr = array('last_update'=>$lastUpdate[0]["date"], 'Assigned'=>$data[0]["Assigned"] ,'delivery_date'=>$data[0]["delivery_date"], 'status' =>$data[0]["status"] , 'order_id' =>$data[0]["order_id"], 'customer_id' =>$data[0]["customer_id"],
        'inserted_date' =>$data[0]["inserted_date"], 'customer_name'=>$details[0]["customer_name"] ,'recipient'=>$details[0]["recipient"],'city'=>$details[0]["city"] ,'address'=>$details[0]["address"] ,'zip'=>$details[0]["zip"],
        'tracking_number'=>$details[0]["tracking_number"], 'phone'=>$details[0]["phone"],'remark' =>$data[0]["remark"],'method' =>$payment[0]["method"], 'payment_name' =>$payment[0]["name"],
        'transaction_number' =>$payment[0]["transaction_number"], 'invoice_title' =>$payment[0]["invoice_title"] , 'tax_id' =>$payment[0]["tax_id"], 'bank_number' =>$payment[0]["bank_number"] , 'bank_name' =>$payment[0]["bank_name"],
        'invoice_status' =>$payment[0]["invoice_status"], 'data'=> $data);
    header('Content-Type: application/json');
    //$data = $data[0];
    echo json_encode($arr);
    $db = null;
    exit;
}



function get_history($customer_id, $page)
{
    $start = ($page - 1) * 10;
    $db = connect_db();
    $sql = "SELECT * FROM  browsing_history WHERE user_id='$customer_id' ORDER BY date DESC LIMIT 10 OFFSET $start  ";
    
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $stmt2 = $db->prepare("SELECT * FROM  browsing_history WHERE user_id='$customer_id'  ");
    $stmt2->execute();
    $count = $stmt2->get_result();

    $rowcount=mysqli_num_rows($count);

    $nbPages = ceil($rowcount / 10);



    $arr = array( 'totalOrder'=> $rowcount ,'totalPage' => $nbPages, 'curPage' => (int)$page  ,  'customer_id' =>$customer_id,
        'data'=> $data);
    header('Content-Type: application/json');
    //$data = $data[0];
    echo json_encode($arr);
    $db = null;
    exit;
}



//get order by user ID
function user_card_order($customer_id, $page)
{

    $start = ($page - 1) * 5;
    $db = connect_db();
    $sql = "SELECT DISTINCT (cards_orders.order_id),   cards_orders.inserted_date, cards_orders.complete_date ,status.name AS status   FROM cards_orders, status  WHERE  cards_orders.status = status.status_id AND `customer_id` = '$customer_id' ORDER BY inserted_date DESC LIMIT 5 OFFSET $start  ";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);


    $stmt2 = $db->prepare("SELECT DISTINCT (cards_orders.order_id)  FROM cards_orders   WHERE   `customer_id` = '$customer_id'  ");
    $stmt2->execute();
    $count = $stmt2->get_result();

    $rowcount=mysqli_num_rows($count);

    $nbPages = ceil($rowcount / 5);






    $arr = array( 'totalOrder'=> $rowcount ,'totalPage' => $nbPages, 'curPage' => (int)$page  ,  'customer_id' =>$customer_id,
        'data'=> $data);
    header('Content-Type: application/json');
    //$data = $data[0];
    echo json_encode($arr);
    $db = null;
    exit;
}



//get sigle product information
function get_assembly_order_id($order_id) {

    $db = connect_db();
    $sql = "SELECT orders.*,  workers.username AS Assigned, status.name AS status, products.assembly_price AS assembly_price , products.product_name  AS product_name  FROM orders, workers, status, products WHERE workers.worker_id = orders.coworker_id AND orders.status = status.status_id AND orders.product_number= products.product_id AND `order_id` = '$order_id' ORDER BY `order_id`";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $arr = array('Assigned'=>$data[0]["Assigned"] ,'assembly_date'=>$data[0]["assembly_date"], 'status' =>$data[0]["status"] , 'order_id' =>$data[0]["order_id"], 'customer_id' =>$data[0]["customer_id"],
        'isell_number' =>$data[0]["isell_number"], 'isell_date' =>$data[0]["isell_date"], 'inserted_date' =>$data[0]["inserted_date"], 'remark' =>$data[0]["remark"], 'data'=> $data);
    header('Content-Type: application/json');
    //$data = $data[0];
    echo json_encode($arr);
    $db = null;
    exit;
}

//get sigle product information
function get_product_id($product_id) {

    $db = connect_db();
    $sql = "SELECT assembly_price FROM products WHERE `product_id` = '$product_id'";;
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    if (count($data) == 0) {
        header('Content-Type: application/json');
        echo json_encode (json_decode ("{}"));
    }
    else
    {
        $data = $data[0];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    $db = null;
    exit;
}


//get sigle company information
function get_company_id($company_id) {
    $db = connect_db();
    $sql = "SELECT * FROM company WHERE `company_id` = '$company_id'";;
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;

    echo json_encode($data);
    exit;
}



/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory directory to which the file is moved
 * @param UploadedFile $uploaded file uploaded file to move
 * @return string filename of moved file
 */
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{

    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

    $basename = bin2hex(random_bytes(8));

    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}


function update_card($data, $uploadedFile)
{
    $stock = $data["stock"];
    $name = $data["name"];
    $id = $data["id"];
    $description = $data["description"];
    $picture ="";

    $flag =0;
    $update="";
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

        $filename = moveUploadedFile('/var/www/html/oms/slim/uploads', $uploadedFile);

        $picture ='http://www.wpic.oms.com/uploads/'. $filename;
    }

    if ($stock != "") {
        if ($flag == 0) {
            $update .= "  stock = $stock";
            $flag = 1;
        }
        else
            $update .= ",  stock = $stock";
    }
    if ($name != "") {
        if ($flag == 0) {
            $update .= "  name = '$name'";
            $flag = 1;
        }
        else
            $update .= ",  name = '$name'";
    }
    if ($picture != "") {
        if ($flag == 0) {
            $update .= "  picture = '$picture'";
            $flag = 1;
        }
        else
            $update .= ", picture = '$picture'";
    }

    if ($description != "") {
        if ($flag == 0) {
            $update .= "  description = '$description'";
            $flag = 1;
        }
        else
            $update .= ", description = '$description'";
    }

    $db = connect_db();

    $sql = "update cards SET $update"
        . " WHERE id = '$id'";


    $exe = $db->query($sql);
    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows))
        echo "Update card success";
    exit;
}

//add card
function add_card($data, $uploadedFile)
{

    $stock = $data["stock"];
    $name = $data["name"];
    $picture ="";

    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

        $filename = moveUploadedFile('/var/www/html/oms/slim/uploads', $uploadedFile);

        $picture ='http://www.wpic.oms.com/uploads/'. $filename;
    }

    $db = connect_db();
    $sql = "insert into cards (name,stock, picture)"
        . " VALUES('$name', $stock, '$picture')";

    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    if (!empty($last_id))
     {
        echo '{"response":"success"}';
        exit;
    }
    else{
        echo '{"response":"failed"}';
        exit;
    }

}


//add rating
function add_rating($data)
{

    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());

    $db = connect_db();
    foreach ( $data["products"] as $single) {
        $sql = "insert into product_rating (user_id,product_id,rate, date, name, phone, com, order_id)"
            . " VALUES('$data[user_id]','$single[product_id]','$single[rate]','$date','$data[name]','$data[phone]','$single[com]','$data[order_id]')";

        $exe = $db->query($sql);
        $last_id = $db->insert_id;

        if (!empty($last_id)) {
            echo "Add rating done";
            if (!empty($single["tags"])) {
                foreach ($single["tags"] as $tag) {
                    $sql = "insert into product_tags (rating_id,tag_id)"
                        . " VALUES($last_id, $tag)";
                    $exe = $db->query($sql);
                }

            }
        }
    }
    $db = null;
    exit;
}

//add rating
function add_history($data)
{


    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());

    $db = connect_db();
    $sql = "insert into browsing_history (user_id,product_id,url, date, product_name)"
        . " VALUES('$data[user_id]','$data[product_id]','$data[url]','$date', '$data[product_name]')";


    $exe = $db->query($sql);
    $last_id = $db->insert_id;

    if (!empty($last_id)) {
        echo "Add rating done";

    }
    $db = null;
    exit;
}
//add user
function add_user($data)
{

    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());

    $db = connect_db();
    $sql = "insert into workers (worker_id,username,role, email,password,department, create_time)"
        . " VALUES('$data[worker_id]','$data[username]','$data[role]','$data[email]','$data[password]','$data[department]', '$date')";

    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    $db = null;
    if (!empty($last_id))
        echo "Add user success, userid is ". $last_id;
    exit;
}

//assign order to coworker

function assign_coworker($orderId, $date, $scope)
{

    $db = connect_db();
    $sql = "SELECT * FROM worker_schedule WHERE `date` > '$date' AND `department`= '$scope' AND `booked`< 10 order by date";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);

    foreach ($data as $single) {

        $sql = "UPDATE orders SET coworker_id=".$single["worker_id"]." WHERE order_id ='$orderId'";
        $exe = $db->query($sql);
        $sql = "UPDATE worker_schedule SET booked= booked +1 WHERE id =".$single["id"];
        $exe = $db->query($sql);
        exit;
    }
}


//add order
function add_order($data) {


    $customerId = $data["customer_id"];
    $orderId = $data["order_id"];
    $db = connect_db();
    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());

    foreach ($data["details"] as $details)
    {

        $idProduct = $details["id_product"];
        $product_units = $details["product_unit"];
        $sql = "insert into orders (order_id,customer_id,product_number, remark, status, coworker_id, inserted_date, product_units)"
            . " VALUES('$orderId','$customerId','$idProduct', '', 1, 1, '$date', $product_units)";

        $exe = $db->query($sql);

        $action  = "Order ".$orderId . " has been created";
        $sql = "insert into assembly_logs (worker_id, action , date, order_id)"
            . " VALUES('1','$action','$date', '$orderId')";

        $exe = $db->query($sql);
    }

    $last_id = $db->insert_id;
    assign_coworker($orderId, $date, 1);
    $db = null;
    if (!empty($last_id)) {
        //echo "Add Product success, companyid is " . $last_id;
        header("Status: 200");
        exit;
    }
    else
    {
        header("Status: 400");
        exit;
    }
}

// update card cart
function update_card_cart($data)
{
    $customerId = $data["user_id"];

    $db = connect_db();
    foreach ($data["products"] as $product)
    {

        $cardId = $product["card_id"];
        $product_units = $product["quantity"];
        $price = $product["price"];

       $sql = "update cards_cart set units = $product_units, price=$price  where customer_id='$customerId' AND card_id='$cardId'";


        $exe = $db->query($sql);
        $action  = "Cart for user  ".$customerId . " has been created";

    }


    $last_id = $db->insert_id;

    if (!empty($last_id) || $exe) {
        //echo "Add Product success, companyid is " . $last_id;
        header("Status: 200");
        exit;
    }
    else
    {
        header("Status: 400");
        exit;
    }
    $db = null;
}

//add card to cart
function add_card_cart($data) {


    $customerId = $data["user_id"];

    $db = connect_db();
    foreach ($data["products"] as $product)
    {

        $cardId = $product["card_id"];
        $product_units = $product["quantity"];
        $price = $product["price"];

        $sql = "SELECT * from cards_cart where customer_id='$customerId' AND card_id='$cardId' AND price = $price ";
        $exe = $db->query($sql);
        $row = $exe->fetch_all();

        if(count($row) == 0)
         $sql = "insert into cards_cart (customer_id,card_id, units, price)"
                . " VALUES('$customerId','$cardId', $product_units, $price) ";
         else
            $sql = "update cards_cart set units = units+$product_units where customer_id='$customerId' AND card_id='$cardId' AND price = $price";

        $exe = $db->query($sql);
        $action  = "Cart for user  ".$customerId . " has been created";

    }


    $last_id = $db->insert_id;

    if (!empty($last_id) || $exe) {
        //echo "Add Product success, companyid is " . $last_id;
        header("Status: 200");
        exit;
    }
    else
    {
        header("Status: 400");
        exit;
    }
    $db = null;
}



//confirm cart order
function confirm_card_order($data)
{
    $db = connect_db();
    foreach ($data["orders"] as $order)
    {
        $order_id = $order["order_id"];
        $sql = "UPDATE cards_orders SET confirmed=1 WHERE order_id='$order_id'";
        $exe = $db->query($sql);
    }
    $rows = $db->affected_rows;


    if (!empty($rows)) {
        //echo "Add Product success, companyid is " . $last_id;
        header("Status: 200");
        exit;
    }
    else
    {
        header("Status: 400");
        exit;
    }
    $db = null;
    exit;
}

function get_card_payment($order_id)
{
    $db = connect_db();
    $sql = "SELECT cards_orders_payment.*, invoice_status.name AS invoice_status_name FROM cards_orders_payment, invoice_status  WHERE cards_orders_payment.invoice_status = invoice_status.id AND cards_orders_payment.order_id='$order_id'";

    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    if ($data[0])
        $data = $data[0];
    echo json_encode($data);
    $db = null;
    exit;
}



// add card payment info
function add_card_payment($data, $order_id)
{

    $db = connect_db();
    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());
    $sql = "insert into cards_orders_payment (method,total, name, transaction_number, invoice_title, tax_id, bank_number, bank_name, order_id, date)"
        . " VALUES('$data[method]','$data[total]', '$data[name]', '$data[transaction_number]', '$data[invoice_title]', '$data[tax_id]', '$data[bank_number]', '$data[bank_name]', '$order_id', '$date')";

    $exe = $db->query($sql);
    $last_id = $db->insert_id;

    if (!empty($last_id)) {
        //echo "Add Product success, companyid is " . $last_id;
        header("Status: 200");
        exit;
    }
    else
    {
        header("Status: 400");
        exit;
    }
    $db = null;

}

//add order
function add_card_order($data) {


    $customerId = $data["customer_id"];

    $db = connect_db();
    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());
    $orderId =uniqid();

    $sql = "insert into cards_orders_details (customer_name, recipient , city,address,zip ,order_id, phone)"
        . " VALUES('$data[customer_name]','$data[recipient]','$data[city]', '$data[address]','$data[zip]', '$orderId', '$data[phone]')";

    foreach ($data["details"] as $details)
    {

        $idProduct = $details["id_product"];
        $product_units = $details["product_unit"];
        $price = $details["price"];

        $sql = "insert into cards_orders (customer_id,card_id, remark, status, coworker_id, inserted_date, units, price, order_id)"
            . " VALUES('$customerId','$idProduct', '', 1, 1, '$date', $product_units, $price, '$orderId')";

        $exe = $db->query($sql);



        $sql2 = "UPDATE cards SET stock = stock -$product_units WHERE id = $idProduct";

        $exe = $db->query($sql2);
    }

    $sql = "insert into cards_orders_details (customer_name, recipient , city,address,zip ,order_id, phone)"
        . " VALUES('$data[customer_name]','$data[recipient]','$data[city]', '$data[address]','$data[zip]', '$orderId', '$data[phone]')";

    $exe = $db->query($sql);



    $action  = "Order ".$orderId . " has been created";
    $sql = "insert into cards_logs (worker_id, action , date, order_id)"
        . " VALUES('1','$action','$date', '$orderId')";

    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    assign_coworker($orderId, $date, 2);

    if (!empty($last_id)) {
        //echo "Add Product success, companyid is " . $last_id;
        header("Status: 200");
        exit;
    }
    else
    {
        header("Status: 400");
        exit;
    }
    $db = null;
}

// search order
function search_order($dataR, $page, $limite)
{

    $start = ($page - 1) * $limite;
    $db = connect_db();


    $order_id = $dataR["order_id"];
    $article_number = $dataR["article_number"];
    $isell_number = $dataR["isell_number"];
    $status = $dataR["status"];
    $assigned = $dataR["assigned"];

    $created_date = $dataR["created_date"];

    $search = "";
    if ($order_id != "")
        $search .= " AND orders.order_id = '$order_id'";
    if ($article_number != "")
        $search .= " AND orders.product_number = '$article_number'";
    if ($isell_number != "")
        $search .= " AND orders.isell_number = '$isell_number'";
    if ($status != "")
        $search .= " AND orders.status = $status";
    if ($assigned != "")
        $search .= " AND orders.coworker_id = $assigned";
    if ($created_date != "") {
        $dates = explode(" to ", $created_date);
        $search .= " AND orders.inserted_date  between '$dates[0]' and '$dates[1]'";
    }



    $stmt = $db->prepare("SELECT DISTINCT(orders.order_id), orders.customer_id,orders.isell_number,  orders.remark, orders.assembly_date,orders.inserted_date, workers.username AS Assigned, status.name AS status FROM orders, workers, status WHERE workers.worker_id = orders.coworker_id AND orders.status = status.status_id ".$search." ORDER BY  `inserted_date` DESC LIMIT $limite OFFSET $start ");

    // $stmt->bind_param("ss", $customer_id, $article_number);

    $stmt->execute();

    $exe = $stmt->get_result();
    $stmt2 = $db->prepare("SELECT DISTINCT(orders.order_id), orders.customer_id,orders.isell_number,  orders.remark, orders.assembly_date,orders.inserted_date, workers.username AS Assigned, status.name AS status FROM orders, workers, status WHERE workers.worker_id = orders.coworker_id AND orders.status = status.status_id ".$search." ORDER BY  `inserted_date` DESC");
    $stmt2->execute();
    $count = $stmt2->get_result();

    $rowcount=mysqli_num_rows($count);

    $nbPages = ceil($rowcount / $limite);

    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $arr = array('totalOrder'=> $rowcount ,'totalPage' => $nbPages, 'curPage' => (int)$page, 'pageSize' =>  $limite, 'assembles' => $data);
    echo json_encode($arr);
    die;

}


// search card order
function search_card_order($dataR, $page, $limite)
{



    $start = ($page - 1) * $limite;
    $db = connect_db();


    $order_id = $dataR["order_id"];
    $status = $dataR["status"];
    $assigned = $dataR["Assigned"];
    $customerId = $dataR["customer_id"];

    $created_date = $dataR["created_date"];

    $search = "";
    if ($order_id != "")
        $search .= " AND cards_orders.order_id = '$order_id'";
    if ($status != "")
        $search .= " AND cards_orders.status = $status";
    if ($assigned != "")
        $search .= " AND cards_orders.coworker_id = $assigned";
    if ($customerId != "")
        $search .= " AND cards_orders.customer_id = $customerId";
    if ($created_date != "") {
        $dates = explode(" to ", $created_date);
        $search .= " AND cards_orders.inserted_date  between '$dates[0]  00:00:00' and '$dates[1]  23:59:59'";
    }




    $stmt = $db->prepare("SELECT DISTINCT(cards_orders.order_id), cards_orders.customer_id,  cards_orders.remark,cards_orders.inserted_date, workers.username AS Assigned, status.name AS status FROM cards_orders, workers, status WHERE workers.worker_id = cards_orders.coworker_id AND cards_orders.status = status.status_id ".$search." ORDER BY  `inserted_date` DESC LIMIT $limite OFFSET $start ");
    /*var_dump("SELECT DISTINCT(cards_orders.order_id), cards_orders.customer_id,  cards_orders.remark,cards_orders.inserted_date, workers.username AS Assigned, status.name AS status FROM cards_orders, workers, status WHERE workers.worker_id = cards_orders.coworker_id AND cards_orders.status = status.status_id ".$search." ORDER BY  `inserted_date` DESC LIMIT $limite OFFSET $start ");
die;*/
    $stmt->execute();

    $exe = $stmt->get_result();
    $stmt2 = $db->prepare("SELECT DISTINCT(cards_orders.order_id), cards_orders.customer_id,  cards_orders.remark,cards_orders.inserted_date, workers.username AS Assigned, status.name AS status FROM cards_orders, workers, status WHERE workers.worker_id = cards_orders.coworker_id AND cards_orders.status = status.status_id ".$search." ORDER BY  `inserted_date` DESC");
    $stmt2->execute();
    $count = $stmt2->get_result();

    $rowcount=mysqli_num_rows($count);

    $nbPages = ceil($rowcount / $limite);

    $data = $exe->fetch_all(MYSQLI_ASSOC);

    $arr = array('totalOrder'=> $rowcount ,'totalPage' => $nbPages, 'curPage' => (int)$page, 'pageSize' =>  $limite, 'cards_orders' => $data);
    echo json_encode($arr);
    die;

}


function export_txt($dataR)
{
    $db = connect_db();
    $txt  = "";
    foreach ($dataR as $single)
    {
        $sql = "SELECT card_id, card_number FROM cards_orders WHERE order_id='".$single["order_id"]."'";
        $stmt = $db->prepare($sql);

        $stmt->execute();
        $exe = $stmt->get_result();
        $data = $exe->fetch_all(MYSQLI_ASSOC);
        foreach ($data as $one)
        {
            if ($one["card_number"] != "")
            {
                $numbers = explode(',', $one["card_number"]);
                foreach ($numbers as $number)
                {
                    $txt.=$single["order_id"]." ". $one["card_id"]. " ". $number."\n";
                }
            }
        }


    }
    echo $txt;
  //  var_dump($dataR);
    die;
}



function rating_search($dataR   )
{

    $db = connect_db();


    //$dataR =$dataR[0];
    $rate_min = $dataR["rate_min"];
    $rate_max = $dataR["rate_max"];
    $tags = $dataR["tags"];
    $date_range = $dataR["date_range"];


    $search = "";
    if ($rate_min != "")
        $search .= " AND pr.rate >= $rate_min";
    if ($rate_max != "")
        $search .= " AND pr.rate <= $rate_max";
    if (!empty($tags)) {
        $ids = join("','",$tags);
        $search .= " AND product_tags.tag_id IN ( '$ids')";
    }
    if ($date_range != "") {
        $dates = explode(" to ", $date_range);
        $search .= " AND pr.date  between '$dates[0]  00:00:00' and '$dates[1]  23:59:59'";
    }

    /*$sql = "SELECT DISTINCT pr.*, (SELECT IF( (SELECT pt.tag_id FROM product_tags pt WHERE pt.tag_id = 1 AND pt.rating_id = pr.id ) IS NULL , 0, 1)) AS Tag_1, (SELECT IF( (SELECT pt.tag_id FROM product_tags pt WHERE pt.tag_id = 2 AND pt.rating_id = pr.id ) IS NULL , 0, 1)) AS Tag_2 FROM product_rating pr, product_tags, rating_tags WHERE rating_tags.id = product_tags.tag_id ".$search." ORDER BY  `date` DESC";
    var_dump($sql);
    die;*/

    $stmt = $db->prepare("SELECT DISTINCT pr.*, (SELECT IF( (SELECT pt.tag_id FROM product_tags pt WHERE pt.tag_id = 1 AND pt.rating_id = pr.id ) IS NULL , 0, 1)) AS Tag_1, (SELECT IF( (SELECT pt.tag_id FROM product_tags pt WHERE pt.tag_id = 2 AND pt.rating_id = pr.id ) IS NULL , 0, 1)) AS Tag_2 FROM product_rating pr, product_tags, rating_tags WHERE rating_tags.id = product_tags.tag_id ".$search." ORDER BY  `date` DESC");


    $stmt->execute();

    $exe = $stmt->get_result();

    $data = $exe->fetch_all(MYSQLI_ASSOC);
    //Get the column names.
    $columnNames = array();
    $fp = fopen('php://output', 'w');
    if(!empty($data)){
        //We only need to loop through the first row of our result
        //in order to collate the column names.
        $firstRow = $data[0];
        foreach($firstRow as $colName => $val){
            $columnNames[] = $colName;
        }
    }

    fputcsv($fp, $columnNames, ";");

    foreach ($data as $row) {

        fputcsv($fp, $row, ";");
    }
    header("Content-type: application/csv");
    /*       header("Content-Disposition: attachment; filename=test.csv");
   */
    //var_dump('LA');
    exit;
}




// update user
function update_user($data) {
    $db = connect_db();
    $sql = "update user SET user_name = '$data[user_name]',birth = '$data[birth]',country='$data[country]',region = '$data[region]',company = '$data[company]'"
        . " WHERE user_id = '$data[user_id]'";
    $exe = $db->query($sql);
    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows))
        echo "Update user success";
    exit;
}






// update card order
function update_card_order($dataR, $id) {


    $status = $dataR["status"];
    $assigned = $dataR["Assigned"];
    $remark = $dataR["remark"];
    $userEdit = $dataR["user_edit"];
    $notification = $dataR["remark_notify"];
    $tracking_number = $dataR["tracking_number"];
    $update = "";
    $details = "";
    $flag = 0;

    if ($status != "") {
        if ($flag == 0) {
            $update .= "  status = $status";
            $flag = 1;
        }
        else
            $update .= ",  status = $status";
        $details .= " change status to ".$status;
    }
    if ($assigned != "") {
        if ($flag == 0) {
            $update .= "  coworker_id = $assigned";
            $flag = 1;
        }
        else
            $update .= ",  coworker_id = $assigned";
        $details .= " change Assigner Worker ID  to ".$assigned;
    }
    if ($remark != "") {
        if ($flag == 0) {
            $update .= "  remark = '$remark'";
            $flag = 1;
        }
        else
            $update .= ", remark = '$remark'";
        $details .= " change Remarks  to ".$remark;
    }
    
    $db = connect_db();
    $action = "";
    date_default_timezone_set('Asia/Shanghai');
    $date = date('Y-m-d H:i:s', time());
    foreach ($dataR['cards_number'] as $card) {
        if (isset($card["id"]) && isset($card["number"])) {
            $sql = "update cards_orders SET card_number='" . $card["number"] . "' WHERE id = '" . $card["id"] . "'";

            $exe = $db->query($sql);
            if ($card["number"] && $card["number"] != "")
            {

            $action = "Cards " . $card["number"] . " has been added ";
            $sql = "insert into cards_logs (worker_id, action , date, order_id)"
                . " VALUES($userEdit,'$action','$date', '$id') ";

            $exe = $db->query($sql);
            }
        }
    }
    $sql = "update cards_orders_details SET tracking_number='$tracking_number' WHERE order_id = '$id'";

    $exe = $db->query($sql);

    //$action  = "Values  ".$update . " has been updated by user ".$userEdit;
    if($details != "") {
        $sql = "insert into cards_logs (worker_id, action , date, order_id)"
            . " VALUES($userEdit,'$details','$date', '$id') ";

        $exe = $db->query($sql);
    }
    if($status == 5 || $status == 4)
        $update .= ", complete_date = '$date'";
    $sql = "update cards_orders SET $update"
        . " WHERE order_id = '$id'";
    $exe = $db->query($sql);



    if ($notification != "")
    {

        $sql = "insert into notifications (order_id, worker_id, scope, date)"
            . " VALUES ('$id', '$notification', 2, '$date')";

        $exe = $db->query($sql);
    }

    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows) && $dataR != NULL) {
        echo '{"response":"success"}';
        exit;
    }
    else{
        echo '{"response":"failed"}';
        exit;
    }
}



















// update assembly order
function update_assembly_order($dataR, $id) {


    $isell_number = $dataR["isell_number"];
    $status = $dataR["status"];
    $assigned = $dataR["Assigned"];
    $assembly_date = $dataR["assembly_date"];
    $remark = $dataR["remark"];
    $userEdit = $dataR["user_edit"];
    $notification = $dataR["remark_notify"];

    $update = "";
    $details = "";
    $flag = 0;
    if ($isell_number != "") {
        if ($flag == 0) {
            $update .= "  isell_number = '$isell_number'";
            $flag = 1;
        }
        else
            $update .= ",  isell_number = $isell_number";

        $details .= " change isell number to ".$isell_number;
    }
    if ($status != "") {

        if ($flag == 0) {
            $update .= "  status = $status";
            $flag = 1;
        }
        else
            $update .= ",  status = $status";

        $details .= " change status to ".$status;
    }
    if ($assigned != "") {
        if ($flag == 0) {
            $update .= "  coworker_id = $assigned";
            $flag = 1;
        }
        else
            $update .= ",  coworker_id = $assigned";
        $details .= " change Assigner Worker ID  to ".$assigned;
    }
    if ($assembly_date != "") {
        if ($flag == 0) {
            $update .= "  assembly_date = '$assembly_date'";
            $flag = 1;
        }
        else
            $update .= ",  assembly_date = '$assembly_date'";
        $details .= " change Assembly Date  to ".$assembly_date;
    }
    if ($remark != "") {
        if ($flag == 0) {
            $update .= "  remark = '$remark'";
            $flag = 1;
        }
        else
            $update .= ", remark = '$remark'";
        $details .= " change Remarks  to ".$remark;
    }
    $db = connect_db();
    $date = date('Y-m-d H:i:s', time());
    $action  = "Values  ".$update . " has been updated by user ".$userEdit;
    $sql = "insert into assembly_logs (worker_id, action , date, order_id)"
        . " VALUES($userEdit,'$details','$date', '$id') ";

    $exe = $db->query($sql);


    if($status == 5 || $status == 4)
        $update .= ", complete_date = '$date'";
    $sql = "update orders SET $update"
        . " WHERE order_id = '$id'";
    $exe = $db->query($sql);



    if ($notification != "")
    {

        $sql = "insert into notifications (order_id, worker_id, scope, date)"
            . " VALUES ('$id', '$notification', 1, '$date')";

        $exe = $db->query($sql);
    }

    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows) && $dataR != NULL) {
        echo '{"response":"success"}';
        exit;
    }
    else{
        echo '{"response":"failed"}';
        exit;
    }
}

// delete user
function delete_user($user) {
    $db = connect_db();
    $sql = "DELETE FROM user WHERE user_id = '$user[user_id]'";
    $exe = $db->query($sql);
    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows)) {
        echo '{"response":"success"}';
        exit;
    }
    else{
        echo '{"response":"failed"}';
        exit;
    }
}


function delete_card_cart($data)
{
    $customerID = $data['user_id'];
    $card_id = $data['card_id'];
    $price = $data['price'];
    $db = connect_db();
    $sql = "DELETE FROM cards_cart WHERE customer_id='$customerID'  AND card_id='$card_id' AND price = $price";

    $exe = $db->query($sql);
    $rows = $db->affected_rows;
    $db = null;
    if (!empty($rows))
        echo "Delete Card success";
    exit;
}



function delete_card($card) {
    $db = connect_db();
    $sql = "DELETE FROM cards WHERE id = $card";

    $exe = $db->query($sql);
    $rows = $db->affected_rows;
    $db = null;

        if (!empty($rows)) {
            echo '{"response":"success"}';
            exit;
        }
        else{
            echo '{"response":"failed"}';
            exit;
        }
    exit;
}



?>
