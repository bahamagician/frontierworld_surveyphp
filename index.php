<?php
  try {
    require_once 'includes/pdo_connect.php';
    $prelim = 
            "INSERT INTO prelim_guest_Info 
            (first_name, last_name, email, phone_number)
            VALUES (:first_name, :last_name, :email, :phone_number)";
    $stmt_prelim = $db->prepare($prelim);
    $stmt_prelim->bindParam(':first_name',$_POST["first_name"]);
    $stmt_prelim->bindParam(':last_name',$_POST["last_name"]);
    $stmt_prelim->bindParam(':email',$_POST["email"]);
    $stmt_prelim->bindParam(':phone_number',$_POST["phone_number"]);
    //$stmt_prelim->execute();

    $ratings = 
            "INSERT INTO guest_ratings_comments
            (comments, ratings, stay_length)
            VALUES (:comments, :ratings, :stay_length)";
    $stmt_ratings = $db->prepare($ratings);
    $stmt_ratings->bindParam(':comments', $_POST["Extra_comments"]);
    $stmt_ratings->bindParam(':ratings', $_POST["rating"]);
    $stmt_ratings->bindParam(':stay_length', $_POST["days_spent"]);
    //$stmt_ratings->execute();

    if(!empty($_POST["newsletters"])) {
      $newsletter = $_POST["newsletters"];
      foreach($newsletter as $theme){
        $newsletter_insert = 
              "INSERT newsletter_subscriptions
              (updates)
              VALUES (:updates)";
        $newsletter_stmt = $db->prepare($newsletter_insert);
        $newsletter_stmt -> bindParam(':updates', $theme);
        //$newsletter_stmt -> execute();
      }
    }
    
    $guest_first_name = $_POST["first_name"];
    //Transaction
    // $db->beginTransaction();
    // $stmt_prelim->execute();
    // if(!$stmt_prelim->rowCount()){
    //   $db->rollBack();
    //   $error = "Submission failed: Could not add $guest_first_name's prime credentials.";
    // } else {
    //   $stmt_ratings->execute();
    //   if(!$stmt_ratings->rowCount()){
    //   $db->rollback();
    //   $error = "Submission failed: Could not add $guest_first_name's ratings.";
    //   } else {
    //     $newsletter_stmt->execute();
    //     if (!$newsletter_stmt->rowCount()){
    //       $db->rollback();
    //       $error = "Submission failed: Could not add $guest_first_names's desired subscriptions";
    //     } else {
    //       $db->commit();
    //     }
    //   }
    // }
    $db->beginTransaction();
    $stmt_prelim->execute();
    $stmt_ratings->execute();
    $newsletter_stmt->execute();
    $db->commit();

    
  } catch (Exception $e) {
      $error = $e->getMessage();
      $db->rollback();

  }
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>FrontierWorld Guest Survey</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- import the webpage's stylesheet -->
    <link rel="stylesheet" href="/style.css">
    
    <!-- import the webpage's javascript file -->
    <script src="/script.js" defer></script>
    <script src="https://cdn.freecodecamp.org/testable-projects-fcc/v1/bundle.js"></script>
  </head>  
  <body>
    <header>
      <h1 id="title">
        FrontierWorld Survey Form
        
      </h1>

    </header>
    <main>
      <p id="description">
        Let us know how we can improve FrontierWorld!<br/>
        
      </p>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>"  id="survey-form">
        <label id="name-label">*First Name <input autocomplete="on" placeholder="Enter your first name here" name="first_name" id="first_name" type="text" required></label>
        <br>
        <label id="name-label">*Last Name <input autocomplete="on" placeholder="Enter your last name here" name="last_name" id="last_name" type="text" required></label>
        <br>
        <label id="email-label">*Email <input autocomplete="on" placeholder="Enter your email address here" name="email" id="email" type="email" min="6" max="128" required></label>
        <br>
        <label id="number-label">*Phone Number <input autocomplete="on" placeholder="Enter a phone number here. Must be in former US format" id="number" type="tel" name="phone_number" required pattern="[^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$"></label>
        <br>
        <label>
          How long was your recent stay at FrontierWorld?
          <label for="days-spent">Number of days spent 3-42</label>
          <input type="text" id="day-spent" name="days-spent" min="3" max="42">
        </label>
        <br>
        <p>How would you rate your recent stay at FrontierWorld?</p>
        <div>
          <input type="radio" id="excellentRating" name="rating" value="5">
          <label for="excellentRating">Excellent</label>
          &nbsp;
          <input type="radio" id="greatRating" name="rating" value="4">
          <label for="greatRating">Great</label>
          &nbsp;
          <input type="radio" id="goodRating" name="rating" value="3">
          <label for="goodRating">Good</label>
          &nbsp;
          <input type="radio" id="somewhat-goodRating" name="rating" value="2">
          <label for="some-whatgoodRating">Somewhat Good</label>
          &nbsp;
          <input type="radio" id="fairRating" name="rating" value="1">
          <label for="fairRating">Fair</label>
        </div>
        <p>Stay up to date on the newest stories being unveiled in FrontierWorld's sister attractions (check all that interest you)!</p>
        <div>
          <input type="checkbox" id="shanghaiWorld" name="newsletters[0]" value="shanghaiNewsletter">
          <label for="shanghaiWorld">SamuraiWorld</label>
          &nbsp;
          <input type="checkbox" id="baltimoreWorld" name="newsletters[1]" value="baltimoreNewsletter">
          <label for="baltimoreWorld">BaltimoreWorld</label>
          &nbsp;
          <input type="checkbox" id="caesarWorld" name="newsletters[2]" value="caesarNewsletter">
          <label for="caesarWorld">CaesarWorld</label>
          <br>
          <input type="checkbox" id="kiplingWorld" name="newsletters[3]" value="kiplingNewsletter">
          <label for="kiplingWorld">KiplingWorld</label>
          &nbsp;
          <input type="checkbox" id="postWorld" name="newsletters[4]" value="postNewsletter">
          <label for="postWorld">PostWorld</label>
          &nbsp;
          <input type="checkbox" id="medievalWorld" name="newsletters[5]" value="medievalNewsletter">
          <label for="medievalWorld">MedievalWorld</label>
        </div>
        <p>Do you have any questions, comments, or concerns regarding your recent stay at Frontier World? Feel free to add them in the space below!</p>
        <textarea name="Extra-comments" rows="10" cols="150">Enter your comment here! Please keep any negative comments to 125 characters, please!</textarea>
        <div>
          <input type="submit" id="submit" value="Send">
        </div>
      </form>
    </main>
    <footer>
      <p>We hope you enjoyed your stay at FrontierWorld, a Dellos Destinations Attraction</p>
    </footer>
  </body>
</html>
