<?php

namespace peazy;

use muqsit\invmenu\InvMenuHandler;
use peazy\commands\GadgetsCommand;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	public static array $vanish = [];

    public function onEnable(): void{
        $this->getLogger()->info("§aDas Plugin wurde geladen! :3");
        $this->getLogger()->info("§bPlugin by YourPeaZ");

        $this->getServer()->getCommandMap()->register("gadgets", new GadgetsCommand());

        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
    }
}
