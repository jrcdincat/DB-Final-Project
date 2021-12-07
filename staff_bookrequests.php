<?php
    include('db_connection.php');

    if(!isset($_COOKIE['email']) || $_COOKIE['email'] == "") {
        header("Location: staff.php");
    }

    $email = $_COOKIE['email'];
    //mysqli_close($conn);
?>


<html>
    <!-- Add Jquery Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/navbar.php'); ?>
        <section class="container" style="text-align: center;">
        
        <!-- Create a dropdown that allows the user to select for semester terms like Spring 2022, Summer 2022, Fall 2022, etc. -->
        <form action="staff_bookrequests.php" method="post">
            <select name="term">
                <option value="s2022">Spring 2022</option>
                <option value="su2022">Summer 2022</option>
                <option value="f2022">Fall 2022</option>
                <option value="s2023">Spring 2023</option>
            </select>
            <input type="submit" name="submit" value="Submit">
        </form>
        <table style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:18%">Book Title</th>
                            <th style="width:18%">ISBN</th>
                            <th style="width:18%">Author</th>
                            <th style="width:18%">Publisher</th>
                            <th style="width:18%">Edition</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($_POST['submit'])){
                                $term = $_POST['term'];
                                $copy = $term;
                                // if there's 'su' in term, create a variable that will save 'Summer' + the digits of term
                                // if there's 'f' in term, create a variable that will save 'Fall' + the digits of term
                                // if there's 's' in term, create a variable that will save 'Spring" + the digits of term
                                if(strpos($term, 'su') !== false){
                                    $copy = 'Summer ' . substr($term, 2);
                                }
                                else if(strpos($term, 'f') !== false){
                                    $copy = 'Fall ' . substr($term, 1);
                                }
                                else if(strpos($term, 's') !== false){
                                    $copy = 'Spring ' . substr($term, 1);
                                }
                                


                                echo "<h3>You Selected: $copy</h3>";
                                $sql = "SELECT * FROM forms WHERE semester = '$term'";
                                $results = mysqli_query($conn, $sql);
                                $form_data = mysqli_fetch_all($results, MYSQLI_ASSOC);

                                // Loop through each professor display f_name, l_name, and email
                                foreach ($form_data as $data) {
                                    $formID = $data['formID'];
                                    $sql = "SELECT * FROM books WHERE formID = '$formID'";
                                    $results2 = mysqli_query($conn, $sql);
                                    $book_data = mysqli_fetch_all($results2, MYSQLI_ASSOC);
                                    foreach ($book_data as $book) {
                                        echo "<tr>";
                                        echo "<td>".$book['title']."</td>";
                                        echo "<td>".$book['isbn']."</td>";
                                        echo "<td>".$book['writers']."</td>";
                                        echo "<td>".$book['publisher']."</td>";
                                        echo "<td>".$book['b_edition']."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
 
                        ?>
                    </tbody>
                    <?php                                     
                        mysqli_close($conn);
                    ?>
                </table>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>