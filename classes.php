<?php
abstract class User
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $image;
    protected $password;
    public $created_at;
    public $updated_at;

    function __construct($id, $name, $email, $phone, $image, $password, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->image = $image;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }





    public static function login($email, $password)
    {

        $user = null;
        $qry = "SELECT * FROM USERS WHERE email='$email' AND PASSWORD='$password'";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        if ($arr = mysqli_fetch_assoc($rslt)) {
            switch ($arr["role"]) {
                case 'subscriber':
                    $user = new Subscriber($arr["id"], $arr["name"], $arr["email"], $arr["phone"], $arr["image"], $arr["password"], $arr["created_at"], $arr["updated_at"]);
                    break;
                case 'admin':
                    $user = new Admin($arr["id"], $arr["name"], $arr["email"], $arr["phone"], $arr["image"], $arr["password"], $arr["created_at"], $arr["updated_at"]);
                    break;
            }
        }
        mysqli_close($cn);
        return $user;
    }
}



class Subscriber extends User
{

    public $role = "subscriber";

    public static function register($name, $email, $password, $phone)
    {
        $qry = "INSERT INTO  USERS(name ,email, password,phone) 
        values('$name','$email','$password','$phone')";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function stor_post($tite, $content, $imageName, $user_id)
    {
        $qry = "INSERT INTO POSTS(title,content,image,user_id) 
        values('$tite','$content','$imageName',$user_id)";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function my_posts($user_id)
    {
        $qry = "SELECT * FROM POSTS WHERE user_id=$user_id ORDER BY created_at DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        return $data;
    }
    public function home_posts()
    {
        $qry = "SELECT * FROM POSTS join users on posts.user_id= users.id ORDER BY posts.created_at DESC limit 10";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        return $data;
    }


    public function update_profile_pic($imagepath, $user_id)
    {
        $qry = "UPDATE USERS SET IMAGE='$imagepath' where id=$user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }

    public function get_post_comment($post_id)
    {
        $qry = "SELECT * FROM comments join users on comments.user_id=users.id WHERE post_id=$post_id ORDER BY comments.created_at DESC";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }



    public function store_comment($comment, $post_id, $user_id)
    {
        $qry = "INSERT INTO comments(comment,post_id,user_id) 
        values('$comment',$post_id,$user_id)";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
}


class Admin extends User
{

    public $role = "admin";

    function  get_all_users()
    {
        $qry = "SELECT * FROM USERS ORDER BY created_at";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        $data = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
        mysqli_close($cn);
        return $data;
    }

    function Delete_Account($user_id)
    {
        $qry = "DELETE FROM USERS where id=$user_id";
        require_once('config.php');
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);
        return $rslt;
    }
}