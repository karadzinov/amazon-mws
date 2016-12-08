<?php

require_once 'header.php'; 

// the table name
$tableName = "reports";

// this is the page which should be targeted. If you call this script
// on a page named about.php then 'about.php' should be the target page
$targetpage = "tracking.php";

// How many records you want to show on each page
$limit = 30;



//   SELECT COUNT(*) as num FROM nastan WHERE nastan_type = 'nastan' ORDER BY date DESC LIMIT $start, $limit
$query = "SELECT COUNT(*) as num FROM tracking";

$total_pages = mysql_fetch_array(mysql_query($query));
$total_pages = $total_pages[num];

$stages = 3;
$page = mysql_escape_string($_GET['page']);
if ($page) {
    $start = ($page - 1) * $limit;
} else {
    $start = 0;
}

// Get page data
$query1 = "SELECT * FROM tracking ORDER BY id DESC LIMIT $start, $limit";
$result = mysql_query($query1);
$resultdva = mysql_query($query1);

// Initial page num setup
if ($page == 0) {
    $page = 1;
}
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total_pages / $limit);
$LastPagem1 = $lastpage - 1;


$paginate = '';
if ($lastpage > 1) {




    $paginate .= '<div>';
    $paginate .= '<ul class="pagination">';
    // Previous
    if ($page > 1) {
        $paginate.= "<li><a href='?page=$prev'>&larr; previous</a></li>";
    } else {
        $paginate.= "<li><span class='disabled'>&larr; previous</span></li>";
    }



    // Pages	
    if ($lastpage < 7 + ($stages * 2)) { // Not enough pages to breaking it up
        for ($counter = 1; $counter <= $lastpage; $counter++) {
            if ($counter == $page) {
                $paginate.= "<li><span class='active'>$counter</span></li>";
            } else {
                $paginate.= "<li><a href='?page=$counter'>$counter</a></li>";
            }
        }
    } elseif ($lastpage > 5 + ($stages * 2)) { // Enough pages to hide a few?
        // Beginning only hide later pages
        if ($page < 1 + ($stages * 2)) {
            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                if ($counter == $page) {
                    $paginate.= "<li><span class='active'>$counter</span></li>";
                } else {
                    $paginate.= "<li><a href='?page=$counter'>$counter</a></li>";
                }
            }
            $paginate.= "<li><a href='#'>...</a></li>";
            $paginate.= "<li><a href='/$LastPagem1'>$LastPagem1</a></li>";
            $paginate.= "<li><a href='/$lastpage'>$lastpage</a></li>";
        }
        // Middle hide some front and some back
        elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
            $paginate.= "<li><a href='?page=1'>1</a></li>";
            $paginate.= "<li><a href='?page=2'>2</a></li>";
            $paginate.= "<li><a href='#'>...</a></li>";
            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                if ($counter == $page) {
                    $paginate.= "<li><span class='active'>$counter</span></li>";
                } else {
                    $paginate.= "<li><a href='?page=$counter'>$counter</a></li>";
                }
            }
            $paginate.= "<li><a href='#'>...</a></li>";
            $paginate.= "<li><a href='?page=$LastPagem1'>$LastPagem1</a></li>";
            $paginate.= "<li><a href='?page=$lastpage'>$lastpage</a></li>";
        }
        // End only hide early pages
        else {
            $paginate.= "<li><a href='?page=1'>1</a></li>";
            $paginate.= "<li><a href='?page=2'>2</a></li>";
            $paginate.= "<li><a href='#'>...</a>";
            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $paginate.= "<li><span class='active'>$counter</span></li>";
                } else {
                    $paginate.= "<li><a href='?page=$counter'>$counter</a></li>";
                }
            }
        }
    }

    // Next
    if ($page < $counter - 1) {
        $paginate.= "<li><a href='?page=$next'>next &rarr; </a></li>";
    } else {
        $paginate.= "<li><span class='disabled'>next &rarr; </span></li>";
    }

    $paginate.= "</ul>";
    $paginate.= "</div>";
}
?>
