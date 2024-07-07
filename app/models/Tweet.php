<?php
class Tweet {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getTweets() {
        $this->db->query('SELECT tweets.*, users.username FROM tweets INNER JOIN users ON tweets.user_id = users.id ORDER BY tweets.created_at DESC');
        return $this->db->resultSet();
    }

    public function addTweet($data) {
        $this->db->query('INSERT INTO tweets (user_id, tweet) VALUES (:user_id, :tweet)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':tweet', $data['tweet']);
        return $this->db->execute();
    }

    public function getUserTweets($userId) {
        $this->db->query('SELECT * FROM tweets WHERE user_id = :user_id ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
?>
