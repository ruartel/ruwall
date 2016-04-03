<?php
require_once 'meekrodb.2.3.class.php';
require_once 'Controller/User.php';
// Sent the correct header so browsers display properly, with or without XSL.
header( 'Content-Type: application/xml' );

$output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
echo $output;
?>
    <url>
        <loc>https://yizkorwall.org</loc> 
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>https://yizkorwall.org/#/about</loc> 
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>https://yizkorwall.org/#/donate</loc> 
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>https://yizkorwall.org/#/add-loved-one</loc> 
        <changefreq>monthly</changefreq>
    </url>
    <?php
    $user = new User();
    $allUsers = $user->getAllUsers();
    foreach($allUsers as $k=>$v){
        ?>
        <url>
            <loc>https://yizkorwall.org/d/d.php?id=<?php echo $v['id']; ?></loc> 
            <changefreq>monthly</changefreq>
        </url>
        <?php
    }
    ?>
</urlset>
