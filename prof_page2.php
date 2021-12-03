<?php

    // Set visibility of add new books form
    $is_add_book_visible = false;
    if(isset($_POST['open_new_book_form']))
    {
        $is_add_book_visible = true;
    }
    if(isset($_POST['close_add_new_book_form']))
    {
        $is_add_book_visible = false;
    }
?>

<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section style="text-align: center;">

            <!-- Table -->
            <form class="table-form" action="prof_page2.php" method="POST">
            <h1>
                <?php echo "Books"; ?>
            </h1>
            <div style="overflow: auto;">
                <table style="width:100%">
                    <tr>
                        <th style="width: 3%;"></th>
                        <th style="width:18%">Title</th>
                        <th style="width:18%">Author(s)</th>
                        <th style="width:18%">Edition</th>
                        <th style="width:18%">Publisher</th>
                        <th style="width:18%">ISBN</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="check[]" value="..."></td>
                        <td>Test Title</td>
                        <td>Test Author</td>
                        <td>Test Edition</td>
                        <td>Test Publisher</td>
                        <td>Test ISBN</td>
                    </tr>
                </table>
            </div>
            </form>

            <!-- Button Options -->
            <form action="prof_page2.php" method="POST">
                <button name="open_new_book_form" class="btn-options" type="submit" class="btn">Add New Book</button>
                <button name="delete_books" class="btn-options" type="submit" class="btn" style="top: 355px;">Delete Books</button>
                <button name="delete_form" class="btn-options" type="submit" class="btn" style="top: 410px;">Delete Form</button>
            </form>

            <!-- Add new books popup -->
            <div class="form-popup" id="add_book_form" <?php if($is_add_book_visible){echo 'style="display:inline;"';}?>>
                <form action='prof_page2.php' method="POST" class="form-container">
                    <h1>Add Book</h1>

                    <label for="Title"><b>Title</b></label>
                    <input type="text" placeholder="Enter Title" name="title">

                    <label for="Author(s)"><b>Author(s)</b></label>
                    <input type="text" placeholder="Enter Author(s)" name="authors">

                    <label for="Edition"><b>Edition</b></label>
                    <input type="text" placeholder="Enter Edition" name="edition">

                    <label for="Publisher"><b>Publisher</b></label>
                    <input type="text" placeholder="Enter Publisher" name="publisher">

                    <label for="ISBN"><b>ISBN</b></label>
                    <input type="text" placeholder="Enter ISBN" name="isbn">

                    <button type="submit" class="btn">Add</button>
                    <form action="prof_page2.php" method="POST">
                        <button name="close_add_new_book_form" type="submit" class="btn cancel">Cancel</button>
                    </form>
                </form>
            </div>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>