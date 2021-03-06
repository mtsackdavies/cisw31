<!--Replaced all instances of 'isbn' with 'item_num'-->

<?php

function do_html_header($title = '') {
  // print an HTML header

  // declare the session variables we want access to inside the function
  /*
  if (!$_SESSION['items']) {
    $_SESSION['items'] = '0';
  }
  if (!$_SESSION['total_price']) {
    $_SESSION['total_price'] = '0.00';
  }
  if(isset($_SESSION['admin_user'])) {
    echo "&nbsp;";
  } else {
    echo "Total Items = ".$_SESSION['items'];
  }
     
  if(isset($_SESSION['admin_user'])) {
    echo "&nbsp;";
  } else {
    echo "Total Price = $".number_format($_SESSION['total_price'],2);
  }
  */
?>

<html>
<head>
  <title>Dunder Mifflin Paper Products</title>
<!-- Define Style in document -->  
<style type="text/css">
    h1 {color:white; font-size:24pt; text-align:center;
        font-family:arial,sans-serif}
    .menu {color:#81DAF5; font-size:12pt; text-align:center;
           font-family:calibri,sans-serif; font-weight:bold}
    p {color:black; font-size:12pt; text-align:justify;
       font-family:calibri,sans-serif}
    p.foot {color:white; font-size:9pt; text-align:center;
            font-family:calibri,sans-serif; font-weight:bold}
    a:link,a:visited,a:active {color:#00BFFF}
  </style>
</head>
<body>

  <!-- page header -->
  <table width="100%" cellpadding="12" cellspacing="0" border="0">
  <tr bgcolor="#15384E">
    <td align="left"><img src="images/logo.jpg" alt="TLA logo" height="90" width="165"></td>
    <td>
        <h1>Dunder Mifflin Paper Products</h1>
    </td>
    <td align="right"><img src="images/logo.jpg" alt="TLA logo" height="90" width="165" /></td>
  </tr>
  </table>

  <!-- menu -->

<!-- Label and link to Home -->
  <table width="100%" bgcolor="#CEECF5" cellpadding="4" cellspacing="4">
  <tr bgcolor="#15384E">
    <td width="25%" href="index.php" style="cursor:pointer">
      <a href="index.php">
      <img src="images/s-logo.png" alt="" height="38"" width="80" />
      <span class="menu">Home</span></a></td>

<!-- Label and link to Products 
    <td width="25%" href="products.php" style="cursor:pointer">
      <a href="products.php">
      <img src="s-logo.png" alt="" height="38"" width="80" />
      <span class="menu">Products</span></a></td> //-->

<!-- TEMPORARY link to home -->
    <td width="25%" href="index.php" style="cursor:pointer">
      <a href="index.php">
      <img src="images/s-logo.png" alt="" height="38"" width="80" />
      <span class="menu">Order</span></a></td>

<!-- Label and link to logout.php or show_cart -->
<td width="25%" style="cursor:pointer"
     <?php
     if(isset($_SESSION['admin_user'])) {
      echo "href=\"logout.php\">
      <a href=\"logout.php\">
      <img src=\"images/s-logo.png\" alt=\"\" height=\"38\" width=\"80\" />
      <span class=\"menu\">Log Out</span></a></td>";  
     } else {
      echo "href=\"show_cart.php\">
      <a href=\"show_cart.php\">
      <img src=\"images/s-logo.png\" alt=\"\" height=\"38\" width=\"80\" />
      <span class=\"menu\">Cart</span></a></td>";  
     }
     ?>

    <td width="25%">
      <img src="images/s-logo.png" alt="" height="38"" width="80" />
      <span class="menu">Feedback</span></td>


  </tr>
  </table>
<?php
  if($title) {
    do_html_heading($title);
  }
}

function do_html_footer() {
   //print an html footer
?>
   </body>
   </html>
<?php
}

function do_html_heading($heading) {
   //print heading
?>
  <h2><?php echo $heading; ?></h2>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
}

function display_categories($cat_array) {
  if (!is_array($cat_array)) {
     echo "<p>No categories currently available</p>";
     return;
  }
  echo "<ul>";
  foreach ($cat_array as $row)  {
    $url = "show_cat.php?catid=".$row['catid'];
    $title = $row['catname'];
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";
  }
  echo "</ul>";
  echo "<hr />";
}

function display_items($item_array) {
  //display all items in the array passed in
  if (!is_array($item_array)) {
    echo "<p>No items currently available in this category</p>";
  } else {
    //create table
    echo "<table width=\"100%\" border=\"0\">";

    //create a table row for each item
    foreach ($item_array as $row) {
      $url = "show_item.php?item_num=".$row['item_num'];
      echo "<tr><td>";
      if (@file_exists("images/".$row['item_num'].".jpg")) {
        $title = "<img src=\"images/".$row['item_num'].".jpg\"
                  style=\"border: 1px solid black\"/>";
        do_html_url($url, $title);
      } else {
        echo "&nbsp;";
      }
      //Removed author
      echo "</td><td>";
      $title = $row['name'];
      do_html_url($url, $title);
      echo "</td></tr>";
    }

    echo "</table>";
  }

  echo "<hr />";
}

function display_item_details($item) {
  // display all details about this item
  if (is_array($item)) {
    echo "<table><tr>";
    //display the picture if there is one
    if (@file_exists("images/".$item['item_num'].".jpg"))  {
      $size = GetImageSize("images/".$item['item_num'].".jpg");
      if(($size[0] > 0) && ($size[1] > 0)) {
        echo "<td><img src=\"images/".$item['item_num'].".jpg\"
              style=\"border: 1px solid black\"/></td>";
      }
    }
    //Removed 'Author'
    echo "<td><ul>";
    echo "</li><li><strong>Item_Num:</strong> ";
    echo $item['item_num'];
    echo "</li><li><strong>Name:</strong> ";
    echo $item['name'];
    echo "</li><li><strong>Description:</strong> ";
    echo $item['description'];
    echo "</li><li><strong>Our Price:</strong> ";
    echo number_format($item['price'], 2);
    echo "</li></ul></td></tr></table>";
  } else {
    echo "<p>The details of this item cannot be displayed at this time.</p>";
  }
  echo "<hr />";
}

function display_checkout_form() {
  //display the form that asks for name and address
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
  <form action="purchase.php" method="post">
  <tr><th colspan="2" bgcolor="#cccccc">Your Details</th></tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="name" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>City/Suburb</td>
    <td><input type="text" name="city" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>State/Province</td>
    <td><input type="text" name="state" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>Postal Code or Zip Code</td>
    <td><input type="text" name="zip" value="" maxlength="10" size="40"/></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><input type="text" name="country" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr><th colspan="2" bgcolor="#cccccc">Shipping Address (leave blank if as above)</th></tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="ship_name" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="ship_address" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>City/Suburb</td>
    <td><input type="text" name="ship_city" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>State/Province</td>
    <td><input type="text" name="ship_state" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>Postal Code or Zip Code</td>
    <td><input type="text" name="ship_zip" value="" maxlength="10" size="40"/></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><input type="text" name="ship_country" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p><strong>Please press Purchase to confirm
         your purchase, or Continue Shopping to add or remove items.</strong></p>
     <?php display_form_button("purchase", "Purchase These Items"); ?>
    </td>
  </tr>
  </form>
  </table><hr />
<?php
}

function display_shipping($shipping) {
  // display table row with shipping cost and total price including shipping
?>
  <table border="0" width="100%" cellspacing="0">
  <tr><td align="left">Shipping</td>
      <td align="right"> <?php echo number_format($shipping, 2); ?></td></tr>
  <tr><th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
      <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
  </tr>
  </table><br />
<?php
}

function display_card_form($name) {
  //display form asking for credit card details
?>
  <table border="0" width="100%" cellspacing="0">
  <form action="process.php" method="post">
  <tr><th colspan="2" bgcolor="#cccccc">Credit Card Details</th></tr>
  <tr>
    <td>Type</td>
    <td><select name="card_type">
        <option value="VISA">VISA</option>
        <option value="MasterCard">MasterCard</option>
        <option value="American Express">American Express</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Number</td>
    <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
  </tr>
  <tr>
    <td>AMEX code (if required)</td>
    <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
  </tr>
  <tr>
    <td>Expiry Date</td>
    <td>Month
       <select name="card_month">
       <option value="01">01</option>
       <option value="02">02</option>
       <option value="03">03</option>
       <option value="04">04</option>
       <option value="05">05</option>
       <option value="06">06</option>
       <option value="07">07</option>
       <option value="08">08</option>
       <option value="09">09</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       </select>
       Year
       <select name="card_year">
       <?
       for ($y = date("Y"); $y < date("Y") + 10; $y++) {
         echo "<option value=\"".$y."\">".$y."</option>";
       }
       ?>
       </select>
  </tr>
  <tr>
    <td>Name on Card</td>
    <td><input type="text" name="card_name" value = "<?php echo $name; ?>" maxlength="40" size="40"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
      add or remove items</strong></p>
     <?php display_form_button('purchase', 'Purchase These Items'); ?>
    </td>
  </tr>
  </table>
<?php
}

function display_cart($cart, $change = true, $images = 1) {
  // display items in shopping cart
  // optionally allow changes (true or false)
  // optionally include images (1 - yes, 0 - no)

   echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
         <th bgcolor=\"#cccccc\">Price</th>
         <th bgcolor=\"#cccccc\">Quantity</th>
         <th bgcolor=\"#cccccc\">Total</th>
         </tr>";

  //display each item as a table row
  foreach ($cart as $item_num => $qty)  {
    $item = get_item_details($item_num);
    echo "<tr>";
    if($images == true) {
      echo "<td align=\"left\">";
      if (file_exists("images/".$item_num.".jpg")) {
         $size = GetImageSize("images/".$item_num.".jpg");
         if(($size[0] > 0) && ($size[1] > 0)) {
           echo "<img src=\"images/".$item_num.".jpg\"
                  style=\"border: 1px solid black\"
                  width=\"".($size[0]/3)."\"
                  height=\"".($size[1]/3)."\"/>";
         }
      } else {
         echo "&nbsp;";
      }
      echo "</td>";
    }
    echo "<td align=\"left\">
          <a href=\"show_item.php?item_num=".$item_num."\">".$item['name']."</a>
          </td>
          <td align=\"center\">\$".number_format($item['price'], 2)."</td>
          <td align=\"center\">";

    // if we allow changes, quantities are in text boxes
    if ($change == true) {
      echo "<input type=\"text\" name=\"".$item_num."\" value=\"".$qty."\" size=\"3\">";
    } else {
      echo $qty;
    }
    echo "</td><td align=\"center\">\$".number_format($item['price']*$qty,2)."</td></tr>\n";
  }
  // display total row
  echo "<tr>
        <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            \$".number_format($_SESSION['total_price'], 2)."
        </th>
        </tr>";

  // display save change button
  if($change == true) {
    echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"center\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"images/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
  }
  echo "</form></table>";
}

function display_login_form() {
  // dispaly form asking for name and password
?>
 <form method="post" action="admin.php">
 <table bgcolor="#cccccc">
   <tr>
     <td>Username:</td>
     <td><input type="text" name="username"/></td></tr>
   <tr>
     <td>Password:</td>
     <td><input type="password" name="passwd"/></td></tr>
   <tr>
     <td colspan="2" align="center">
     <input type="submit" value="Log in"/></td></tr>
   <tr>
 </table></form>
<?php
}

function display_admin_menu() {
?>
<br />
<a href="index.php">Go to main site</a><br />
<a href="insert_category_form.php">Add a new category</a><br />
<a href="insert_item_form.php">Add a new item</a><br />
<a href="change_password_form.php">Change admin password</a><br />
<?php
}

function display_button($target, $image, $alt) {
  echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
}

function display_form_button($image, $alt) {
  echo "<div align=\"center\"><input type=\"image\"
           src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></div>";
}

?>
