<?php
namespace app\components;

use yii;
use yii\db\Migration as BaseMigration;
use yii\helpers\Console;

class Migration extends BaseMigration
{
    public $operations = [];

    public function up()
    {
        foreach ($this->operations as $index => $operation) {
            $transaction = null;
            $time = microtime(true);

            if (!empty($operation['transactional'])) {
                $transaction = Yii::$app->getDb()->beginTransaction();
                echo "    > execute transactional queries ...";
            }

            try {
                $operationFunction = $operation['up'];
                $operationFunction($this);

                if (!empty($operation['transactional'])) {
                    echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
                    $transaction->commit();
                }
            } catch (\Exception $exception) {
                if (!empty($operation['transactional'])) {
                    $transaction->rollBack();
                }

                $indexFrom = !empty($operation['transactional']) ? $index : $index - 1;

                echo Console::ansiFormat("\n\n=========================\n==== ROLL BACK BEGIN ====\n=========================\n", [Console::FG_RED]);
                for ($i = $indexFrom; $i >= 0; $i--) {
                    if (!empty($this->operations[$i]['down'])) {
                        $function = $this->operations[$i]['down'];
                        $function($this);
                    }
                }
                echo Console::ansiFormat("\n=======================\n==== ROLL BACK END ====\n=======================\n", [Console::FG_RED]);
                echo Console::ansiFormat(
                    "\n\n\n================================================\n\n" .
                    "  !!! DATABASE RESTORED | NO CHANGES APPLIED !!!  \n\n" .
                    "================================================\n\n\n"
                , [Console::FG_CYAN, Console::BOLD]);
                throw $exception;
            }
        }
    }

    public function down()
    {
        for ($i = count($this->operations) - 1; $i >= 0; $i--) {
            if (!empty($this->operations[$i]['down'])) {
                $this->operations[$i]['down']($this);
            }
        }
    }
}