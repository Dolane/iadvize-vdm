<?php
namespace iadvdm\service\api;

/**
 * Posts class is used to encapsulate Post for api service response
 * @author Ludovic TOURMAN
 *
 */
class Posts {
	/**
	 * Do not use direct accessor $posts->posts
	 * because $posts->count won't be update
	 */
	public $posts;
	
	public $count;
	
	/**
	 * @param array $a_posts : An array of Post
	 */
	public function __construct(array $a_posts = array()){
		$this->posts = $a_posts;
		$this->count = count($this->posts);
	}
	
	/**
	 * Set an array of Post and change count attribute in consequences
	 * @param array $a_posts : 
	 */
	public function setPosts(array $a_posts = array()){
		$this->posts = $a_posts;
		$this->count = count($this->posts);
	}
}
?>