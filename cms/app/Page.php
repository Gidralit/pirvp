<?php

class Page{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }


    public function blockedPage($blocked, $pageId){
        $query = "UPDATE pages SET blocked = :blocked WHERE id = :pageId";

        echo $blocked;

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':blocked' => $blocked,
            ':pageId' => $pageId
        ]);
    }

    public function blockedUser($userId, $pageId){
        $query = "INSERT INTO pages_blocked_users (user_id, page_id) VALUES (:userId, :pageId)";
        $stmt = $this->db->prepare($query);
        if($stmt->execute([':userId' => $userId, ':pageId' => $pageId])){
            return true;
        }
        return false;
    }

    public function create($title, $description, $link){
        $query = "INSERT INTO pages (title, description, link) VALUES (:title, :description, :link)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':link', $link);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function userBlockedForPage($userId, $pageId){
        $query = "SELECT COUNT(*) FROM pages_blocked_users WHERE user_id = :userId AND page_id = :pageId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':userId' => $userId, ':pageId' => $pageId]);
        return $stmt->fetchColumn() > 0;
    }

    public function ratePage($userId, $pageId, $rating){
        $query = "INSERT INTO pages_rating (user_id, page_id, rating) VALUES (:userId, :pageId, :rating)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':pageId', $pageId);
        $stmt->bindParam(':rating', $rating);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getPages($userId){
        $query = "
        SELECT 
            p.id,
            p.title,
            p.description,
            p.link,
            p.blocked,
            AVG(r.rating) AS average_rating,
            CASE WHEN r2.user_id IS NULL THEN 0 ELSE 1 END AS rated_by_user
        FROM 
            pages p
        LEFT JOIN 
            pages_rating r ON p.id = r.page_id
        LEFT JOIN 
            pages_rating r2 ON p.id = r2.page_id AND r2.user_id = :user_id
        GROUP BY 
            p.id, p.title, p.description, p.link, r2.user_id
    ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPagesAdmin(){
        $query = "
            SELECT
                p.id,
                p.title,
                p.description,
                p.link
            FROM pages p 
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRatePages() {
        $sql = "
        SELECT 
            p.id AS page_id,
            p.title AS page_title,
            u.username,
            pr.rating
        FROM pages_rating pr
        JOIN pages p ON pr.page_id = p.id
        JOIN users u ON pr.user_id = u.id
        ORDER BY p.id ASC
    ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            // Обработка ошибок
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function getRatings($pageId){
        $query = "
        SELECT 
            p.id AS page_id,
            u.username,
            pr.rating
        FROM pages_rating pr
        JOIN pages p ON pr.page_id = p.id
        JOIN users u ON pr.user_id = u.id
        WHERE pr.page_id = :pageId
        ORDER BY p.id ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':pageId' => $pageId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPage($pageId){
        $query = "
            SELECT
                id,
                title,
                description,
                link
            FROM pages
            WHERE id = :pageId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':pageId' => $pageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function deletePageRate($pageId){
        $query = "DELETE FROM pages_rating WHERE page_id = :pageId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':pageId' => $pageId]);
    }
}