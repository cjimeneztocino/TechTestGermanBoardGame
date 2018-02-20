<?php

namespace CJimenez\AergereDichNicht;

/**
 * Description of Game
 *
 * @author cristobal
 */
class Game 
{
    const TEAM_YELLOW = "yellow";
    const INI_YELLOW = 1;
    const END_YELLOW = 40;
    const TEAM_RED = "red";
    const INI_RED = 11;
    const END_RED = 10;
    const TEAM_BLUE = "blue";
    const INI_BLUE = 21;
    const END_BLUE = 20;
    const TEAM_GREEN = "geen";
    const INI_GREEN = 31;
    const END_GREEN = 30;
    const HOME = -1;
    
    private $players = [];
    
    private $lastMovement;
    
    function __construct() {
        $this->players[1] = new Player(Game::TEAM_YELLOW);
        $this->players[2] = new Player(Game::TEAM_RED);
        $this->players[3] = new Player(Game::TEAM_BLUE);
        $this->players[4] = new Player(Game::TEAM_GREEN);
        $this->lastMovement = [
            "color" => "default",
            "position" => Game::HOME
        ];
    }

    public function getPlayers() {
        return $this->players;
    }
    
    public function setLastMovement($color, $pieceposition){
        $this->lastMovement['color'] = $color;
        $this->lastMovement['position'] = $pieceposition;
    }
 
    function getLastMovement() {
        return $this->lastMovement;
    }
    
            
    public function startGame(){
        $winner = $this->winner();
//      int $actualPlayer = getFirstPlayerToPlay();
//      while (!$winner) {
//          $dice = getDiceThrow();
//          $this->playerTurn($actualPlayer, $dice);
//          
//          $this->updatePositionAllPlayers($actualPlayer);
//          $actualPlayer= $actualPlayer++<4 ? $actualPlayer++ :1;  
//            
//          $winner = $this->winner();    
//      }
    }
    
    public function winner() {
        $winner = false;
        foreach ($this->players as $player) {
            $pieces = $player->getPieces();
            $end = $this->returnEndbyColor($player->getColor());
            if($pieces[1] == $end && $pieces[2] == $end && $pieces[3] == $end && $pieces[4] == $end) {
                $winner = true;
            }
        }
        return $winner;
    }
    
    public function returnStartbyColor($color) {
        switch ($color) {
            case Game::TEAM_YELLOW:
                return Game::INI_YELLOW;
            case Game::TEAM_RED:
                return Game::INI_RED;
            case Game::TEAM_BLUE:
                return Game::INI_BLUE;
            case Game::TEAM_GREEN:
                return Game::INI_GREEN;
            default:
                break;
        }
    }
    public function returnEndbyColor($color) {
        switch ($color) {
            case Game::TEAM_YELLOW:
                return Game::END_YELLOW;
            case Game::TEAM_RED:
                return Game::END_RED;
            case Game::TEAM_BLUE:
                return Game::END_BLUE;
            case Game::TEAM_GREEN:
                return Game::END_GREEN;
            default:
                break;
        }
    }
    
    public function updatePositionAllPlayers($actualPlayer) {
        $actual = $this->players[$actualPlayer];
        
        foreach ($this->players as $player) {
            if ($this->lastMovement['color']!= $player->getColor()) {
                $pices = $player->getPieces();
                for ($i=1; $i < count($pices); $i++){
                    if($pices[$i] == $this->lastMovement['position']) {
                        $player->setPositionPiece($i, Game::HOME);
                    }
                }
            }
        }
    }
    
    public function playerTurn($actualPlayer, $dice) {
        $actual = $this->players[$actualPlayer];
        
        
        if($dice == 6) {
           if (!$this->playerTakePieceOut($actual)){
                //$this->playerMakesMove($actual, $dice);
           } 
        }
        if ($dice<6){
            //$this->playerMakesMove($actual, $dice);
        }
    }
    
    public function playerTakePieceOut($actual) {
        $i=1;
        if ($this->iniPositionIsFree($actual->getPieces(), $actual->getColor())){
            while ($actual->getPieces()[$i] != Game::HOME && $i < 4) {
                $i++;
            }
            if ($i <= 4) {
                $actual->setPositionPiece($i, $this->returnStartbyColor($actual->getColor()));
                return(true);
            }
        }
        return false;
    }
    
    public function iniPositionIsFree($pieces, $color) {
        $ini = $this->returnStartbyColor($color);
        foreach ($pieces as $piece) {
            if ($piece == $ini) {
                return (false);
            }
        }
        return true;
    }
//    playerMakesMove($actual, $dice){
//     Decide which Piece from the Actual Player move.
//     Update position of the Pieces of Actuall Player
//     Update $this->lastMovement
//    
//}
//    
//    getFirstPlayerToPlay() {
//      Decide which player is the first to play.
//    }
}
