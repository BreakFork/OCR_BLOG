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
     * @var string $postRoute the route of the post
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
     * @Column(type="text")
     */
    protected $postContent;

    /**
     * The date of the last modification of the post
     *
     * @var integer $lastUpdateTimestamp the date of the last modification of the post
     *
     * @Column(type="integer")
     */
    protected $lastUpdateTimestamp;

    /**
     * Returns a post created into the database
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist()
    {
        $entityManager = Database::getEntityManager();
        $entityManager->persist($this);
        $entityManager->flush();
    }

    /**
     * Returns a post object from DB selected by id
     *
     * @param int|null $postId the id of the post if the post has been selected on the list or null if it has not been
     *
     * @return Post|null a post object from DB choosen by id or null if $postId is null
     */
    public static function getPost($postId): ?Post
    {
            $postRepository = Database::getEntityManager()->getRepository("Models\\Post");
            $post = $postRepository->findOneBy(
                array(
                    "id" => $postId
                )
            );

            if($postId != null) {
                /**
                 * @noinspection PhpIncompatibleReturnTypeInspection
                 * Safe because $post has been generated by Doctrine
                 */
                return $post;
            }
            return null;
    }

    /**
     * Returns a list of posts from DB
     *
     * @return array $postList the list of the posts
     */
    public static function getPostList(): array
    {
        $postRepository = Database::getEntityManager()->getRepository("Models\\Post");
        $postList = $postRepository->findAll();

        return $postList;
    }

    /**
     * Returns a post object from DB selected by route
     *
     * @param string|null $postRoute the route of the post if the post has been selected on the list or null if it has not been
     *
     * @return Post|null a post object from DB choosen by route or null if $postRoute is null
     */
    public static function getPostByRoute($postRoute): ?Post
    {
        $postRepository = Database::getEntityManager()->getRepository("Models\\Post");
        $post = $postRepository->findOneBy(
            array(
                "postRoute" => $postRoute
            )
        );

        if($postRoute != null) {
            /**
             * @noinspection PhpIncompatibleReturnTypeInspection
             * Safe because $post has been generated by Doctrine
             */
            return $post;
        }
        return null;
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
    public function getPostRoute()
    {
        return $this->postRoute;
    }

    /**
     * Sets the route of the post
     *
     * @param $postRoute
     */
    public function setPostRoute(string $postRoute): void
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
     * @return integer the date of the last modification of the post
     */
    public function getLastUpdateTimestamp(): int
    {
        return $this->lastUpdateTimestamp;
    }

    /**
     * Sets the date of the last modification of the post
     *
     * @param integer $lastUpdateTimestamp
     */
    public function setLastUpdateTimestamp(int $lastUpdateTimestamp): void
    {
        $this->lastUpdateTimestamp = $lastUpdateTimestamp;
    }
}
