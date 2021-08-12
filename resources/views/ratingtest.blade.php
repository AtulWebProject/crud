@php
$starNumber=2;
    for($x=1;$x<=$starNumber;$x++) {
        echo '<img src="../public/img/star.png" />';
    }
    if (strpos($starNumber,'.')) {
        echo '<img src="../public/img/star.png" />';
        $x++;
    }
    while ($x<=5) {
        echo '<img src="../public/img/bstar.png" />';
        $x++;
    }

@endphp