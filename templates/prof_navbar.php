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
    if(basename($_SERVER['PHP_SELF']) == "index.php")
    {
        echo "<!-- HTML for a horzintal navbar with 3 options -->
        <div class='navbar'>
        </div>";
    }
    else
    {
        echo "<!-- HTML for a horzintal navbar with 3 options -->
        <div class='navbar'>
          <a href='prof_page1.php'>Forms</a>
        </div>";
    }
?>
