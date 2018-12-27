<?php
  try {
    include_once 'includes/pdo_connect.php';
    $db->beginTransaction();
    $prelim =
            "INSERT INTO prelim_guest_Info
            (first_name, last_name, email, phone_number)
            VALUES (:first_name, :last_name, :email, :phone_number)";
    $stmt_prelim = $db->prepare($prelim);
    $stmt_prelim->bindParam(':first_name', $_POST["first_name"]);
    $stmt_prelim->bindParam(':last_name', $_POST["last_name"]);
    $stmt_prelim->bindParam(':email', $_POST["email"]);
    $stmt_prelim->bindParam(':phone_number', $_POST["phone_number"]);

    $last_id = $db->lastInsertId();
    $stmt_prelim->execute();

    $ratings =
            "INSERT INTO guest_ratings_comments
            (guest_code_ratings, comments, ratings, stay_length)
            VALUES (:guest_code_ratings, :comments, :ratings, :stay_length)";
    $stmt_ratings = $db->prepare($ratings);
    $stmt_ratings->bindParam(':guest_code_ratings', $last_id);
    $stmt_ratings->bindParam(':comments', $_POST["Extra_comments"]);
    $stmt_ratings->bindParam(':ratings', $_POST["rating"]);
    $stmt_ratings->bindParam(':stay_length', $_POST["days_spent"]);
    $stmt_ratings->execute();



    $theme = null;
    $newsletter_insert =
            "INSERT INTO  newsletter_subscriptions
            (guest_code_news_subs, updates)
            VALUES (:guest_code_news_subs, :updates)";
    $newsletter_stmt = $db->prepare($newsletter_insert);
    $newsletter_stmt -> bindParam(':guest_code_news_subs', $last_id);
    $newsletter_stmt -> bindParam(':updates', $theme);

    if(!empty($_POST["newsletters"])) {
      foreach($_POST["newsletters"] as $theme){
        //echo $theme;
        $newsletter_stmt -> execute();
      }
    }

    $guest_first_name = $_POST["first_name"];
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
          <input type="checkbox" id="shanghaiWorld" name="newsletters[]" value="shanghaiNewsletter">
          <label for="shanghaiWorld">SamuraiWorld</label>
          &nbsp;
          <input type="checkbox" id="baltimoreWorld" name="newsletters[]" value="baltimoreNewsletter">
          <label for="baltimoreWorld">BaltimoreWorld</label>
          &nbsp;
          <input type="checkbox" id="caesarWorld" name="newsletters[]" value="caesarNewsletter">
          <label for="caesarWorld">CaesarWorld</label>
          <br>
          <input type="checkbox" id="kiplingWorld" name="newsletters[]" value="kiplingNewsletter">
          <label for="kiplingWorld">KiplingWorld</label>
          &nbsp;
          <input type="checkbox" id="postWorld" name="newsletters[]" value="postNewsletter">
          <label for="postWorld">PostWorld</label>
          &nbsp;
          <input type="checkbox" id="medievalWorld" name="newsletters[]" value="medievalNewsletter">
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
