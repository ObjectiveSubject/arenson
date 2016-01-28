<?
function aof_pagination($current_page, $totalposts,$p,$lpm1,$prev,$next){
	$pagination="";
	$adjacents = 3;
	if($totalposts > 1)
	{
		//previous button
		if ($p > 1)
			$pagination.= "<a class=\"icon-left-open\" href=\"?page=" . $current_page . "&pg=$prev\"></a> ";
		else
			$pagination.= "<span title=\"No more data\" class=\"disabled icon-left-open\"></span> ";
		if ($totalposts < 7 + ($adjacents * 2)){
			for ($counter = 1; $counter <= $totalposts; $counter++){
				if ($counter == $p)
				$pagination.= "<span class=\"current\">$counter</span>";
				else
				$pagination.= " <a class='hey' href=\"?page=" . $current_page . "&pg=$counter\">$counter</a> ";}
		}elseif($totalposts > 5 + ($adjacents * 2)){
			if($p < 1 + ($adjacents * 2)){
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
					if ($counter == $p)
					$pagination.= " <span class=\"current\">$counter</span> ";
					else
					$pagination.= " <a href=\"?page=" . $current_page . "&pg=$counter\">$counter</a> ";
				}
				$pagination.= " ... ";
				$pagination.= " <a href=\"?page=" . $current_page . "&page=" . $current_page . "&pg=$lpm1\">$lpm1</a> ";
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=$totalposts\">$totalposts</a> ";
			}
			//in middle; hide some front and some back
			elseif($totalposts - ($adjacents * 2) > $p && $p > ($adjacents * 2)){
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=1\">1</a> ";
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=2\">2</a> ";
				$pagination.= " ... ";
				for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++){
					if ($counter == $p)
					$pagination.= " <span class=\"current\">$counter</span> ";
					else
					$pagination.= " <a href=\"?page=" . $current_page . "&pg=$counter\">$counter</a> ";
				}
				$pagination.= " ... ";
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=$lpm1\">$lpm1</a> ";
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=$totalposts\">$totalposts</a> ";
			}else{
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=1\">1</a> ";
				$pagination.= " <a href=\"?page=" . $current_page . "&pg=2\">2</a> ";
				$pagination.= " ... ";
				for ($counter = $totalposts - (2 + ($adjacents * 2)); $counter <= $totalposts; $counter++){
					if ($counter == $p)
					$pagination.= " <span class=\"current\">$counter</span> ";
					else
					$pagination.= " <a href=\"?page=" . $current_page . "&pg=$counter\">$counter</a> ";
				}
			}
		}
		if ($p < $counter - 1)
		$pagination.= " <a class=\"icon-right-open\" href=\"?page=" . $current_page . "&pg=$next\"></a>";
		else 
		$pagination.= " <span  title=\"No more data\" class=\"icon-right-open disabled\"></span>";
	}
	return $pagination;
}

function aof_paginationDIV($current_table, $current_page, $p,$max,$prev,$next) {
	//Get total records from db
	global $wpdb;
	$table_name = $current_table;		
	
	$myquery = "SELECT COUNT(id) AS tot FROM $table_name WHERE active != '0'";
	$totalres = $wpdb->get_var($myquery);
	
	//devide it with the max value & round it up
	$totalposts = ceil($totalres / $max);
	$lpm1 = $totalposts - 1;

	return aof_pagination($current_page, $totalposts,$p,$lpm1,$prev,$next);
}


?>