<?php

namespace Blogger\BlogBundle\Repository;
use Blogger\BlogBundle\Entity\Comment;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function addComment(Comment $comment)
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();
    }

    public function getCommentsForBlog($blogId, $isApproved = true)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.article = :article_id')
            ->addOrderBy('c.created')
            ->setParameter('article_id', $blogId)
        ;

        $qb
            ->andWhere('c.approved = :approved')
            ->setParameter('approved', $isApproved)
        ;

        return $qb->getQuery()
            ->getResult();
    }
}
