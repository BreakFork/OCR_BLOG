<?php
/**
 * Post class file
 *
 * PHP Version 7.2
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 */

namespace Models;

use System\Database;

/**
 * Model for post
 *
 * @category Models
 * @package  Models
 * @author   Hervé Boulangué <h.boulangue@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://blog.local/
 *
 * @Entity @Table(name="Post")
 */
class Post
{
    /**
     * Post's id into Post table
     *
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * The route of the post
     *
     * @var string $route the route of the post
     *
     * @Column(type="string")
     */
    protected $postRoute;

    /**
     * The title of the post
     *
     * @var string $postTitle the title of the post
     *
     * @Column(type="string")
     */
    protected $postTitle;

    /**
     * The author of the post
     *
     * @var string $postAuthor the author of the post
     *
     * @Column(type="string")
     */
    protected $postAuthor;

    /**
     * The content of the post
     *
     * @var string $postContent the content of the post
     *
     * @Column(type="string")
     */
    protected $postContent;

    /**
     * The date of the last modification of the post
     *
     * @var date $postDateModified the date of the last modification of the post
     *
     * @Column(type="date")
     */
    protected $postDateModified;

    /**
     * Instantiates a new post
     *
     * @param string   $postRoute        the route of the post to set
     * @param string   $postTitle        the title of the post to set
     * @param string   $postAuthor       the author of the post to set
     * @param string   $postContent      the content of the post to set
     * @param date     $postDateModified the date of the last modification of the post to set
     */
    public function __construct(string $postRoute, string $postTitle, string $postAuthor, string $postContent, DateTime $postDateModified)
    {
        $this->setPostRoute($postRoute);
        $this->setPostTitle($postTitle);
        $this->setPostAuthor($postAuthor);
        $this->setPostContent($postContent);
        $this->setPostDateModified($postDateModified);
    }

    /**
     * Returns a post created into the database
     *
     * @param string   $postRoute        the route of the post to return
     * @param string   $postTitle        the title of the post to return
     * @param string   $postAuthor       the author of the post to return
     * @param string   $postContent      the content of the post to return
     * @param date     $postDateModified the date of the last modification of the post to return
     *
     * @return Post
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public static function createPost(string $postRoute, string $postTitle, string $postAuthor, string $postContent, DateTime $postDateModified): ?Post
    {
       $postRepository = Database::getEntityManager()->getRepository("Models\\Post");
       $post = $postRepository->persist(
           array(
               "route" => $postRoute,
               "title" => $postTitle,
               "author" => $postAuthor,
               "content" => $postContent,
               "postDateModified" => $postDateModified
           )
       );
       $postRepository->flush();

       return $post;
    }

    /**
     * Returns the post's id for the database
     *
     * @return integer the id of the post
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id of the post
     *
     * @param integer $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the route of the post
     *
     * @return string the route of the post
     */
    public function getRoute()
    {
        return $this->postRoute;
    }

    /**
     * Sets the route of the post
     *
     * @param string $route
     */
    public function setPostRoute($postRoute): void
    {
        $this->postRoute = $postRoute;
    }

    /**
     * Returns the title of the post
     *
     * @return string the title of the post
     */
    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    /**
     * Sets the title of the post
     *
     * @param string $postTitle
     */
    public function setPostTitle(string $postTitle): void
    {
        $this->postTitle = $postTitle;
    }

    /**
     * Returns the author of the post
     *
     * @return string the author of the post
     */
    public function getPostAuthor(): string
    {
        return $this->postAuthor;
    }

    /**
     * Sets the author of the post
     *
     * @param string $postAuthor
     */
    public function setPostAuthor(string $postAuthor): void
    {
        $this->postAuthor = $postAuthor;
    }

    /**
     * Returns the content of the post
     *
     * @return string the content of the post
     */
    public function getPostContent(): string
    {
        return $this->postContent;
    }

    /**
     * Sets the content of the post
     *
     * @param string $postContent
     */
    public function setPostContent(string $postContent): void
    {
        $this->postContent = $postContent;
    }

    /**
     * Returns the date of the last modification of the post
     *
     * @return DateTime the date of the last modification of the post
     */
    public function getPostDateModified(): DateTime
    {
        return $this->postDateModified;
    }

    /**
     * Sets the date of the last modification of the post
     *
     * @param DateTime $postDateModified
     */
    public function setPostDateModified(DateTime $postDateModified): void
    {
        $this->postDateModified = $postDateModified;
    }
}
