<?php
/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020 JaxkDev
 *
 * Twitter :: @JaxkDev
 * Discord :: JaxkDev#2698
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot;

use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Parts\User\Activity;
use pocketmine\utils\MainLogger;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class Bot {
	/**
	 * @var BotThread
	 */
	private $thread;

	/**
	 * @var Discord
	 */
	private $client;

	/** @var bool */
	private $ready = false;

	public function __construct(BotThread $thread) {
		$this->thread = $thread;

		register_shutdown_function(array($this, 'shutdownHandler'));

		// TODO Bot Config.

		try {
			$this->client = new Discord([
				'token' => 'KEY HERE REMINDER TO SELF, MY KEY IS IN SERVER_KEY.TXT',
			]);
		} catch (IntentException $e) {
			MainLogger::getLogger()->logException($e);
			return;
		} catch (InvalidOptionsException $e) {
			MainLogger::getLogger()->logException($e);
			return;
		}

		$this->registerHandlers();
		$this->registerTimers();

		$this->client->run();
	}

	private function registerTimers(): void{
		// Handles shutdown.
		$this->client->getLoop()->addPeriodicTimer(1, function(){
			if($this->thread->isStopping()){
				$this->shutdown();
			}
		});

		// Handles any problems pre-ready.
		$this->client->getLoop()->addTimer(10, function(){
			if(!$this->ready){
				MainLogger::getLogger()->error("Client failed to login/connect within 10 seconds, See log for details.");
				$this->shutdown();
			}
		});

		// TODO 'Ticking' Communication between thread + plugin via lists/Queues of data
	}

	private function registerHandlers(): void{
		$this->client->on('ready', function ($discord) {
			$this->ready = true;
			MainLogger::getLogger()->info("Client ready.");
			$discord->updatePresence($discord->factory(Activity::class, [
				'name' => "PocketMine-MP Server",
				'type' => Activity::TYPE_PLAYING
			]));

			// Listen for messages.
			$discord->on('message', function ($message, $discord) {
				MainLogger::getLogger()->info("{$message->author->username}: {$message->content}");
			});
		});
	}

	public function shutdown(): void{
		if($this->client !== null){
			$this->client->close(true);
			$this->client = null;
			MainLogger::getLogger()->debug("Client closed.");
		}
	}

	public function shutdownHandler(): void{
		if($this->client !== null) {
			$this->client->close();
		}
		$this->thread->stop();  //Flag as stopping/stopped if not already.
		MainLogger::getLogger()->debug("BotThread shutdown.");
	}
}