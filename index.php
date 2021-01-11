<?php
require_once("config.php");
require_once("protect.php");
require_once("protect-exec.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
</head>
<body>
<h2>PHP Telegram message sender</h2>
<p>How are you?</p>

<?php if(!empty($response)) { ?>
	<p><?php echo $response; ?></p>
<?php } ?>

<div class="container">
  <form method="post" action="send.php">
    <div class="row">
      <div class="col-25">
        <label for="target">Target</label>
      </div>
      <div class="col-75">
        <select id="target" name="target" required>
          <option value="">Select one</option>
<?php foreach($targets as $target_key => $target) { ?>
          <option value="<?php echo $target_key; ?>"><?php echo $target["title"]; ?></option>
<?php } ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="subject">Message</label>
      </div>
      <div class="col-75">
        <textarea id="message" name="message" placeholder="Write something.." style="height:200px" required></textarea>
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>
<p><a href="logout.php">Logout</a> | It's "PHP Telegram message sender", written by <a href="https://alihardan.github.io/">Ali Hardan</a>.</p>
</body>
</html>
