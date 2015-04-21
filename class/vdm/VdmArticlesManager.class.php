<?php
namespace iadvdm\vdm;

/**
 * VdmArticlesManager class manage articles persistence (save/load)
 * @author Ludovic TOURMAN
 *
 */
class VdmArticlesManager {

	/**
	 * Loop on "www.viedemerde.fr/?page=" until new articles are availables
	 * @param boolean $saveToFile : Default true.<br>Save new articles to json file
	 * @return array<VdmArticle> : Return an array of VdmArticle
	 */
	public static function loadNewArticles($saveToFile = true){
		//Set default page argument to 0
		$vdmPage = 0;
		$downloadedArticles = 0;
		
		// Load existing articles from json file
		$a_fileArticles = VdmArticlesManager::loadFromJsonFile();
		$a_newArticles = array();
		
		\iadvdm\Timer::start('parsePages');
		\Logger::getLogger(APP_NAME)->debug('Start : Check new articles');
		
		// Loop while they are pages to parse
		while($vdmPage !== null){
			
			// Parse articles from page=$vdmPage
			$a_webArticles = VdmArticlesParser::getArticlesFromWeb($vdmPage);
			
			$i_pageNewArticles = 0;

			// Increment $vdmPage for next loop
			$vdmPage++;

			VdmArticlesUtils::orderBy($a_webArticles, 'id', false);
			// Set total articles downloaded (to stop when max download)
			$downloadedArticles += count($a_webArticles);
			
			foreach ($a_webArticles as $webArticle){
				// If webArticle does not exist, add it to array
				if(!in_array($webArticle,$a_fileArticles)){
					$a_newArticles[] = $webArticle;
					$i_pageNewArticles++;
				}
			}
			
			// If number of new article exceed max download articles
			// or no new articles on current page, stop downloading
			if($downloadedArticles >= VDM_MAX_ARTICLES_DOWNLOAD || $i_pageNewArticles == 0){
				$vdmPage = null;
			}
		}
		\Logger::getLogger(APP_NAME)->debug('End : Check new articles');
		
		// If there is new articles and save option, add new articles to json file
		if($saveToFile && count($a_newArticles) > 0){
			$a_fileArticles = VdmArticlesManager::addToJsonFile($a_newArticles);
			\Logger::getLogger(APP_NAME)->info('Added '.count($a_newArticles).' new article(s) to json file in '.\iadvdm\Timer::getDuration('parsePages'));
		}else{
			\Logger::getLogger(APP_NAME)->info('No new articles added');
		}
		
		return $a_newArticles;
	}
	
	/**
	 * Save articles to specified json file (Replace entire content)
	 * Use addToJsonFile() method to add new articles without losing existing
	 * @param Array<VdmArticle> $a_fileArticles : Array of VdmArticle to store
	 * @param string $f_jsonArticles (Opt.) : The file to store data
	 * @return boolean : True if data was saved successfully
	 */
	public static function saveToJsonFile($a_fileArticles, $f_jsonArticles = VDM_ARTICLES_JSON_FILE){
		$fileSaved = false;
		
		// Check if file can be written (existing, writable access, etc...)
		$f_jsonArticles = fopen($f_jsonArticles, 'w');
		if(!$f_jsonArticles){ 
			\Logger::getLogger(APP_NAME)->error('Unable to open file "'.$f_jsonArticles."', please check access.");
		}else{
			// Order articles by id before storing them
			VdmArticlesUtils::orderBy($a_fileArticles, 'id', false);
			// Encode articles to json format (Still pretty ;)
			$j_articles = json_encode($a_fileArticles, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			
			// Write to file
			fwrite($f_jsonArticles, $j_articles);
			fclose($f_jsonArticles);
			$fileSaved = true;
		}
		
		return $fileSaved;
	}
	
	/**
	 * Add new articles to existing one in the json file
	 * @param Array<VdmArticle> $a_newArticles : Array of VdmArticle to add
	 * @param string $f_jsonArticles (Opt.) : The file to store data
	 * @return Array<VdmArticle> $a_mergedArticles : Return the list of unique merged articles (old + new)
	 */
	public static function addToJsonFile($a_newArticles, $f_jsonArticles = VDM_ARTICLES_JSON_FILE){
		// Get articles from json file
		$a_fileArticles = VdmArticlesManager::loadFromJsonFile($f_jsonArticles);
		// Merge json articles with new articles
		$a_mergedArticles = VdmArticlesUtils::merge($a_fileArticles, $a_newArticles);
		// Save them into json file
		VdmArticlesManager::saveToJsonFile($a_mergedArticles, $f_jsonArticles);
		
		return $a_mergedArticles;
	}
	
	/**
	 * Load articles from json file
	 * @param string $f_jsonArticles (Opt.) : The file to store data
	 * @return Array<VdmArticle> $a_fileArticles : Array of VdmArticle stored in file
	 */
	public static function loadFromJsonFile($f_jsonArticles = VDM_ARTICLES_JSON_FILE){
		$a_fileArticles = array();
		
		// Get articles from json and merge them
		if(file_exists($f_jsonArticles)){
			$f_jsonArticles = file_get_contents($f_jsonArticles);
			
			// Check if file was not empty
			if(!empty($f_jsonArticles)){
				$j_fileArticles = json_decode($f_jsonArticles);
				
				// Force cast to VdmArticle instead of stdclass (Usefull for next treatments)
				foreach ($j_fileArticles as $fileArticle){
					$a_fileArticles[] = VdmArticle::cast($fileArticle);
				}
			}
		}else{
			\Logger::getLogger(APP_NAME)->warn('File "'.$f_jsonArticles."' was not found.");
		}
		
		return $a_fileArticles;
	}
}
?>