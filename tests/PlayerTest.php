<?php


namespace CJimenez\AergereDichNicht\Test;

use PHPUnit\Framework\TestCase;
use CJimenez\AergereDichNicht\Player;
use CJimenez\AergereDichNicht\Game;
/**
 * Description of PlayerTest
 *
 * @author cristobal
 */
class PlayerTest extends TestCase
{
    
    public function testPlayers() {
        $player = new Player(Game::TEAM_RED);
        
        $this->assertEquals('red', $player->getColor());
        $pieces = $player->getPieces();
        foreach ($pieces as $piece) {
           $this->assertEquals(-1, $piece); 
        }
    }
    
    public function testPositionPieces(){
        $player = new Player(Game::TEAM_YELLOW);
        $player->setPositionPiece(2, 20);
        $this->assertEquals([-1,20,-1,-1], $player->getPositionPieces());
    }
    
    public function testSetPositionPiece() {
        $player = new Player(Game::TEAM_RED);
        $player->setPositionPiece(1, Game::END_RED);
        $player->setPositionPiece(2, Game::END_RED);
        $player->setPositionPiece(3, Game::END_RED);
        $player->setPositionPiece(4, Game::END_RED);
        $pieces = $player->getPieces();
        foreach ($pieces as $piece) {
            $this->assertEquals(10, $piece);
        }
    }
}
