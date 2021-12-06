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
        <table style="width:100%">
                    <h1>Upcoming Semester's Book Requests (Spring 2022) </h1>
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
                                $sql = "SELECT * FROM forms WHERE semester = 's2022'";
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
                        ?>
                    </tbody>
                    <?php                                     
                        mysqli_close($conn);
                    ?>
                </table>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>