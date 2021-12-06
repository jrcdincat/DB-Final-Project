<!-- CSS for a horzintal navbar with 3 options -->
<style>
.navbar {
  overflow: hidden;
  background-color: #333;
  display: block;
  width: 100%;
  height: 50px;
}
.navbar a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}
.navbar a:hover {
  background-color: #ddd;
  color: black;
}
</style>

<?php
    if(basename($_SERVER['PHP_SELF']) == "staff.php" ||
      basename($_SERVER['PHP_SELF']) == "staff_password.php")
    {
        echo "<!-- HTML for a horzintal navbar with 3 options -->
        <div class='navbar'>
        <a href='index.php'>Professor Login</a>
        <a href='staff.php'>Staff Login</a>
        </div>";
    }
    else
    {
        echo "<!-- HTML for a horzintal navbar with 3 options -->
        <div class='navbar'>
          <a href='staffhome.php'>Home</a>
          <a href='staff_page1.php'>Admin Management</a>
          <a href='staff_page2.php'>Faculty Management</a>
          <a href='staff_upcomingsemester.php'>Upcoming Semester's Book Request</a>
          <a href='staff_bookrequests.php'>Additional Book Requests</a>
          <a href='?sign_out' name='sign_out'>Sign Out</a>
        </div>";
    }

    if (isset($_GET['sign_out']))
    {
      foreach ($_COOKIE as $key=>$val)
      {
        if(isset($_COOKIE[$key])):
          setcookie($key, '', time()-7000000, '/');
        endif;
      }
      header('Location: staff.php');
    }

?>

