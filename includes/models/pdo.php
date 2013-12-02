<?php
/**
 * Name:        Php Data Objects based Database Abstraction Layer
 * Description: Sets up connections to the database through the pdo.
 * Date:        12/2/13
 * Programmer:  Liam Kelly
 */

//Inlcudes
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'includes/models/protected_settings.php');

class db{

    //Variables

        //Connection Related
        public $db_name = '';   //Set in constructor
        public $db_host = '';   //Set in constructor
        public $db_user = '';   //Set in constructor
        public $db_pass = '';   //Set in constructor
        public $dbc = '';       //Set in connect()

        //Control Related
        public $results = '';
        public $fail = false;
        public $errors = '';

    //Constructor
    public function __construct(){

        //Define connection credentials

            //Fetch protected settings
            $set = new protected_settings;
            $settings = $set->fetch();

            //Define the creds
            $this->db_name = $settings['db_name'];
            $this->db_host = $settings['db_host'];
            $this->db_user = $settings['db_user'];
            $this->db_pass = $settings['db_pass'];

        //Connect to the database
        $this->connect();

    }

    //Function connect()
    public function connect(){

        //Attempt to connect to the database
        try {

            $this->dbc = new PDO('mysql:host=localhost;dbname='.$this->db_name, $this->db_user, $this->db_pass);
            $this->dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){

            $this->errors = $this->errors."\r\n".$e->getMessage();
            $this->fail = true;

        }

    }

    //Function sanitize
    public function sanitize($data){

        //Make sure we have not failed
        if($this->fail == false){

            return $this->dbc->quote($data);

        }else{

            return false;

        }

    }

    //Function Query
    public function query($query){

        //Make sure we have not failed
        if($this->fail == false){

            //Attempt to query the database
            try{

                $this->results =  $this->dbc->query($query);

            }catch(PDOException $e){

                $this->errors = $this->errors.$e->getMessage();
                $this->fail = true;

            }

            //Check for failures (again)
            if($this->fail == false){

                //Make sure the pdo returned an object
                if(is_object($this->results)){

                    while($row = $this->results->fetchALL()) {	//fetch assoc array
                        $array[] = $row;
                    }

                }else{

                    //In the event $this->results is not an object
                    return false;

                }

                //Check for an empty results array
                if(!(empty($array))){

                    //We have results, so return them
                    return $array;	//return results

                }else{

                    //No results, array was empty
                    return false;

                }

            }else{

                //If the query failed
                return false;

            }

        }else{

            //If we failed before calling this function
            return false;

        }

    }

    //Function close
    public function close(){

        //Nullify the connection
        unset($this->dbc);

        //Return true
        return true;

    }

    //Function get_errors()
    public function get_errors(){

        //Check for errors
        if(!(empty($this->errors))){

            //Spit out any error messages
            echo "<br />".$this->errors."<br />";

        }

    }

    //Function Destruct
    public function __destruct(){

        //Destroy the connection
        $this->close();

    }

}
