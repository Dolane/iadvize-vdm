<?php
namespace iadvdm\business;

/**
 * 
 * @author Ludovic TOURMAN
 *
 */
class ArticlesApi {
	
	/**
	 * Function called by "/api/posts" URL
	 * @param Array $criteria : Array containing criteria for filtering<br>Ex: $criteria['author']='Genius' (?author=Genius)
	 * @return String $json_encode : Return posts encoded to json
	 */
	public static function getPosts($criteria = array()){
		// Download latest articles from web
		\iadvdm\vdm\VdmArticlesManager::loadNewArticles();
		
		$a_articles = \iadvdm\vdm\VdmArticlesManager::loadFromJsonFile();
		
		// If criteria is filled, use VdmArticlesUtils::find method to filter results
		if(count($criteria) > 0){
			$a_articles = \iadvdm\vdm\VdmArticlesUtils::find($a_articles, $criteria);
		}
		
		//Limit articles to VDM_MAX_ARTICLES_SHOW
		$a_articles = array_slice($a_articles, 0, VDM_MAX_ARTICLES_SHOW);
		
		// Order articles by date desc
		\iadvdm\vdm\VdmArticlesUtils::orderBy($a_articles, 'date', false);
		
		$posts = ArticlesApi::articlesToPosts($a_articles);
		
		return ArticlesApi::postsToJson($posts);
	}
	

	/**
	 * Function called by "/api/posts/:id" URL
	 * @param String $id : Id of articles to get<br>Ex: $criteria['id']='12345' (/api/posts/12345)
	 * @return String $json_encode : Return posts encoded to json
	 */
	public static function getPost($id){
		$a_post = array();

		// Download latest articles from web
		\iadvdm\vdm\VdmArticlesManager::loadNewArticles();
	
		$a_articles = \iadvdm\vdm\VdmArticlesManager::loadFromJsonFile();
	
		// Create $criteria from $id
		$criteria['id'] = (int) $id;
		
		// Get corresponding articles from criteria
		$a_articles = \iadvdm\vdm\VdmArticlesUtils::find($a_articles, $criteria);
	
		// Map articles to posts (articles=>DAO, posts=>Service)
		$posts = ArticlesApi::articlesToPosts($a_articles);
		
		if(!empty($posts->posts[0])){
			$a_post['post'] = $posts->posts[0]; 
		}
	
		return ArticlesApi::postsToJson($a_post);
	}
	
	/**
	 * Convert \iadvdm\vdm\VdmArticle to \iadvdm\service\api\Posts
	 * @param Array<\iadvdm\vdm\VdmArticle> $a_articles : Array of VdmArticle
	 * @return \iadvdm\service\api\Posts : Return Posts (Array of Post)
	 */
	public static function articlesToPosts($a_articles){
		$posts = new \iadvdm\service\api\Posts();
		$a_posts = array();
		
		//Mapping 1 to 1 (Post <-> Article)
		foreach ($a_articles as $article){
			$post = new \iadvdm\service\api\Post();
			
			$post->id		= $article->id;
			$post->content	= $article->content;
			$post->date 	= $article->date;
			$post->author	= $article->author;
			
			$a_posts[] = $post;
		}
		
		// Use setPosts() to also set "count" attribute
		$posts->setPosts($a_posts);
		
		return $posts;
	}
	
	/**
	 * Convert posts to json response
	 * @param iadvdm\service\api\Posts $posts : Array of Post
	 * @return String $json_encode : Return posts encoded to json
	 */
	public static function postsToJson($posts){
		$json_response;
		
		try {
			// Keep it pretty ;)
			$json_response = json_encode($posts, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		}catch (Exception $e){
			$j_error = new \iadvdm\service\ServiceError();
			$j_error->setFromException($e)->logError();
			$json_response = json_encode($j_error->getJsonError(), JSON_PRETTY_PRINT);
		}
		
		return $json_response;
	}
}
?>