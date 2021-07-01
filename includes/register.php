<?php
require_once("../core/init.php");
$errorHandler = new ErrorHandler;
$checkDB = new DBfunctions($pdo);
if(isset($_POST['register']) ){
    // create array for response to the frontend
    $responseArr = [
        'errors' =>[

        ],
        'success' =>[

        ]
    ];
    $regValidator = new Validator($errorHandler);
// create an array for the validation class, what should be validated
    $validation = $regValidator->check($_POST,[
        'Firstname' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3,
        ],
        'Lastname' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3
        ],
        'Username' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3,
            'alnum' => true
        ],
        'Email' =>[
            'required' => true,
            'maxlenght' => 225,
            'email' => true
        ],
        'Password' =>[
            'required' => true,
            'minlenght' => 6
        ]
     ]);
        // check if the validation gives errormessages 
     if($validation->fails()){
        $errors = $validation->errors()->all();
        foreach($errors as $error){
            foreach($error as $message){
                array_push($responseArr['errors'], $message);
            }
        }
        // echo '<pre>'. print_r($validation->errors()->all('regFirstname')) .'<pre>';
     }else{
        // echo 'new user registered ';
        $Firstname = escape($_POST['Firstname']);
        $Lastname = escape($_POST['Lastname']);
        $Username = escape($_POST['Username']);
        $Email = escape($_POST['Email']);
        $Password = escape($_POST['Password']);

        /**
         * fetchSingle and fetchAll awaits 2 parameters
         * @param $query -> query wich should be executed
         * @param $params -> array, with parameters for prepared statements
         */
        $registerComp = $checkDB->fetchAll("SELECT * from `users` WHERE email = :email OR username = :username",
                                            [':email' => $Email, ':username' => $Username]);
        // var_dump($registerComp);
        // if the compare function found something, errormessage
        if($registerComp){
            array_push($responseArr['errors'],' Email adress or Username already taken. ');
        }else{
            $hashpass = password_hash($Password, PASSWORD_DEFAULT);
            // otherwise, register user
              /**
             * createDBcontent awaits 2 parameters - it is used for inster and update
             * @param $query -> query wich should be executed
             * @param $params -> array, with parameters for prepared statements
             */
            $registerUser = $checkDB->createDBcontent(
                "INSERT INTO `users` (`username`, `first_name`, `last_name`, `email`, `password`)
                VALUES
                (:username, :firstname, :lastname, :email, :password)",
                [':username'=>$Username,':firstname'=>$Firstname,':lastname'=>$Lastname,':email'=>$Email,':password'=>$hashpass]
            );
            // echo 'User successfully registered';
            array_push($responseArr['success'],'User successfully registered.');
        }
    }
}
echo json_encode($responseArr);
?>