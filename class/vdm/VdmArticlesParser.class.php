<?php
namespace iadvdm\vdm;

/**
 * VdmArticlesParser is used to parse www.viedemerde.fr html articles to VdmArticle object
 * @author Ludovic TOURMAN
 *
 */
class VdmArticlesParser {
	
	/**
	 * Get html content from page and parse it to an array of VdmArticle
	 * @param integer $page : Number used for url www.viedemerde.fr/?page=
	 * @return array<\iadvdm\vdm\VdmArticle> : Return an array of VdmArticle
	 */
	public static function getArticlesFromWeb($page = 0){
		$a_articles = array();
		$htmlContent = '';

		$vdmPageURL = VDM_BASE_URL.$page;
		
		\iadvdm\Timer::start('parsePage');
		// Get html content from page (Suppress error messages) 
		@$htmlContent = file_get_contents($vdmPageURL);
		
		// Check if there were no error
		if($htmlContent === false){
			\Logger::getLogger(APP_NAME)->error('Unable to load content from "'.$vdmPageURL.'"');
		}else{
			// Check if page/file has content
			if(empty($htmlContent)){
				\Logger::getLogger(APP_NAME)->warn('Nothing to load from "'.$vdmPageURL.'"');
			}else{
				// Get page encoding
				$htmlEncoding = mb_detect_encoding($htmlContent, 'UTF-8', true);
				
				// If not in UTF-8, convert content to UTF-8 encoding
				if(!$htmlEncoding){
					$htmlContent = mb_convert_encoding($htmlContent, 'UTF-8', $htmlEncoding);
				}
				
				// Parse html to object with Sunra's HtmlDomParser library
				$domContent = \Sunra\PhpSimple\HtmlDomParser::str_get_html($htmlContent);
				
				// Parse htmlObject to VdmArticles
				$a_articles = VdmArticlesParser::parseArticles($domContent);
				
				\Logger::getLogger(APP_NAME)->debug('Page "'.$vdmPageURL.'" parsed in '.\iadvdm\Timer::getDuration('parsePage'));
			}
		}
		return $a_articles;
	}
	
	/**
	 * Return array of VdmArticle
	 * @param \Sunra\PhpSimple\HtmlDomParser $domContent
	 * @return Array<VdmArticle> : Return an array of VdmArticle
	 */
	public static function parseArticles($domContent){
		$a_articles = array();
		
		// Check if dom is not empty
		if(!empty($domContent)){
			// Get html articles from selector
			$dom_articles = $domContent->find(VDM_SELECTOR_ARTICLES);
			
			// Loop on each html articles to get data
			foreach ($dom_articles as $dom_article){
				// Parse html to get id
				$id 		= VdmArticlesParser::parseArticleId ( $dom_article );
				// Parse html to get content
				$content	= VdmArticlesParser::parseArticleContent ( $dom_article );
				// Parse html to get date
				$date		= VdmArticlesParser::parseArticleDate ( $dom_article );
				// Parse html to get author
				$author		= VdmArticlesParser::parseArticleAuthor ( $dom_article );
				
				$vdmArticle = new \iadvdm\vdm\VdmArticle ( $id, $content, $date, $author );
				
				// Add article to array
				$a_articles [] = $vdmArticle;
			}
		}
		return $a_articles;
	}
	
	/**
	 * Parse html to get article's id
	 * @param \Sunra\PhpSimple\HtmlDomParser $dom_article
	 * @return number $id : Return the id of article
	 */
	public static function parseArticleId($dom_article){
		return (int) $dom_article->id;
	}
	
	/**
	 * Parse html to get article's content
	 * @param \Sunra\PhpSimple\HtmlDomParser $dom_article
	 * @return string $content : Return the content of article
	 */
	public static function parseArticleContent($dom_article){
		$content = '';
		$elements = $dom_article->find('p', 0)->find('a');
		
		// Concat all <a/> tag to get content
		foreach($elements as $element){
			$content .= $element->plaintext;
		}
		
		return $content;
	}
	
	/**
	 * Parse html to get article's date
	 * @param \Sunra\PhpSimple\HtmlDomParser $dom_article
	 * @return string $date : Return string date formatted in yyyy-mm-dd hh:mm:ss
	 */
	public static function parseArticleDate($dom_article){
		$date = '';
		$element = $dom_article->find('div[class="date"]', 0)->find('div[class="right_part]', 0)->find('p', 1)->plaintext;

		// Ex : "Le 18/04/2015 à 23:54 - enfants - par yasmina13012003" 
		$date = preg_replace(VDM_ARTICLE_DATE_REGEX, VDM_ARTICLE_DATE_FORMAT, $element);

		return $date;
	}
	
	/**
	 * Parse html to get article's author
	 * @param \Sunra\PhpSimple\HtmlDomParser $dom_article
	 * @return string $author : Return the author of article
	 */
	public static function parseArticleAuthor($dom_article){
		$author = '';
		$element = $dom_article->find('div[class="date"]', 0)->find('div[class="right_part]', 0)->find('p', 1)->plaintext;

		// Ex : "Le 18/04/2015 à 23:54 - enfants - par yasmina13012003"
		$author = preg_replace(VDM_ARTICLE_AUTHOR_REGEX, VDM_ARTICLE_AUTHOR_FORMAT, $element);
		$author = trim($author);
	
		return $author;
	}
}
?>