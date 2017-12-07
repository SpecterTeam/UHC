<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/6/2017
 * Time: 6:23 PM
 */

namespace uhc;


use pocketmine\utils\Config;

class LangManager
{
    //TODO: More languages

    const DEFAULT_LANG = "eng";
    const LANGS_FOLDER = "lang";

    const START_GAME = "start.game";
    const STOP_GAME = "stop.game";
    const END_GAME = "end.game";
    const DEATH = "died";

    private $default = self::DEFAULT_LANG;
    private $plugin;

    private static $langs = [];

    /**
     * LangManager constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        if(!is_dir($plugin->getDataFolder() . self::LANGS_FOLDER)){
            @mkdir($plugin->getDataFolder() . self::LANGS_FOLDER);
        }
        $this->registerDefaultLanguage();
    }

    public function registerDefaultLanguage()
    {
        //TODO: Custom lang support
        $messages = [
            self::START_GAME => "{prefix} the game has started!",
            self::STOP_GAME => "{prefix} the game has stopped!",
            self::END_GAME => "{prefix} the game has ended!",
            self::DEATH => "{prefix} {death} died."
        ];
        $config = new Config($this->getPlugin()->getDataFolder() . self::LANGS_FOLDER . DIRECTORY_SEPARATOR . self::DEFAULT_LANG . ".yml", Config::YAML, $messages);
        self::$langs["eng"] = $config->getAll(true);
    }

    /**
     * @param string $message
     * @param string $lang
     * @return string
     */
    public static function translate(string $message, string $lang)
    {
        switch (strtolower($message)){
            case self::START_GAME:
                return self::$langs[$lang][$message];
            break;

            case self::STOP_GAME:
                return self::$langs[$lang][$message];
            break;

            case self::END_GAME:
                return self::$langs[$lang][$message];
            break;

            default:
                return $message; //when message isn't registered it will return the given message
            break;
        }
    }

    /**
     * @return string
     */
    public function getDefault() : string
    {
        return $this->default;
    }

    /**
     * @param string $default
     */
    public function setDefault(string $default)
    {
        $this->default = $default;
    }

    /**
     * @return UHC
     */
    public function getPlugin() : UHC
    {
        return $this->plugin;
    }

    /**
     * @param UHC $plugin
     */
    public function setPlugin(UHC $plugin)
    {
        $this->plugin = $plugin;
    }
}