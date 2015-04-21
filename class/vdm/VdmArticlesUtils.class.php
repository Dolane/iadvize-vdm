<?php
namespace iadvdm\vdm;

/**
 * VdmArticlesUtils is used to manipulate array of VdmArticle
 * @author Ludovic TOURMAN
 *
 */
class VdmArticlesUtils {
	
	/**
	 * Find corresponding articles of criteria
	 * (Loop on each articles, if one criteria is not corresponding
	 * to article, this one is removed from the returning list)
	 * @param array $criteria
	 * @return array<VdmArticle> : Return the corresponding articles
	 */
	public static function find($a_articles, $criteria){
		// By default, all articles are corresponding 
		$matched_articles = $a_articles;
		
		// Loop on each articles
		foreach ($matched_articles as $index => $article){
			
			// If criteria has "id" filter
			// Check matching on "id" attribute
			if(array_key_exists('id', $criteria)){
				$id = trim($criteria['id']);
				// Control $id is digital Regex "\d+")
				if(preg_match('/^\d+$/',$id)){
					//Force cast to int
					$id = (int) $id;
					//If element not matching, remove it from result and go to next element
					if(!empty($criteria['id']) && $article->id != $id){
						unset($matched_articles[$index]);
						continue;
					}
				}
			}
			
			// If criteria has "author" filter
			// Check matching on "author" attribute
			if(array_key_exists('author', $criteria)){
				$author = trim($criteria['author']);
				//If element not matching, remove it from result and go to next element
				if(!empty($criteria['author']) && $article->author !== $author){
					unset($matched_articles[$index]);
					continue;
				}
			}
			
			// Parse article string date to DateTime (Usefull for date comparison)
			$d_articleDate = \DateTime::createFromFormat('Y-m-d H:i:s', $article->date);
			
			// If criteria has "from" filter
			// Check matching on "date" attribute
			if(array_key_exists('from', $criteria)){
				$d_criteriaDate;
				if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$criteria['from'])){
					//Y-m-d H:i:s means Y-m-d H:i:s.000
					$cleanDate = $criteria['from'].'.000';
					$d_criteriaDate = \DateTime::createFromFormat('Y-m-d H:i:s.u', $cleanDate);
				}else{
					if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$criteria['from'])){
						//Y-m-d means Y-m-d 00:00:00.000
						$cleanDate = $criteria['from'].' 00:00:00.000';
						$d_criteriaDate = \DateTime::createFromFormat('Y-m-d H:i:s.u', $cleanDate);
					}else{
						// If malformatted date, remove article from result
						unset($matched_articles[$index]);
						continue;
					}
				}
				
				// If date criteria is still valid (not empty)
				// and date criteria is greater than date article, remove article from result 
				if(!empty($d_criteriaDate) && ($d_articleDate < $d_criteriaDate)){
					unset($matched_articles[$index]);
					continue;
				}
			}
			
			// If criteria has "to" filter
			// Check matching on "date" attribute
			if(array_key_exists('to', $criteria)){
				$d_criteriaDate;
				if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$criteria['to'])){
					//Y-m-d H:i:s means Y-m-d H:i:s.999
					$cleanDate = $criteria['to'].'.999';
					$d_criteriaDate = \DateTime::createFromFormat('Y-m-d H:i:s.u', $cleanDate);
				}else{
					if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$criteria['to'])){
						//Y-m-d means Y-m-d 23:59:59.999
						$cleanDate = $criteria['to'].' 23:59:59.999';
						$d_criteriaDate = \DateTime::createFromFormat('Y-m-d H:i:s.u', $cleanDate);
					}else{
						// If malformatted date, remove article from result
						unset($matched_articles[$index]);
						continue;
					}
				}
			
				// If date criteria is still valid (not empty)
				// and date criteria is lower than date article, remove article from result
				if(!empty($d_criteriaDate) && ($d_articleDate > $d_criteriaDate)){
					unset($matched_articles[$index]);
					continue;
				}
			}
		}
		
		//Reordering array indexes (Ex : array(0,7,10,23) => array(0,1,2,3))
		$matched_articles = array_values($matched_articles);
		
		return $matched_articles;
	}
	
	/**
	 * Order articles by attribute
	 * @param array<$a_articles> : Array of VdmArticle
	 * @param string $attribute : Name of VdmArticle attribute used for ordering
	 * @param string $asc : True : Ordering ascendant, False : Ordering descendant
	 * @return array<$a_articles> : Array of ordered VdmArticle
	 */
	public static function orderBy(&$a_articles, $attribute, $asc=true){
		$cmpFunction;
		
		// Depending on attribute, compare function won't be the same
		switch ($attribute){
			// Order alphabetically on author attribute
			case 'author':
				if($asc){
					$cmpFunction = function($a,$b){
						return strcmp($a->author, $b->author);
					};
				}else{
					$cmpFunction = function($a,$b){
						return strcmp($b->author, $a->author);
					};
				}
				break;
			// Order timely on date attribute
			case 'date':
				if($asc){
					$cmpFunction = function($a,$b){
						$a_date = \DateTime::createFromFormat('Y-m-d H:i:s', $a->date);
						$b_date = \DateTime::createFromFormat('Y-m-d H:i:s', $b->date);
						return $a_date > $b_date;
					};
				}else{
					$cmpFunction = function($a,$b){
						$a_date = \DateTime::createFromFormat('Y-m-d H:i:s', $a->date);
						$b_date = \DateTime::createFromFormat('Y-m-d H:i:s', $b->date);
						return $a_date < $b_date;
					};
				}
				break;
			// By default, order on id attribute
			default:
				if($asc){
					$cmpFunction = function($a,$b){
						return ($a->id > $b->id);
					};
				}else{
					$cmpFunction = function($a,$b){
						return ($a->id < $b->id);
					};
				}
				break;
		}
		
		// Call usort function with custom compare method
		usort($a_articles, $cmpFunction);
		
		return $a_articles;
	}
	
	/**
	 * Merge arrays of VdmArticle to a unique array (Remove duplicates)
	 * @param array<VdmArticle> : First array of VdmArticle to merge
	 * @param array<VdmArticle> : Second array of VdmArticle to merge
	 * @return array<VdmArticle> : Return a merged duplicateless array of VdmArticle
	 */
	public static function merge($a_articles, $a_newArticles){
		return array_unique(array_merge($a_articles,$a_newArticles));
	}
}
?>