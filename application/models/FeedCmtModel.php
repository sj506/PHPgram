<?php
namespace application\models;
use PDO;

class FeedCmtModel extends Model
{
  public function insFeedCmt(&$param)
  {
    $sql = "INSERT INTO t_feed_cmt
                (ifeed, iuser, cmt)
                values
                (:ifeed, :iuser, :cmt)";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':ifeed', $param['ifeed']);
    $stmt->bindValue(':iuser', $param['iuser']);
    $stmt->bindValue(':cmt', $param['cmt']);
    $stmt->execute();

    return intval($this->pdo->lastInsertId());
  }

  public function selFeedCmt(&$param)
  {
    $sql = "SELECT G.*,COUNT(G.icmt) -1 AS ismore
                FROM (
                SELECT A.icmt, A.cmt, A.regdt, A.ifeed,
                        B.iuser, B.nm AS writer, B.mainimg AS writerimg FROM t_feed_cmt A 
                INNER JOIN t_user B 
                ON A.iuser = B.iuser 
                WHERE A.ifeed = :ifeed
                ORDER BY A.icmt DESC LIMIT 2) G
                GROUP BY G.ifeed
        ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':ifeed', $param['ifeed']);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  public function selFeedCmtLIST(&$param)
  {
    $sql = "SELECT A.icmt, A.cmt, A.regdt, A.iuser, 
                B.nm AS writer, B.mainimg AS writerimg from t_feed_cmt A 
                INNER JOIN t_user B on A.iuser = B.iuser 
                WHERE A.ifeed = :ifeed
                ORDER BY A.icmt
                ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':ifeed', $param['ifeed']);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function FeedCmtDel(&$param)
  {
    $sql = 'DELETE FROM t_feed_cmt WHERE icmt = :icmt';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':icmt', $param);
    $stmt->execute();

    return $stmt->rowCount();
  }
}
