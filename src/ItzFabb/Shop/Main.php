<?php



namespace ItzFabb\Shop;

//Essentials Class
use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\Commandsender;

use pocketmine\inventory\transaction\action\SlotChangeAction;

use pocketmine\item\Item;

use pocketmine\utils\TextFormat;
use pocketmine\utils\TextFormat as TF;

use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use libs\muqsit\invmenu\InvMenu;
use libs\muqsit\invmenu\InvMenuHandler;

use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{
	
	public function onEnable(){
		//OnEnable 
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		$this->menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
		
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
		//Log Info
          $this->getLogger()->info(" _______  __   __  _______  _______  _______  __   __  ___");    
          $this->getLogger()->info("|       ||  | |  ||       ||       ||       ||  | |  ||   |");
          $this->getLogger()->info("|  _____||  |_|  ||   _   ||    _  ||    ___||  | |  ||   |  ____");
          $this->getLogger()->info("| |_____ |       ||  | |  ||   |_| ||   | __ |  |_|  ||   | |____|");
          $this->getLogger()->info("|_____  ||       ||  |_|  ||    ___||   ||  ||       ||   |");
          $this->getLogger()->info(" _____| ||   _   ||       ||   |    |   |_| ||       ||   |"); 
          $this->getLogger()->info("|_______||__| |__||_______||___|    |_______||_______||___|");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info("ShopGUI- Has Been Enabled!");
          $this->getLogger()->info("Plugin Version: 2.0");
          $this->getLogger()->info("Api Version: 3.0.0");
          $this->getLogger()->info("Plugin Software: Pocketmine");
          $this->getLogger()->info("Author: ItzFabb");
          $this->getLogger()->info("(NOTE): this plugin is not premium!");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info(" §r ");
          $this->getLogger()->info(" §r ");
	}
	//Command 
	public function onCommand(Commandsender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "shop"){

          $name = $sender->getName();
            if(!$sender instanceof Player){
                $sender->sendMessage(TextFormat::RED . "§cError!: §7Use this command in-game");
                return false;
            }
            if(!$sender->hasPermission("use.shop.menu")){
                $sender->sendMessage(TextFormat::RED . "§cError!: §7You don't have permission to use this command");
                $volume = mt_rand();
	              $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
                return false;
            }
            $this->shop($sender);
            $volume = mt_rand();
	       $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        return true;
	}
	/**
	 * 
	 * SHOP MAIN MENU
	 * 
	 * 
	 * */
	public function shop($sender)
	{
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "shopmenu"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //Chest Section 1-8
	    $inventory->setItem(0, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(1, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(2, Item::get(1, 0, 1)->setCustomName("§r§e§l§nBLOCKS SHOP\n§r\n§7This shop contains blocks that\n§7to build up your project...\n\n§eInformations:\n§8§l■ §r§7Category: §eBlocks\n§8§l■ §r§7Contains: §e§n72 Blocks§r\n\n§9(Click to open)"));
	    $inventory->setItem(3, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(4, Item::get(47, 0, 1)->setCustomName("§r§e§l§nDECORATIONS SHOP\n§r\n§7This shop contains Decorations blocks\n§7to make your home more modern...\n\n§eInformations:\n§8§l■ §r§7Category: §eDecorations\n§8§l■ §r§7Contains: §e§n24 Decorations§r\n\n§9(Click to open)"));
	    $inventory->setItem(5, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(6, Item::get(170, 0, 1)->setCustomName("§r§e§l§nFARMS SHOP\n§r\n§7This shop contains farms stuffs\n§7to make your farm growth goods...\n\n§eInformations:\n§8§l■ §r§7Category: §eFarms\n§8§l■ §r§7Contains: §e§n30 Farms§r\n\n§9(Click to open)"));
	    $inventory->setItem(7, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(11, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(12, Item::get(268, 0, 1)->setCustomName("§r§e§l§nTOOLS SHOP\n§r\n§7This shop contains tools to make you\n§7be more powerful at pvping...\n\n§eInformations:\n§8§l■ §r§7Category: §eTools\n§8§l■ §r§7Contains: §e§n24 Tools§r§r\n\n§9(Click to open)"));
         $inventory->setItem(13, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(14, Item::get(351, 1, 1)->setCustomName("§r§e§l§nDYES SHOP\n§r\n§7This shop contains Dyes from flowers \n§7so that you can colored ur bed or ur wool...\n§7etc..\n\n§eInformations:\n§8§l■ §r§7Category: §eDyes\n§8§l■ §r§7Contains: §e§n19 Dyes§r§r\n\n§9(Click to open)"));
         $inventory->setItem(15, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(16, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(17, Item::get(160, 9, 1)->setCustomName(" §r §7 §r"));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
         $inventory->setitem(19, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(20, Item::get(289, 0, 1)->setCustomName("§r§e§l§nMOB DROPS SHOP\n§r\n§7This shop contains Mob Drops\n§7so you dont need to kill mobs...\n\n§eInformations:\n§8§l■ §r§7Category: §eMob Drops\n§8§l■ §r§7Contains: §e§n17 Mob Drops§r\n\n§9(Click to open)"));
	    $inventory->setItem(21, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(22, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(23, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(24, Item::get(264, 0, 1)->setCustomName("§r§e§l§nORES SHOP\n§r\n§7This shop contains ores thats is so\n§7expensive and gorgeous price...\n\n§eInformations:\n§8§l■ §r§7Category: §eOres\n§8§l■ §r§7Contains: §e§n21 Ores§r\n\n§9(Click to open)"));
	    $inventory->setItem(25, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(26, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
	    //Chest Section 27-35
	    $inventory->setItem(27, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(28, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(29, Item::get(297, 0, 1)->setCustomName("§r§e§l§nFOODS SHOP\n§r\n§7This shop contains Foods that\n§7to make ur felt more energy...\n\n§eInformations:\n§8§l■ §r§7Category: §eFoods\n§8§l■ §r§7Contains: §e§n20 Foods§r\n\n§9(Click to open)"));
	    $inventory->setItem(30, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(31, Item::get(35, 0, 1)->setCustomName("§r§e§l§nWOOLS SHOP\n§r\n§7This shop contains wools\n§7to make your life colorful :3...\n\n§eInformations:\n§8§l■ §r§7Category: §eWools\n§8§l■ §r§7Contains: §e§n48 Wools§r\n\n§9(Click to open)"));
	    $inventory->setItem(32, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(33, Item::get(20, 0, 1)->setCustomName("§r§e§l§nGLASS SHOP\n§r\n§7This shop contains colorful glass\n§7to make your house colorful...\n\n§eInformations:\n§8§l■ §r§7Category: §eGlass\n§8§l■ §r§7Contains: §e§n32 Glass§r\n\n§9(Click to open)"));
	    $inventory->setItem(34, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(35, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(236, 0, 1)->setCustomName("§r§e§l§nCONCRETES SHOP\n§r\n§7This shop contains concretes to make your\n§7project more colorful and full of life...\n\n§eInformations:\n§8§l■ §r§7Category: §eConcretes\n§8§l■ §r§7Contains: §e§n32 Concretes§r\n\n§9(Click to open)"));
         $inventory->setItem(40, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(373, 1, 1)->setCustomName("§r§e§l§nPOTIONS SHOP\n§r\n§7This shop contains potions boosters\n§7that could give u more power...\n\n§eInformations:\n§8§l■ §r§7Category: §ePotions\n§8§l■ §r§7Contains: §e§n58 Potions§r\n\n§9(Click to open)"));
         $inventory->setItem(42, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 9, 1)->setCustomName(" §r §7 §r"));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
         $inventory->setitem(46, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(48, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
	    $inventory->setItem(50, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(51, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(52, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(53, Item::get(160, 9, 1)->setCustomName(" §r §7 §r "));
	    
	    $this->menu->send($sender);
	}
	public function shopmenu(Player $sender, Item $item){
	   $hand = $sender->getInventory()->getItemInHand()->getCustomName();
        $inventory = $this->menu->getInventory();
        
        if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 8){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        //Blocks shop function ✓
        if($item->getId() == 1 && $item->getDamage() == 0){
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        	$this->blocks($sender);
        }
        //Decorations shop function ✓
        if($item->getId() == 47 && $item->getDamage() == 0){
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        	$this->decorations($sender);
        }
        //Farms shop funtion ✓
        if($item->getId() == 170 && $item->getDamage() == 0){
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        	$this->farms($sender);
        }
        //Tools shop function ✓
        if($item->getId() == 268 && $item->getDamage() == 0){
        	$this->tools($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Dyes shop function ✓
        if($item->getId() == 351 && $item->getDamage() == 1){
        	$this->dyes($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Mobdrops shop function ✓
        if($item->getId() == 289 && $item->getDamage() == 0){
        	$this->mobsdrops($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Ores shop function ✓
        if($item->getId() == 264 && $item->getDamage() == 0){
        	$this->ores($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Foods shop function ✓
        if($item->getId() == 297 && $item->getDamage() == 0){
        	$this->foods($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Wools shop function ✓
        if($item->getId() == 35 && $item->getDamage() == 0){
        	$this->wools($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Glass shop function ✓
        if($item->getId() == 20 && $item->getDamage() == 0){
       	$this->glass($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Concrete shop function ✓
        if($item->getId() == 236 && $item->getDamage() == 0){
        	$this->concretes($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        //Potions shop function X 
        if($item->getId() == 373 && $item->getDamage() == 1){
        	$sender->removeWindow($inventory);
        	$sender->sendMessage("§8[§eShopGUI-§8] §r§7This features is coming soon! ^^ Join at ItzFabb §9Discord Server §7for an shopgui- update!");
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
	}
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * CONCRETES SHOP PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function concretes($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "concretesshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(236, 0, 1)->setCustomName("§r§fWhite Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(1, Item::get(236, 1, 1)->setCustomName("§r§fOrange Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(2, Item::get(236, 2, 1)->setCustomName("§r§fMagenta Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(3, Item::get(236, 3, 1)->setCustomName("§r§fLight Blue Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setitem(4, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(5, Item::get(237, 0, 1)->setCustomName("§r§fWhite Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(6, Item::get(237, 1, 1)->setCustomName("§r§fOrange Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(7, Item::get(237, 2, 1)->setCustomName("§r§fMagenta Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(8, Item::get(237, 3, 1)->setCustomName("§r§fLight Blue Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(236, 4, 1)->setCustomName("§r§fYellow Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(10, Item::get(236, 5, 1)->setCustomName("§r§fLime Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(11, Item::get(236, 6, 1)->setCustomName("§r§fPink Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(12, Item::get(236, 7, 1)->setCustomName("§r§fGray Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(13, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(14, Item::get(237, 4, 1)->setCustomName("§r§fYellow Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(15, Item::get(237, 5, 1)->setCustomName("§r§fLime Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(16, Item::get(237, 6, 1)->setCustomName("§r§fPink Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(17, Item::get(237, 7, 1)->setCustomName("§r§fGray Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(236, 8, 1)->setCustomName("§r§fLight Gray Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(19, Item::get(236, 9, 1)->setCustomName("§r§fCyan Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(20, Item::get(236, 10, 1)->setCustomName("§r§fPurple Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(21, Item::get(236, 11, 1)->setCustomName("§r§fBlue Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(22, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(23, Item::get(237, 8, 1)->setCustomName("§r§fLight Gray Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(24, Item::get(237, 9, 1)->setCustomName("§r§fCyan Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(25, Item::get(237, 10, 1)->setCustomName("§r§fPurple Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(26, Item::get(237, 11, 1)->setCustomName("§r§fBlue Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(236, 12, 1)->setCustomName("§r§fBrown Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(28, Item::get(236, 13, 1)->setCustomName("§r§fGreen Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(29, Item::get(236, 14, 1)->setCustomName("§r§fRed Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(30, Item::get(236, 15, 1)->setCustomName("§r§fBlack Concrete\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
         $inventory->setItem(31, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(32, Item::get(237, 12, 1)->setCustomName("§r§fBrown Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(33, Item::get(237, 13, 1)->setCustomName("§r§fGreen Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(34, Item::get(237, 14, 1)->setCustomName("§r§fRed Powder Concrete\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(35, Item::get(237, 15, 1)->setCustomName("§r§fBlack Powder Concrete\n§7Cost: §a§l⛃§r§a5.0 §r"));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 10, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6concrete and concrete powders! §7you could §abuy"));
         
         $this->menu->send($sender);
        } 
        public function concretesshop(Player $sender, Item $item){ 
        	$hand = $sender->getInventory()->getItemInHand()->getCustomName();
          $inventory = $this->menu->getInventory();
          
        if($item->getId() == 152 && $item->getDamage() == 0){
       	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 10){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 160 && $item->getDamage() == 0){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 236 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 237 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(237, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Powder Concrete§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * GLASS SHOP PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function glass($sender){
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "glassshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(241, 0, 1)->setCustomName("§r§fWhite Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(1, Item::get(241, 1, 1)->setCustomName("§r§fOrange Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(2, Item::get(241, 2, 1)->setCustomName("§r§fMagenta Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(3, Item::get(241, 3, 1)->setCustomName("§r§fLight Blue Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setitem(4, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(5, Item::get(160, 0, 1)->setCustomName("§r§fWhite Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(6, Item::get(160, 1, 1)->setCustomName("§r§fOrange Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(7, Item::get(160, 2, 1)->setCustomName("§r§fMagenta Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(8, Item::get(160, 3, 1)->setCustomName("§r§fLight Blue Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(241, 4, 1)->setCustomName("§r§fYellow Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(10, Item::get(241, 5, 1)->setCustomName("§r§fLime Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(11, Item::get(241, 6, 1)->setCustomName("§r§fPink Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(12, Item::get(241, 7, 1)->setCustomName("§r§fGray Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(13, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(14, Item::get(160, 4, 1)->setCustomName("§r§fYellow Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(15, Item::get(160, 5, 1)->setCustomName("§r§fLime Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(16, Item::get(160, 6, 1)->setCustomName("§r§fPink Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(17, Item::get(160, 7, 1)->setCustomName("§r§fGray Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(241, 8, 1)->setCustomName("§r§fLight Gray Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(19, Item::get(241, 9, 1)->setCustomName("§r§fCyan Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(20, Item::get(241, 10, 1)->setCustomName("§r§fPurple Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(21, Item::get(241, 11, 1)->setCustomName("§r§fBlue Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(22, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(23, Item::get(160, 8, 1)->setCustomName("§r§fLight Gray Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(24, Item::get(160, 9, 1)->setCustomName("§r§fCyan Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(25, Item::get(160, 10, 1)->setCustomName("§r§fPurple Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(26, Item::get(160, 11, 1)->setCustomName("§r§fBlue Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(241, 12, 1)->setCustomName("§r§fBrown Glass\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(28, Item::get(241, 13, 1)->setCustomName("§r§fGreen Carpet\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(29, Item::get(241, 14, 1)->setCustomName("§r§fRed Carpet\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(30, Item::get(241, 15, 1)->setCustomName("§r§fBlack Carpet\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(31, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(32, Item::get(160, 12, 1)->setCustomName("§r§fBrown Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(33, Item::get(160, 13, 1)->setCustomName("§r§fGreen Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(34, Item::get(160, 14, 1)->setCustomName("§r§fRed Stained Glass\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(35, Item::get(160, 15, 1)->setCustomName("§r§fBlack Stained Glass\n§7Cost: §a§l⛃§r§a3.0 §r"));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(101, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6glass! §7you could §abuy"));
         
         $this->menu->send($sender);
        } 
        public function glassshop(Player $sender, Item $item){ 
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
       if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 101 && $item->getDamage() == 0){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
        }
        if($item->getId() == 241 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 241 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(241, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 160 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(160, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Stained Glass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * WOOL SHOP PAGE 1 && PAGE 2
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function wools($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "woolsshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    $inventory->setItem(0, Item::get(35, 0, 1)->setCustomName("§r§fWhite Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(1, Item::get(35, 1, 1)->setCustomName("§r§fOrange Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(2, Item::get(35, 2, 1)->setCustomName("§r§fMagenta Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(3, Item::get(35, 3, 1)->setCustomName("§r§fLight Blue Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setitem(4, Item::get(35, 4, 1)->setCustomName("§r§fYellow Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(5, Item::get(35, 5, 1)->setCustomName("§r§fLime Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(6, Item::get(35, 6, 1)->setCustomName("§r§fPink Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(7, Item::get(35, 8, 1)->setCustomName("§r§fGray Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(8, Item::get(35, 8, 1)->setCustomName("§r§fLight Gray Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(35, 9, 1)->setCustomName("§r§fCyan Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(11, Item::get(35, 10, 1)->setCustomName("§r§fPurple Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(12, Item::get(35, 11, 1)->setCustomName("§r§fBlue Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(13, Item::get(35, 12, 1)->setCustomName("§r§fBrown Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(14, Item::get(35, 13, 1)->setCustomName("§r§fGreen Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(15, Item::get(35, 14, 1)->setCustomName("§r§fRed Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(16, Item::get(35, 15, 1)->setCustomName("§r§fBlack Wool\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(17, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(171, 0, 1)->setCustomName("§r§fWhite Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(19, Item::get(171, 1, 1)->setCustomName("§r§fOrange Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(20, Item::get(171, 2, 1)->setCustomName("§r§fMagenta Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(21, Item::get(171, 3, 1)->setCustomName("§r§fLight Blue Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(22, Item::get(171, 4, 1)->setCustomName("§r§fYellow Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(23, Item::get(171, 5, 1)->setCustomName("§r§fLime Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(24, Item::get(171, 6, 1)->setCustomName("§r§fPink Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(25, Item::get(171, 7, 1)->setCustomName("§r§fGray Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(26, Item::get(171, 8, 1)->setCustomName("§r§fLight Gray Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(28, Item::get(171, 9, 1)->setCustomName("§r§fCyan Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(29, Item::get(171, 10, 1)->setCustomName("§r§fPurple Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(30, Item::get(171, 11, 1)->setCustomName("§r§fBlue Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(31, Item::get(171, 12, 1)->setCustomName("§r§fBrown Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(32, Item::get(171, 13, 1)->setCustomName("§r§fGreen Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(33, Item::get(171, 14, 1)->setCustomName("§r§fRed Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(34, Item::get(171, 15, 1)->setCustomName("§r§fBlack Carpet\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(35, Item::get(159, 13, 1)->setCustomName("§r§a§lNEXT PAGE\n§r§7Click to go to the next pages!"));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 14, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(339, 2, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6wools! §7you could §abuy"));
         
         $this->menu->send($sender);
        }
        public function woolsshop(Player $sender, Item $item)
        { 
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
        if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 0){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 160 && $item->getDamage() == 14){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 159 && $item->getDamage() == 13){
        	$this->wools1($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        if($item->getId() == 35 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 35 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(35, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Wool§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 171 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(171, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Carpet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	 public function wools1($sender){
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "woolsshop1"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //Chest Section 1-8
	    $inventory->setItem(0, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(1, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(2, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(3, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(4, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(5, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(6, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(7, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(10, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(11, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(12, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(13, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(14, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(15, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(16, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(17, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(446, 0, 1)->setCustomName("§r§fBlack Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setitem(19, Item::get(446, 1, 1)->setCustomName("§r§fRed Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(20, Item::get(446, 2, 1)->setCustomName("§r§fGreen Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(21, Item::get(446, 3, 1)->setCustomName("§r§fBrown Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(22, Item::get(446, 4, 1)->setCustomName("§r§fBlue Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(23, Item::get(446, 5, 1)->setCustomName("§r§fPurple Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(24, Item::get(446, 6, 1)->setCustomName("§r§fCyan Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(25, Item::get(446, 7, 1)->setCustomName("§r§fLight Gray Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(26, Item::get(446, 8, 1)->setCustomName("§r§fGray Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    //Chest Section 27-35
	    $inventory->setItem(27, Item::get(159, 4, 1)->setCustomName("§r§e§lPREVIOUS PAGE\n§r§7Click to go to the next pages!"));
	    $inventory->setItem(28, Item::get(446, 9, 1)->setCustomName("§r§fPink Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(29, Item::get(446, 10, 1)->setCustomName("§r§fLime Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(30, Item::get(446, 11, 1)->setCustomName("§r§fYellow Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(31, Item::get(446, 12, 1)->setCustomName("§r§fLight Blue Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(32, Item::get(446, 13, 1)->setCustomName("§r§fMagenta Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(33, Item::get(446, 14, 1)->setCustomName("§r§fOrange Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
	    $inventory->setItem(34, Item::get(446, 15, 1)->setCustomName("§r§fWhite Banner\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(35, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 1, 1)->setCustomName(" §r §7 §r"));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setitem(46, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(48, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(49, Item::get(152, 2, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
	    $inventory->setItem(50, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(51, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(52, Item::get(160, 1, 1)->setCustomName(" §r §7 §r "));
	    $inventory->setItem(53, Item::get(339, 2, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6wools! §7you could §abuy"));
	    	    
	    $this->menu->send($sender);
        }
        public function woolsshop1(Player $sender, Item $item)
        { 
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
           
       if($item->getId() == 159 && $item->getDamage() == 4){
        	$this->wools($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
       if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 2){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 160 && $item->getDamage() == 1){
       	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 446 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 446 && $item->getDamage() == 15){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(446, 15, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Banner§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this blocks!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * FOODS PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function foods($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "foodsshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	 	
	     //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(1, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(2, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(3, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(4, Item::get(339, 2, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6foods! §7you could §abuy"));
         $inventory->setItem(5, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(6, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(7, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(363, 0, 1)->setCustomName("§r§fRaw Beef\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(11, Item::get(364, 0, 1)->setCustomName("§r§fCooked Beef\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(12, Item::get(365, 0, 1)->setCustomName("§r§fRaw Chicken\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(13, Item::get(354, 0, 1)->setCustomName("§r§fCake\n\n§7Cost: §a§l⛃§r§a35.0 §r"));
         $inventory->setItem(14, Item::get(366, 0, 1)->setCustomName("§r§fCooked Chicken\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(15, Item::get(319, 0, 1)->setCustomName("§r§fRaw Porkchop\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(16, Item::get(320, 0, 1)->setCustomName("§r§fCooked Porkchop\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(17, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(19, Item::get(411, 0, 1)->setCustomName("§r§fRaw Rabbit\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(20, Item::get(412, 0, 1)->setCustomName("§r§fCooked Rabbit\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(21, Item::get(423, 0, 1)->setCustomName("§r§fRaw Mutton\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(22, Item::get(357, 0, 1)->setCustomName("§r§fCookie\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(23, Item::get(424, 0, 1)->setCustomName("§r§fCooked Mutton\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(24, Item::get(463, 0, 1)->setCustomName("§r§fCooked Salmon\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(25, Item::get(350, 0, 1)->setCustomName("§r§fCooked Cod\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(26, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(28, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(29, Item::get(393, 0, 1)->setCustomName("§r§fBaked Potato\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(30, Item::get(282, 0, 1)->setCustomName("§r§fMushroom Stew\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(31, Item::get(413, 0, 1)->setCustomName("§r§fRabbit Stew\n\n§7Cost: §a§l⛃§r§a15.0 §r"));
         $inventory->setItem(32, Item::get(459, 0, 1)->setCustomName("§r§fBeetroot Soup\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(33, Item::get(396, 0, 1)->setCustomName("§r§fGolden Carrot\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(34, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(35, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(297, 0, 1)->setCustomName("§r§fBread\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(41, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 5, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         
         $this->menu->send($sender);
        } 
        public function foodsshop(Player $sender, Item $item)
        { 
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
        if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 5){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 160 && $item->getDamage() == 0){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 363 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(363, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Raw Beef§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 364 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(364, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Beef§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 365 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(365, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Raw Chicken§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 354 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 35){
	          $this->eco->reduceMoney($sender, "35"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(354, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cake§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 366 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(366, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Chicken§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 319 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(319, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Raw Porkchop§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 320 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(320, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Porkchop§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 411 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(411, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Raw Rabbit§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 412 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(412, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Rabbit§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 423 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(423, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Raw Mutton§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 424 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(424, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Mutton§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 357 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(357, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cookie§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 463 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(463, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Salmon§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 350 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(350, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cooked Cod§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 393 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(393, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Baked Potato§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 282 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(282, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Mushroom Stew§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 413 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 15){
	          $this->eco->reduceMoney($sender, "15"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(413, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Rabbit Stew§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 459 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(459, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Beetroot Soup§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 396 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(396, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Golden Carrot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 297 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(297, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bread§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this foods!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * ORES SHOP PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function ores($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "oresshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(1, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(2, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(3, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(4, Item::get(339, 2, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6ores! §7you could §abuy"));
         $inventory->setItem(5, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(6, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(7, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(16, 0, 1)->setCustomName("§r§fCoal Ore\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(11, Item::get(56, 0, 1)->setCustomName("§r§fDiamond Ore\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(12, Item::get(129, 0, 1)->setCustomName("§r§fEmerald Ore\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(13, Item::get(14, 0, 1)->setCustomName("§r§fGold Ore\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(14, Item::get(15, 0, 1)->setCustomName("§r§fIron Ore\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(15, Item::get(21, 0, 1)->setCustomName("§r§fLapis Ore\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(16, Item::get(73, 0, 1)->setCustomName("§r§fRedstone Ore\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
         $inventory->setItem(17, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(19, Item::get(263, 0, 1)->setCustomName("§r§fCoal\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(20, Item::get(264, 0, 1)->setCustomName("§r§fDiamond\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(21, Item::get(388, 0, 1)->setCustomName("§r§fEmerald\n\n§7Cost: §a§l⛃§r§a75.0 §r"));
         $inventory->setItem(22, Item::get(266, 0, 1)->setCustomName("§r§fGold\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(23, Item::get(265, 0, 1)->setCustomName("§r§fIron\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(24, Item::get(351, 4, 1)->setCustomName("§r§fLapis Lazuli\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(25, Item::get(331, 0, 1)->setCustomName("§r§fRedstone Dust\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(26, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(28, Item::get(173, 0, 1)->setCustomName("§r§fBlock of Coal\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(29, Item::get(57, 0, 1)->setCustomName("§r§fBlock of Diamond\n\n§7Cost: §a§l⛃§r§a500.0 §r"));
         $inventory->setItem(30, Item::get(133, 0, 1)->setCustomName("§r§fBlock of Emerald\n\n§7Cost: §a§l⛃§r§a1.000.0 §r"));
         $inventory->setItem(31, Item::get(41, 0, 1)->setCustomName("§r§fBlock of Gold\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(32, Item::get(42, 0, 1)->setCustomName("§r§fBlock of Iron\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(33, Item::get(22, 0, 1)->setCustomName("§r§fBlock of Lapis\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(34, Item::get(152, 0, 1)->setCustomName("§r§fBlock of Redstone\n\n§7Cost: §a§l⛃§r§a15.0 §r"));
         $inventory->setItem(35, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(159, 14, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         
         $this->menu->send($sender);
        } 
        public function oresshop(Player $sender, Item $item){ 
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
        
        if($item->getId() == 159 && $item->getDamage() == 14){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 0){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 16 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(16, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Coal Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 56 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(56, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 129 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(129, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Emerald Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 14 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(14, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 15 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(15, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 21 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(21, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lapis Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 73 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(73, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Redstone Ore§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 263 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(263, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Coal§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 264 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "5p"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(264, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 388 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 75){
	          $this->eco->reduceMoney($sender, "75"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(388, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Emerald§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 266 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(266, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Ingot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 265 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(265, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Ingot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lapis Lazuli§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 331 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(331, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Redstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 173 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(173, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Coal§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 57 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 500){
	          $this->eco->reduceMoney($sender, "500"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(57, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Diamond§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 133 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1000){
	          $this->eco->reduceMoney($sender, "1000"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(133, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Emerald§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 41 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(41, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Gold§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 42 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(42, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Iron§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 22 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(22, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Lapis§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 152 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 15){
	          $this->eco->reduceMoney($sender, "15"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(152, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Redstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this ore!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * MOB DROPS PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function mobsdrops($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "mobsdropsshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(1, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(2, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(3, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(4, Item::get(339, 2, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6mob drops! §7you could §abuy"));
         $inventory->setItem(5, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(6, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(7, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(414, 0, 1)->setCustomName("§r§fRabbit Foot\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(11, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(12, Item::get(262, 0, 1)->setCustomName("§r§fArrow\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(13, Item::get(288, 0, 1)->setCustomName("§r§fFeather\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(14, Item::get(368, 0, 1)->setCustomName("§r§fEnder Pearl\n\n§7Cost: §a§l⛃§r§a45.0 §r"));
         $inventory->setItem(15, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(16, Item::get(341, 0, 1)->setCustomName("§r§fSlime ball\n\n§7Cost: §a§l⛃§r§a7.0 §r"));
         $inventory->setItem(17, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(377, 0, 1)->setCustomName("§r§fBlaze Powder\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(19, Item::get(370, 0, 1)->setCustomName("§r§fGhast Tear\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(20, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(21, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(22, Item::get(334, 0, 1)->setCustomName("§r§fLeather\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(23, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(24, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(25, Item::get(369, 0, 1)->setCustomName("§r§fBlaze Rod\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(26, Item::get(352, 0, 1)->setCustomName("§r§fBone\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(287, 0, 1)->setCustomName("§r§fString\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(28, Item::get(367, 0, 1)->setCustomName("§r§fRotten Flesh\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(29, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(30, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(31, Item::get(289, 0, 1)->setCustomName("§r§fGunpowder\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(32, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(33, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(34, Item::get(415, 0, 1)->setCustomName("§r§fRabbit Hide\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(35, Item::get(378, 0, 1)->setCustomName("§r§fMagma Cream\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(375, 0, 1)->setCustomName("§r§fSpider Eye\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(38, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(160, 0, 1)->setCustomName("§r§fRed Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(40, Item::get(160, 0, 1)->setCustomName("§r§fGreen Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(41, Item::get(160, 0, 1)->setCustomName("§r§fPurple Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(42, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(344, 0, 1)->setCustomName("§r§fEgg\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(44, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 11, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         
         $this->menu->send($sender);
        }
        public function mobsdropsshop(Player $sender, Item $item){
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
        
        	if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        	}
        	if($item->getId() == 160 && $item->getDamage() == 11){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        	}
        	if($item->getId() == 262 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(262, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Arrow§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 377 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(377, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blaze Powder§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 369 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(369, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blaze§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 352 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(352, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 368 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 45){
	          $this->eco->reduceMoney($sender, "45"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(368, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Ender Pearl§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 288 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(288, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Feather§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 370 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(370, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Ghast Tear§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 289 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(289, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gunpowder§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 334 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(334, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Leather§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 378 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(378, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magma Cream§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 414 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(414, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Rabbit Foot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 415 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(415, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Rabbit Hide§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 367 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(367, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Rotten Flesh§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 287 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(287, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x String§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 375 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(375, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spider Eye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 344 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(344, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Egg§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 341 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 7){
	          $this->eco->reduceMoney($sender, "7"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(341, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Slime Ball§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * DYES SHOP PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function dyes($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "dyesshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	    //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(1, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(2, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(3, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(4, Item::get(339, 2, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6dyes! §7you could §abuy"));
         $inventory->setItem(5, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(6, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(7, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(11, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(12, Item::get(351, 17, 1)->setCustomName("§r§fBrown Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(13, Item::get(351, 18, 1)->setCustomName("§r§fBlue Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(14, Item::get(351, 19, 1)->setCustomName("§r§fWhite Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(15, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(16, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(17, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(19, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(20, Item::get(351, 11, 1)->setCustomName("§r§fYellow Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(21, Item::get(351, 12, 1)->setCustomName("§r§fLight Blue Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(22, Item::get(351, 13, 1)->setCustomName("§r§fMagenta Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(23, Item::get(351, 14, 1)->setCustomName("§r§fOrange Dye\n\n§7Cost: §a§\⛃§r§a3.0 §r"));
         $inventory->setItem(24, Item::get(351, 16, 1)->setCustomName("§r§fBlack Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(25, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(26, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(28, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(29, Item::get(351, 6, 1)->setCustomName("§r§fCyan Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(30, Item::get(351, 7, 1)->setCustomName("§r§fLight Gray Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(31, Item::get(351, 8, 1)->setCustomName("§r§fGray Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(32, Item::get(351, 9, 1)->setCustomName("§r§fPink Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(33, Item::get(351, 10, 1)->setCustomName("§r§fLime Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(34, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(35, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(38, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(39, Item::get(351, 1, 1)->setCustomName("§r§fRed Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(40, Item::get(351, 2, 1)->setCustomName("§r§fGreen Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(41, Item::get(351, 5, 1)->setCustomName("§r§fPurple Dye\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(42, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(43, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(44, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 0, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(160, 2, 1)->setCustomName(" §r §7 §r "));
         
         $this->menu->send($sender);
        }
        public function dyesshop(Player $sender, Item $item)
        { 
        	$hand = $sender->getInventory()->getItemInHand()->getCustomName();
          $inventory = $this->menu->getInventory();
     
        	if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 0){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 160 && $item->getDamage() == 2){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 351 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Green Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purple Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cyan Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 7){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 7, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Gray Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gray Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 9){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 9, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pink Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Lime Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 11){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 11, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Yellow Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 12){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 12, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Light Blue Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 13){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 13, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Magenta Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 14){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 14, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Orange Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 16){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 16, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Black Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 17){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 17, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 18){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 18, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Blue Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 351 && $item->getDamage() == 19){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(351, 19, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x White Dye§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        	
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * TOOLS SHOP PAGE 1 && PAGE 2
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function tools($sender)
	 {
	 	 $this->menu->readonly();
	      $this->menu->setListener([$this, "toolsshop"]);
           $this->menu->setName("§0( Shop | Menu )");
	      $inventory = $this->menu->getInventory();
           
	 	//53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(1, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(2, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(3, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(4, Item::get(160, 3, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6armors and tools! §7you could §abuy"));
         $inventory->setItem(5, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(6, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(7, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(8, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(298, 0, 1)->setCustomName("§r§fLeather Helmet\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(11, Item::get(302, 0, 1)->setCustomName("§r§fChainmail Helmet\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(12, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(13, Item::get(306, 0, 1)->setCustomName("§r§fIron Helmet\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(14, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(15, Item::get(310, 0, 1)->setCustomName("§r§fDiamond Helmet\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
         $inventory->setItem(16, Item::get(314, 0, 1)->setCustomName("§r§fGolden Helmet\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(17, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(19, Item::get(299, 0, 1)->setCustomName("§r§fLeather Chestplate\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(20, Item::get(303, 0, 1)->setCustomName("§r§fChainmail Chestplate\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(21, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(22, Item::get(307, 0, 1)->setCustomName("§r§fIron Chestplate\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(23, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(24, Item::get(311, 0, 1)->setCustomName("§r§fDiamond Chestplate\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
         $inventory->setItem(25, Item::get(315, 0, 1)->setCustomName("§r§fGolden Chestplate\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(26, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(28, Item::get(300, 0, 1)->setCustomName("§r§fLeather Leggings\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(29, Item::get(304, 0, 1)->setCustomName("§r§fChainmail Leggings\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(30, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(31, Item::get(308, 0, 1)->setCustomName("§r§fIron Leggings\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(32, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(33, Item::get(312, 0, 1)->setCustomName("§r§fDiamond Leggings\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
         $inventory->setItem(34, Item::get(316, 0, 1)->setCustomName("§r§fGolden Leggings\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(35, Item::get(159, 13, 1)->setCustomName("§r§a§lNEXT PAGE\n§r§7Click to go to the next pages!"));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(301, 0, 1)->setCustomName("§r§fLeather Boots\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
         $inventory->setItem(38, Item::get(305, 0, 1)->setCustomName("§r§fChainmail Boots\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
         $inventory->setItem(39, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(40, Item::get(309, 0, 1)->setCustomName("§r§fIron Boots\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
         $inventory->setItem(41, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(42, Item::get(313, 0, 1)->setCustomName("§r§fDiamond Boots\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
         $inventory->setItem(43, Item::get(317, 0, 1)->setCustomName("§r§fGolden Boots\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
         $inventory->setItem(44, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(47, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(48, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(51, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(52, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(53, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
         
         $this->menu->send($sender);
        }
        public function toolsshop(Player $sender, Item $item){ 
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
       if($item->getId() == 160 && $item->getDamage() == 3){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
       if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 159 && $item->getDamage() == 13){
        	$this->tools1($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 298 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(298, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Leather Helmet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 299 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(299, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Leather Chestplate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 300 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(300, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Leather Leggings§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 301 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(301, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Leather Boots§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 302 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(302, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chainmail Helmet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 303 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(303, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chainmail Chestplate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 304 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(304, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chainmail Leggings§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 305 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(305, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chainmail Boots§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 306 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(306, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Helmet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 307 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(307, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Chestplate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 308 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(308, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Leggings§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 309 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(309, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Boots§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 310 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(310, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Helmet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 311 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(311, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Chestplate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 312 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(312, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Leggings§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 313 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(313, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Boots§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 314 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(314, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Helmet§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 315 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(315, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Chestplate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 316 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(316, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Leggings§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 317 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(317, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Boots§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this armor!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	 public function tools1($sender)
	 {
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "toolsshop1"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	    
	 	//53 Size Chest 
        	//Chest Section 0-8
        	$inventory->setItem(0, Item::get(268, 0, 1)->setCustomName("§r§fWooden Sword\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
        	$inventory->setItem(1, Item::get(272, 0, 1)->setCustomName("§r§fStone Sword\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(2, Item::get(267, 0, 1)->setCustomName("§r§fIron Sword\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
          $inventory->setItem(3, Item::get(283, 0, 1)->setCustomName("§r§fGold Sword\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
          $inventory->setItem(4, Item::get(276, 0, 1)->setCustomName("§r§fDiamond Sword\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
          $inventory->setItem(5, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6armors and tools! §7you could §abuy"));
          $inventory->setItem(6, Item::get(325, 0, 1)->setCustomName("§r§fBucket\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(7, Item::get(325, 8, 1)->setCustomName("§r§fBucket of Water\n\n§7Cost: §a§l⛃§r§a8.0 §r"));
          $inventory->setItem(8, Item::get(325, 10, 1)->setCustomName("§r§fBucket of Lava\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
          //Chest Section 9-17
          $inventory->setItem(9, Item::get(270, 0, 1)->setCustomName("§r§fWooden Pickaxe\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(10, Item::get(274, 0, 1)->setCustomName("§r§fStone Pickaxe\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(11, Item::get(257, 0, 1)->setCustomName("§r§fIron Pickaxe\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
          $inventory->setItem(12, Item::get(285, 0, 1)->setCustomName("§r§fGold Pickaxe\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
          $inventory->setItem(13, Item::get(278, 0, 1)->setCustomName("§r§fDiamond Pickaxe\n\n§7Cost:§a§l⛃§r§a100.0 §r"));
          $inventory->setItem(14, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(15, Item::get(347, 0, 1)->setCustomName("§r§fClock\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
          $inventory->setItem(16, Item::get(359, 0, 1)->setCustomName("§r§fShears\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
          $inventory->setItem(17, Item::get(345, 0, 1)->setCustomName("§r§fCompass\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
          //Chest Section 18-26
          $inventory->setItem(18, Item::get(271, 0, 1)->setCustomName("§r§fWooden Axe\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(19, Item::get(275, 0, 1)->setCustomName("§r§fStone Axe\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(20, Item::get(258, 0, 1)->setCustomName("§r§fIron Axe\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
          $inventory->setItem(21, Item::get(286, 0, 1)->setCustomName("§r§fGold Axe\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
          $inventory->setItem(22, Item::get(279, 0, 1)->setCustomName("§r§fDiamond Axe\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
          $inventory->setItem(23, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(24, Item::get(346, 0, 1)->setCustomName("§r§fFishing Rod\n\n§7Cost: §a§l⛃§r§a20.0 §r"));
          $inventory->setItem(25, Item::get(259, 0, 1)->setCustomName("§r§fFlint and Steel\n\n§7Cost: §a§l⛃§r10.0 §r"));
          $inventory->setItem(26, Item::get(261, 0, 1)->setCustomName("§r§fBow\n\n§7Cost: §a§l⛃§r§a30.0 §r"));
          //Chest Section 27-35
          $inventory->setItem(27, Item::get(269, 0, 1)->setCustomName("§r§fWooden Shovel\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(28, Item::get(273, 0, 1)->setCustomName("§r§fStone Shovel\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(29, Item::get(256, 0, 1)->setCustomName("§r§fIron Shovel\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
          $inventory->setItem(30, Item::get(284, 0, 1)->setCustomName("§r§fGolden Shovel\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
          $inventory->setItem(31, Item::get(277, 0, 1)->setCustomName("§r§fDiamond Shovel\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
          $inventory->setItem(32, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(33, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(34, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(35, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 36-44
          $inventory->setItem(36, Item::get(290, 0, 1)->setCustomName("§r§fWooden Hoe\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(37, Item::get(291, 0, 1)->setCustomName("§r§fStone Hoe\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(38, Item::get(292, 0, 1)->setCustomName("§r§fIron Hoe\n\n§7Cost: §a§l⛃§r§a50.0 §r"));
          $inventory->setItem(39, Item::get(294, 0, 1)->setCustomName("§r§fGolden Hoe\n\n§7Cost: §a§l⛃§r§a25.0 §r"));
          $inventory->setItem(40, Item::get(293, 0, 1)->setCustomName("§r§fDiamond Hoe\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
          $inventory->setItem(41, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(42, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(43, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(44, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 45-53
          $inventory->setItem(45, Item::get(159, 4, 1)->setCustomName("§r§e§lPREVIOUS PAGE\n§r§7Click to go to the previous pages!"));
          $inventory->setItem(46, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(47, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(48, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
          $inventory->setItem(50, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(51, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(52, Item::get(160, 3, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(53, Item::get(262, 0, 1)->setCustomName("§r§fArrow\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
	 }
	 public function toolsshop1(Player $sender, Item $item)
	 {
	 	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
        
        if($item->getId() == 159 && $item->getDamage() == 4){
        	$this->tools($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
	   if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 160 && $item->getDamage() == 3){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 325 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(325, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bucket§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 325 && $item->getDamage() == 8){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(325, 8, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bucket of Water§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 325 && $item->getDamage() == 10){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(325, 10, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bucket of Lava§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 347 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(347, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Clock§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 345 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(345, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Compass§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 346 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 20){
	          $this->eco->reduceMoney($sender, "20"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(346, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Fishing rod§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 259 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(259, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Flint and Steel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 262 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(262, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Arrow§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 359 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(359, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Shears§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 261 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 30){
	          $this->eco->reduceMoney($sender, "30"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(261, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bow§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 268 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(268, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wooden Sword§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 270 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(270, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wooden Pickaxe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 271 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(271, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wooden Axe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 269 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(269, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wooden Shovel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 290 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(290, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wooden Hoe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 272 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(272, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone Sword§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 274 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(274, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone Pickaxe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 275 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(275, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone Axe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 273 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(273, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone Shovel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 291 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(291, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone Hoe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 267 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(267, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Sword§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 257 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(257, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Pickaxe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 258 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(258, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Axe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 256 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(256, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Shovel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 292 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 50){
	          $this->eco->reduceMoney($sender, "50"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(292, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Iron Hoe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 283 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(283, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Sword§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 285 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(285, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Pickaxe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 286 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(286, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Axe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 284 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(284, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Shovel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 294 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 25){
	          $this->eco->reduceMoney($sender, "25"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(294, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gold Hoe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 276 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(276, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Sword§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 278 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(278, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Pickaxe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 279 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(279, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Axe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 277 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(277, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Shovel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 293 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(293, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diamond Hoe§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this items!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * FARMS PAGE 1
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function farms($sender)
	 {
	 	$this->menu->readonly();
	     $this->menu->setListener([$this, "farmsshop"]);
          $this->menu->setName("§0( Shop | Menu )");
 	     $inventory = $this->menu->getInventory();
 	     
 	     //53 Size Chest 
        	//Chest Section 0-8
        	$inventory->setItem(0, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
        	$inventory->setItem(1, Item::get(295, 0, 1)->setCustomName("§r§fSeeds\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(2, Item::get(361, 0, 1)->setCustomName("§r§fPumpkin Seeds\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(3, Item::get(362, 0, 1)->setCustomName("§r§fMelon Seeds\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(4, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6farms! §7you could §abuy"));
          $inventory->setItem(5, Item::get(458, 0, 1)->setCustomName("§r§fBeetroot Seeds\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(6, Item::get(391, 0, 1)->setCustomName("§r§fCaddot\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(7, Item::get(392, 0, 1)->setCustomName("§r§fPotato\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(8, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 9-17
          $inventory->setItem(9, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(10, Item::get(170, 0, 1)->setCustomName("§r§fHayblock\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(11, Item::get(86, 0, 1)->setCustomName("§r§fPumpkin\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(12, Item::get(103, 0, 1)->setCustomName("§r§fMelonblock\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(13, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(14, Item::get(457, 0, 1)->setCustomName("§r§fBeetroot\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(15, Item::get(338, 0, 1)->setCustomName("§r§fSugarcane\n\n§r§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(16, Item::get(260, 0, 1)->setCustomName("§r§fApple \n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(17, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 18-26
          $inventory->setItem(18, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(19, Item::get(296, 0, 1)->setCustomName("§r§fWheat\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(20, Item::get(400, 0, 1)->setCustomName("§r§fPumpkin Pie\n\n§r§7Cost: §a§l⛃§r§a10.0 §r"));
          $inventory->setItem(21, Item::get(360, 0, 1)->setCustomName("§r§fSlice Melon\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(22, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(23, Item::get(81, 0, 1)->setCustomName("§r§fCactus\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(24, Item::get(39, 0, 1)->setCustomName("§r§fBrown Mushroom\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(25, Item::get(40, 0, 1)->setCustomName("§r§fRed Mushroom\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(26, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 27-35
          $inventory->setItem(27, Item::get(6, 0, 1)->setCustomName("§r§fOak Sapling\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(28, Item::get(6, 1, 1)->setCustomName("§r§fSpruce Sapling\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(29, Item::get(6, 2, 1)->setCustomName("§r§fBirch Sapling\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(30, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(31, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(32, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(33, Item::get(6, 3, 1)->setCustomName("§r§fJungle Sapling\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(34, Item::get(6, 4, 1)->setCustomName("§r§fAcacia Sapling\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(35, Item::get(6, 5, 1)->setCustomName("§r§fDark Oak Sapling\n\n§r§7Cost: §a§l⛃§r§a3.0 §r"));
          //Chest Section 36-44
          $inventory->setItem(36, Item::get(18, 0, 1)->setCustomName("§r§fOak Leaves\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(37, Item::get(18, 1, 1)->setCustomName("§r§fSpruce Leaves\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(38, Item::get(18, 2, 1)->setCustomName("§r§fBirch Leaves\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(39, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(40, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(41, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(42, Item::get(18, 3, 1)->setCustomName("§r§fJungle Leaves\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(43, Item::get(161, 0, 1)->setCustomName("§r§fAcacia Leaves\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(44, Item::get(161, 1, 1)->setCustomName("§r§fDark Oak Leaves\n\n§r§7Cost: §a§l⛃§r§a2.0 §r"));
          //Chest Section 45-53
          $inventory->setItem(45, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(46, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(47, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(48, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
          $inventory->setItem(50, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(51, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(52, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(53, Item::get(160, 13, 1)->setCustomName(" §r §7 §r "));
          
          $this->menu->send($sender);
        }
	 public function farmsshop(Player $sender, Item $item)
	 {
	 	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
       if($item->getId() == 160 && $item->getDamage() == 13){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        if($item->getId() == 295 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(295, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wheat Seeds§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 361 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(361, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pumpkin Seeds§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 362 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(362, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Melon Seeds§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 458 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(458, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Beetroot Seeds§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 391 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(391, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Caddot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 392 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(392, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Potato§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 170 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(170, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Hayblock§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 86 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(86, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pumpkin§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 103 && $item->getDamage() == 0){
         	   $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(103, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Melon Block§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 457 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(457, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Beetroot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 338 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(338, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Sugarcane§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 260 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(260, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Apple§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 296 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(296, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Wheat§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 360 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(360, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Melon Slice§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 400 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(400, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pumpkin Pie§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 81 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(81, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cactus§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 39 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(39, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brown Mushroom§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 40 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(40, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Mushroom§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 6 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(6, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Sapling§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 6 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(6, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Sapling§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 6 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(6, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Sapling§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 6 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(6, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Sapling§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 6 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(6, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Sapling§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 6 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(6, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Sapling§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 18 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(18, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Leaves§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 18 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(18, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Leaves§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 18 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(18, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Leaves§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 18 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(18, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Leaves§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 161 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(161, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Leaves§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 161 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(161, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Leaves§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	 }
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * DECORATIONS PAGE 1 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	 public function decorations($sender)
	 {
	 	$this->menu->readonly();
 	     $this->menu->setListener([$this, "decorationsshop"]);
          $this->menu->setName("§0( Shop | Menu )");
	     $inventory = $this->menu->getInventory();
	     
	     //53 Size Chest 
        	//Chest Section 0-8

        	$inventory->setItem(0, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
        	$inventory->setItem(1, Item::get(145, 0, 1)->setCustomName("§r§fAnvil\n\n§7Cost: §a§l⛃§r§a100.0 §r"));
          $inventory->setItem(2, Item::get(355, 0, 1)->setCustomName("§r§fBer\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
          $inventory->setItem(3, Item::get(47, 0, 1)->setCustomName("§r§fBookshelf\n\n§7Cost: §a§l⛃§r§a7.0 §r"));
          $inventory->setItem(4, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6DECORATIONS! §7you could §abuy"));
          $inventory->setItem(5, Item::get(379, 0, 1)->setCustomName("§r§fBrewing Stand\n\n§7Cost: §a§l⛃§r§a12.0 §r"));
          $inventory->setItem(6, Item::get(380, 0, 1)->setCustomName("§r§fCauldron\n\n§7Cost: §a§l⛃§r§a15.0 §r"));
          $inventory->setItem(7, Item::get(54, 0, 1)->setCustomName("§r§fChest\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(8, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 9-17
          $inventory->setItem(9, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(10, Item::get(58, 0, 1)->setCustomName("§r§fCrafting Table\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(11, Item::get(23, 0, 1)->setCustomName("§r§fDispenser\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(12, Item::get(125, 0, 1)->setCustomName("§r§fDropper\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(13, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(14, Item::get(116, 0, 1)->setCustomName("§r§fEnchanting Table\n\n§a§l⛃§r§a250.0 §r"));
          $inventory->setItem(15, Item::get(130, 0, 1)->setCustomName("§r§fEnded Chest\n\n§a§l⛃§r§a75.0 §r"));
          $inventory->setItem(16, Item::get(390, 0, 1)->setCustomName("§r§fFlower Pot\n\n§a§l⛃§r§a1.0 §r"));
          $inventory->setItem(17, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 18-26
          $inventory->setItem(18, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(19, Item::get(389, 0, 1)->setCustomName("§r§fItem Frame\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(20, Item::get(61, 0, 1)->setCustomName("§r§fFurnace\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(21, Item::get(410, 0, 1)->setCustomName("§r§fHopper\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
          $inventory->setItem(22, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(23, Item::get(84, 0, 1)->setCustomName("§r§fJukebox\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(24, Item::get(25, 0, 1)->setCustomName("§r§fNoteblock\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(25, Item::get(236, 0, 1)->setCustomName("§r§fObserver\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(26, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 27-35
          $inventory->setItem(27, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(28, Item::get(321, 0, 1)->setCustomName("§r§fPainting\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(29, Item::get(33, 0, 1)->setCustomName("§r§fPiston\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(30, Item::get(29, 0, 1)->setCustomName("§r§fSticky Piston \n\n§7Cost: §a§l⛃§r§a8.0 §r"));
          $inventory->setItem(31, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(32, Item::get(50, 0, 1)->setCustomName("§r§fTorch\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(33, Item::get(96, 0, 1)->setCustomName("§r§fOak Trapdoor\n\n§7Cost: §a§l⛃§r§a10.0 §r"));
          $inventory->setItem(34, Item::get(65, 0, 1)->setCustomName("§r§fLadder\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(35, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 36-44
          $inventory->setItem(36, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(37, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(38, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(39, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(40, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(41, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(42, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(43, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(44, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 45-53
          $inventory->setItem(45, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(46, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(47, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(48, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
          $inventory->setItem(50, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(51, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(52, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(53, Item::get(160, 4, 1)->setCustomName(" §r §7 §r "));
          
          $this->menu->send($sender); 
        }
        public function decorationsshop(Player $sender, Item $item) 
        {
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
        	if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        	}
        	if($item->getId() == 160 && $item->getDamage() == 4){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        	}
        	if($item->getId() == 145 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 100){
	          $this->eco->reduceMoney($sender, "100"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(145, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Anvil§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 355 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(355, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Ber§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 47 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 7){
	          $this->eco->reduceMoney($sender, "7"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(47, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Bookshelf§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 379 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 12){
	          $this->eco->reduceMoney($sender, "12"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(379, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Brewing Stand§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 380 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 15){
	          $this->eco->reduceMoney($sender, "15"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(380, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cauldron§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 54 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(54, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chest§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 58 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(58, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Crafting Table§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 23 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(23, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dispenser§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     } 
        }
        if($item->getId() == 125 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(125, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dropper§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 116 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 250){
	          $this->eco->reduceMoney($sender, "250"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(116, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Enchanting Table§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 130 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 75){
	          $this->eco->reduceMoney($sender, "75"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(130, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Ended Chest§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 390 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(390, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Flower Pot§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 389 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(389, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Item Frame§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 61 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(61, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Furnace§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 410 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(410, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Hopper§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 84 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(84, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x JukeBox§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 25 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(25, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Noteblock§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 236 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(236, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Observer§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 321 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(321, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Painting§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 33 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(33, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Piston§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 29 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(29, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Sticky Piston§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 50 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(50, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Torch§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 96 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(96, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Trapdoor§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 65 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(65, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Ladder§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	}
        
	/**
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * BLOCKS PAGE 1 && PAGE 2
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * 
	 * */
	public function blocks($sender)
	{
	    $this->menu->readonly();
	    $this->menu->setListener([$this, "blocksshop"]);
         $this->menu->setName("§0( Shop | Menu )");
	    $inventory = $this->menu->getInventory();
	     
	    //53 Large DOUBLE Chest
         //Chest Section 0-8
         $inventory->setItem(0, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(1, Item::get(17, 0, 1)->setCustomName("§r§fOak Log\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(2, Item::get(17, 1, 1)->setCustomName("§r§fSpruce Log\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(3, Item::get(17, 2, 1)->setCustomName("§r§fBirch Log\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(4, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6Woods! §7you could §abuy"));
         $inventory->setItem(5, Item::get(17, 3, 1)->setCustomName("§r§fJungle Log\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(6, Item::get(162, 0, 1)->setCustomName("§r§fAcacia Log\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(7, Item::get(162, 1, 1)->setCustomName("§r§fDark Oak Log\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
         $inventory->setItem(8, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(10, Item::get(5, 0, 1)->setCustomName("§r§fOak Planks\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(11, Item::get(5, 1, 1)->setCustomName("§r§fSpruce Planks\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(12, Item::get(5, 2, 1)->setCustomName("§r§fBirch Planks\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(13, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(14, Item::get(5, 3, 1)->setCustomName("§r§fJungle Planks\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(15, Item::get(5, 4, 1)->setCustomName("§r§fAcacia Planls\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(16, Item::get(5, 5, 1)->setCustomName("§r§fDark Oak Planks\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(17, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 18-26
         $inventory->setItem(18, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(19, Item::get(53, 0, 1)->setCustomName("§r§fOak Stairs\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(20, Item::get(134, 0, 1)->setCustomName("§r§fSpruce Stairs\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(21, Item::get(135, 0, 1)->setCustomName("§r§fBirch Stairs\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(22, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(23, Item::get(136, 0, 1)->setCustomName("§r§fJungle Stairs\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(24, Item::get(163, 0, 1)->setCustomName("§r§fAcacia Stairs\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(25, Item::get(164, 0, 1)->setCustomName("§r§fDark Oak Stairs\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(26, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 27-35
         $inventory->setItem(27, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(28, Item::get(158, 0, 1)->setCustomName("§r§fOak Slab\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(29, Item::get(158, 1, 1)->setCustomName("§r§fSpruce Slab\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(30, Item::get(158, 2, 1)->setCustomName("§r§fBirch Slab\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(31, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(32, Item::get(158, 3, 1)->setCustomName("§r§fJungle Slab\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(33, Item::get(158, 4, 1)->setCustomName("§r§fAcacia Slab\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(34, Item::get(158, 5, 1)->setCustomName("§r§fDark Oak Slab\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(35, Item::get(159, 13, 1)->setCustomName("§r§a§lNEXT PAGE\n§r§7Click to go to the next pages!"));
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(37, Item::get(107, 0, 1)->setCustomName("§r§fOak Fence Gate\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(38, Item::get(183, 0, 1)->setCustomName("§r§fSpruce Fence Gate\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(39, Item::get(184, 0, 1)->setCustomName("§r§fBirch Fence Gate\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(40, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(41, Item::get(185, 0, 1)->setCustomName("§r§fJungle Fence Gate\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(42, Item::get(187, 0, 1)->setCustomName("§r§fAcacia Fence Gate\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(43, Item::get(186, 0, 1)->setCustomName("§r§fDark Oak Fence Gate\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(44, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         $inventory->setItem(46, Item::get(85, 0, 1)->setCustomName("§r§fOak Fence\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(47, Item::get(85, 1, 1)->setCustomName("§r§fSpruce Fence\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(48, Item::get(85, 2, 1)->setCustomName("§r§fBirch Fence\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
         $inventory->setItem(50, Item::get(85, 3, 1)->setCustomName("§r§fJungle Fence\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(51, Item::get(85, 4, 1)->setCustomName("§r§fAcacia Fence\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(52, Item::get(85, 5, 1)->setCustomName("§r§fDark Oak Fence\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
         $inventory->setItem(53, Item::get(160, 12, 1)->setCustomName(" §r §7 §r "));
         
         $this->menu->send($sender);
        }
        public function blocksshop(Player $sender, Item $item)
        {
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
        	if($item->getId() == 160 && $item->getDamage() == 12){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        	if($item->getId() == 159 && $item->getDamage() == 13){
        		$this->blocks1($sender);
        		$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        	}
        	if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        	if($item->getId() == 17 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(17, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Log§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 17 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(17, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Log§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 17 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(17, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Log§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 17 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(17, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Log§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 162 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(162, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Log§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 162 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(162, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Log§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 5 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(5, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Planks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 5 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(5, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Planks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 5 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(5, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Planks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 5 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(5, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Planks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 5 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(5, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Planks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 5 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(5, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Planks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 53 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(53, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Stairs§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 134 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(134, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Stairs§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 135 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(135, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Stairs§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 136 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(136, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Stairs§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 163 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(163, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Stairs§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 164 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(164, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Stairs§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 158 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(158, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Slab§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 158 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(158, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Slab§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 158 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(158, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Slab§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 158 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(158, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Slab§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 158 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(158, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Slab§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 158 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(158, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Slab§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 107 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(107, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Fence Gate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 183 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(183, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Fence Gate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 184 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(184, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Fence Gate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 185 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(185, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Fence Gate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 187 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(187, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Fence Gate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 186 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(186, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Fence Gate§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 85 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(85, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Oak Fence§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 85 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(85, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Spruce Fence§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 85 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(85, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Birch Fence§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 85 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(85, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Jungle Fence§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 85 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(85, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Acacia Fence§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 85 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(85, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Oak Fence§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
		}
        }
        }
        public function blocks1($sender)
        {
        	$this->menu->readonly();
	     $this->menu->setListener([$this, "blocksshop1"]);
          $this->menu->setName("§0( Shop | Menu )");
	     $inventory = $this->menu->getInventory();
	    
        	$inventory->setItem(0, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
        	$inventory->setItem(1, Item::get(1, 0, 1)->setCustomName("§r§fStone\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(2, Item::get(4, 0, 1)->setCustomName("§r§fCobblestone\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(3, Item::get(48, 0, 1)->setCustomName("§r§fMossy Cobblestone\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(4, Item::get(339, 0, 1)->setCustomName("§r§6What's this page?\n\n§7this pages is contain\n§6stones! §7you could §abuy"));
          $inventory->setItem(5, Item::get(13, 0, 1)->setCustomName("§r§fGravel\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(6, Item::get(98, 0, 1)->setCustomName("§r§fStone Bricks\n\n§7Cost: §a§l⛃§r§a5.0 §r"));
          $inventory->setItem(7, Item::get(98, 1, 1)->setCustomName("§r§fMossy Stone Bricks\n\n§7Cost: §a§l⛃§r§a4.0 §r"));
          $inventory->setItem(8, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 9-17
          $inventory->setItem(9, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(10, Item::get(98, 2, 1)->setCustomName("§r§fCracker Stone Bricks\n\n§7Cost: §a§l⛃§r§a3.0 §r"));
          $inventory->setItem(11, Item::get(98, 3, 1)->setCustomName("§r§fChiseled Stone Bricks\n\n§7Cost: §a§l⛃§r§a4.0 §r"));
          $inventory->setItem(12, Item::get(121, 0, 1)->setCustomName("§r§fEnd Stone\n\n§7Cost: §a§l⛃§r§a2.0 §r"));
          $inventory->setItem(13, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(14, Item::get(1, 1, 1)->setCustomName("§r§fGranite\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(15, Item::get(1, 3, 1)->setCustomName("§r§fDiorite\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(16, Item::get(1, 5, 1)->setCustomName("§r§fAndesite\n\n§7Cost: §a§l⛃§r§a1.0 §r"));
          $inventory->setItem(17, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 18-26
          $inventory->setItem(18, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(19, Item::get(82, 0, 1)->setCustomName("§r§fClay\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(20, Item::get(49, 0, 1)->setCustomName("§r§fObsidian\n\n§7Cost: §r§a§l⛃§r§a5.0 §r"));
          $inventory->setItem(21, Item::get(87, 0, 1)->setCustomName("§r§fNetherrack\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(22, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(23, Item::get(1, 2, 1)->setCustomName("§r§fPolished Granite\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(24, Item::get(1, 4, 1)->setCustomName("§r§fPolished Diorite\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(25, Item::get(1, 6, 1)->setCustomName("§r§fPolished Andesite\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(26, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 27-35
          $inventory->setItem(27, Item::get(159, 4, 1)->setCustomName("§r§e§lPREVIOUS PAGE\n§r§7Click to go to the previous pages!"));
          $inventory->setItem(28, Item::get(168, 0, 1)->setCustomName("§r§fPrismarine\n\n§7Cost: §r§a§l⛃§r§a5.0 §r"));
          $inventory->setItem(29, Item::get(168, 1, 1)->setCustomName("§r§fDark Prismarine Block\n\n§7Cost: §r§a§l⛃§r§a7.0 §r"));
          $inventory->setItem(30, Item::get(168, 2, 1)->setCustomName("§r§fPrismarine Bricks\n\n§7Cost: §r§a§l⛃§r§a10.0 §r"));
          $inventory->setItem(31, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(32, Item::get(155, 0, 1)->setCustomName("§r§fBlock of Quartz\n\n§7Cost: §r§a§l⛃§r§a5.0 §r"));
          $inventory->setItem(33, Item::get(155, 1, 1)->setCustomName("§r§fChiseled Quartz Block\n\n§7Cost: §r§a§l⛃§r§a7.0 §r"));
          $inventory->setItem(34, Item::get(155, 2, 1)->setCustomName("§r§fPillar Quartz Block\n\n§7Cost: §r§a§l⛃§r§a10.0§r"));
          $inventory->setItem(35, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 36-44
          $inventory->setItem(36, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(37, Item::get(179, 0, 1)->setCustomName("§r§fRed Sandstone\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(38, Item::get(179, 1, 1)->setCustomName("§r§fChiseled Sandstone\n\n§7Cost: §r§a§l⛃§r§a3.0 §r"));
          $inventory->setItem(39, Item::get(179, 2, 1)->setCustomName("§r§fCut Red Sandstone\n\n§7Cost: §r§a§l⛃§r§a5.0 §r"));
          $inventory->setItem(40, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(41, Item::get(24, 0, 1)->setCustomName("§r§fSandstone\n\n§7Cost: §r§a§l⛃§r§a2.0 §r"));
          $inventory->setItem(42, Item::get(24, 1, 1)->setCustomName("§r§fChiseled Sandstone\n\n§7Cost: §r§a§l⛃§r§a3.0 §r"));
          $inventory->setItem(43, Item::get(24, 2, 1)->setCustomName("§r§fCut Sandstone\n\n§7Cost: §r§a§l⛃§r§a5.0 §r"));
          $inventory->setItem(44, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          //Chest Section 45-53
          $inventory->setItem(45, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          $inventory->setItem(46, Item::get(88, 0, 1)->setCustomName("§r§fSoul Sand\n\n§7Cost: §r§a§l⛃§r§a3.0 §r"));
          $inventory->setItem(47, Item::get(46, 0, 1)->setCustomName("§r§fTnT\n\n§7Cost: §r§a§l⛃§r§a5.0 §r"));
          $inventory->setItem(48, Item::get(12, 0, 1)->setCustomName("§r§fSand\n\n§7Cost: §r§a§l⛃§r§a1.0 §r"));
          $inventory->setItem(49, Item::get(152, 0, 1)->setCustomName("§r§c§lEXIT\n§r§7Click to exit the shop menu"));
          $inventory->setItem(50, Item::get(12, 1, 1)->setCustomName("§r§fRed Sand\n\n§7Cost: §r§a§l⛃§r§a1.0 §r"));
          $inventory->setItem(51, Item::get(201, 0, 1)->setCustomName("§r§fPurpur Block\n\n§7Cost: §r§a§l⛃§r§a8.0 §r"));
          $inventory->setItem(52, Item::get(201, 2, 1)->setCustomName("§r§fPurpur Pillar\n\n§7Cost: §r§a§l⛃§r§a8.0 §r"));
          $inventory->setItem(53, Item::get(160, 8, 1)->setCustomName(" §r §7 §r "));
          
          $this->menu->send($sender);
        }
        public function blocksshop1(Player $sender, Item $item)
        {
        	 $hand = $sender->getInventory()->getItemInHand()->getCustomName();
           $inventory = $this->menu->getInventory();
           
        if($item->getId() == 159 && $item->getDamage() == 4){
        	$this->blocks($sender);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_OPEN);
        }
        if($item->getId() == 160 && $item->getDamage() == 8){
        	$volume = mt_rand();
	     $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_CLICK, (int) $volume);
        }
        if($item->getId() == 152 && $item->getDamage() == 0){
        	$sender->removeWindow($inventory);
        	$sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_CHEST_CLOSED);
        }
        
        if($item->getId() == 1 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 4 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(4, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cobblestone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 48 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(48, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Mossy Cobblestone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 13 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(13, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Gravel§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 98 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(98, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Stone Bricks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 98 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 4){
	          $this->eco->reduceMoney($sender, "4"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(98, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Mossy Stone Bricks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 98 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(98, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Crack Stone Bricks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 98 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 4){
	          $this->eco->reduceMoney($sender, "4"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(98, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chiseled Stone Bricks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 121 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(121, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x End Stone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 1 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Granite§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 1 && $item->getDamage() == 3){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 3, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Diorite§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 1 && $item->getDamage() == 5){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 5, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Andesite§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 82 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(82, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Clay§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 49 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(49, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Obsidian§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 87 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(87, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Netherrack§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 1 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Polished Granite§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 1 && $item->getDamage() == 4){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 4, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Polished Diorite§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 1 && $item->getDamage() == 6){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 6, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Polished Andesite§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 168 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(1, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Prismarine§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 168 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 7){
	          $this->eco->reduceMoney($sender, "7"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(168, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Dark Prismarine§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 168 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(168, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Prismarine Bricks§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 155 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(155, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Block of Quartz§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 155 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 7){
	          $this->eco->reduceMoney($sender, "7"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(155, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chiseled Quartz§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 155 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 10){
	          $this->eco->reduceMoney($sender, "10"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(155, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Pillar Quartz§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 179 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(179, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Sandstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 179 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(179, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cut Red Sandstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 179 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(179, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cut Red Sandstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 24 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 2){
	          $this->eco->reduceMoney($sender, "2"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(24, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Sandstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 24 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(24, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Chiseled Sandstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 24 && $item->getDamage() == 2){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(24, 2, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Cut Sandstone§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 88 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 3){
	          $this->eco->reduceMoney($sender, "3"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(88, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Soul Sand§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 46 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 5){
	          $this->eco->reduceMoney($sender, "5"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(46, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x TnT§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 12 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(12, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Sand§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 12 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 1){
	          $this->eco->reduceMoney($sender, "1"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(12, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Red Sand§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 201 && $item->getDamage() == 0){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(201, 0, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purpur Block§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
        if($item->getId() == 201 && $item->getDamage() == 1){
	        $sender->getLevel()->broadcastLevelSoundEvent($sender->add(0, $sender->eyeHeight, 0), LevelSoundEventPacket::SOUND_UI_LOOM_TAKE_RESULT);
	        $money = $this->eco->myMoney($sender);
	        if($money >= 8){
	          $this->eco->reduceMoney($sender, "8"); 
		     $inv = $sender->getInventory();
		     $inv->addItem(Item::get(201, 1, 1));
		     $sender->sendMessage("§a§lSuccess! §r§7You have bought §e1x Purpur Pillar§7!");
		}else{
	        $sender->sendMessage("§c§lError! §r§7You don't have money to buy this block!");
	        $volume = mt_rand();
	        $sender->getLevel()->broadcastLevelEvent($sender, LevelEventPacket::EVENT_SOUND_ANVIL_FALL, (int) $volume);
	     }
        }
	}
}