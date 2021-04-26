<?php
class DB {
    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli('localhost', 'root', '', 'chess');
    }

    public function newGame(int $whitePlayerID, int $blackPlayerID) : int
    {
        $query = $this->connection->prepare("INSERT INTO game (id, whitePlayer, blackPlayer) VALUES (NULL, ?, ?)");
        $query->bind_param('ii', $whitePlayerID, $blackPlayerID);
        $query->execute();
        return $query->insert_id;
    }

    public function saveMove(int $gameID, string $source, string $destination, string $pieceType)
    {
        $this->connection = new mysqli('localhost', 'root', '', 'chess');
        $query = $this->connection->prepare("INSERT INTO move (id, source, destination, gameID, pieceType) VALUES (NULL, ?, ?, ?, ?)");
        $query->bind_param('ssis', $source, $destination, $gameID, $pieceType);
        $query->execute();
        $this->connection->close();
    }
}
?>