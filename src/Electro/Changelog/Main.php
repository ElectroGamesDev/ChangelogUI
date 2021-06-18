<?php

namespace Electro\Changelog;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class Main extends PluginBase implements Listener{
   
   public function onEnable(){
       $this->saveDefaultConfig();
   }

   public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
       switch($cmd->getName()) {
             case "changelog":
                 if($sender instanceof Player) {
                    $this->openChangelog($sender);
                 }else{
                        $sender->sendMessage("§cThis command can only be used in-game");
                        return true;
                    }
                 return true;
       }
       return true;
   }

   public function openChangelog($sender){ 
       $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
       $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
           $result = $data;
           if($result === null){
               return true;
           }             
           });
           $form->setTitle($this->getConfig()->get("title"));
           $form->setContent($this->getConfig()->get("description"));
           $form->addButton($this->getConfig()->get("close_button"), 0, "textures/ui/realms_green_check");
           $form->sendToPlayer($sender);
           return $form;
   }
}
