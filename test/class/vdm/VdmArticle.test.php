<?php
namespace iadvdm\vdm;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-04-21 at 00:27:08.
 * 
 */
class VdmArticleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VdmArticle
     */
    protected $article;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    	$id = 9999999;
    	$content = 'Dummy content';
    	$date = '2015-12-31 23:59:59';
    	$author = 'Dummy author';
    	
        $this->article = new VdmArticle($id, $content, $date, $author);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers iadvdm\vdm\VdmArticle::__toString
     * @todo   Implement test__toString().
     */
    public function test__toString()
    {
    	$expected = serialize($this->article);
    	$generated = $this->article->__toString();
    	
        $this->assertTrue($generated===$expected);
    }

    /**
     * @covers iadvdm\vdm\VdmArticle::cast
     * @todo   Implement testCast().
     */
    public function testCast()
    {
        $this->assertTrue(true);
    }
}