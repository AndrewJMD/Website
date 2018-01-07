<?php
$page_title = 'Register';
include('includes/head.php');
include('includes/header.php');
?>

<h1 class="title">Register</h1>

<section class="register-section">
  <form class="register-form">
    <label for="firstname">First Name</label><br />
    <input type="text" id="firstname" name="firstname" />
    <br />
    <label for="week">Week</label><br />
    <select id="week">
      <option value="1">Week One</option>
      <option value="2">Week Two</option>
    </select>
    <br />
    <label for="coverletter">Tell Us About Yourself</label><br/>
    <textarea id="coverletter" rows="6" cols="50">
    </textarea>
    <br />
    <input type="submit" value="Apply" />
  </form>
</section>

<?php include('includes/footer.php'); ?>
