<?php
header("Access-Control-Allow-Origin: *");
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

// API group
$app->group('/api', function () use ($app) {

    // User Group
    $app->group('/users', function () use ($app) {
        //Get All Users
        $app->get('', function(Request $request, Response $response){
            $sql = "SELECT * FROM User";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($users);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get All Users
        $app->get('/employee', function(Request $request, Response $response){
            $sql = "SELECT * FROM User WHERE userType = 'employee'";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($users);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        // Get Single User By UserId
        $app->get('/userId/{userId}', function(Request $request, Response $response){
            $ui = $request->getAttribute('userId');
            $sql = "SELECT * FROM User WHERE userId = '$ui'";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $user = $stmt->fetch(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($user);
            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        // Get Single User By UserName
        $app->get('/userName/{userName}', function(Request $request, Response $response){
            $un = $request->getAttribute('userName');
            $sql = "SELECT * FROM User WHERE userName = '$un'";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $user = $stmt->fetch(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($user);
            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });
        
        // Add User
        $app->post('/add', function(Request $request, Response $response){
            $requestData = json_decode(file_get_contents('php://input'));           
            $firstName = $requestData->firstName;
            $lastName =  $requestData->lastName; 
            $userName =  $requestData->userName; 
            $phone =  $requestData->phone; 
            $email =  $requestData->email; 
            $gender =  $requestData->gender; 
            $age =  $requestData->age; 
            $userType =  $requestData->userType; 
            $password =  $requestData->password; 
            
            $sql = "INSERT INTO user (firstName,lastName,userName,email,phone,gender,age,userType,password) VALUES
            (:firstName,:lastName,:userName,:email,:phone,:gender,:age,:userType,:password)";

            try{
                $db = new db();
                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName',  $lastName);
                $stmt->bindParam(':userName',$userName);
                $stmt->bindParam(':email',      $email);
                $stmt->bindParam(':phone',      $phone);
                $stmt->bindParam(':gender',      $gender);
                $stmt->bindParam(':age',      $age);
                $stmt->bindParam(':userType',      $userType);
                $stmt->bindParam(':password',      $password);

               
                $stmt->execute();

                echo '{"notice": {"text": "User Added"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        // Update User
        $app->put('/update/{userId}', function(Request $request, Response $response){

            $userId = $request->getAttribute('userId');

            $requestData = json_decode(file_get_contents('php://input'));           
            $firstName = $requestData->firstName;
            $lastName =  $requestData->lastName; 
            $phone =  $requestData->phone; 
            $email =  $requestData->email; 
            $gender =  $requestData->gender; 
            $age =  $requestData->age; 

            $sql = "UPDATE User SET 
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                phone = :phone,
                gender = :gender,
                age = :age
                WHERE userId = :userId";

            try{
                $db = new db();
                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName',  $lastName);
                $stmt->bindParam(':email',      $email);
                $stmt->bindParam(':phone',      $phone);
                $stmt->bindParam(':gender',      $gender);
                $stmt->bindParam(':age',      $age);

                $stmt->bindParam(':userId',      $userId);

               
                $stmt->execute();

                echo '{"notice": {"text": "User Updated"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Delete User
        $app->delete('/delete/{userId}', function(Request $request, Response $response){
            $userId = $request->getAttribute('userId');
            $sql = "DELETE FROM User WHERE userId = :userId";
            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':userId',  $userId);

                $stmt->execute();

                echo '{"notice": {"text": "User Deleted"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });
    }); 

    //Hours Group
    $app->group('/hours', function () use ($app) {
        //Get All Hours
        $app->get('', function(Request $request, Response $response){
            $sql = "SELECT * FROM Hours ORDER BY Date DESC";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sales = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sales);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get Hours By userId
        $app->get('/userId/{userId}', function(Request $request, Response $response){
            $ui = $request->getAttribute('userId');
            $sql = "SELECT * FROM Hours WHERE userId = $ui ORDER BY Date DESC";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sales = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sales);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get Hours By Id
        $app->get('/hoursId/{hoursId}', function(Request $request, Response $response){
            $ui = $request->getAttribute('hoursId');
            $sql = "SELECT * FROM Hours WHERE hoursId = $ui";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sale = $stmt->fetch(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sale);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get Hours Chart
        $app->get('/hourschart', function(Request $request, Response $response){
            $sql = "SELECT SUM(hoursWorked) AS sum, Hours.userId, firstName, lastName 
                FROM Hours INNER JOIN User ON Hours.userId = User.userId
                GROUP BY userId";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sale = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sale);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Add Hours
        $app->post('/add', function(Request $request, Response $response){
            $requestData = json_decode(file_get_contents('php://input'));    

            $hoursWorked =  $requestData->hoursWorked; 
            $date =  $requestData->date; 
            $userId =  $requestData->userId; 
            
            $sql = "INSERT INTO Hours (hoursWorked,date,userId) 
            VALUES (:hoursWorked,:date,:userId)";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':hoursWorked',  $hoursWorked);
                $stmt->bindParam(':date',  $date);
                $stmt->bindParam(':userId',  $userId);

                $stmt->execute();

                echo '{"notice": {"text": "Hours Added"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Update Hours
        $app->put('/update/{hoursId}', function(Request $request, Response $response){
            $hoursId = $request->getAttribute('hoursId');

            $requestData = json_decode(file_get_contents('php://input'));           
            $hoursWorked =  $requestData->hoursWorked; 
            $date = $requestData->date; 

            $sql = "UPDATE Hours SET 
            hoursWorked = :hoursWorked,
            date = :date
            WHERE hoursId = :hoursId";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':hoursWorked',  $hoursWorked);
                $stmt->bindParam(':date',  $date);
                $stmt->bindParam(':hoursId',  $hoursId);

                $stmt->execute();

                echo '{"notice": {"text": "Hours Updated"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Delete Hours
        $app->delete('/delete/{hoursId}', function(Request $request, Response $response){
            $hoursId = $request->getAttribute('hoursId');

            $sql = "DELETE FROM Hours WHERE hoursId = :hoursId";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':hoursId',  $hoursId);

                $stmt->execute();

                echo '{"notice": {"text": "Hours Deleted"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });
    }); 

    //Item Group
    $app->group('/items', function () use ($app) {
        //Get All Items
        $app->get('', function(Request $request, Response $response){
            $sql = "SELECT * FROM Item";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $items = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($items);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get Item By Id
        $app->get('/itemId/{itemId}', function(Request $request, Response $response){
            $itemId = $request->getAttribute('itemId');
            $sql = "SELECT * FROM Item WHERE itemId = '$itemId'";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $item = $stmt->fetch(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($item);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Add Item
        $app->post('/add', function(Request $request, Response $response){
            $requestData = json_decode(file_get_contents('php://input'));           
            $text = $requestData->text;
            $amount =  $requestData->amount; 
            
            $sql = "INSERT INTO Item (text,amount) 
            VALUES (:text,:amount)";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':text', $text);
                $stmt->bindParam(':amount',  $amount);

                $stmt->execute();

                echo '{"notice": {"text": "Item Added"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Update Item
        $app->put('/update/{itemId}', function(Request $request, Response $response){
            $itemId = $request->getAttribute('itemId');

            $requestData = json_decode(file_get_contents('php://input'));           
            $text = $requestData->text;
            $amount =  $requestData->amount; 

            $sql = "UPDATE Item SET 
            text = :text,
            amount = :amount
            WHERE itemId = :itemId";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':text', $text);
                $stmt->bindParam(':amount',  $amount);
                $stmt->bindParam(':itemId',  $itemId);

                $stmt->execute();

                echo '{"notice": {"text": "Item Updated"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Delete Item
        $app->delete('/delete/{itemId}', function(Request $request, Response $response){
            $itemId = $request->getAttribute('itemId');


            $sql = "DELETE FROM Item WHERE itemId = :itemId";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':itemId',  $itemId);

                $stmt->execute();

                echo '{"notice": {"text": "Item Deleted"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });
        
    }); 


    //Sales Group
    $app->group('/sales', function () use ($app) {
        //Get All Sales
        $app->get('', function(Request $request, Response $response){
            $sql = "SELECT * FROM Sale ORDER BY Date DESC";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sales = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sales);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get Sales By User Id
        $app->get('/userId/{userId}', function(Request $request, Response $response){
            $ui = $request->getAttribute('userId');
            $sql = "SELECT * FROM Sale WHERE userId = $ui ORDER BY Date DESC";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sales = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sales);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get Sales By SaleId
        $app->get('/saleId/{saleId}', function(Request $request, Response $response){
            $ui = $request->getAttribute('saleId');
            $sql = "SELECT * FROM Sale WHERE saleId = $ui";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sale = $stmt->fetch(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sale);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Get SalesChart
        $app->get('/saleschart', function(Request $request, Response $response){
            $sql = "SELECT SUM(amount) AS sum, Sale.userId, firstName, lastName 
                FROM Sale INNER JOIN User ON Sale.userId = User.userId
                GROUP BY userId";
            try{
                $db = new db();
                $db = $db->connect();
                $stmt = $db->query($sql);
                $sale = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($sale);
            }
            catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Add Sale
        $app->post('/add', function(Request $request, Response $response){
            $requestData = json_decode(file_get_contents('php://input'));    

            $text = $requestData->text;
            $amount =  $requestData->amount; 
            $date =  $requestData->date; 
            $userId =  $requestData->userId; 
            
            $sql = "INSERT INTO Sale (text,amount,date,userId) 
            VALUES (:text,:amount,:date,:userId)";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':text', $text);
                $stmt->bindParam(':amount',  $amount);
                $stmt->bindParam(':date',  $date);
                $stmt->bindParam(':userId',  $userId);

                $stmt->execute();

                echo '{"notice": {"text": "Sale Added"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Update Sale
        $app->put('/update/{saleId}', function(Request $request, Response $response){
            $saleId = $request->getAttribute('saleId');

            $requestData = json_decode(file_get_contents('php://input'));           
            $text = $requestData->text;
            $amount =  $requestData->amount; 
            $date = $requestData->date; 

            $sql = "UPDATE Sale SET 
            text = :text,
            amount = :amount,
            date = :date
            WHERE saleId = :saleId";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':text', $text);
                $stmt->bindParam(':amount',  $amount);
                $stmt->bindParam(':date',  $date);
                $stmt->bindParam(':saleId',  $saleId);

                $stmt->execute();

                echo '{"notice": {"text": "Sale Updated"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });

        //Delete Sale
        $app->delete('/delete/{saleId}', function(Request $request, Response $response){
            $saleId = $request->getAttribute('saleId');


            $sql = "DELETE FROM Sale WHERE saleId = :saleId";

            try{
                $db = new db();

                $db = $db->connect();

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':saleId',  $saleId);

                $stmt->execute();

                echo '{"notice": {"text": "Sale Deleted"}';

            } catch(PDOException $e){
                echo '{"error": {"text": '.$e->getMessage().'}';
            }
        });
    }); 



}); 





