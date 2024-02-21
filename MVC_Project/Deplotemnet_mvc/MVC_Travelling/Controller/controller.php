<?php
// echo  "called controller";

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

require_once("Model/model.php");

class controller extends model
{
    public $baseURL = "http://localhost/PHP/PHP_MVC/MVC_Travelling/Public/";

    public $mail = "";
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        ob_start();
        parent::__construct();
        // echo "<pre>";
        // print_r($_SERVER);
        // echo "</pre>";


        // $this->baseURL="http://localhost/php/Work/PHP_MVC/Travelling/Public/";
        if (isset($_SERVER['PATH_INFO'])) {
            switch ($_SERVER['PATH_INFO']) {
                case '/home':
                    include_once("Views/header.php");
                    include_once("Views/home.php");
                    include_once("Views/footer.php");
                    break;
                case '/about':
                    include_once("Views/header.php");
                    include_once("Views/about.php");
                    include_once("Views/footer.php");
                    break;
                case '/service':
                    include_once("Views/header.php");
                    include_once("Views/services.php");
                    include_once("Views/footer.php");
                    break;
                case '/package':
                    include_once("Views/header.php");
                    include_once("Views/pacakges.php");
                    include_once("Views/footer.php");
                    break;

                case '/booking':
                    include_once("Views/header.php");
                    include_once("Views/booking.php");
                    include_once("Views/footer.php");
                    break;
                case '/destination':
                    include_once("Views/header.php");
                    include_once("Views/destination.php");
                    include_once("Views/footer.php");
                    break;
                case '/team':
                    include_once("Views/header.php");
                    include_once("Views/travelguide.php");
                    include_once("Views/footer.php");
                    break;
                case '/testimonial':
                    include_once("Views/header.php");
                    include_once("Views/testimonial.php");
                    include_once("Views/footer.php");
                    break;
                case '/404':
                    include_once("Views/header.php");
                    include_once("Views/error.php");
                    include_once("Views/footer.php");
                    break;
                case '/forgotpassword':
                    // include_once("Views/header.php");
                    include_once("Views/admin/forgotpassword.php");
                    // echo $_REQUEST;
                    print_r($_REQUEST);

                    // include_once("Views/footer.php");
                    break;
                case '/sendmail':
                    // include_once("Views/header.php");
                    include_once("Views/admin/adminsendmail.php");
                    if (isset($_POST['send-otp'])) {
                        $mailexists =  $this->select("users", array("email" => $_POST['email']));
                        if ($mailexists['Code'] == 1) {

                            $email = $_POST['email'];
                            $otp = random_int(100000, 999999);
                            $msg = "Youy OTP is : $otp";
                            $this->update("users", array("OTP" => $otp), array("email" => $email));
                            // $this->mailsend($email, $msg);

                            header("location:forgotpassword?email=$email");
                        } else {
                            echo "<script>alert('This Email IS Not Exists....')</script>";
                        }
                    }

                    // include_once("Views/footer.php");
                    break;
                case '/contact':
                    include_once("Views/header.php");
                    include_once("Views/contact.php");
                    include_once("Views/footer.php");
                    break;
                case '/login':
                    include_once("Views/header.php");

                    include_once("Views/login.php");
                    include_once("Views/footer.php");

                    if (isset($_REQUEST['btn-login'])) {
                        // print_r($_REQUEST);
                        $loginres = $this->login($_REQUEST['username'], $_REQUEST['password']);

                        // echo "<pre>";
                        // print_r($loginres);
                        // exit;

                        if ($loginres['Code'] == 1) {
                            // echo "inside if true auth";
                            $_SESSION['userdata'] = $loginres['Data'];

                            // echo "<pre>";
                            // print_r($_SESSION['userdata']);
                            // print_r($loginres['Data']->roll_id);
                            // exit;
                            if ($loginres['Data']->roll_id == 1) {
                                header("location:admindashboard");
                            } else {
                                header("location:login");
                                # code...
                            }
                        } else {
                            // echo "inside else inavalid user";
                        }
                    }
                    break;

                case '/register':
                    include_once("Views/header.php");
                    include_once("Views/register.php");
                    include_once("Views/footer.php");
                    if (isset($_REQUEST['register'])) {
                        array_pop($_POST);
                        $hobbyData = implode(",", $_POST['chk']);
                        unset($_POST['chk']);
                        // echo $hobbyData;

                        $data = array_merge($_POST, array("	hobby" => $hobbyData));

                        // echo "<pre>";
                        // print_r($data);
                        // echo "</pre>";
                        // exit;
                        $inserdata = $this->insert("users", $data);
                        // echo "<pre>";
                        // print_r($inserdata);
                        // echo "</pre>";
                        if ($inserdata['Code'] == 1) {
                            header("location:login");
                            //     echo "  <script>
                            //   alert('register success')
                            //   window.location.href='login'
                            //   </script>";
                        }
                    }
                    break;
                case '/admindashboard':
                    include_once("Views/admin/adminheader.php");
                    include_once("Views/admin/admindashboard.php");
                    include_once("Views/admin/adminfooter.php");
                    break;

                case '/adminallusers':

                    // $allUsers = $this->select("users");

                    // $allUsers = $this->selectjoin("users", array("cities_data" => "cities_data.cityid=users.city"));

                    // $allusers = $this->select("users", array("roll_id" => 2));

                    $allUsers = $this->selectjoin("users", array("cities_data" => "cities_data.cityid=users.city"));


                    // echo "<pre>";
                    // print_r($allUsers);
                    // echo "</pre>";
                    // exit;
                    include_once("Views/admin/adminheader.php");
                    include_once("Views/admin/adminallusers.php");
                    include_once("Views/admin/adminfooter.php");
                    break;


                case '/edit':
                    $EditRes = $this->select("users", array("id" => $_GET['userid']));


                    // $EditRes = $this->selectjoin("users", array("cities_data" => "cities_data.cityid=users.city"), array("id" => $_GET['userid']));


                    $CitiesData  = $this->select("cities_data");
                    // echo "<pre>";
                    // print_r($EditRes['Data']);
                    // echo "</pre>";
                    // exit;
                    include_once("Views/admin/adminheader.php");
                    include_once("Views/admin/adminedituser.php");
                    include_once("Views/admin/adminfooter.php");


                    if (isset($_POST['update'])) {

                        // echo "<pre>";
                        // print_r($_FILES);
                        // echo "</pre>";
                        if ($_FILES['prof_pic']['error'] == 0) {
                            // echo "inside if";
                            $target_dir = "Upload/";
                            $target_file = $target_dir . basename($_FILES["prof_pic"]["name"]);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $allowedTypes = ['jpg', 'png'];
                            // echo $imageFileType;
                            // exit;
                            if (!in_array($imageFileType, $allowedTypes)) {
                                $msg = "Type is not allowed";
                            } else {


                                $target_file = $target_dir . basename($_FILES["prof_pic"]["name"]);
                                move_uploaded_file($_FILES["prof_pic"]["tmp_name"], $target_file);

                                $profilepic = $_FILES["prof_pic"]["name"];
                                $msg = "success";
                            }
                        } else {
                            // echo "inside else";
                            $profilepic = $_REQUEST['old_profile_pic'];
                            // $msg = "no file";
                        }
                        // exit;

                        // echo $profilepic;

                        $hobbyData = implode(",", $_POST['hobby']);
                        array_pop($_POST);
                        unset($_POST['hobby']);
                        unset($_POST['old_profile_pic']);
                        // echo $hobbyData;
                        $data = array_merge($_POST, array("hobby" => $hobbyData, "prof_pic" => $profilepic));
                        // echo "<pre>";
                        // print_r($data);
                        // echo "</pre>";


                        // exit;

                        $UpdateRes = $this->update("users", $data, array("id" => $_GET['userid']));

                        echo "<pre>";
                        print_r($UpdateRes);
                        echo "</pre>";


                        if ($UpdateRes['Code'] == 1) {
                            header("location:adminallusers");
                        }
                    }
                    break;

                case '/delete':
                    // echo "called";
                    // exit;
                    $usersdeleteresponse = $this->delete("users", array("id" => $_GET['userid']));

                    $DeleteRes = $this->delete("users", array("id" => $_GET['userid']));
                    if ($DeleteRes['Code'] == 1) {
                        header("location:adminallusers");
                    }

                    break;

                case '/logout':
                    session_destroy();
                    header("location:login");
                    break;
            }
        } else {
            header("location:home");
        }

        ob_flush();
    }
    function mailsend($email, $msg)

    {

        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = 'komalvadariya0802@gmail.com';                     //SMTP username
            $this->mail->Password   = 'aufzdxetetutswri';                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->mail->setFrom('komalvadariya0802@gmail.com', 'komal');
            $this->mail->addAddress($email, 'user');     //Add a recipient
            // $this->mail->addAddress('ellen@example.com');               //Name is optional
            $this->mail->addReplyTo('komalvadariya0802@gmail.com', 'Information');
            // $this->mail->addCC('cc@example.com');
            // $this->mail->addBCC('bcc@example.com');

            //Attachments
            // $this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'forgot password otp';
            $this->mail->Body    = $msg;
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}


$controller = new controller;

// echo "<pre>";
// print_r ($_SERVER);
// echo "</pre>";
