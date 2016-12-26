<html>
<head>
    <title>Search Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menubar.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/carousel.css"/>
    <script>
        $(document).ready(function () {
            $('#myCarousel').carousel({
                interval: 4000
            });

            var clickEvent = false;
            $('#myCarousel').on('click', '.nav a', function () {
                clickEvent = true;
                $('.nav li').removeClass('active');
                $(this).parent().addClass('active');
            }).on('slid.bs.carousel', function (e) {
                if (!clickEvent) {
                    var count = $('.nav').children().length - 1;
                    var current = $('.nav li.active');
                    current.removeClass('active').next().addClass('active');
                    var id = parseInt(current.data('slide-to'));
                    if (count == id) {
                        $('.nav li').first().addClass('active');
                    }
                }
                clickEvent = false;
            });
        });
    </script>
</head>
<body>
<?php
require_once "../controller/session.php";
require_once "common/header.phtml"; ?>

<div id="divSearch">
    <form action='./search.php' method='get'>
        <input type='text' name='searchKey' placeholder="Ürün Arayın..." value = '<?php echo $_GET[searchKey]; ?>'/>
        <input type='submit' name='search' value='Getir'>
    </form>
	<hr />
	<?php
		
		require_once __DIR__ . '/db/db_connect.php';
        $db=new DB_CONNECT(); //DATABASE BAGLANTISI
        $mysqli = $db->connect();
        $result=mysqli_query($mysqli,"SELECT * FROM users WHERE id='$id'");
		
		$searchKey = $_GET[searchKey];
		$terms = explode(" ",$searchKey);
		$query="SELECT * FROM search WHERE ";
		
		foreach ($terms as $each){
			$i++;
			
			if($i == 1)
				$query .= "keywords LIKE '%$each%' ";
			else
				$query .= "OR keywords LIKE '%$each%' ";
		}
		
		//connect 
		
		
		$query = mysql_query($query);
		$numrows = mysql_num_rows($query);
		if($numrows > 0){
			while($row = mysql_fetch_assoc($query)){
				$id=$row['id'];
				$title=$row['title'];
				$description=$row['description'];
				$keywords=$row['keywords'];
				$link=$row['link'];
				
				echo
			}
		}
		else
			echo"No results found for\"<b>$searchKey</b>\"";
		//disconnect
		
	?>
</div>

<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <label id="kategoriBaslk" class="navbar-brand">Kategoriler</label>
            </div>
            <div class="collapse navbar-collapse js-navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <?php
                    require_once __DIR__ . "/../model/Category.php";
                    $result = Category::getCategoryByParentId(0);


                    while ($entry = mysqli_fetch_array($result)) {
                        echo "<li class='dropdown mega-dropdown'>" .
                            //Üst ana menü isimlerini yaz.
                            "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>" . $entry["name"] . "<span class='caret'></span></a>";
                        echo "<ul class='dropdown-menu mega-dropdown-menu'>" .
                            "<li class='col-sm-3'>
                           <ul>
                                <li class='dropdown-header'>" . $entry["name"] . "</li>
                                <div id='menCollection' class='carousel slide' data-ride='carousel'>
                                    <div class='carousel-inner'>
                                        <div class='item active'>
                                            <a href='#'><img src=" . Category::getCategoryImage($entry["id"]) . "
                                            class='img-responsive' alt='product 1'></a>                                        
                                        </div>";
                        echo "</div>
                                </div>
                           </ul> 
                        </li>";
                        //Alt Menüler
                        $subMenus = Category::getCategoryByParentId($entry["id"]);
                        $count = 0;
                        while ($subMenu = mysqli_fetch_array($subMenus)) {
                            $count++;
                            if ($count == 1) {
                                echo "<li class='col-sm-3'><ul>";
                            }
                            echo "<li class='dropdown-header'><a href ='" . $subMenu['id'] . "'>" . $subMenu["name"] . "</a></li>";
                            $subsubMenus = Category::getCategoryByParentId($subMenu['id']);
                            if (!empty($subsubMenus))
                                while (($subsubMenu = mysqli_fetch_array($subsubMenus))) {
                                    echo "<li><a href='" . $subsubMenu['id'] . "'>" . $subsubMenu["name"] . "</a>";
                                }

                            if ($count != 3)
                                echo "<li class='divider'></li>";
                            if ($count == 3) {
                                echo "</ul></li>";
                                $count = 0;
                            }
                        }
                        if ($count != 0) {
                            echo "</ul></li>";
                        }
                        echo "</ul>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
<?
if ($cat2show == 0)
    echo '
<!-- Carousel -->
<div class="container">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item active">
                <img src="img/car1.jpg">

            </div><!-- End Item -->

            <div class="item">
                <img src="img/car2.png">

            </div><!-- End Item -->

            <div class="item">
                <img src="img/car3.jpg">

            </div><!-- End Item -->

            <div class="item">
                <img src="img/car4.jpg">

            </div><!-- End Item -->

        </div><!-- End Carousel Inner -->


        <ul class="nav nav-pills nav-justified">
            <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#">Nike Ürünleri<small>Ayakkabılarda %30\'a varan indirim</small></a></li>
            <li data-target="#myCarousel" data-slide-to="1"><a href="#">Samsung Ürünleri<small>Samsung Galaxy S7 Edge stoklarımızda</small></a></li>
            <li data-target="#myCarousel" data-slide-to="2"><a href="#">Apple Ürünleri<small>Apple Iphone 7 ve Iphone 7 Plus stoklarımızda</small></a></li>
            <li data-target="#myCarousel" data-slide-to="3"><a href="#">Hp Ürünleri<small>Dizüstü bilgisayarlarda %10\'a varan indirim</small></a></li>
        </ul>


    </div><!-- End Carousel -->
</div>';
else echo "
<div>
    <h1 style=\"color:crimson; font-family: 'Times New Roman'\">" . mysqli_fetch_array(Category::getCategoryById($cat2show))['name'] . "</h1>
</div>
";
?>


<?php $count = 3; ?>
<div class="container">
    <?php require_once "../model/Product.php";
    if ($cat2show == 0)
        $products = Product::getAll();
    else
        $products = Product::getChildsOf($cat2show);
    if (mysqli_num_rows($products) > 0) {
        while ($product = mysqli_fetch_array($products)) {
            if ($count == 3) {
                echo "<div class=\"row\" style=\"margin-top:20px\">";
                $count = 0;
            }
            echo "
        <div class=\" col-sm-6 col-md-4\">
            <div class=\"thumbnail\">
                <img src='" . $product['image_url'] . "' style='width: 250px; height:250px' alt=\"...\">
                <div class=\"caption\">
                    <h3><a href='show-product?id=" . $product['id'] . "'>" . $product['name'] . "</a></h3>
                    <p>" . $product['price'] . "TL</p>
                </div>
            </div>
        </div>
        ";
            if ($count == 2) {
                echo "</div>";
            }
            $count++;
        }
    } else {
        echo "
        <table align='center'>
            <tr>
                 <td>      
                 <img src='http://educationnews.educationviewsor.netdna-cdn.com/wp-content/uploads/2013/10/ooops-sign.jpg'>
                 </td>
            </tr>
            <tr>
                 <td>     
                 <h4 align='center'>Bu kategoride satışa sunulmuş ürün bulunmamaktadır.</h4>
                 </td>
            </tr>
        </table>
        ";
    }
    ?>
</div>

<?php require_once "common/footer.phtml"; ?>
</body>
</html>

