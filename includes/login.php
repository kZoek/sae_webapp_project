<?php 
require_once("../core/init.php");
$errorHandler = new ErrorHandler;
$checkDB = new DBfunctions($pdo);
// chekc if the POST is set
if(!empty($_POST)){
    // var_dump($_POST);
    // echo $_SESSION['userId'] ;
    // response array, wich will be send back to frontend
    $responseArr = [
        'errors' =>[

        ],
        'logindata' =>[

        ]
    ];
    // create new instance from validator
    $validator = new Validator($errorHandler);
    $validation = $validator->check($_POST,[
        'username' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3
        ],
        'password' =>[
            'required' => true,
            'minlenght' => 6
        ]
     ]);
    // if the validation of some input fails, save error messages in response array
     if($validation->fails()){
        $errors = $validation->errors()->all();
        foreach($errors as $error){
            foreach($error as $message){
                array_push($responseArr['errors'], $message);
            }
        }
     }else{
        // echo '<p> </p>';
        // echo 'successful login ';
        // echo $_SESSION['userId'] ;
        // echo $_POST['username'];

        // if all inputs are good, compare DB and password
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);
        /**
         * fetchSingle and fetchAll awaits 2 parameters
         * @param $query -> query wich should be executed
         * @param $params -> array, with parameters for prepared statements
         */
        $loginComp = $checkDB->fetchSingle("SELECT * from `users` WHERE username = :user",['user' => $username]);
        // var_dump($loginComp);
        // echo $loginComp['id'];
        $_SESSION['userId'] = $loginComp['id'];
        if($loginComp){
            if(password_verify($password,$loginComp['password'])){
                // echo 'successful login';
                $_SESSION['status'] = true;
                $_SESSION['userId'] = $loginComp['id'];
                // echo $_SESSION['userId'] ;

                // if all check are good, send the userid to the frontend
                array_push($responseArr['logindata'], $_SESSION['userId']);
            }else{
                // if the password not matches, get errormessage
                $_SESSION['userId'] = 0;
                array_push($responseArr['errors'],'wrong password');
            }
        }else{
            // if the user is not in DB, get errormessage
            array_push($responseArr['errors'],'User not found');
        }
    }
}
echo json_encode($responseArr);
?>