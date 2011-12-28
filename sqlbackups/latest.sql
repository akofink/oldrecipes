-- MySQL dump 10.13  Distrib 5.1.58, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: recipes
-- ------------------------------------------------------
-- Server version	5.1.58-1ubuntu1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `recipes`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `recipes` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `recipes`;

--
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth` (
  `username` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `userlevel` int(1) DEFAULT NULL,
  `no_of_recipes` int(10) DEFAULT NULL,
  `no_of_comments` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth`
--

LOCK TABLES `auth` WRITE;
/*!40000 ALTER TABLE `auth` DISABLE KEYS */;
INSERT INTO `auth` VALUES ('akofink','Andrew','Kofink','akofink@me.com','403029f8ef4151611b5061d0d0b38ccbd9bd5237',1,8,0);
/*!40000 ALTER TABLE `auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `subject` varchar(500) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `reply_id` int(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `indx` int(10) DEFAULT NULL,
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recipes` (
  `indx` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `imageLocation` varchar(500) DEFAULT NULL,
  `ingredients` varchar(5000) DEFAULT NULL,
  `directions` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`indx`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recipes`
--

LOCK TABLES `recipes` WRITE;
/*!40000 ALTER TABLE `recipes` DISABLE KEYS */;
INSERT INTO `recipes` VALUES (4,'Guacamole','akofink','Appetizer','uploads/avocado1.jpg','Avocado\r\nTomato\r\nOnion\r\nLime Juice\r\nCumin\r\nSpice if desired (Peppers, etc.)','Mix it all together and enjoy!'),(5,'Lentil Soup (Vegetarian)','akofink','Soup','uploads/lentilsoup2.gif','2 cups lentils\r\n4 cups water\r\n4 cups vegetable broth4\r\n1 onion, diced\r\n3 stalks celery, sliced\r\n2 carrots, chopped\r\n2 cloves garlic, minced\r\n1 tsp salt\r\n1/4 tsp black pepper\r\n1/2 tsp oregano\r\n1 14 ounce can diced tomatoes','Put everything together in a crock pot for a few hours until the house smells great.'),(6,'Black Bean Soup','akofink','Soup','uploads/BlackBeanSoup.jpg','1 tablespoon olive oil\r\n1 large onion, chopped\r\n1 stalk celery, chopped\r\n2 carrots, chopped\r\n4 cloves garlic, chopped\r\n2 tablespoons chili powder\r\n1 tablespoon ground cumin\r\n1 pinch black pepper\r\n4 cups vegetable broth\r\n4 (15 ounce) cans black beans\r\n1 (15 ounce) can whole kernel corn\r\n1 (14.5 ounce) can crushed tomatoes','<ol><li>Heat oil in a large pot over medium-high heat. Saute onion, celery, carrots and garlic for 5 minutes. Season with chili powder, cumin, and black pepper; cook for 1 minute. Stir in vegetable broth, 2 cans of beans, and corn. Bring to a boil.</li>\r\n<li>Meanwhile, in a food processor or blender, process remaining 2 cans beans and tomatoes until smooth. Stir into boiling soup mixture, reduce heat to medium, and simmer for 15 minutes.</li>\r\n</ol>'),(7,'Candied Yams','akofink','Casserole','','6 large bright orange sweet potatoes\r\n1 lb. dark brown sugar\r\n1 stick of butter\r\n2 cups of miniature marshmallows\r\n1/4 cup of white sugar\r\n2 teaspoons of salt','<p>Wash and peel potatoes. Chunk potatoes into 2 inch disks. Put potatoes in a pan and cover with water. Add 2 teaspoons of salt and 1/4 cup of white sugar to the potatoes and water. Cover. Boil until potatoes are fork tender (approximately 30 minutes). Drain potatoes.\r\nPut potatoes in a baking dish and sprinkle with brown sugar. Dot potatoes with butter.\r\n</p><p>\r\nBake for 20 minutes in 350 degree oven. Sprinkle with marshmallows. Return to oven and bake until marshmallows are brown.</p>'),(8,'Cabbage Soup','akofink','Soup','uploads/1cabbage_soup_recipe.jpg','1 tablespoon extra virgin olive oil\r\na big pinch of salt\r\n1/2 pound potatoes, skin on, cut 1/4-inch pieces\r\n4 cloves garlic, chopped\r\n1/2 large yellow onion, thinly sliced\r\n5 cups stock of your choice\r\n1 1/2 cups white beans, precooked or canned (drained & rinsed well)\r\n1/2 medium cabbage, cored and sliced into 1/4-inch ribbons\r\n\r\nmore good-quality extra-virgin olive oil for drizzling\r\n1/2 cup Parmesan cheese, freshly grated','<p>\r\nWarm the olive oil in a large thick-bottomed pot over medium-high heat. Stir in the salt and potatoes. Cover and cook until they are a bit tender and starting to brown a bit, about 5 minutes - it\'s o.k. to uncover to stir a couple times. Stir in the garlic and onion and cook for another minute or two. Add the stock and the beans and bring the pot to a simmer. Stir in the cabbage and cook for a couple more minutes, until the cabbage softens up a bit. Now adjust the seasoning - getting the seasoning right is important or your soup will taste flat and uninteresting. Taste and add more salt if needed, the amount of salt you will need to add will depend on how salty your stock is (varying widely between brands, homemade, etc)…\r\n</p>\r\n\r\n<p>\r\nServe drizzled with a bit of olive oil and a generous dusting of cheese.\r\n</p>\r\n\r\n<p>Serves 4.</p>'),(9,'Miso Soup','akofink','Soup','uploads/miso_soup_recipe.jpg','3 ounces dried soba noodles\r\n2 - 4 tablespoons miso paste (to taste) \r\n2 - 3 ounces firm tofu (2 handfuls), chopped into 1/3-inch cubes\r\na handful of watercress or spinach, well washed and stems trimmed\r\n2 green onions, tops removed thinly sliced\r\na small handful of cilantro\r\na pinch of red pepper flakes','<p>\r\nCook the soba noodles in salted water, drain, run cold water over the noodles to stop them from cooking, shake off any excess water and set aside.\r\n</p><p>\r\nIn a medium sauce pan bring 4 cups of water to a boil. Reduce the heat to a gentle simmer and remove from heat. Pour a bit of the hot water into a small bowl and whisk in the miso paste - so it thins out a bit (this step is to avoid clumping). Stir this back into the pot. Taste, and then add more (the same way) a bit at a time until it is to your liking. Also, some miso pastes are less-salty than others, so you may need to add a bit of salt here. Add the tofu, remove from the heat, and let it sit for just a minute or so.\r\n</p><p>\r\nSplit the noodles between two (or three) bowls, and pour the miso broth and tofu over them. Add some watercress, green onions, cilantro, and red pepper flakes to each bowl and enjoy.\r\n</p><p>\r\nServes 2 - 3.</p>'),(10,'Simple Bread','akofink','Bread','uploads/20050115simpleloafdonesliced.jpg','3 cups flour\r\n2 teaspoons salt\r\n2 teaspoons yeast\r\n1 1/8 cup water','<p>Mix everything together. If it is too wet and won\'t come free from the sides of the bowl or keeps sticking to your hands, add a little more flour. If it is too dry and won\'t form into a ball, add a bit of water.</p><p>\r\nKnead it for 10 minutes. Cover and set it aside to rise until it doubles in size, approximately 90 minutes. Punch it down and let it rise again. Shape it, either by putting it in a greased loaf pan or by rolling it out into a long loaf and putting it on the back of a cookie sheet.</p><p>\r\nAfter it has risen to twice it size again, another hour or so, put the loaf into a preheated oven at 375 degrees. Let it bake for 45 minutes and then pull it out. If you made it into a long skinny loaf, it may cook 5 or 10 minutes quicker, so adjust the time based on what shape you chose. I baked the loaf in these photos for 40 minutes). 50-375 for 45 minutes is typical for a loaf in a loaf pan.</p>'),(11,'No Bake Cookies','akofink','Dessert - Cookies','uploads/21125.jpg','1 3/4 cups white sugar\r\n1/2 cup milk\r\n1/2 cup butter\r\n4 tablespoons unsweetened cocoa powder\r\n1/2 cup crunchy peanut butter\r\n3 cups quick-cooking oats\r\n1 teaspoon vanilla extract','In a medium saucepan, combine sugar, milk, butter, and cocoa. Bring to a boil, and cook for 1 1/2 minutes. Remove from heat, and stir in peanut butter, oats, and vanilla. Drop by teaspoonfuls onto wax paper. Let cool until hardened.');
/*!40000 ALTER TABLE `recipes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-12-28  8:00:01
