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
        if($this->checkMove($s, $d))
        {
            echo "Ruch legalny";
            if(isset($this->board[$s])) {
                $this->board[$d] = clone $this->board[$s]; //skopiuj
                unset($this->board[$s]);
            }
        } 
        else 
            echo "ruch nielegalny";
    }
    public function checkMove(string $s, string $d) : bool {
        echo "sprawdzam ruch...";
        if(!isset($this->board[$s]))
            return false;
        if($s == $d) //przestawiamy w tym samym miejscu
            return false;
        if(isset($this->board[$d]))
        {
            //nie stawiamy na puste
            if($this->board[$s]->getColor() == $this->board[$d]->getColor()) //probujemy postawic na swoim pionku
                return false;
        }
        
        // $s - pole z którego podnosimy figurę
        // $d - docelowe współrzędne w formacie 'A1'
        $deltaX = ord($d) - ord($s); //różnica w kolumnach
        $deltaY = intval($d[1]) - intval($s[1]); //różnica w wieszach   
        //var_dump($deltaX);
        //var_dump($deltaY);   
        //sprawdz czy nie ma figury "po drodze" 
        $x = 0; //przesunieciex
        $y = 0; //przesnieciey
        while($x != $deltaX || $y != $deltaY) {
            if($this->board[$s]->getType() == 'knight')
                break;
            if ($x < $deltaX) $x++;
            if ($x > $deltaX) $x--;
            if ($y < $deltaY) $y++;
            if ($y > $deltaY) $y--;
            //echo "Przesuniecie x: $x, przesuniecie y: $y<br>";
            $coord = chr(ord($s) + $x) . (intval($s[1])+$y);
            if($coord == $d) break;
            if(isset($this->board[$coord]))
                return false;     
        }
        switch($this->board[$s]->getType()) {
            case 'rook': //kod sprawdzania poprawności ruchu dla wieży
                if($deltaX == 0 || $deltaY == 0) //porusza się tylko w pionie lub poziomie
                    return true;                
                return false;
            break;
            case 'knight':
                if(abs($deltaX) + abs($deltaY) == 3 && $deltaX != 0 && $deltaY != 0)
                    return true;
                return false;
            break;
            case 'bishop':
                if(abs($deltaX) == abs($deltaY))
                    return true;
                return false;
            break;
            case 'queen':
                if( ($deltaX == 0 || $deltaY == 0) || abs($deltaX) == abs($deltaY) )
                    return true;
                return false;
            break;
            case 'king':
                if(abs($deltaX) <= 1 && abs($deltaY) <= 1)
                    return true;
                return false;
            break;
            case 'pawn':
                //todo: ruchy pionka
                return false;
            break;
            default:
                return false;
        }
    }
}
