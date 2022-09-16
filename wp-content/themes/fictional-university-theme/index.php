<!--Function in PHP/WP-->
<!--
<?php
function greet($name, $color)
{
    echo "<p>Hi, my name is $name and my favourite color is $color.</p>";
}

greet('John', 'blue');
greet('Jane', 'red');
?> 
-->

<!-- Built in bloginfo() function in PHP/WP -->
<!--
<h1><?php bloginfo('name'); ?></h1>
<p><?php bloginfo('description'); ?></p> 
-->

<!-- Arrays in PHP/WP -->
<!--
<?php
$names = array('Brad', 'John', 'Jane', 'Meowsalot');
?>
<p>Hi, my name is
    <?php echo $names[0] ?>
</p>
-->

<!-- While loop in PHP/WP -->
<!-- <?php
$count = 1;

while($count < 100){
    echo "<li>$count</li>";
    $count++;
}
?> -->

<!-- While loop on Arrays/WP -->
<!-- <?php
$names = array('Brad', 'John', 'Jane', 'Meowsalot');
$count = 0;

while($count < count($names)){
    echo "<li>Hi, my name is $names[$count]</li>";
    $count++;
}
?> -->