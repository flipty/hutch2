<?php
global $post;


 echo '<h1 class="entry-title">Web Nursery</h1>';

$currentMonth = date('m'); 


//Baby Information
$babyMonth = get_post_meta($post->ID, 'month', true);

if (empty($babyMonth)){
	$thisMonth = filter_input(INPUT_GET, 'month');
	if( is_numeric($thisMonth) && $thisMonth > 0 && $thisMonth <= 12 ){
		$babyMonth =  $thisMonth;		
	}
	else{
		$babyMonth = $currentMonth;
	}
}

echo '<div class="baby-month-buttons">';



for ($i=11; $i >= 0; $i--)
{       

        //$monthNumber = intval(date('m',strtotime("now - $i month") ));
        //$monthNumber = intval(date('m',strtotime("midnight - $i month") ));

		//Updated 3-29-18
        $monthNumber = intval(date('m',strtotime(date('Y-m-01')." - $i month") ));

        //$monthName = date('F',strtotime("now - $i month") );
		//$thisYear = date('Y',strtotime("now - $i month") );
		//$monthName = date('F',strtotime("midnight - $i month") );
		//$thisYear = date('Y',strtotime("midnight - $i month") );

		//Updated 3-29-18
		$monthName = date('F',strtotime(date('Y-m-01')." - $i month") );
		$thisYear = date('Y',strtotime(date('Y-m-01')." - $i month") );

		
		$x=$i+1;
		
		//echo '<a href="/babies/?month='.$monthNumber.'&y=' .$thisYear. '" class="baby-month">' .$monthName. '</a><BR>';
		
		if ($monthNumber == $babyMonth) {
			echo '<a href="/babies/?month='.$monthNumber.'&y=' .$thisYear. '" class="baby-currentmonth">' .$monthName. '</a>';
		} else {	
			echo '<a href="/babies/?month='.$monthNumber.'&y=' .$thisYear. '" class="baby-month">' .$monthName. '</a>';
		}

}


echo '</div>';
?>

