<?php
namespace CJimenez\AergereDichNicht\Test;

use PHPUnit\Framework\TestCase;
use CJimenez\AergereDichNicht\Game;


/**
 * Description of GameTest
 *
 * @author cristobal
 */
class GameTest extends TestCase
{
    public function testInitializationGame() {
        $game = new Game();
        $players = $game->getPlayers();
        
        $this->assertEquals(Game::TEAM_YELLOW, $players[1]->getColor());
        $this->assertEquals(Game::TEAM_RED, $players[2]->getColor());
        $this->assertEquals(Game::TEAM_BLUE, $players[3]->getColor());
        $this->assertEquals(Game::TEAM_GREEN, $players[4]->getColor());
        
        $yellowTeam = $players[1];
        $this->assertEquals(Game::TEAM_YELLOW, $yellowTeam->getColor());
        $pieces = $yellowTeam->getPieces();
        foreach ($pieces as $piece) {
           $this->assertEquals(Game::HOME, $piece); 
        }
    }
    
    public function testReturnStartbyColor(){
        $game = new Game();
        $this->assertEquals(1, $game->returnStartbyColor(Game::TEAM_YELLOW)); 
        $this->assertEquals(11, $game->returnStartbyColor(Game::TEAM_RED));
        $this->assertEquals(21, $game->returnStartbyColor(Game::TEAM_BLUE));
        $this->assertEquals(31, $game->returnStartbyColor(Game::TEAM_GREEN));
    }
    
    public function testReturnEndbyColor(){
        $game = new Game();
        $this->assertEquals(40, $game->returnEndbyColor(Game::TEAM_YELLOW)); 
        $this->assertEquals(10, $game->returnEndbyColor(Game::TEAM_RED));
        $this->assertEquals(20, $game->returnEndbyColor(Game::TEAM_BLUE));
        $this->assertEquals(30, $game->returnEndbyColor(Game::TEAM_GREEN));
    }
    
    public function testnowinner() {
        $game = new Game();
        $this->assertEquals(false, $game->winner()); 
    }
    
    public function testwinner() {
        $game = new Game();
        $players = $game->getPlayers();
        $player = $players[2];
        $player->setPositionPiece(1, Game::END_RED);
        $player->setPositionPiece(2, Game::END_RED);
        $player->setPositionPiece(3, Game::END_RED);
        $player->setPositionPiece(4, Game::END_RED);
        $this->assertEquals(true, $game->winner()); 
    }
    
    public function testStartGame(){
        $game = new Game();
        $players = $game->getPlayers();
            
        $yellow = $players[1];
        $red = $players[2];
        $yellow->setPositionPiece(1, 20);
        $red->setPositionPiece(4, 25);
        
        $this->assertEquals([20,-1,-1,-1], [$yellow->getPieces()[1],$yellow->getPieces()[2],$yellow->getPieces()[3],$yellow->getPieces()[4]]);
        $this->assertEquals([-1,-1,-1,25], $red->getPositionPieces());   
    }
    
    public function testSetLastMovement(){
        $game = new Game();
        $this->assertEquals(["default", -1], [$game->getLastMovement()['color'],$game->getLastMovement()['position']]);
        $game->setLastMovement("yellow", 20);
        $this->assertEquals(["yellow", 20], [$game->getLastMovement()['color'],$game->getLastMovement()['position']]);
    }

    public function testUpdatePositionAllPlayer(){
        $game = new Game();
        $players = $game->getPlayers();
        
        $currentPlayer = $players[1];
        $secondPlayer = $players[2];
        
        $currentPlayer->setPositionPiece(2, 20);
        $secondPlayer->setPositionPiece(2, 20);
        
        $game->setLastMovement($currentPlayer->getColor(), 20);
        
        
        $game->updatePositionAllPlayers(1);
        $this->assertEquals([-1,-1,-1,-1], $secondPlayer->getPositionPieces());
        
    }
    
    public function testIniPositionIsFree() {
        $game = new Game();
        $players = $game->getPlayers();
        $actual = $players[3];
        
        $actual->setPositionPiece(1, 20);
        $actual->setPositionPiece(2, 31);//INI_GREEN
        $actual->setPositionPiece(3, 11);//INI_RED
        $actual->setPositionPiece(4, 1);//INI_YELLOW
        $this->assertEquals(true, $game->iniPositionIsFree($actual->getPositionPieces(), $actual->getColor()));
        
    }
    
    public function testPlayerTakePieceOut() {
        $game = new Game();
        $players = $game->getPlayers();
        $yellow = $players[1];
        
        $game->playerTakePieceOut($yellow); 
        $this->assertEquals([1,-1,-1,-1], $yellow->getPositionPieces());
        
        $yellow->setPositionPiece(1, 5);
        
        $game->playerTakePieceOut($yellow); 
        $this->assertEquals([5,1,-1,-1], $yellow->getPositionPieces());
        
        $red = $players[2];
        $game->playerTakePieceOut($red); 
        $this->assertEquals([11,-1,-1,-1], $red->getPositionPieces());
    }
    
    public function testUpdateActualPlayer() {
        $actual = 1;
        $actual = $actual++<4 ? $actual++ :1;
        $this->assertEquals(2, $actual);
        
    }
    
    public function testPlayerTurn(){
        $game = new Game();
        $players = $game->getPlayers();
        $yellow = $players[1];
        $red = $players[2];
        

        //Piece 1° from Red, get into INI_YEllOW
        $red->setPositionPiece(1, 1);
        $this->assertEquals([1,-1,-1,-1], $red->getPositionPieces());
        
        
        //Piece 1° from Yellow comes out
        $game->playerTurn(1, 6);
        //Update LastMovement needed for UpdatePosionAllPlayers
        $game->setLastMovement("yellow", 1);
        $game->updatePositionAllPlayers(1);
        
        //Checking possiton Red and Yellow after UpdatePositionAllPlayer
        $this->assertEquals([1,-1,-1,-1], $yellow->getPositionPieces());
        $this->assertEquals([-1,-1,-1,-1], $red->getPositionPieces());
    }
    
}
