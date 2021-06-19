<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Reward;
use app\models\Customer;

/**
 * This command calculates customer reward points
 */
class RewardController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $customers = Customer::find()->all();
        
        foreach ($customers as $customer) {
            $rewards = 0;
            foreach ($customer->rewards as $reward) {
                if ($reward->expiry_date <= date('Y-m-d')) {
                    $reward->status = 0;
                    $reward->save();
                } else {
                    $rewards += $reward->points;
                }
            }

            $customer->reward = $rewards;
            $customer->save();
        }

        print 'Rewards updated.' . PHP_EOL;
        return ExitCode::OK;
    }
}
