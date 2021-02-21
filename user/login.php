<?php


// For login


function wordpress_custom_login_form($username, $password) {
    global $username, $password;

    echo '
    <style>
    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:10px;
    }

    .mx-auto{
        margin:auto;
    }
    </style>
    ';

    // var_dump(get_current_user_id());
   echo '
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="mx-auto">
    <div class="form-group">
    <label>Username Or Email <strong>*</strong></label> <br>
    <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '"><br>

    </div>
    <div class="form-group">
    <label>Password <strong>*</strong></label><br>
    <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '"><br>
    <br>
    </div>
    <input type="submit" name="submit" style="background-color: #dd9933; border-color: #dd9933;" value="Login"/>
    </form>
    ';

}
function wp_log_form_valid( $username, $password)  {
    global $customize_error_validation;
    $customize_error_validation = new WP_Error;
    if ( empty( $username ) || empty( $password ) ) {
        $customize_error_validation->add('field', ' Please Fill the field of the login form');
    }
    // if ( username_exists( $username ) )
    //     $customize_error_validation->add('user_name', ' User Already Exist');
    if ( is_wp_error( $customize_error_validation ) ) {
        foreach ( $customize_error_validation->get_error_messages() as $error ) {
         echo '<strong>Hold</strong>:';
         echo $error . '<br/>';
        }
    }
}
 
function wordpress_user_login_form_completion() {
    global $customize_error_validation, $username, $password;
    if ( 1 > count( $customize_error_validation->get_error_messages() ) ) {

        // die($password);
        $userdata = array(
         'user_login' =>   $username,
         'user_email' =>   $email,
         'user_pass' =>   $password,
 
        );
        // if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
        //     $userdata
        // }
        // else {
        //     // it's not valid so do something else
        // }

        // mail($email, 'Please Verify Your Account', 'Please click on the link below to verify your acount');
        // $user = wp_insert_user( $userdata );
        // die($userdata['user_pass']);

        if ($user=model('User')->login($userdata['user_login'], $userdata['user_pass'])) {
            CreateUserSession($user);

            redirect(get_site_url());
        } else {
            echo 'Invalid Login Details';
        }
        
        
    }
}

 function CreateUserSession($user)
{
    $_SESSION['user_id'] = $user->ID;
    $_SESSION['email'] = $user->user_email;
    $_SESSION['user_name'] = $user->display_name;
    $_SESSION['usertype'] = $user->account_no;
}

function wordpress_custom_login_form_function() {
    global $first_name, $last_name,$username, $password, $email ;
    if ( isset($_POST['submit'] ) ) {
        wp_log_form_valid(
         $_POST['username'],
         $_POST['password']
       );
 
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        // $email   =   sanitize_email( $_POST['email'] );
       wordpress_user_login_form_completion(
         $username,
         $password
        );
    }
    wordpress_custom_login_form(
        $username,
        $password
    );
}
 
add_shortcode( 'wp_login_form', 'wp_custom_shortcode_login' );
 
function wp_custom_shortcode_login() {
    ob_start();
    wordpress_custom_login_form_function();
    return ob_get_clean();
}
 
// Custom Validation Field Method
// add_filter( 'login_errors', 'custom_validation_error_method', 10, 2 );
// function custom_validation_error_method( $errors, $lname, $last_name ) {
 
//     if ( empty( $_POST['fname'] ) || ( ! empty( $_POST['fname'] ) && trim( $_POST['fname'] ) == '' ) ) {
//         $errors->add( 'fname_error', __( '<strong>Error</strong>: Enter Your First Name.' ) );
//     }
 
//     if ( empty( $_POST['lname'] ) || ( ! empty( $_POST['lname'] ) && trim( $_POST['lname'] ) == '' ) ) {
//         $errors->add( 'lname_error', __( '<strong>Error</strong>: Enter Your Last Name.' ) );
//     }
//     return $errors;
// }
