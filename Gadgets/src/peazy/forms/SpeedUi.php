<?php

namespace peazy\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;

class SpeedUi {

	public static function open(Player $player) {
		$form = new SimpleForm(function(Player $player, int $data = null){
			if ($data === null){
				return false;
			}
			switch ($data){
				case 0:
					$player->setMovementSpeed(0.1);
					$player->sendMessage("§aDu bist jetzt Super Langsam!");
					break;
				case 1:
					$player->setMovementSpeed(0.3);
					$player->sendMessage("§aDu bist jetzt Langsam!");
					break;
				case 2:
					$player->setMovementSpeed(0.10);
					$player->sendMessage("§aDu bist jetzt wieder Normal Schnell!");
					break;
				case 3:
					$player->setMovementSpeed(0.40);
					$player->sendMessage("§aDu bist jetzt schnell!");
					break;
				case 4:
					$player->setMovementSpeed(1);
					$player->sendMessage("§aDu bist jetzt Super Schnell!");
					break;
			}
		});
		$form->setTitle("§eGeschwindigkeit");
		$form->setContent("Stelle ein welche Geschwindigkeit du bekommen sollst!");
		$form->addButton("§7Sehr Langsam!");
		$form->addButton("§7Langsam!");
		$form->addButton("§7Normal!");
		$form->addButton("§7Schnell!");
		$form->addButton("§7Sehr Schnell!");
		$player->sendForm($form);
	}

}