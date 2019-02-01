<?php

$DBHost = 'localhost';
$DBUser = 'ab99783_genesis';
$DBPass = '**********';
$DBName = 'ab99783_vidflixclub';

// Create short variable names for html form
$query=$_POST["siteSearch"];
$submit=$_POST["submit"];

// Display search results when 'Search' button is selected.
if ($submit == 'Search')
{

// Create database connection
$db = mysqli_connect($DBHost,$DBUser,$DBPass)
 or die('Could not connect: ' . mysqli_connect_error());

// Select your database
mysqli_select_db($db, "$DBName") or die("Unable to select database"); 

// Setting the query to the result
$result = mysqli_query($db, "SELECT mp.Movie, w.ReviewDate, mp.Genre, mp.MPRS, mp.Duration, mp.Streaming_Site, mp.Description, mp.Link 
          FROM Movie_picks mp
          INNER JOIN Weeks w ON mp.Weekid=w.Weekid
          WHERE mp.Movie LIKE '%$query%'
          OR mp.Streaming_Site LIKE '%$query%'
          OR mp.Genre LIKE '%$query%'
          ORDER BY mp.Movie") or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0) {
echo "<table><thead>
        <tr>
          <th>Movie</th>
          <th nowrap>Review Date</th>
          <th>Genre</th>
          <th>MPRS</th>
          <th>Duration</th>
          <th>Streaming Site</th>
          <th class='desc'>Description</th>
        </tr></thead>";

    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td><a href='".$row["Link"]."'>".$row["Movie"]. 
             "</td><td>" .$row["ReviewDate"].  
             "</td><td>" .$row["Genre"].  
             "</td><td>" .$row["MPRS"]. 
             "</td><td>" .$row["Duration"].
             "</td><td>" .$row["Streaming_Site"].
             "</a></td><td class='desc'>" .$row["Description"]. "</td></tr>";
    }
echo "</table>";
} else {
    echo "0 results";
    echo "<p>Please enter a search query</p>";
}	
 
mysqli_free_result($result);
mysqli_close($db);

} // End IF Statement

?>
