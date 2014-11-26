<div id="content-container">
    <div id="section-navigation">
        <ul class="navi">
            <?php 
                // Xac dinh cat_id de to dam link
                $cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT, array('min_range' => 1));
                $pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT, array('min_range' => 1));

                // Cau lenh truy xuat categories
                $q = "SELECT cat_name, cat_id FROM categories ORDER BY position ASC";
                $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);

                // Lay categories tu co so du lieu
                while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    echo "<li><a href='index.php?cid={$cats['cat_id']}'";
                        if (isset($cid) && $cid == $cats['cat_id']) echo " class='active'";
                    echo ">" . $cats['cat_name'] ."</a>"; 

                    // cau lenh truy xuat pages
                    $q1 = "SELECT page_name, page_id FROM pages WHERE cat_id = {$cats['cat_id']} ORDER BY position ASC";
                    $r1 = mysqli_query($dbc, $q1);
                    confirm_query($r1, $q1);

                    // Lay page tu co so du lieu
                    echo "<ul class='pages'>";
                    while ($pages = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
                        echo "<li><a href='single.php?pid={$pages['page_id']}'";
                            if (isset($pid) && $pid == $pages['page_id']) echo " class='active'";
                        echo ">".$pages['page_name']."</a></li>";
                        
                    } // end WHILE pages
                    echo "</ul>";
                    echo "</li>";
                } // end WHILE cats
            ?>
        </ul>
    </div><!--end section-navigation-->