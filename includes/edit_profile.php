<?php 
require_once("../core/init.php");
$errorHandler = new ErrorHandler;
$checkDB = new DBfunctions($pdo);
// check if POST is set 
if(!empty($_POST)){
    // var_dump($_POST);
    // array, wich will be send back to the frondend
    $responseArr = [
        'errors' =>[

        ],
        'success' =>[

        ]
    ];
    // create new instance from Validator
    $validator = new Validator($errorHandler);
    $validation = $validator->check($_POST,[
        'firstname' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3,
        ],
        'lastname' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3
        ],
        'username' =>[
            'required' => true,
            'maxlenght' => 20,
            'minlenght' => 3,
            'alnum' => true
        ],
        'email' =>[
            'required' => true,
            'maxlenght' => 225,
            'email' => true
        ],
        'oldpassword' =>[
            'required' => true,
            'minlenght' => 6
        ],
        'new_password' =>[
            'required' => true,
            'minlenght' => 6
        ]
     ]);
    // if the validation got errors, push those in to the response array
     if($validation->fails()){
        $errors = $validation->errors()->all();
        foreach($errors as $error){
            foreach($error as $message){
                array_push($responseArr['errors'], $message);
            }
        }
     }else{
        //  create variables for inputs
        $firstname = escape($_POST['firstname']);
        $lastname = escape($_POST['lastname']);
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $oldpassword = escape($_POST['oldpassword']);
        $password = escape($_POST['new_password']);
        // hash new password
        $haspass = password_hash($password,PASSWORD_DEFAULT);
        // get user from DB to check password
        /**
         * fetchSingle and fetchAll awaits 2 parameters
         * @param $query -> query wich should be executed
         * @param $params -> array, with parameters for prepared statements
         */
        $DBpass = $checkDB->fetchSingle("SELECT * from `users` WHERE username = :user",['user' => $username]);
        // if the pass is correct update data in DB
        if(password_verify($oldpassword,$DBpass['password'])){
             /**
             * createDBcontent awaits 2 parameters - it is used for inster and update
             * @param $query -> query wich should be executed
             * @param $params -> array, with parameters for prepared statements
             */
            $checkDB->createDBcontent(
                "UPDATE `users` SET username = :username, first_name = :firstname, last_name = :lastname,
                email = :email, password = :pass WHERE id = :id ",
                ['username' => $username,'firstname' => $firstname,'lastname' => $lastname,
                'email' => $email,'pass' => $haspass, 'id' =>$_SESSION['userId']]
            );
            // add success message to the array
            array_push($responseArr['success'], 'Informations saved!');
        }else{
            // add error message to the array
            array_push($responseArr['errors'], 'current password is wrong');
        }
      
        
    }
}
// send the created array back to frontend
echo json_encode($responseArr);

?>