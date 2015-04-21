<?php
namespace iadvdm\service\api;

/**
 * Post class is used for api service response
 * @author Ludovic TOURMAN
 *
 */
class Post {
	public $id;
	
	public $content;
	
	public $date;
	
	public $author;	
	
	/**
	 * 
	 * @param integer $id
	 * @param string $content
	 * @param string $date
	 * @param string $author
	 */
	public function __construct(integer $id = null, string $content = null, string $date = null, string $author = null){
		$this->id		= $id;
		$this->content	= $content;
		$this->date		= $date;
		$this->author	= $author;
	}
}
?>