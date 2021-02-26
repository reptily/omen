<?php

namespace Omen\Debug;

use Omen\Server\Server;

class Console implements Colors
{

    /** @var int */
    private $countTabs;

    /**
     * @param string $text
     * @param string $color
     */
    static public function PrintLn(string $text, string $color = Colors::NONE): void
    {
        echo $color . $text . Colors::NONE . "\n";
    }

    /**
     * @param $object
     * @return array
     */
    static public function log($object)
    {
        $dd = new static;
        $result = $dd->logPrint($object, -1);
        Server::manualSendAll(json_encode($result));
    }

    /**
     * @param $object
     * @param $countTabs
     * @return array
     */
    private function logPrint($object, $countTabs): array
    {
        $result = [];
        $countTabs++;

        if (is_array($object) || is_object($object)) {
            if (is_object($object)) {
                $this->tabPrint($countTabs);
                echo Colors::CYAN . get_class($object) . Colors::NONE . "\n";
            }
            foreach ($object as $i => $item) {
                $this->tabPrint($countTabs);
                echo "[" . Colors::BLUE . $i . Colors::NONE . "]";
                if (is_array($item) || is_object($item)) {
                    echo " => " . Colors::PURPLE . gettype($item) . Colors::NONE ."\n";
                    $result[$i] = dd($item, $countTabs);
                } else {
                    $result[$i] = dd($item, 0);
                }

            }
        } else {
            $this->tabPrint($countTabs);
            echo "(" . Colors::YELLOW . gettype($object) . Colors::NONE . ") " .Colors::GREEN . $object . Colors::NONE . "\n";
            $result[gettype($object)] = $object;
        }

        return $result;
    }

    /**
     * @param int $tab
     */
    private function tabPrint(int $countTabs)
    {
        if ($countTabs > 0) {
            echo "\t";
            $countTabs--;
            $this->tabPrint($countTabs);
        }
    }
}
