<?php

namespace  CJimenez\AergereDichNicht;

/**
 * Representation of the Player for the game Ärgere Dich Nicht
 *
 * @author cristobal
 */
class Player 
{
    private $color;
    
    private $pieces = [];
    
    public function __construct($color) {
        $this->color = $color;
        $this->pieces[1] = Game::HOME;
        $this->pieces[2] = Game::HOME;
        $this->pieces[3] = Game::HOME;
        $this->pieces[4] = Game::HOME;
        
    }
    
    public function getColor() {
        return $this->color;
    }
    
    public function getPieces() {
        return $this->pieces;
    }
    
    public function setPositionPiece($piece, $newposition) {
        $this->pieces[$piece] = $newposition;
    }
    
    public function getPositionPieces(){
        return [$this->pieces[1],$this->pieces[2],$this->pieces[3],$this->pieces[4]];
    }
}
