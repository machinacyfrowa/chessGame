<?php
require('Piece.class.php');

class GameManager
{
    private $board;

    public function __construct()
    {
        $this->board = array();
        $this->board['A8'] = new Piece('black', 'rook');
        $this->board['H8'] = new Piece('black', 'rook');
        $this->board['B8'] = new Piece('black', 'knight');
        $this->board['G8'] = new Piece('black', 'knight');
        $this->board['C8'] = new Piece('black', 'bishop');
        $this->board['F8'] = new Piece('black', 'bishop');
        $this->board['D8'] = new Piece('black', 'queen');
        $this->board['E8'] = new Piece('black', 'king');
    }
    public function getBoardHTML(): string
    {
        $html = "<div id=\"grid-container\">";
        for ($i = 8; $i >= 1; $i--) {
            for ($j = 65; $j <= 72; $j++) {
                $position = chr($j) . $i;
                if (($i + $j) % 2)
                    $class = "black";
                else
                    $class = "white";
                $html .= "<div id=\"$position\" class=\"$class\">";
                if (isset($this->board[$position]))
                    $html .= $this->board[$position]->getHTML();
                $html .= "</div>"; //pole
            }
        }
        $html .= "</div>"; //grid-container
        return $html;
    }
    public function movePiece(string $s, string $d) { //source, destination
        if(isset($this->board[$s])) {
            $this->board[$d] = clone $this->board[$s]; //skopiuj
            unset($this->board[$s]);
        }
    }
}
