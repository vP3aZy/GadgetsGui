<?php

namespace peazy\commands;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use peazy\forms\SpeedUi;
use peazy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemIds;
use pocketmine\item\VanillaItems;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;

class GadgetsCommand extends Command {

	public function __construct() {
		parent::__construct("gadgets", "Öffne das Gadgets Menü!", false, ["ggm"]);
		$this->setPermission("gadgets.use");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if ($sender instanceof Player){
			if ($this->testPermission($sender)){
				$menu = InvMenu::create(InvMenu::TYPE_CHEST);
				$inventory = $menu->getInventory();
				$inventory->setItem(10, VanillaItems::FEATHER()->setCustomName("§dFliegen"));
				$inventory->setItem(13, VanillaItems::ENDER_PEARL()->setCustomName("§aUnsichtbar"));
				$inventory->setItem(16, VanillaItems::SLIMEBALL()->setCustomName("§eGeschwindigkeit"));
				$menu->setListener(function (InvMenuTransaction $transaction) : InvMenuTransactionResult {
					if($transaction->getOut()->getId() === ItemIds::FEATHER){
						$player = $transaction->getPlayer();
						$player->setAllowFlight(!$player->getAllowFlight());
						$player->setFlying(!$player->isFlying());
						$player->sendMessage(($player->getAllowFlight() || $player->isFlying() ? "§aDu kannst nun fliegen!" : "§4Du kannst nun nicht mehr fliegen!"));
						return $transaction->discard();
					}
					if($transaction->getOut()->getId() === ItemIds::ENDER_PEARL){
						$player = $transaction->getPlayer();
						if (!in_array($player->getName(), Main::$vanish)){
							Main::$vanish[] = $player->getName();
							$player->setInvisible(true);
							$player->sendMessage("§aDu bist nun sichtbar!");
						}else{
							unset(Main::$vanish[$player->getName()]);
							$player->setInvisible(false);
							$player->sendMessage("§cDu bist nun nicht mehr Unsichtbar!");
						}
						return $transaction->discard();
					}
					if($transaction->getOut()->getId() === ItemIds::SLIMEBALL){
						$transaction->getPlayer()->removeCurrentWindow();
						SpeedUi::open($transaction->getPlayer());
						return $transaction->discard();
					}
				});
				$menu->send($sender, "§bGadgets §3Menü");
			}else{
				$sender->sendMessage("§4Dafür fehlen dir leider die Benötigten Berechtigungen!");
			}
		}else{
			$sender->sendMessage("§cIrgendetwas ist da falsch?");
		}
	}

}