<?php

class Pagination{

public $perPage =50;

function pageLimit($currentPage,$items_per_page){

	$limit = null;
        if ($currentPage > 0) {
            $currentPage--;

			//$items_per_page=item_per_page;
            $currentPage *= $items_per_page;



            $limit = $currentPage.",".$items_per_page;

        }
		
		return $limit;
}
function printPageLinks($recordCount, $currentPage, $recordsPerPage=null) {	
		
			$itemsPerPage=$this->perPage;
		    $page_number_limit=5;
			//const COMMONFUNCTIONS_PAGE_NUMBER_LIMIT = 5;
			
			$strpagedump= "<ul class='pagination pagination-sm no-margin pull-right'>" ;

			if ($recordCount) {
	    			$recCount = $recordCount;
			} else {
					$recCount = 0;
			}

			if (isset($recordsPerPage)) {
		   		 $noPages = (int) ($recCount / $recordsPerPage);
		   		 $additionalPage = $recCount%$recordsPerPage;
			} else {
		   		 $noPages = (int) ($recCount / $itemsPerPage);
		   		 $additionalPage = $recCount%$itemsPerPage;
			}

			if($additionalPage)
		   		$noPages++;

			if ($noPages > 1) {

				if($currentPage == 1) {
						$strpagedump .= '<li><a href="#">&lsaquo;&lsaquo;</a></li>';
		    			//$strpagedump .= "  ";
						//$strpagedump .= "<font color='Gray'>#previous</font>";
				} else {
						$strpagedump .= '<li><a href="#" class="prev_page">&lsaquo;&lsaquo;</a></li>';
	    				
				}

	    		$strpagedump .= "  ";

				$lowerLimit = (($currentPage - $page_number_limit) <= 0) ? 1 : ($currentPage - $page_number_limit);
				$c = $lowerLimit;
					while($c < $currentPage) {
	    				$strpagedump .= "<li><a href='#' id='".$c."' class='change_page'>" .$c. "</a></li>";
		    			$strpagedump .= "  ";
						$c++;
				}

	    		$strpagedump .= " <li><a href='#' > <font color='red'>". $currentPage . "</font></a> </li> ";


				$upperLimit = (($currentPage + $page_number_limit) >= $noPages) ? $noPages : ($currentPage + $page_number_limit);
				$c = $currentPage + 1;
				while($c <=  $upperLimit) {
	    				$strpagedump .= "<li><a href='#' id='".$c."' class='change_page'>" .$c. "</a></li>";
		    			$strpagedump .= "  ";
			   			 $c++;
				}

				if ($currentPage == $noPages) {
					
					$strpagedump .= '<li><a href="#">&rsaquo;&rsaquo;</a></li>';
				} else {
				
					$strpagedump .= '<li><a href="#" class="next_page">&rsaquo;&rsaquo;</a></li>';
	    			
				}
			}
			$strpagedump.= "</ul>";
			
		return $strpagedump;
	}


}

?>