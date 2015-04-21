<?php
namespace iadvdm\vdm;

/**
 * VdmArticle class is used when parsing and storing articles
 * @author Ludovic TOURMAN
 *
 */
class VdmArticle {
	
	public $id;
	
	public $content;
	
	public $date;
	
	public $author;	
	
	public function __construct($id = null, $content = null, $date = null, $author = null){
		if(is_int($id)){
			$this->id	= (int) $id;
		}
		$this->content	= $content;
		$this->date		= $date;
		$this->author	= $author;
	}
	
	/**
	 * Custom function used for object comparison
	 */
	public function __toString()
	{
		return serialize($this);
	}
	
	/**
	 * Cast object to a VdmArticle
	 * @param Object $object
	 * @return \iadvdm\vdm\VdmArticle
	 */
	public static function cast($object){
		$article = new VdmArticle();
		
		// Loop on each $object public property
		foreach($object as $key => $val) {
			// If property exist in VdmArticle, set it
			if(property_exists(__CLASS__,$key)) {
				$article->$key = $val;
			}
		}

		return $article;
	}
}
?>